<?php
session_start();
@include 'config.php';

// Check if user is logged in and has the role of "buyer", redirect if not
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}

// Redirect the user to the cart page if the cart is empty or not set
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    header('Location: cart.php');
    exit();
}

// Calculate the total price of all items in the cart
$totalPrice = 0;
foreach ($_SESSION['cart'] as $cartItem) {
    $totalPrice += $cartItem['price'] * $cartItem['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $buyer_id = $_SESSION['user_id'];

    // Insert order details into the orders table
    foreach ($_SESSION['cart'] as $cartItem) {
        $product_id = $cartItem['id'];
        $product_name = mysqli_real_escape_string($conn, $cartItem['name']);
        $product_price = $cartItem['price'];
        $quantity = $cartItem['quantity'];

        mysqli_query($conn, "INSERT INTO orders (buyer_id, product_id, product_name, price, quantity) VALUES ('$buyer_id', '$product_id', '$product_name', '$product_price', '$quantity')");

        // Update the product quantity in the products table
        mysqli_query($conn, "UPDATE products SET quantity = quantity - $quantity WHERE product_id = $product_id");
    }

    // Clear the cart
    $_SESSION['cart'] = [];

    // Redirect to the order confirmation page
    header('Location: order_confirmation.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <style>
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

        .total-price {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .payment-form {
            margin-top: 20px;
            text-align: center;
        }

        .payment-btn,
        .back-to-cart-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .payment-btn:hover {
            background-color: #0056b3;
        }

        .back-to-cart-btn {
            background-color: #000;
        }

        .back-to-cart-btn:hover {
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
    <div class="container">
        <h1>Checkout</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $cartItem) : ?>
                    <?php
                    // Fetch the product details from the database
                    $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE product_id = " . $cartItem['id']);
                    $product = mysqli_fetch_assoc($productQuery);

                    // Retrieve the image path for the current product
                    $imageQuery = mysqli_query($conn, "SELECT * FROM image WHERE product_id = " . $cartItem['id']);
                    $image = mysqli_fetch_assoc($imageQuery);

                    $total = $cartItem['quantity'] * $product['price'];
                    ?>
                    <tr>
                        <td><img src="<?php echo $image['path']; ?>" alt="Product Image"></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $cartItem['quantity']; ?></td>
                        <td><?php echo $total; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="total-price">
            Total Price: RM <?php echo $totalPrice; ?>
        </div>
        <div class="payment-form">
            <form action="order.php" method="post">
                <!-- Include any additional input fields for the payment form -->
                <p>Select Payment Method:</p>
                <input type="radio" id="online_payment" name="payment_method" value="online_payment">
                <label for="online_payment">Online Payment</label><br>
                <input type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery">
                <label for="cash_on_delivery">Cash on Delivery</label><br>
                <input type="radio" id="credit_debit_card" name="payment_method" value="credit_debit_card">
                <label for="credit_debit_card">Credit/Debit Card</label><br><br>

                <button type="submit" class="payment-btn">Make Payment</button>
            </form>
        </div>
        <div class="back-to-cart">
            <button class="back-button" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
        </div>
    </div>
</body>

</html>
