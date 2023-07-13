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
    <title>My Cart</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo_index.css">
    <link rel="stylesheet" type="text/css" href="style_buyer.css" title="style" />

    <!-- icon -->
    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <style>

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
    </style>
</head>

<body>

<!-- Start Nav Bar -->
<nav class="top-nav-bar">

    <div class="title-left">
        <img class="head_logo" src="image/tdlogo.png" alt="Logo">

        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="keyword" placeholder="Search products...">
            <button type="submit"><i class="bi bi-search-heart"></i></button>
        </form>
    </div>


    <div class="list-right">
        <ul class="list">
            <li class="list-inline-item text-center">
                <a class="text-light text-decoration-none" href="index_buyer.php"><i class="bi bi-house-fill"></i></a>
            </li>
            <li class="list-inline-item text-center">
                <a class="text-light text-decoration-none" href="product_page.php"><i class="bi bi-shop"></i></a>
            </li>
            <li class="list-inline-item text-center">
                <a class="text-light text-decoration-none" href="buyer_profile.php"><i class="bi bi-person-circle"></i></a>
            </li>
            <li class="list-inline-item text-center">
                <a class="cart_botton text-light text-decoration-none" href="cart.php"><span class="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span><i class="bi bi-cart3"></i></a>
            </li>
            <li class="list-inline-item text-center">
                <a class="text-light text-decoration-none" href="logout.php"><i class="bi bi-box-arrow-right"></i></a>
            </li>
        </ul>
    </div>
</nav>
<!-- End Nav Bar -->

<div class="bprofile_container">

    <?php if (empty($_SESSION['cart'])) : ?>
        <div class="empty-cart">
            <h2 class="bprofile_title">Your cart is empty</h2>
            <a href="product_page.php" class="continue-shopping-button">Continue Shopping</a>
        </div>
    <?php else : ?>
        <h2 class="bprofile_title">Cart</h2>

    <div class="cart_list_container">
        <div class="cart_table_container">
            <table class="cart_table">
                <tr class="cart_table">
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
                        <td><img class="cart_image" src="<?php echo $image['path']; ?>" alt="Product Image"></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td>
                            <form class="cart_quantity" action="" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $cartItem['id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $cartItem['quantity']; ?>" min="1" max="10">
                                <button type="submit" name="update_quantity" class="update-button">Update</button>
                            </form>
                        </td>
                        <td><?php echo $total; ?></td>
                        <td><a href="cart.php?remove_from_cart=<?php echo $cartItem['id']; ?>" class="remove-button">Remove</a></td>
                    </tr>
                <?php } ?>
                <tr class="cart_total" >
                    <td  colspan="4" style="text-align: right;"><strong>Total:  </strong></td>
                    <td class="cart_total">RM <?php echo $cartTotal; ?></td>
                    <td></td>
                </tr>
            </table>
            <?php endif; ?>
        </div>

        <div class="cart-buttons">
            <a href="product_page.php" class="go-back-button">Go Back</a>
            <a href="checkout.php" class="checkout-button">Checkout</a>
        </div>
    </div>

</div>


<!-- Start Footer -->
<footer class="bg-dark" id="tempaltemo_footer">

    <div class="container">

        <div class="row">

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Thrifts Depot</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        <a class="text-decoration-none" href=" ">Penang 11500 Malaysia</a>
                    </li>

                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none" href="tel:010-020-0340">010-776 0340</a>
                    </li>

                    <li>
                        <i class="fa fa-envelope fa-fw"></i>
                        <a class="text-decoration-none" href="mailto:info@company.com">thriftsdepot@gmail.com</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Categories</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="">Clothes</a></li>
                    <li><a class="text-decoration-none" href="">Books</a></li>
                    <li><a class="text-decoration-none" href="">Electronic Gadgets</a></li>
                    <li><a class="text-decoration-none" href="">Others</a></li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Learn More</h2>
                <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="about_us.php">About Us</a></li>
                        <li><a class="text-decoration-none" href="contact_us.php">Contact us</a></li>
                        <li><a class="text-decoration-none" href="faqs.php">FAQs</a></li>
                    </ul>
            </div>

        </div>

        <div class="row text-light mb-4">
            
            <div class="col-12 mb-3">
                <div class="w-100 my-3 border-top border-light"></div>
            </div>

            <div class="col-auto me-auto">
                <p class="text-left text-light">Follow us on our Social Media Platforms to get instant updates<a rel="sponsored" target="_blank"></a></p>
                <ul class="list-inline text-left footer-icons">
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.facebook.com/profile.php?id=100092172631539"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/thrifts_depot/"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
                    </li>
                </ul>
            </div>

        </div>

    </div>

    <div class="w-100 bg-black py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                    <p class="text-left text-light">
                        Copyright &copy; 2023 Thrifts Depot
                        || <a rel="sponsored" target="_blank" href="https://www.disted.edu.my/">by Disted College Students</a>
                        ||<a class="sponsored" target="_blank" href="admin_login.php"> Admin Panel</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- End Footer -->

<!-- Start Script -->
    <div>
        <script src="assets/js/jquery-1.11.0.min.js"></script>
        <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/templatemo.js"></script>
        <script src="assets/js/custom.js"></script>
    </div>
<!-- End Script -->

</body>

</html>
