<!-- This code is written by Eng Jing Yi (CSD21005) -->

<?php
// ship_out.php

// Include the necessary configuration and database connection files
@include 'add_product_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Process ship out request
    if (isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];
    
    // Update order status to "Shipped" in the database
    $updateQuery = "UPDATE test_order SET status = 'Shipped' WHERE order_id = $orderId";
    $updateResult = mysqli_query($conn, $updateQuery);
    
    if (!$updateResult) {
        die("Error: " . mysqli_error($conn));
    }
}
}
?>
