<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

@include 'config.php';
// Check if user is logged in and has the role of "buyer", redirect if not
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve the product details from the database based on the product ID
    $result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
    $product = mysqli_fetch_assoc($result);

    // Check if the product exists
    if (!$product) {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid product ID.";
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $quantity = $_POST['quantity'];

    // Fetch the product details from the database
    $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
    $product = mysqli_fetch_assoc($productQuery);

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Check if the user has the required role
        if ($_SESSION['role'] === 'buyer') {
            // Check if the product quantity is greater than 0
            if ($product['quantity'] > 0) {
                // Check if the requested quantity is greater than the available quantity
                if ($quantity > $product['quantity']) {
                    echo '<script>alert("Requested quantity is greater than the available quantity.");</script>';
                } else {
                    // Check if the product is already in the cart
                    $existingItem = array_search($product['product_id'], array_column($_SESSION['cart'], 'id'));

                    if ($existingItem !== false) {
                        // Product is already in the cart
                        echo '<script>alert("Product is already in the cart.");</script>';
                    } else {
                        // Add the product to the cart
                        $cartItem = [
                            'id' => $product['product_id'],
                            'name' => $product['name'],
                            'price' => $product['price'],
                            'quantity' => $quantity
                        ];

                        // Check if the cart session variable exists
                        if (!isset($_SESSION['cart'])) {
                            $_SESSION['cart'] = [];
                        }

                        // Add the new item to the cart
                        $_SESSION['cart'][] = $cartItem;

                        // Insert cart details into the cart table
                        $buyer_id = $_SESSION['user_id'];
                        $cart_item_id = mysqli_real_escape_string($conn, $product['product_id']);
                        $cart_item_quantity = mysqli_real_escape_string($conn, $quantity);

                        $insertQuery = mysqli_query($conn, "INSERT INTO cart (buyer_id, product_id,  quantity) VALUES ('$buyer_id', '$cart_item_id',  '$cart_item_quantity')");

                        if ($insertQuery) {
                            echo '<script>alert("Product added to cart.");</script>';
                        } else {
                            echo '<script>alert("Failed to add product to cart.");</script>';
                        }
                    }
                }
            } else {
                // Product quantity is 0, cannot add to cart
                echo '<script>alert("Product quantity is 0. Cannot add to cart.");</script>';
            }
        } else {
            // User doesn't have the required role, redirect to an unauthorized page
            header('location: unauthorized.php');
            exit();
        }
    } else {
        // User is not logged in, redirect to the login page
        header('location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <style>
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

        /* Add your custom styles here */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            align-items: flex-start;
        }

        .container {
            display: flex;
        }

        .left {
            flex: 1;
        }

        .right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .right textarea {
            width: 300px;
            height: 200px;
            padding: 5px;
            margin-bottom: 10px;
        }

        .right input[type="submit"] {
            width: 100px;
        }

        .cart-icon {
            /* Your existing CSS for the cart icon */
            position: fixed;
            top: 150px;
            right: 20px;
        }

        .cart-icon i {
            font-size: 24px;
            color: black
        }

        .cart-icon .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: grey;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;

        }

        /* Basic Styling */
        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px;
            display: flex;
        }

        /* Left Column */
        .left-column {
            width: 40%;
            position: relative;
        }

        .left-column img {
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .left-column img.active {
            opacity: 1;
        }

        /* Right Column */
        .right-column {
            width: 60%;
            margin-top: 60px;
            margin-left: 20px;
            /* Add left margin to create space between image and details */
        }


        /* Product Description */
        .product-description {
            border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;
        }

        .product-description h1 {
            font-weight: 300;
            font-size: 52px;
            color: #43484D;
            letter-spacing: -2px;
        }

        .product-description p {
            font-size: 16px;
            font-weight: 300;
            color: #86939E;
            line-height: 24px;
        }

        /* Product Configuration */
        .product-configuration {
            border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;
        }

        .product-configuration span {
            font-size: 12px;
            color: #358ED7;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
        }

        .product-configuration button {
            border: 2px solid #E1E8EE;
            border-radius: 6px;
            padding: 13px 20px;
            font-size: 14px;
            color: #5E6977;
            background-color: #fff;
            cursor: pointer;
            transition: all .5s;
        }

        .product-configuration button:hover,
        .product-configuration button:active,
        .product-configuration button:focus {
            border: 2px solid #86939E;
            outline: none;
        }

        /* Product Color */
        .product-color {
            margin-bottom: 30px;
        }

        .color-choose div {
            display: inline-block;
        }

        label span {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin: -1px 4px 0 0;
            vertical-align: middle;
            cursor: pointer;
            border-radius: 50%;
        }

        #red+label span {
            background-color: #C91524;
        }

        #blue+label span {
            background-color: #314780;
        }

        #black+label span {
            background-color: #323232;
        }

        .product-price {
            display: flex;
            align-items: center;
        }

        .product-price span {
            font-size: 26px;
            font-weight: 300;
            color: #43474D;
            margin-right: 20px;
        }

        .add-to-cart-button {
            display: inline-block;
            background-color: gray;
            color: #FFF;
            text-align: center;
            padding: 18px 30px;
            border-radius: 6px;
            transition: all .5s;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .add-to-cart-button:hover {
            background-color: black;
        }

        /* Responsive */
        @media (max-width: 940px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .left-column,
            .right-column {
                width: 100%;
            }

            .left-column img {
                width: 10%;
                right: 0;
                top: -65px;
                left: initial;
            }
        }

        @media (max-width: 535px) {
            .left-column img {
                width: 10%;
                top: -85px;
            }
        }

        /*seller css */
        .seller-details {
            margin-top: 30px;
            border-top: 1px solid #E1E8EE;
            padding-top: 20px;
        }

        .seller-heading {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .seller-info {
            display: grid;
            grid-template-columns: auto auto;
            grid-gap: 10px;
        }

        .seller-info-row {
            display: flex;
            align-items: center;
        }

        .seller-info-label {
            width: 80px;
            font-weight: bold;
        }

        .seller-info-value {
            flex: 1;
        }

        /* Additional styling for better visual appeal */
        .seller-info-label::after {
            content: ":";
            margin-right: 5px;
        }

        .seller-info-value {
            color: #43474D;
        }

        .seller-info-value a {
            color: #007BFF;
            text-decoration: none;
        }

        .seller-info-value a:hover {
            text-decoration: underline;
        }

        .seller-container {
            background-color: #fff;
            padding: 20px;
            margin-top: 30px;
        }

        .seller-heading {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .seller-details {
            margin-left: 20px;
        }

        .seller-info-row {
            margin-bottom: 10px;
        }

        .seller-info-label {
            font-weight: bold;
        }

        .seller-info-value {
            margin-left: 10px;
        }

        .gold-star {
            color: gold;
        }

        .white-star {
            color: #ccc;
        }

        /* rating css */
        .product-review-container {
            margin-top: 20px;
        }

        .review-heading {
            font-size: 24px;
            font-weight: bold;
        }

        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .username {
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
        }

        .stars {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .gold-star {
            color: gold;
        }

        .white-star {
            color: #ccc;
        }

        .description {
            font-size: 14px;
            line-height: 1.4;
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


    <div class="cart-icon">
        <a href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count"><?php echo count($_SESSION['cart']); ?></span>
        </a>
    </div>

    <main class="container">
        <!-- Left Column -->
        <div class="left-column">
            <?php
            // Retrieve and display the first product image
            $result = mysqli_query($conn, "SELECT * FROM image WHERE product_id = $product_id");
            $image = mysqli_fetch_assoc($result);
            if ($image) {
                echo '<img src="' . $image['path'] . '" alt="Product Image" class="img-fluid active">';
            } else {
                echo '<img src="path_to_default_image.jpg" alt="Product Image" class="img-fluid active">';
            }
            ?>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <div class="product-description">
                <h1><?php echo $product['name']; ?></h1>
                <h2><span>RM: <?php echo $product['price']; ?></span></h2>
            </div>

            <div class="product-configuration">

                <div class="cable-config">
                    <span>About this product
                    </span>
                    <div class="cable-choose">
                        <p class="description">Description : <?php echo $product['description']; ?></p>
                        <p class="category">Category: <?php echo $product['category']; ?></p>
                        <p class="category">Condition: <?php echo $product['product_condition']; ?></p>
                        <p class="category">Quantity Available: <?php echo $product['quantity']; ?></p>
                    </div>
                </div>
            </div>

            <div class="product-price">

                <form method="post">
                    <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                    <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                </form>
            </div>
        </div>
    </main>

    <?php
    // Retrieve and display the seller details
    $result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
    $product = mysqli_fetch_assoc($result);
    if ($product) {
        $seller_id = $product['seller_id'];
        $seller_result = mysqli_query($conn, "SELECT * FROM users INNER JOIN seller ON users.user_id = seller.user_id WHERE seller.seller_id = $seller_id");
        $seller = mysqli_fetch_assoc($seller_result);
        if ($seller) {
            $seller_name = $seller['firstname'];
            $seller_email = $seller['email'];
            $seller_phone = $seller['phone_number'];

            // Seller details HTML
    ?>
            <div class="seller-container">
                <h2 class="seller-heading">Seller Details</h2>
                <div class="seller-details">
                    <div class="seller-info-row">
                        <span class="seller-info-label">Name</span>
                        <span class="seller-info-value"><?php echo $seller_name; ?></span>
                    </div>
                    <div class="seller-info-row">
                        <span class="seller-info-label">Email</span>
                        <div class="seller-email">
                            <a href="mailto:<?php echo $seller['email']; ?>">Contact the seller</a>
                        </div>
                    </div>
                    <div class="seller-info-row">
                        <span class="seller-info-label">Phone</span>
                        <span class="seller-info-value"><?php echo $seller_phone; ?></span>
                    </div>
                </div>

            </div>
    <?php
        }
    }



    ?>
    <!-- Product Review Container -->
    <div class="product-review-container">
        <h2>Products Reviews</h2>
        <!-- Display product reviews here -->
        <!-- Product Review Container -->
        <div class="product-review-container">
            <div class="container">
                <div class="review-list">
                    <ul>
                        <?php
                        // Fetch the rating details from the database for the current product ID
                        $ratingQuery = mysqli_query($conn, "SELECT br.rating_date,br.rating_date,br.rating, br.description, br.buyer_id, u.username
                FROM buyer_rate br
                INNER JOIN buyer b ON br.buyer_id = b.buyer_id
                INNER JOIN users u ON b.user_id = u.user_id
                INNER JOIN test_order ord ON br.order_id = ord.order_id
                WHERE ord.product_id = $product_id");



                        // Check if any ratings are available
                        if (mysqli_num_rows($ratingQuery) > 0) {
                            // Display the ratings
                            while ($rating = mysqli_fetch_assoc($ratingQuery)) {
                                echo '<li>';
                                echo '<div class="d-flex align-items-center">';
                                echo '<div class="right">';
                                echo '<h4 class="username">';
                                echo $rating['username'];
                                echo '</h4>';
                                echo '</div>';

                                // Calculate the number of gold stars
                                $goldStars = floor($rating['rating']);


                                echo '<div class="stars ml-3">';

                                // Display gold stars
                                for ($i = 0; $i < $goldStars; $i++) {
                                    echo '<i class="fas fa-star gold-star"></i>';
                                }

                                // Calculate the remaining white stars
                                $whiteStars = 5 - $goldStars;

                                // Display white stars
                                for ($i = 0; $i < $whiteStars; $i++) {
                                    echo '<i class="far fa-star white-star"></i>';
                                }

                                echo '</div>';

                                echo '</div>';
                                echo '<div class="country d-flex align-items-center">';
                                echo '</div>';
                                echo '<div class="review-description">';
                                echo '<p>';
                                echo $rating['description'];
                                echo '</p>';
                                echo $rating['rating_date'];
                                echo '</div>';
                                echo '</li>';
                            }
                        } else {
                            // No ratings available
                            echo '<li>';
                            echo '<div class="d-flex">';
                            echo '<div class="right">';
                            echo '<h4>No reviews available</h4>';
                            echo '</div>';
                            echo '</div>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- Display product reviews here -->
        </div>

    </div>


    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>

</body>

</html>