<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    @include 'add_product_config.php';

    // Assuming you have a session variable 'seller_id' that stores the ID of the currently logged in seller

    if(isset($_POST['add_product'])){

        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_description = $_POST['product_description'];
        $product_category = $_POST['product_category'];
        $product_quantity = $_POST['product_quantity'];
        $product_condition = $_POST['product_condition'];
        $product_image = $_FILES['product_image'];

        // Insert product info into the products table, including the seller ID
        $insertQuery = "INSERT INTO products(seller_id, name, price, description, category, quantity, product_condition)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $insertQuery);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "isdssis", $_SESSION['seller_id'], $product_name, $product_price, $product_description, $product_category, $product_quantity, $product_condition);

        // Execute the statement
        $insertResult = mysqli_stmt_execute($stmt);

        if ($insertResult) {

            $product_id = mysqli_insert_id($conn);

            // Set your desired directory
            $target_directory = "uploaded_img/";
            foreach ($product_image['tmp_name'] as $key => $tmp_name) {
                
                $image_name = basename($product_image['name'][$key]);
                $target_path = $target_directory . $image_name;
                move_uploaded_file($tmp_name, $target_path);

                // Insert image information into the image table
                $query = "INSERT INTO image (product_id, path) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "is", $product_id, $target_path);
                mysqli_stmt_execute($stmt);

            }

            $message[] = 'New Product Added Successfully';

        } else {

            $message[] = 'Could Not Add The Product';

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Product Page</title>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- custom css file link -->
        <link rel="stylesheet" href="add_product_style.css" type="text/css">

        <!-- javascript link -->
        <script src="add_product_javascript.js"></script>

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

        <h2 class="title">Add New Product</h2>

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

            <div class="add-product-form-container">

                <!-- show the message after the product info upload successfully -->
                <div class="success-message">
                    
                    <?php

                        if(isset($message)){
                            foreach($message as $message){
                                echo '<span class="message">'.$message.'</span>';
                            }
                        }

                    ?>
                    
                </div>

                <!-- add product form -->
                <form name="add-product" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" 
                    onsubmit="return confirmAddProduct();">


                        <div class="p_name">    <!-- p_name = product name -->

                            <label for="product-name" class="l_name">Product Name:</label><br>  <!-- l_name = label for product name -->

                            <input type="text" placeholder="Enter Product Name" name="product_name" class="name" 
                                required oninvalid="this.setCustomValidity('Please fill in your product name.')" 
                                    oninput="this.setCustomValidity('')"><br>

                        </div>

                        <div class="p_price">

                            <label for="product-price" class="l_price">Product Price (RM):</label><br> 

                            <input type="text" placeholder="Enter Product Price (RM)" name="product_price" pattern="^[0-9]+\.?[0-9]{2}$" 
                                class="price" required oninvalid="this.setCustomValidity('Please fill in your product price.\nThe price must in 2 decimal places.\nFor example: 123.45')"
                                    oninput="this.setCustomValidity('')"><br>

                        </div>

                        <div class="p_description">

                            <label for="product-description" class="l_description">Product Description:</label><br>

                            <textarea placeholder="Enter Product Description..." name="product_description" class="description" 
                                required oninvalid="this.setCustomValidity('Please fill in your product description.')"
                                    oninput="this.setCustomValidity('')"></textarea><br>

                        </div>

                        <div class="p_category">

                            <label for="product-category" class="l_category">Product Category:</label><br>

                            <select name="product_category" class="category" required 
                                oninvalid="this.setCustomValidity('Please select a category for your product.')"
                                    oninput="this.setCustomValidity('')">
                                <option value="" selected disabled hidden>Select a Category</option>
                                <option value="Stationary">Stationaries</option>
                                <option value="Book">Books</option>
                                <option value="Cloth">Clothes</option>
                                <option value="Electronic">Electronic Items</option>
                            </select><br>

                        </div>

                        <div class="p_quantity">

                            <label for="product-quantity" class="l_quantity">Product Quantity:</label><br>

                            <input type="number" min="1" placeholder="Quantity" name="product_quantity" class="quantity" required
                                oninvalid="this.setCustomValidity('Please fill in your product quantity.')"
                                    oninput="this.setCustomValidity('')"><br>

                        </div>

                        <div class="p_condition">

                            <label for="product-condition" class="l_condition">Product Condition:</label><br>

                            <textarea placeholder="Enter Product Condition..." name="product_condition" class="condition" required 
                                oninvalid="this.setCustomValidity('Please fill in your product condition.')"
                                    oninput="this.setCustomValidity('')"></textarea><br>

                        </div>

                        <div class="p_image">

                            <label for="product-image" class="l_image">Product Image:</label><br>

                            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image[]" class="image" multiple required 
                                oninvalid="this.setCustomValidity('Please upload your product image(s).')"
                                    oninput="this.setCustomValidity('')"><br>

                        </div>

                        <div class="p_submit">

                            <input type="submit" class="add-product-button" name="add_product" value="Add Product">

                        </div>

                </form>

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