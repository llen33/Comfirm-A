<?php
session_start();
@include 'config.php'; // Assuming your config file is named config.php

if (isset($_SESSION['AdminLoginId']) && isset($_POST['order_id'])) {
  $orderId = $_POST['order_id'];

  // Update the admin_status column in the test_order table
  $updateQuery = "UPDATE test_order SET admin_status = 'released' WHERE order_id = $orderId";
  $updateResult = mysqli_query($conn, $updateQuery);

  if ($updateResult) {
    // Successful update
    http_response_code(200); // OK status code
  } else {
    // Error occurred
    http_response_code(500); // Internal Server Error status code
  }
} else {
  // Invalid request
  http_response_code(400); // Bad Request status code
}
