<!-- This code is written by Eng Jing Yi (CSD21005) -->

<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    @include 'add_product_config.php';

    // Get seller information
    $sellerId = $_SESSION['seller_id'];

    $query = "SELECT * FROM seller INNER JOIN users ON seller.user_id = users.user_id WHERE seller.seller_id = $sellerId";
    $result = mysqli_query($conn, $query);

    if (!$result) {

        die("Error: " . mysqli_error($conn));

    }

    // Fetch order details for the logged-in seller
    $orderQuery = "SELECT test_order.order_id, test_order.product_id, test_order.quantity, test_order.price, test_order.total, test_order.status, products.name, users.username, users.home_address, users.email, users.phone_number
        FROM test_order
        INNER JOIN products ON test_order.product_id = products.product_id
        INNER JOIN users ON test_order.user_id = users.user_id
        WHERE products.seller_id = $sellerId
        ORDER BY CASE WHEN test_order.status = 'Pending' THEN 0 ELSE 1 END, test_order.status DESC"; // Order by status with pending orders first
    $orderResult = mysqli_query($conn, $orderQuery);

    if (!$orderResult) {

        die("Error: " . mysqli_error($conn));

    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Order</title>

        <!-- custom css file link -->
        <link rel="stylesheet" href="seller_order_style.css" type="text/css">

        <!-- javascript link -->
        <script src="seller_order_javascript.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </head>

    <body>

        <!-- navigation bar on the top -->
        <nav class="top-nav-bar">

            <div class="title-left">
                <img class="head_logo" src="image/tdlogo.png" alt="Logo">

                <h1>Thrifts Depot</h1>
            </div>

            <div class="list-right">

                <ul class="list">

                    <li><a href="index_seller.php">Home</a></li>
                    <li><a href="seller_profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>

                </ul>

            </div>

        </nav>

        <h2 class="title">Buyers' Orders List</h2>

        <div class="container">

            <!-- left navigation bar -->
            <div class="left-nav-bar">

                <ul class="seller-menu">

                    <li><a href="add_product.php">Add Product</a></li>
                    <li><a href="product_list.php">Product Added List</a></li>
                    <li><a href="seller_profile.php">Profile</a></li>
                    <li><a href="seller_order.php">Order</a></li>

                </ul>

            </div>

            <!-- Orders list -->
            <div class="seller-order-container">

                <!-- Order details table-->
                <div class="order-details-table">

                    <?php

                        if (mysqli_num_rows($orderResult) > 0) {

                    ?>

                            <table id="orderTable" class='order-table'>
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Buyer</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                        <?php

                            while ($order = mysqli_fetch_assoc($orderResult)) {

                        ?>
                                <tr id="orderRow<?php echo $order['order_id']; ?>">    <!-- Add the orderRow id to the table row -->
                                    <td><?php echo $order['order_id']?></td>
                                    <td><?php echo $order['product_id']?></td>
                                    <td><?php echo $order['name']?></td>
                                    <td><?php echo $order['quantity']?></td>
                                    <td><?php echo $order['price']?></td>
                                    <td>RM <?php echo $order['total']?></td>
                                    <td>
                                        <a href="seller_get_buyer_details.php?order_id=<?php echo $order['order_id']; ?>">
                                            <?php echo $order['username']; ?>
                                        </a>
                                    </td>

                                <!-- Check if the order has been shipped -->
                                <?php 

                                    if ($order['status'] === 'Pending') {

                                ?>
                                        <td><button onclick="confirmShipOut(<?php echo $order['order_id']; ?>)" 
                                                id='shipOutBtn<?php echo $order['order_id']; ?>'>Ship Out</button></td>
                                
                                <?php

                                    } else {

                                ?>

                                    <td>Shipped Out</td>

                                <?php

                                    }

                                ?>

                                </tr>

                        <?php

                            }

                        ?>
                            </table>

                    <?php

                        } else {
                    
                    ?>
                            <p>No orders found.</p>
                    <?php

                        }

                    ?>

                </div>

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
