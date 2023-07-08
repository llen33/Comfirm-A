<?php
require_once 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate and sanitize the data if needed

    // Create a new database connection
    $conn = mysqli_connect($hostname, $username, $password, $db_name);

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO contact (name, user_email, subject, contact_desc) VALUES ('$name', '$email', '$subject', '$message')";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
        // Data inserted successfully
        echo "<script>alert('Thank you for your submission.'); window.location.href = 'index.php';</script>";
        exit;
    } else {
        // Error occurred while inserting data
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
