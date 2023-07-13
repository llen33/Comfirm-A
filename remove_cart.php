<?php
session_start();

if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];

    // Remove the selected product from the cart
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}

header('location: cart.php');
exit();
?>
