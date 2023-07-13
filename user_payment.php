<?php
session_start();
@include 'config.php';
if (!isset($_SESSION['AdminLoginId'])) {
    header("Location:admin_login.php");
    exit();
}

$limit = 5; // Number of rows per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page from the URL parameter, default to 1 if not set

// Get the selected date from the URL query parameter
$selectedDate = isset($_GET['selected_date']) ? $_GET['selected_date'] : '';

$query = "SELECT COUNT(*) as total FROM payment";

// Modify the query to filter by date if a date is selected
if (!empty($selectedDate)) {
    $query .= " WHERE DATE(payment_time) = '$selectedDate'";
}

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalRows = $row['total']; // Total number of rows in the table

$totalPages = ceil($totalRows / $limit); // Calculate the total number of pages

$offset = ($page - 1) * $limit; // Calculate the offset for the current page

$query = "SELECT * FROM payment";

// Modify the query to filter by date if a date is selected
if (!empty($selectedDate)) {
    $query .= " WHERE DATE(payment_time) = '$selectedDate'";
}

$query .= " LIMIT $offset, $limit";

$result = mysqli_query($conn, $query);

// Calculate the total number of rows
$totalRows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Thrifts Depot</title>
    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #333;
            color: #fff;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #ff5757;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .navbar {
            background-color: #222;
            color: #fff;
            padding: 10px 40px;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
        }

        .navbar ul li {
            display: inline-block;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .navbar ul li a:hover {
            background-color: #fff;
            color: #161B24;
        }

        .content {
            padding: 20px 40px;
        }

        footer {
            background-color: #222;
            color: #fff;
            font-size: 14px;
            bottom: 0;
            position: fixed;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 999;
            padding: 20px;
        }

        footer p {
            margin: 10px 0;
        }

        footer a {
            color: #3c97bf;
            text-decoration: none;
        }

        .product-details {
            background-color: #f4f4f4;
            padding: 10px;
            margin-bottom: 10px;
        }

        .close-button {
            background-color: transparent;
            border: none;
            color: #000;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
    </style>
</head>

<body>
    <header class="header">
        <h1>Welcome to the Admin Panel, <?php echo $_SESSION['AdminLoginId']; ?></h1>
        <form method="POST" action="admin_login.php">
            <button type="submit" name="Logout">Logout</button>
        </form>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="admin_panel.php">Home</a></li>
            <li><a href="get_buyer_details.php">Buyer</a></li>
            <li><a href="get_seller_details.php">Seller </a></li>
            <li><a href="prod_data_admin.php">Products Database</a></li>
            <li><a href="user_payment.php">Payment</a></li>
            <li><a href="user_profile.php">Contact Panel</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="header-title pb-3 mt-0">Payments</h5>
                        <input type="date" id="calendar" class="form-control" onchange="filterByDate()">

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="align-self-center">
                                        <th>Payment ID</th>
                                        <th>Order ID</th>
                                        <th>Buyer ID</th>
                                        <th>Product ID</th>
                                        <th>Total</th>
                                        <th>Buyer Status</th>
                                        <th>Seller Wallet</th>
                                        <th>Commission</th>
                                        <th>Payment Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalEarnings = 0; // Initialize the variable to calculate the total earnings

                                    // Iterate through the query result and populate the table
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Fetch the values from the current row
                                        $paymentId = $row['payment_id'];
                                        $orderId = $row['order_id'];
                                        $buyerId = $row['buyer_id'];
                                        $productId = $row['product_id'];
                                        $total =$row['total'];
                                        $buyerStatus = $row['buyer_status'];
                                        $paymentTime = $row['payment_time'];
                                        $sellerWallet = number_format($total * 0.9, 2); // Format the seller wallet value
                                        $commission = number_format($total * 0.1, 2); // Format the commission value
                                        $totalEarnings += $total * 0.1; // Accumulate the commission for total earnings

                                        // Replace the placeholders in the HTML template with the fetched values
                                        echo '<tr>
                                        <td>' . $paymentId . '</td>
                                        <td>' . $orderId . '</td>
                                        <td>' . $buyerId . '</td>
                                        <td><a href="#" onclick="toggleProductDetails(' . $productId . ')">' . $productId . '</a></td>
                                        <td>' . $total . '</td>
                                        <td><span class="badge badge-boxed badge-soft-warning">' . $buyerStatus . '</span></td>
                                        <td>' . 'RM ' . $sellerWallet . '</td>
                                        <td>' . 'RM ' . $commission . '</td>
                                        <td>' . $paymentTime . '</td>
                                    </tr>
                                    <tr id="product-details-' . $productId . '" style="display: none;"></tr>';
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="7"></td>
                                        <td>Total Earnings:</td>
                                        <td>RM <?php echo number_format($totalEarnings, 2); ?><div class="print">
                                <a href="#" onclick="window.print(); return false;">
                                    <i class="fa fa-print"></i>
                                    Print
                                </a>
                            </div></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end table-responsive-->

                        <ul class="pagination justify-content-center mt-3">
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ($page - 1); ?>&selected_date=<?php echo $selectedDate; ?>">Previous</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&selected_date=<?php echo $selectedDate; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ($page + 1); ?>&selected_date=<?php echo $selectedDate; ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Thrifts Depot 2023<br>
            <a href="thriftsdepot@gmail.com"> thriftsdepot@gmail.com || </a>
            <a href="index.php"> Homepage || </a>
            <a href="admin_login.php">Admin Panel</a>
        </p>
    </footer>
    <script>
        function filterByDate() {
            var selectedDate = document.getElementById("calendar").value;
            var baseUrl = window.location.href.split('?')[0]; // Get the base URL without query parameters

            // Redirect to the updated URL with the selected date
            window.location.href = baseUrl + '?selected_date=' + selectedDate;
        }

        function toggleProductDetails(productId) {
            // Send an AJAX request to fetch the product details
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_product_details.php?productId=' + productId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Display the fetched product details
                    var productDetails = JSON.parse(xhr.responseText);
                    var toggleElement = document.getElementById('product-details-' + productId);
                    if (toggleElement.style.display === 'none') {
                        toggleElement.style.display = 'block';
                        toggleElement.innerHTML = '<td colspan="9">' +
                            'Product Name: ' + productDetails.name + '<br>' +
                            'Price: ' + productDetails.price + '<br>' +
                            'Quantity: ' + productDetails.quantity + '<br>' +
                            'Category: ' + productDetails.category + '<br>' +
                            'Condition: ' + productDetails.product_condition + '<br>' +
                            'Description: ' + productDetails.description + '<br>' +
                            'Seller ID: ' + productDetails.seller_id +
                            '</td>';
                    } else {
                        toggleElement.style.display = 'none';
                    }
                }
            };
            xhr.send();
        }
    </script>

    <?php
    if (isset($_POST['Logout'])) {
        session_destroy();
        header("Location:/admin_login/admin_login.php");
    }
    ?>
</body>

</html>
