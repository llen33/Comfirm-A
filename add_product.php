<?php

    @include 'add_product_config.php';

    if(isset($_POST['add_product'])){

        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_description = $_POST['product_description'];
        $product_category = $_POST['product_category'];
        $product_quantity = $_POST['product_quantity'];
        $product_condition = $_POST['product_condition'];
        $product_image = $_FILES['product_image']['name'];
        $product_img_tmp_name = $_FILES['product_image']['tmp_name'];
        $product_image_folder = 'uploaded_img/'.$product_image;

        if(empty($product_name) || empty($product_price) || empty($product_description)|| empty($product_category) ||
            empty($product_quantity) || empty($product_condition) || empty($product_image)){

                $message[] = "Please fill out all.";

        } else {

            $insert = "INSERT INTO products(name, price, description, category, quantity, product_condition, image) 
                        VALUES ('$product_name', '$product_price', '$product_description', '$product_category', '$product_quantity', 
                        '$product_condition', '$product_image')";

            $upload = mysqli_query($conn, $insert);

            if($upload){

                move_uploaded_file($product_img_tmp_name, $product_image_folder);
                $message[] = 'New Product Added Successfully';

            } else {

                $message[] = 'Could Not Add The Product';

            }

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

    </head>

    <body>
    <!-- class is for css to identify-->
    <!-- name is for php to post -->

        <?php

            if(isset($message)){
                foreach($message as $message){
                    echo '<span class="message">'.$message.'</span>';
                }
            }

        ?>
        
        <div class="container">

            <div class="add-product-form-container">

                <form name="add-product" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                        <h3>Add New Product</h3>

                        <div class="p_name">    <!-- p_name = product name -->

                            <label for="product-name" class="l_name">Product Name:</label><br>  <!-- l_name = label for product name -->

                            <input type="text" placeholder="Enter Product Name" name="product_name" class="name" 
                                required oninvalid="this.setCustomValidity('This field cannot be left blank.')"
                                    onvalid="this.setCustomValidity('')"><br>

                        </div>

                        <div class="p_price">

                            <label for="product-price" class="l_price">Product Price (RM):</label><br> 

                            <input type="text" placeholder="Enter Product Price (RM)" name="product_price" pattern="^[0-9]+\.?[0-9]{2}$" 
                                class="price" required><br>

                        </div>

                        <div class="p_description">

                            <label for="product-description" class="l_description">Product Description:</label><br>

                            <textarea placeholder="Enter Product Description..." name="product_description" class="description" 
                                required></textarea><br>

                        </div>

                        <div class="p_category">

                            <label for="product-category" class="l_category">Product Category:</label><br>

                            <select name="product_category" class="category" required>
                                <option value="none" selected disabled hidden>Select a Category</option>
                                <option value="Stationary">Stationaries</option>
                                <option value="Book">Books</option>
                                <option value="Cloth">Clothes</option>
                                <option value="Electronic">Electronic Items</option>
                            </select><br>

                        </div>

                        <div class="p_quantity">

                            <label for="product-quantity" class="l_quantity">Product Quantity:</label><br>

                            <input type="number" placeholder="Quantity" name="product_quantity" class="quantity" required><br>

                        </div>

                        <div class="p_condition">

                            <label for="product-condition" class="l_condition">Product Condition:</label><br>

                            <textarea placeholder="Enter Product Condition..." name="product_condition" class="condition" required></textarea><br>

                        </div>

                        <div class="p_image">

                            <label for="product-image" class="l_image">Product Image:</label><br>

                            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="image" required><br>

                        </div>

                        <input type="submit" class="add-product-button" name="add_product" value="Add Product">

                </form>

            </div>

        </div>
    </body>
</html>