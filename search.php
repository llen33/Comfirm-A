<?php
include "config.php";

// Check if the keyword is provided in the URL
if (isset($_GET['keyword'])) {
    // Sanitize the keyword to prevent SQL injection
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);

    // Query the database to search for products matching the keyword
    $query = "SELECT * FROM products WHERE name LIKE '%$keyword%'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
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
        @media screen and (max-width: 805px) {
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

    </nav>
<!-- End Nav Bar -->

    <div class="bprofile_container">
        <section class="container py-5">
            <div class="row">
                <div class="product-list">
                    <?php if (!empty($rows)) : ?>
                        <?php foreach ($rows as $row) : ?>
                            <!-- Display the search results -->
                            <div class="card">
                                <div class="card-image">
                                    <?php
                                    // Retrieve images for the current product
                                    $product_id = $row['product_id'];
                                    $result = mysqli_query($conn, "SELECT * FROM image WHERE product_id = $product_id");
                                    $images = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                    if (!empty($images)) {
                                        $image = $images[0];
                                        echo '<img src="' . $image['path'] . '" alt="Product Image">';
                                    }
                                    ?>
                                </div>
                                <div class="card-details">
                                    <h3 class="card-title"><?php echo $row['name']; ?></h3>
                                    <p class="card-price">Price: RM <?php echo $row['price']; ?></p>
                                    <p class="card-description"><?php echo $row['description']; ?></p>
                                    <p class="card-category">Category: <?php echo $row['category']; ?></p>

                                    <form action="config.php" method="post">
                                        <p class="card-quantity">
                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                        </p>
                                        <p class="card-condition">Condition: <?php echo $row['product_condition']; ?></p>
                                        <a href="product_details.php?product_id=<?php echo $row['product_id']; ?>" class="view-more-button">View More</a>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No products found matching your search.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
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
                                <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                            </li>
                            <li class="list-inline-item border border-light rounded-circle text-center">
                                <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
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

</body>

</html>