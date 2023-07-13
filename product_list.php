<!-- This code is written by Eng Jing Yi (CSD21005) -->

<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    @include 'add_product_config.php';

    if (isset($_GET['delete'])) {

        $id = $_GET['delete'];
    
        // Fetch the product details from the database
        $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
        $product = mysqli_fetch_assoc($productQuery);
    
        // Check if the product belongs to the logged-in seller
        if ($product['seller_id'] == $_SESSION['seller_id']) {

            // Proceed with the delete operation
            mysqli_query($conn, "DELETE FROM image WHERE product_id = $id");
            mysqli_query($conn, "DELETE FROM products WHERE product_id = $id");
            header('location: product_list.php');
            exit();

        }

    };

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Product</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo_index.css">
    <link rel="stylesheet" type="text/css" href="style_seller.css" title="style" />


    <!-- icon -->
    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


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
<!-- class is for css to identify-->
<!-- name is for php to post -->

<!-- Start Nav Bar -->
<nav class="top-nav-bar">

    <div class="title-left">
        <h2 class="head_title"> Thrifts Depot Seller Centre </h2>
    </div>

    <div class="list-right">
        <ul class="list">
            <li class="list-inline-item text-center">
                <a class="text-light text-decoration-none" href="index_seller.php"><i class="bi bi-house-fill"></i></a>
            </li>
            <li class="list-inline-item text-center">
                <a class="text-light text-decoration-none" href="seller_profile.php"><i class="bi bi-person-circle"></i></i></a>
            </li>
            <li class="list-inline-item text-center">
                <a class="text-light text-decoration-none" href="logout.php"><i class="bi bi-box-arrow-right"></i></a>
            </li>
        </ul>
    </div>

</nav>
<!-- End Nav Bar -->


    <div class="flex-container">
        <div class="flex-item-left"><a href="product_list.php">My Product</a></div>
        <div class="flex-item-centre"><a href="add_product.php">Add Product</a></div>
        <div class="flex-item-right"><a href="seller_order.php">My Order</a></div>
    </div>

        <h2 class="sprofile_title">Product List</h2>
        
        <div class="sprofile_container">

            <div class="product_list_container">
                <?php

                    $select = mysqli_query($conn, "SELECT * FROM products WHERE seller_id = ".$_SESSION['seller_id']);
                    $rows = mysqli_fetch_all($select, MYSQLI_ASSOC);

                ?>

                <div class="product-list">

                    <table class="product-list-table">

                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Price (RM)</th>
                                <th>Product Description</th>
                                <th>Product Category</th>
                                <th>Product Quantity</th>
                                <th>Product Condition</th>
                                <th>Product Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <?php 
                        
                            foreach ($rows as $row): 
                            
                        ?>

                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['category']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['product_condition']; ?></td>
                                <td>

                                    <?php
                                        // Retrieve images for the current product
                                        $product_id = $row['product_id'];
                                        $result = mysqli_query($conn, "SELECT * FROM image WHERE product_id = $product_id");
                                        $images = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                    ?>

                                    <?php 
                                    
                                        foreach ($images as $image): 
                                    
                                    ?>
                                            <img src="<?= $image['path'] ?>" height="100" alt="Product Image">

                                    <?php

                                        endforeach; 

                                    ?>

                                </td>
                                <td class="product_list_button">
                                    <a href = "edit_product.php?edit=<?php echo $row['product_id']; ?>" class = "edit-product-button">
                                        <i class="fas fa-edit"></i> Edit</a><br>
                                    <a href="seller_ratings.php?product_id=<?php echo $row['product_id']; ?>" class="view_rating_button">
                                    <i class="fa fa-star"></i> View Rate</a><br>
                                    <a href = "product_list.php?delete=<?php echo $row['product_id']; ?>" class = "delete-product-button" 
                                        onclick="return confirmDeleteProduct();"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr> 

                        <?php 

                            endforeach; 

                        ?>

                    </table>

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
                    <li><a class="text-decoration-none" href="about.html">About Us</a></li>
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
        <script src="product_list_javascript.js"></script>
    </div>
<!-- End Script -->

</body>

</html>