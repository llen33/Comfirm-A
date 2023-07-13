<?php
// Database configuration
$hostname = "localhost";
$username = "root";
$password = "";
$db_name = "student_marketplace23" ;

// Establish a database connection
$conn = mysqli_connect($hostname, $username, $password, $db_name);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
