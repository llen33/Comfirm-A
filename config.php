<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'student_marketplace');

// Database configuration
$hostname = "localhost";
$username = "root";
$password = "";
$db_name = "student_marketplace" ;

// Establish a database connection
$conn = mysqli_connect($hostname, $username, $password, $db_name);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
