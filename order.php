<?php
session_start();
@include 'config.php';

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header('location: cart.php');
    exit();
}

// Check if the user is logged in as a buyer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header('location: login.php');
    exit();
}

// Retrieve the user ID from the session
$userId = $_SESSION['user_id'];

// Retrieve the selected payment method from the form
$paymentMethod = $_POST['payment_method'];

// Prepare the insert statement
$insertQuery = "INSERT INTO test_order (user_id, product_id, name, quantity, price, total, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $insertQuery);

if (!$stmt) {
    // Handle the error if the statement preparation fails
    die('Error: Unable to prepare the statement.');
}

// Insert order details into the test_order table
foreach ($_SESSION['cart'] as $cartItem) {
    $productId = $cartItem['id'];
    $productName = $cartItem['name'];
    $quantity = $cartItem['quantity'];
    $price = $cartItem['price'];
    $total = $price * $quantity;

    // Bind the parameters to the statement
    mysqli_stmt_bind_param($stmt, "iisidss", $userId, $productId, $productName, $quantity, $price, $total, $paymentMethod);

    // Execute the statement
    mysqli_stmt_execute($stmt);
}

// Clear the cart after the order is placed
unset($_SESSION['cart']);

// Close the statement
mysqli_stmt_close($stmt);

header('location: order_confirmation.php');
exit();
?>
