<?php

    @include 'add_product_config.php';

    $id = $_GET['edit'];

    if(isset($_POST['edit_product'])){

        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_description = $_POST['product_description'];
        $product_category = $_POST['product_category'];
        $product_quantity = $_POST['product_quantity'];
        $product_condition = $_POST['product_condition'];
        $product_image = $_FILES['product_image']['name'];
        $product_img_tmp_name = $_FILES['product_image']['tmp_name'];
        $product_image_folder = 'uploaded_img/'.$product_image;

        $product_old_image = $_POST['product_old_image'];

        if(empty($product_name) || empty($product_price) || empty($product_description)|| empty($product_category) ||
            empty($product_quantity) || empty($product_condition)){

                $message[] = "Please fill out all.";

        } else {

            $edit = "UPDATE products SET name = '$product_name', price = '$product_price', description = '$product_description', 
                        category = '$product_category', quantity = '$product_quantity', product_condition = '$product_condition', 
                            image = '$product_image' WHERE product_id = '$id'";

            $upload = mysqli_query($conn, $edit);

            if($upload){

                move_uploaded_file($product_img_tmp_name, $product_image_folder);
                header('location:product_list.php');

            } else {

                $message[] = 'Please fill out all.';

            }

        };

    }

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

    </head>

    <body>

        <?php

            if(isset($message)){
                foreach($message as $message){
                    echo '<span class="message">'.$message.'</span>';
                }
            }

        ?>

        <div class="container">

            <div class="edit-product-form-container">

                <?php
                
                    $select = mysqli_query($conn, "SELECT * FROM products WHERE product_id = '$id' ");

                    while($row = mysqli_fetch_assoc($select)) {
                
                ?>

                    <form name="edit-product" action="" method="post" enctype="multipart/form-data">

                            <h3>Edit Product</h3>

                            <div class="p_name"> 

                                <label for="product-name" class="l_name">Product Name:</label><br>  <!-- l_name = label for product name -->

                                <input type="text" placeholder="Enter Product Name" value="<?php echo $row['name']; ?>" name="product_name" 
                                    class="name" required oninvalid="this.setCustomValidity('This field cannot be left blank.')"
                                        onvalid="this.setCustomValidity('')"><br>

                            </div>

                            <div class="p_price">

                                <label for="product-price" class="l_price">Product Price (RM):</label><br>

                                <input type="text" placeholder="Enter Product Price (RM)" value="<?php echo $row['price']; ?>" 
                                    name="product_price" pattern="^[0-9]+\.?[0-9]{2}$" class="price" required><br>

                            </div>

                            <div class="p_description">

                                <label for="product-description" class="l_description">Product Description:</label><br>

                                <textarea placeholder="Enter Product Description..." name="product_description" class="description" 
                                    required><?php echo $row['description']; ?></textarea><br>

                            </div>

                            <div class="p_category">

                                <label for="product-category" class="l_category">Product Category:</label><br>

                                <select name="product_category" class="category" required>
                                    <option value="none" selected disabled hidden>Select a Category</option>
                                    <option value="Stationary"  <?php if($row['category']=="Stationary") echo 'selected="selected"'; ?> >Stationaries</option>
                                    <option value="Book"        <?php if($row['category']=="Book") echo 'selected="selected"'; ?>       >Books</option>
                                    <option value="Cloth"       <?php if($row['category']=="Cloth") echo 'selected="selected"'; ?>      >Clothes</option>
                                    <option value="Electronic"  <?php if($row['category']=="Electronic") echo 'selected="selected"'; ?> >Electronic Items</option>
                                </select><br>

                            </div>

                            <div class="p_quantity">

                                <label for="product-quantity" class="l_quantity">Product Quantity:</label><br>
                                
                                <input type="number" placeholder="Quantity" value="<?php echo $row['quantity']; ?>" name="product_quantity" 
                                    class="quantity" required><br>

                            </div>

                            <div class="p_condition">

                                <label for="product-condition" class="l_condition">Product Condition:</label><br>

                                <textarea placeholder="Enter Product Condition..." name="product_condition" class="condition" 
                                    required><?php echo $row['product_condition']; ?></textarea><br>

                            </div>

                            <div class="p_image">

                                <label for="product-image" class="l_image">Product Image:</label><br>

                                <input type="hidden" name="product_old_image" value="<?php echo $row['image'];?>">

                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="image"><br>
                                    
                                <label for="product-current-image" class="l_current_image">Current Image: </label>

                                <img src = "uploaded_img/<?php echo $row['image']; ?>" height = "50px" width = "50px" alt = "Product Image"><br>

                            </div>

                            <input type="submit" class="edit-product-button" name="edit_product" value="Done">

                            <a href="product_list.php" class="product-list-button">Back</a>

                    </form>

                <?php
                
                    };
                
                ?>

            </div>

        </div>
        
    </body>

</html>