<?php
session_start();
@include 'config.php';
if (!isset($_SESSION['AdminLoginId'])) {
    header("Location: admin_login.php");
    exit();
}

// Retrieve the selected month and year from the query parameters
$month = $_GET['month'];
$year = $_GET['year'];

// Retrieve sales data for the specified month and year
$query = "SELECT DATE(order_date) AS order_date, COUNT(DISTINCT CONCAT(DATE(order_date), order_id)) AS sales_count FROM test_order WHERE MONTH(order_date) 
= $month AND YEAR(order_date) 
= $year GROUP BY DATE(order_date)";
$result = mysqli_query($conn, $query);

// Initialize arrays for chart data
$dates = array();
$sales = array();

// Process the sales data
while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row['order_date'];
    $sales[] = $row['sales_count'];
}

// Prepare the response as JSON
$response = array(
    'dates' => $dates,
    'sales' => $sales
);

header('Content-Type: application/json');
echo json_encode($response);
