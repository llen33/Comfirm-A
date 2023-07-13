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
    <h2 class="bprofile_title">Our Story</h2>
    
        <div class="story_form">
            <p>
                The main reason we created this website is to avoid wasting resources in a world where people are used to throwing them away, 
                or sitting idle, hoarding and piling up garbage over time.
            </p>
            <p>
                After my friends knew my idea, they agreed that they had the same feeling, and we started our business road. 
                We thought it would be a good way to save resources and earn some pocket money for ourselves. Why not?
            </p>
            <p>
                Our story began with a chance encounter, a moment that seemed insignificant at first, 
                but little did we know it would mark the beginning of an extraordinary journey. 
                As we got to know each other, the initial sparks of connection ignited a flame that would grow into something beautiful and enduring.
            </p>
            <p>
                From that moment forward, we embarked on countless adventures together, 
                traversing both the highs and lows that life presented. Through laughter and tears, 
                triumphs and challenges, we stood by each other's side, offering unwavering support and love. 
                Together, we built a foundation of trust, understanding, and respect that became the bedrock of our relationship.
            </p>
            <p>
                As time went on, our story evolved, and so did we. 
                We celebrated milestones and achievements, always celebrating each other's successes as if they were our own. 
                We weathered storms and faced adversity, finding solace in the strength we drew from one another. 
                With every obstacle we overcame, our bond grew stronger, a testament to our resilience and commitment.
            </p>
            <p>
                But our story is not only about the grand moments and significant milestones. 
                It is also woven with the threads of everyday life, the simple joys of shared laughter, and the comfort found in the ordinary. 
                It is in those seemingly mundane moments that we discovered the true essence of our love, 
                finding happiness in the smallest of gestures and the quiet understanding that can only come from a deep connection.
            </p>
            <p>
                Our story is a tapestry of memories, a collection of chapters that reflect the depth and breadth of our relationship. 
                It is a story that we continue to write together, with each passing day adding new pages filled with love, growth, and infinite possibilities.
            </p>
            <p>
                As we look back on our journey so far, we are filled with gratitude for the twists and turns that led us to each other.
                We cherish the memories we have created and eagerly anticipate the ones that lie ahead. Our story is an ongoing narrative, 
                one that will continue to unfold as we navigate the joys and challenges of life together.
            </p>
            <p>
                In the end, our story is not just about two individuals, but about the power of love and the transformative nature of companionship. 
                It is a testament to the beauty of human connection and the infinite possibilities that exist when two hearts align.
            </p>
            <p>
                Our story is a reminder that love is a journey, and we are grateful to have found our perfect travel companion. 
                Together, we will continue to write the chapters of our lives, creating a story that is uniquely ours and forever cherished in our hearts.
            </p>
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
</body>
</html>
