<?php
session_start();
include "config.php";
// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to the login page or any other page
    header("Location:index.php");
    exit();
}

// Check if user is logged in and has the role of "buyer", redirect if not
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['add_to_cart'])) {
    $id = $_GET['add_to_cart'];

    // Fetch the product details from the database
    $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
    $product = mysqli_fetch_assoc($productQuery);

    // Check if the product has available quantity
    if ($product['quantity'] <= 0) {
        // Product is out of stock, show appropriate message or redirect
        header('location: product_page.php?error=out_of_stock');
        exit();
    }

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Check if the user has the required role
        if ($_SESSION['role'] === 'buyer') {
            // Check if the user has already placed an order for the product
            $existingOrderQuery = mysqli_query($conn, "SELECT * FROM test_order WHERE product_id = $id AND user_id = {$_SESSION['user_id']}");
            if (mysqli_num_rows($existingOrderQuery) > 0) {
                // User has already placed an order, show appropriate message or redirect
                header('location: product_page.php?error=already_ordered');
                exit();
            }

            // Add the product to the cart
            $cartItem = [
                'id' => $product['product_id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];

            // Check if the cart session variable exists
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // Check if the product is already in the cart
            $existingItem = array_search($product['product_id'], array_column($_SESSION['cart'], 'id'));

            if ($existingItem !== false) {
                // Update the quantity of the existing item
                $_SESSION['cart'][$existingItem]['quantity'] += 1;
            } else {
                // Add the new item to the cart
                $_SESSION['cart'][] = $cartItem;
            }

            header('location: cart.php');
            exit();
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

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Retrieve the list of products from the database
$productQuery = mysqli_query($conn, "SELECT * FROM products");
$products = mysqli_fetch_all($productQuery, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrifts Depot - Welcome</title>

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
   
   

<!-- Start Banner Hero -->
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
                <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="row p-5">
                                <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                    <img class="img-fluid" src="disted.png" alt="Disted Logo">
                                </div>
                                <div class="col-lg-6 mb-0 d-flex align-items-center">
                                    <div class="text-align-left align-self-center">
                                        <h1 class="h1 text-success"><b>Thrifts Depot</b> Disted College</h1>
                                        <p>
                                            Are you looking forward to sell or buy thrifts items? Great! You are at right
                                            desitnation. Click here to find out more <a rel="sponsored" class="text-success" href="signup.php" target="_blank"> Register Now to get Started</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row p-5">
                                <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                    <img class="img-fluid" src="mypromo.png" alt="Promotion Banner">
                                </div>
                                <div class="col-lg-6 mb-0 d-flex align-items-center">
                                    <div class="text-align-left">
                                        <h1 class="h1">IS Mid Year SALE!!</h1>
                                        <h3 class="h2">Thrifts Depot</h3>
                                        <p>
                                            The long-awaited mid year sale is here!!! <br>
                                            UP TO 50% OFF on the selacted items and Get another 10% OFF when you spend more than RM80.<br>
                                            <a href="test.php"> Shop it now! -> </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row p-5">
                            <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                <img class="img-fluid" src="assets/img/thriftspic3.jpg" alt="">
                            </div>
                            <div class="col-lg-6 mb-0 d-flex align-items-center">
                                <div class="text-align-left">
                                    <h1 class="h1">Become a Seller Today</h1>
                                    <h3 class="h2">Thrifts Depot</h3>
                                    <p>A lot of stuff around the house? Lost feel waste, give away feel pity?<br> You are at right desitnation. Put your unused items up for sale on our website now.<br>
                                        <a rel="sponsored" class="text-success" href="signup.php" target="_blank">Click ME to Become a SELLER NOW !!!;)</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
                <i class="fas fa-chevron-left"></i>
            </a>
            <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
                <i class="fas fa-chevron-right"></i>
            </a>
    </div>
<!-- End Banner Hero -->

<!-- Start Featured Product -->
    <section class="container py-5">
        <div class="row text-center pt-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Featured Product</h1>
            </div>
        </div>

        <div class="row">
            <div class="product-list">
                <?php 
                    $counter = 0;
                    foreach ($products as $product) :
                    // Fetch the product quantity from the database
                    $quantityQuery = mysqli_query($conn, "SELECT quantity FROM products WHERE product_id = " . $product['product_id']);
                    $quantityResult = mysqli_fetch_assoc($quantityQuery);
                    $productQuantity = $quantityResult['quantity'];

                    // Fetch the order quantity from the database for the particular product_id
                    $orderQuantityQuery = mysqli_query($conn, "SELECT SUM(quantity) AS total_quantity FROM test_order WHERE product_id = " . $product['product_id']);
                    $orderQuantityResult = mysqli_fetch_assoc($orderQuantityQuery);
                    $orderQuantity = $orderQuantityResult['total_quantity'];

                    // Check if the product is unavailable
                    $isUnavailable = ($productQuantity <= $orderQuantity);
                ?>
                
                <?php
                    // Check if the product is unavailable and the counter is less than 4
                    if (!$isUnavailable && $counter < 4) :
                    $counter++; // Increment the counter
                ?>
            
                <div class="card">
                    <div class="card-image">
                        <?php
                            // Retrieve images for the current product
                            $productId = $product['product_id'];
                            $result = mysqli_query($conn, "SELECT * FROM image WHERE product_id = $productId");
                            $images = mysqli_fetch_all($result, MYSQLI_ASSOC);

                            if (!empty($images)) {
                                $image = $images[0];
                                echo '<img src="' . $image['path'] . '" alt="Product Image">';
                            }
                        ?>
                    </div>

                    <div class="card-details">
                        <h3 class="card-title"><?php echo $product['name']; ?></h3>
                        <p class="card-price">Price: RM <?php echo $product['price']; ?></p>
                        <p class="card-description"><?php echo $product['description']; ?></p>
                        <p class="card-category">Category: <?php echo $product['category']; ?></p>

                        <form action="product_page.php" method="get">
                            <input type="hidden" name="add_to_cart" value="<?php echo $product['product_id']; ?>">
                            <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>" class="view-more-button">View More</a>
                        </form>
                    </div>
                </div>
                <?php 
                    endif;
                ?>
                <?php 
                endforeach; 
                ?>
            </div> 

            <p class="text-center"><a class="btn btn-success" href="product_page.php">Shop Now</a></p>
        </div>
    </section>
<!-- End Featured Product -->


<!-- Start Our Story -->
<div class="our_story_container">
    <div class="our_story_form">

        <img class="story_image" src="story.JPG" alt="Image">

        <div class="overlay">
            <p> The main reason we created this website is to avoid wasting resources in a world where people are used to throwing them away, 
                or sitting idle, hoarding and piling up garbage over time. After my friends knew my idea, they agreed that they had the same feeling, 
                and we started our business road.....
            </p>
        </div>

        <div class="story_button">
            <a href="our_story.php" class="our_story_button">Read On</a>
        </div>
    </div>
</div>
<!-- End Our Story -->


<!-- for bottom space -->
<div class="bprofile_container">
    <p>  </p>
</div>
<!-- end bottom space -->


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
                        <li><a class="text-decoration-none" href="our_story.php">About Us</a></li>
                        <li><a class="text-decoration-none" href="">Contact us</a></li>
                        <li><a class="text-decoration-none" href="">FAQs</a></li>
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