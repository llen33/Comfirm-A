<?php

    @include 'add_product_config.php';

    if(isset($_GET['delete'])){

        $id = $_GET['delete'];

        mysqli_query($conn, "DELETE FROM products WHERE product_id = $id");

        header('location:product_list.php');

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
        
    </head>

    <body>
        
        <div class="container">

            <?php

                $select = mysqli_query($conn, "SELECT * FROM products");

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

                        while($row = mysqli_fetch_assoc($select)){

                    ?>

                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['product_condition']; ?></td>
                            <td><img src = "uploaded_img/<?php echo $row['image']; ?>" height = "100" alt = "Product Image"></td>
                            <td>
                                <a href = "edit_product.php?edit=<?php echo $row['product_id']; ?>" class = "edit-product-button"><i class="fas fa-edit"></i> Edit</a><br>
                                <a href = "product_list.php?delete=<?php echo $row['product_id']; ?>" class = "delete-product-button"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr> 

                    <?php  

                        }

                    ?>

                </table>

            </div>

        </div>
    </body>

</html>