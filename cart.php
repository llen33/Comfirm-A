<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch the product details from the database
    $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
    $product = mysqli_fetch_assoc($productQuery);

    // Check if the cart session variable exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    $existingItem = array_search($id, array_column($_SESSION['cart'], 'id'));

    if ($existingItem !== false) {
        // Update the quantity of the existing item
        // Check if the requested quantity is greater than the available quantity in the database
        if ($quantity > $product['quantity']) {
            // Restrict the quantity update
            $quantity = $product['quantity'];
        }

        $_SESSION['cart'][$existingItem]['quantity'] = $quantity;
    }

    header('location: cart.php');
    exit();
}

if (isset($_GET['remove_from_cart'])) {
    $id = $_GET['remove_from_cart'];

    // Find the index of the item to remove
    $index = array_search($id, array_column($_SESSION['cart'], 'id'));

    // Remove the item from the cart
    if ($index !== false) {
        array_splice($_SESSION['cart'], $index, 1);
    }

    // Delete the item from the cart table
    mysqli_query($conn, "DELETE FROM cart WHERE buyer_id = $_SESSION[user_id] AND product_id = $id");

    header('location: cart.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <style>
        /* CSS styles */
        * {
            margin: 0px;
            padding: auto;
            box-sizing: border-box;
            font-family: 'Ubuntu', sans-serif;
        }

        div.header {
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 60px;
            color: black;
        }

        div.header button {
            font-size: 16px;
            padding: 8px 12px;
            border: 2px solid black;
            border-radius: 5px;
            color: white;
            background-color: black;
        }



        @import url('https://fonts.googleapis.com/css2?family=Poppins&family=Ubuntu:wght@300;700&display=swap');

        .navbar {
            background-color: #222;
            display: flex;
            justify-content: space-around;
            align-items: center;
            line-height: 5rem;
            
        }

        h2 {
            text-align: center;
        }

        .left h1 {
            font-size: 2.5rem;
            cursor: pointer;
            color: white;
        }

        .right ul {
            display: flex;
            list-style: none;
        }

        .right ul li a {
            padding: 10px 20px;
            font-size: 1.2rem;
            color: white;
            cursor: pointer;
            text-decoration: none;
            transition: all 1s;
        }

        .right ul li a:hover {
            background-color: #fff;
            border-radius: 7px;
            color: rgb(22, 7, 36);
        }

        @media screen and (max-width:805px) {
            .list {
                width: 100%;
                height: 100vh;
                background-color: rgb(22, 7, 36);
                text-align: center;
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 4rem;
                left: 100%;
                transition: all 1s;
            }
        }


        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
        }

        input[type="number"] {
            width: 50px;
            padding: 5px;
            text-align: center;
        }

        a {
            text-decoration: none;
        }

        .empty-cart {
            text-align: center;
            margin-bottom: 20px;
        }

        .empty-cart h1 {
            margin-bottom: 10px;
        }

        .continue-shopping-button {
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .continue-shopping-button:hover {
            background-color: #0056b3;
            text-decoration: none;
        }

        .cart-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .go-back-button,
        .checkout-button,
        .update-button,
        .remove-button {
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .go-back-button {
            background-color: #000;
            color: #fff;
        }

        .go-back-button:hover {
            background-color: #333;
        }

        .checkout-button {
            background-color: #007bff;
            color: #fff;
        }

        .checkout-button:hover {
            background-color: #0056b3;
        }

        .update-button {
            background-color: #ff0000;
            color: #fff;
        }

        .update-button:hover {
            background-color: #cc0000;
        }

        .remove-button {
            background-color: #000;
            color: #fff;
        }

        .remove-button:hover {
            background-color: #333;
        }
    </style>
</head>

<body>
<nav class="navbar">
        <div class="left">
            <h1>Thrifts Depot</h1>
        </div>

        <div class="right">
            <ul class="list">
                <li><a href="index_buyer.php">Home</a></li>
                <li><a href="product_page.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="buyer_profile.php">My Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <?php if (empty($_SESSION['cart'])) : ?>
        <div class="empty-cart">
            <h1>Your cart is empty</h1>
            <a href="product_page.php" class="continue-shopping-button">Continue Shopping</a>
        </div>
    <?php else : ?>
        <h1>Cart</h1>
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            $cartTotal = 0;
            foreach ($_SESSION['cart'] as $index => $cartItem) {
                // Retrieve the product details from the database
                $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE product_id = " . $cartItem['id']);
                $product = mysqli_fetch_assoc($productQuery);

                // Retrieve the image path for the current product
                $result = mysqli_query($conn, "SELECT * FROM image WHERE product_id = " . $cartItem['id']);
                $image = mysqli_fetch_assoc($result);

                // Calculate the total for the current item
                $total = $cartItem['quantity'] * $product['price'];
                $cartTotal += $total;
                ?>
                <tr>
                    <td><img src="<?php echo $image['path']; ?>" alt="Product Image"></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $cartItem['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $cartItem['quantity']; ?>" min="1" max="10">
                            <button type="submit" name="update_quantity" class="update-button">Update</button>
                        </form>
                    </td>
                    <td><?php echo $total; ?></td>
                    <td><a href="cart.php?remove_from_cart=<?php echo $cartItem['id']; ?>" class="remove-button">Remove</a></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                <td><?php echo $cartTotal; ?></td>
                <td></td>
            </tr>
        </table>
    <?php endif; ?>
    <div class="cart-buttons">
        <a href="index_buyer.php" class="go-back-button">Go Back</a>
        <a href="checkout.php" class="checkout-button">Checkout</a>
    </div>
</body>

</html>
