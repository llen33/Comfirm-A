<!-- This code is written by Eng Jing Yi (CSD21005) -->

<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    @include 'add_product_config.php';
    $id = $_GET['edit'];

    if (isset($_POST['edit_product'])) {

        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_description = $_POST['product_description'];
        $product_category = $_POST['product_category'];
        $product_quantity = $_POST['product_quantity'];
        $product_condition = $_POST['product_condition'];

        $product_new_images = $_FILES['product_image'];
        $product_old_images = $_POST['product_old_image'];

        if (!empty(array_filter($product_new_images['name']))) {

            $target_directory = "uploaded_img/"; // Set your desired directory
            $new_image_paths = [];

            foreach ($product_new_images['tmp_name'] as $key => $tmp_name) {

                $image_name = basename($product_new_images['name'][$key]);
                $target_path = $target_directory . $image_name;
                move_uploaded_file($tmp_name, $target_path);
                $new_image_paths[] = $target_path;

            }

            // Update the image paths in the database
            $product_id = $id;
            $query = "DELETE FROM image WHERE product_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);

            foreach ($new_image_paths as $key => $path) {

                $query = "INSERT INTO image (product_id, path) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "is", $product_id, $path);
                mysqli_stmt_execute($stmt);

            }

        }

        // Check if the product belongs to the logged-in seller
        $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
        $product = mysqli_fetch_assoc($productQuery);

        if ($product['seller_id'] == $_SESSION['seller_id']) {

            $edit = "UPDATE products SET name = ?, price = ?, description = ?, category = ?, quantity = ?, product_condition = ? WHERE product_id = ?";
            $stmt = mysqli_prepare($conn, $edit);
            mysqli_stmt_bind_param($stmt, "ssssisi", $product_name, $product_price, $product_description, $product_category, $product_quantity, $product_condition, $id);
            $upload = mysqli_stmt_execute($stmt);

            if ($upload) {

                header('location: product_list.php');
                exit();

            } else {

                echo "Error updating the product.";

            }
        } else {

            echo "You are not authorized to edit this product.";

        }

    };
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

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


        <h2 class="sprofile_title">Edit Product</h2>

        <div class="sprofile_container">
            <div class="form_container">
                <div class="edit-product-form-container">

                    <?php
                    
                        $select = mysqli_query($conn, "SELECT * FROM products WHERE product_id = '$id' ");

                        $rows = mysqli_fetch_all($select, MYSQLI_ASSOC);
                    
                    ?>

                    <?php 
                        
                        foreach ($rows as $row): 
                        
                    ?>

                        <form name="edit-product" action="" method="post" enctype="multipart/form-data" onsubmit="return confirmEditProduct();">

                                <div class="p_name"> 
                                    <label for="product-name" class="l_name">Product Name:</label><br>  <!-- l_name = label for product name -->
                                    <input type="text" placeholder="Enter Product Name" value="<?php echo $row['name']; ?>" name="product_name" 
                                        class="name" required oninvalid="this.setCustomValidity('Please fill in your product name.')" 
                                        oninput="this.setCustomValidity('')"><br>
                                </div>

                                <div class="p_price">
                                    <label for="product-price" class="l_price">Product Price (RM):</label><br>
                                    <input type="text" placeholder="Enter Product Price (RM)" value="<?php echo $row['price']; ?>" 
                                        name="product_price" pattern="^[0-9]+\.?[0-9]{2}$" class="price" required 
                                            oninvalid="this.setCustomValidity('Please fill in your product price.\nThe price must in 2 decimal places.\nFor example: 123.45')"
                                                oninput="this.setCustomValidity('')"><br>
                                </div>

                                <div class="p_description">
                                    <label for="product-description" class="l_description">Product Description:</label><br>
                                    <textarea placeholder="Enter Product Description..." name="product_description" class="description" 
                                        required oninvalid="this.setCustomValidity('Please fill in your product description.')"
                                            oninput="this.setCustomValidity('')"><?php echo $row['description']; ?></textarea><br>
                                </div>

                                <div class="p_category">
                                    <label for="product-category" class="l_category">Product Category:</label><br>
                                    <select name="product_category" class="category" required 
                                        oninvalid="this.setCustomValidity('Please select a category for your product.')"
                                            oninput="this.setCustomValidity('')">
                                        <option value="" selected disabled hidden>Select a Category</option>
                                        <option value="Stationary"  <?php if($row['category']=="Stationary") echo 'selected="selected"'; ?> >Stationaries</option>
                                        <option value="Book"        <?php if($row['category']=="Book") echo 'selected="selected"'; ?>       >Books</option>
                                        <option value="Cloth"       <?php if($row['category']=="Cloth") echo 'selected="selected"'; ?>      >Clothes</option>
                                        <option value="Electronic"  <?php if($row['category']=="Electronic") echo 'selected="selected"'; ?> >Electronic Items</option>
                                    </select><br>
                                </div>

                                <div class="p_quantity">
                                    <label for="product-quantity" class="l_quantity">Product Quantity:</label><br>                            
                                    <input type="number" placeholder="Quantity" value="<?php echo $row['quantity']; ?>" name="product_quantity" 
                                        class="quantity" required oninvalid="this.setCustomValidity('Please fill in your product quantity.')"
                                            oninput="this.setCustomValidity('')"><br>
                                </div>

                                <div class="p_condition">
                                    <label for="product-condition" class="l_condition">Product Condition:</label><br>
                                    <textarea placeholder="Enter Product Condition..." name="product_condition" class="condition" 
                                        required oninvalid="this.setCustomValidity('Please fill in your product condition.')"
                                            oninput="this.setCustomValidity('')"><?php echo $row['product_condition']; ?></textarea><br>
                                </div>

                                <div class="p_image">
                                    <label for="product-image" class="l_image">Product Image:</label><br> 
                                    <?php

                                        // Retrieve images for the current product
                                        $product_id = $row['product_id'];
                                        $result = mysqli_query($conn, "SELECT * FROM image WHERE product_id = $product_id");
                                        $images = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                    ?>
                                    <?php 
                                    
                                        foreach ($images as $image): 
                                
                                    ?>
                                    <input type="hidden" name="product_old_image[]" value="<?= $image['path'] ?>">
                                    <?php

                                        endforeach; 

                                    ?>
                                    <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image[]" multiple sclass="image"><br>
                                </div>

                                <div class="p_current_image">
                                    <label for="product-current-image" class="l_current_image">Current Image: </label><br>
                                    <br>
                                    <?php 
                                    
                                        foreach ($images as $image): 
                                    
                                    ?>
                                            <img src="<?= $image['path'] ?>" height="100" alt="Product Image">

                                    <?php

                                        endforeach; 

                                    ?>
                                </div>

                                <!-- Button -->
                                <div class="p_submit">
                                    <button type="submit" class="edit-product-button" name="edit_product"><i class="fas fa-save"></i> Save</button>
                                </div>

                                <div class="back">
                                    <a href="product_list.php" class="product-list-button"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                        </form>

                        <?php 

                            endforeach; 

                        ?>

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
        <script src="edit_product_javascript.js"></script>
    </div>
<!-- End Script -->
        
</body>

</html>