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
        <title>Edit Product Page</title>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- custom css file link -->
        <link rel="stylesheet" href="edit_product_style.css" type="text/css">

        <!-- javascript link -->
        <script src="edit_product_javascript.js"></script>

    </head>

    <body>
    <!-- class is for css to identify-->
    <!-- name is for php to post -->

        <!-- navigation bar on the top -->
        <nav class="top-nav-bar">

            <div class="title-left">

                <img class="head_logo" src="image/tdlogo.png" alt="Logo">

                <h1>Thrifts Depot</h1>

            </div>

            <div class="list-right">

                <ul class="list">

                    <li><a href="index_seller.php">Home</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="seller_profile.php">Profile</a></li>
                    <li><a href="index.php">Logout</a></li>

                </ul>

            </div>

        </nav>

        <h2 class="title">Edit Product</h2>

        <div class="container">

            <!-- left navigation bar -->
            <div class="left-nav-bar">

                <ul class="seller-menu">

                    <li><a href="add_product.php">Add Product</a></li>
                    <li><a href="product_list.php">Product Added List</a></li>
                    <li><a href="seller_profile.php">Profile</a></li>
                    <li><a href="#">Payment</a></li>

                </ul>

            </div>

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

        <!-- footer -->
        <div class="footer">

            <div class="foo_container">

                <div class="catogories">
                    <p class="foo_s_title">Categories</p>
                    <ul class="list">
                        <li><a href="#">Clothes</a></li>
                        <li><a href="#">Books</a></li>
                        <li><a href="#">Electronic Gadgets</a></li>
                        <li><a href="#">Stationary</a></li>
                    </ul>
                </div>

                <div class="ours">
                    <img class="foo_logo" src="image/tdlogo.png" alt="Logo"><br>
                    <p class="foo_c_title">Thrifts Depot 2003</p><br>
                    <span class="foo_right"><a href="admin_login.php">Admin Panel</a></span><br>
                </div>

                <div class="contact_us">
                    <span class="foo_right"><a href="">About Us</a></span><br>
                    <span class="foo_right"><a href="">Contact Us</a></span><br>
                    <span class="foo_right"><a href="thriftsdepot@gmail.com">thriftsdepot@gmail.com</a><span><br>
                </div>

            </div>
                
        </div>
        
    </body>

</html>
