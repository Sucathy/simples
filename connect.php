<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $query = $_POST['query'];

    $password = '';

    // Database connection
    $conn = new mysqli('localhost:3306', 'root', $password, 'suresh');

    // Check for connection errors
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die("Connection failed");
    } else {
        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO registration (name, phone, email, course, query) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $phone, $email, $course, $query);
        $execval = $stmt->execute();

        $stmt->close();
        $conn->close();

        // Send email
        $to = "susuresh@gmail.com"; // Replace with the recipient's email address
        $subject = "New Registration";
        $message = "
            Name: $name\n
            Phone: $phone\n
            Email: $email\n
            Course: $course\n
            Query: $query
        ";

        $headers = "From: $email";

        mail($to, $subject, $message, $headers);

        // Display the thank-you message on the website
        echo "<script>";
        echo "alert('Thanks for registration!');";
        echo "window.history.back();";  // Go back to the previous page
        echo "</script>";
        
        
    }
}
?>
