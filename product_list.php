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
        <title>Product Added List Page</title>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- custom css file link -->
        <link rel="stylesheet" href="product_list_style.css" type="text/css">

        <!-- javascript link -->
        <script src="product_list_javascript.js"></script>
        
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

        <h2 class="title">Product List</h2>
        
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
                            <td>
                                <a href = "edit_product.php?edit=<?php echo $row['product_id']; ?>" class = "edit-product-button">
                                    <i class="fas fa-edit"></i> Edit</a><br>

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