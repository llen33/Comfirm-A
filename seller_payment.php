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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Payment</title>
    <!-- custom css file link -->
    <link rel="stylesheet" href="seller_order_style.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .earnings-container {
            background-color: #f2f2f2;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 20px;
        }

        .earnings-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .earnings-amount {
            font-size: 36px;
            font-weight: bold;
        }
    </style>
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

    <h2 class="title">My Wallet</h2>

    <div class="container">
        <!-- left navigation bar -->
        <div class="left-nav-bar">
            <ul class="seller-menu">
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="product_list.php">Product Added List</a></li>
                <li><a href="seller_profile.php">Profile</a></li>
                <li><a href="seller_order.php">Order</a></li>
                <li><a href="seller_payment.php">Payment</a></li>
            </ul>
        </div>

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
                    <tr>
                        <td colspan="8" align="right"><strong>My Total Earnings:</strong></td>
                        <td><?php echo "RM " . number_format($totalEarnings, 2); ?></td>
                    </tr>
                </tfoot>


            </table>
        </div>
    </div>
</body>

</html>