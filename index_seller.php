<?php
session_start();
include "config.php";
// Check if the user is already logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index_seller.php");
    exit();
}

// Handle logout request
if (isset($_POST['logout'])) {
    // Clear all session variables
    session_unset();
    // Destroy the session
    session_destroy();
    // Redirect to index.php
    header("Location:index.php");
    exit();
}

// Get seller information
$sellerId = $_SESSION['seller_id'];

$query = "SELECT * FROM seller INNER JOIN users ON seller.user_id = users.user_id WHERE seller.seller_id = $sellerId";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$username = $row['username'];


// Fetch order details for the logged-in seller
$orderQuery = "SELECT test_order.order_id, test_order.product_id, test_order.quantity, test_order.price, test_order.total, test_order.status, products.name, users.username, users.home_address, users.email, users.phone_number
    FROM test_order
    INNER JOIN products ON test_order.product_id = products.product_id
    INNER JOIN users ON test_order.user_id = users.user_id
    WHERE products.seller_id = $sellerId AND test_order.status = 'Pending'
    ORDER BY test_order.order_id DESC";
$orderResult = mysqli_query($conn, $orderQuery);

if (!$orderResult) {
    die("Error: " . mysqli_error($conn));
}

// Fetch product IDs and names for the current seller from the products table
$productQuery = "SELECT product_id, name FROM products WHERE seller_id = $sellerId";
$productResult = mysqli_query($conn, $productQuery);

if (!$productResult) {
    die("Error: " . mysqli_error($conn));
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrifts Depot Seller Center</title>

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

<div class="sprofile_container">

    <h2 class="sprofile_title">Welcome Back <?php echo $username; ?> !</h2>

    <div class="order_container">
        <div class="form_container">
                <!-- Orders list -->
                <div class="seller-order-container">
                    <h3 class="seller_order_container_title">Don't forget to shipped out your item :)</h3>

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
                                        <td><button class="order_list_shipped" onclick="confirmShipOut(<?php echo $order['order_id']; ?>)" 
                                                id='shipOutBtn<?php echo $order['order_id']; ?>'>Ship Out</button></td>
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
    </div>

    <div class="wallet_container">
        <h2 class="seller_order_container_title">Check Your Earning Here!</h2>

        <div class="wallet_form">
            <!-- Display product details from test_order table -->
            <div class="product-list-table">
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Total</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Buyer Status</th>
                            <th>Admin Status</th>
                            <th>Price</th>
                            <th>My Wallet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalEarnings = 0; // Variable to store the total earnings

                        while ($productRow = mysqli_fetch_assoc($productResult)) {
                            $productId = $productRow['product_id'];

                            // Fetch details from test_order table for the current product ID
                            $testOrderQuery = "SELECT * FROM test_order WHERE product_id = $productId";
                            $testOrderResult = mysqli_query($conn, $testOrderQuery);

                            if (!$testOrderResult) {
                                die("Error: " . mysqli_error($conn));
                            }

                            while ($testOrderRow = mysqli_fetch_assoc($testOrderResult)) {
                                echo "<tr>";
                                echo "<td>{$productRow['product_id']}</td>";
                                echo "<td>{$productRow['name']}</td>";
                                echo "<td>{$testOrderRow['total']}</td>";
                                echo "<td>{$testOrderRow['quantity']}</td>";
                                echo "<td>{$testOrderRow['status']}</td>";
                                echo "<td>{$testOrderRow['buyer_status']}</td>";
                                echo "<td>{$testOrderRow['admin_status']}</td>";
                                echo "<td>{$testOrderRow['price']}</td>";

                                // Deduct 10% from the total if admin_status is 'Released'
                                $myWallet = $testOrderRow['total'];
                                if ($testOrderRow['admin_status'] === 'released') {
                                    $myWallet = $myWallet - ($myWallet * 0.1);
                                    $myWallet = sprintf("RM %.2f", $myWallet); // Format the remaining amount with two decimal places
                                }
                                echo "<td>{$myWallet}</td>";

                                // Calculate total earnings
                                $totalEarnings += (float) str_replace('RM ', '', $myWallet); // Remove 'RM ' and convert to float

                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>

                    <!-- Display total earnings -->
                    <tfoot>
                        <tr class="total_earning">
                            <td colspan="8" align="right"><strong>My Total Earnings:</strong></td>
                            <td><?php echo "RM " . number_format($totalEarnings, 2); ?></td>
                        </tr>
                    </tfoot>


                </table>
            </div>
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
        <script src="seller_order_javascript.js"></script>
    </div>
<!-- End Script -->


</body>

</html>
