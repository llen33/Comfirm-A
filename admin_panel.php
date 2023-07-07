<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['AdminLoginId'])) {
    header("Location:admin_login.php");
    exit();
}


@include 'config.php'; // Assuming your config file is named config.php


// Pagination variables
$limit = 10; // Number of records to show per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Offset for database query

// Fetch total number of records in the table
$totalRecordsQuery = "SELECT COUNT(*) as count FROM test_order";
$totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
$totalRecordsRow = mysqli_fetch_assoc($totalRecordsResult);
$totalRecords = $totalRecordsRow['count'];

// Calculate total number of pages
$totalPages = ceil($totalRecords / $limit);

// Fetch data with pagination
$query = "SELECT * FROM test_order LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Check for errors in the query
if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}

// Function to fetch user details
function fetchUserDetails($conn, $userId)
{
    $query = "SELECT * FROM users WHERE user_id = $userId AND role = 'buyer'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching user details: " . mysqli_error($conn));
    }

    $userDetails = mysqli_fetch_assoc($result);
    return $userDetails;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Admin Panel</title>
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
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
            <li><a href="user_profile.php">Verify Seller</a></li>
            <li><a href="prod_data_admin.php">Products Database</a></li>
            <li><a href="user_payment.php">Payment</a></li>
        </ul>
    </nav>

    <div class="content">
        <!-- Content section -->
        <h2>Admin Panel Content</h2>
        <p>Check Out Sales Info</p>

        <table class="table">
            <!-- Table headers -->
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Seller</th>
                    <th>Buyer</th>
                    <th>Payment Method</th>
                    <th>Release Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['order_id']}</td>";
                    echo "<td><a class='user-details' href='#' data-userid='{$row['user_id']}'>{$row['user_id']}</a></td>";
                    echo "<td>{$row['product_id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['price']}</td>";
                    echo "<td>{$row['quantity']}</td>";
                    echo "<td>{$row['total']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>{$row['buyer_status']}</td>";
                    echo "<td>{$row['payment_method']}</td>";
                    echo "<td><button class='release-payment' data-orderid='{$row['order_id']}'>Release Payment</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination links -->
        <ul class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<li class='page-item'><a class='page-link' href='admin_panel.php?page={$i}'>{$i}</a></li>";
            }
            ?>
        </ul>
    </div>

    <!-- Modal for displaying user details -->
    <div id="userDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <table class="table">
                <tbody id="userDetailsBody">
                    <!-- User details will be dynamically populated here -->
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        <p>Thrifts Depot 2023<br>
            <a href="thriftsdepot@gmail.com">thriftsdepot@gmail.com ||</a>
            <a href="index.php">Homepage ||</a>
            <a href="admin_login.php">Admin Panel</a>
        </p>
    </footer>

    <script>
        // When the user clicks on the user_id link, open the modal and fetch user details
        var userLinks = document.getElementsByClassName("user-details");
        for (var i = 0; i < userLinks.length; i++) {
            userLinks[i].addEventListener("click", function(e) {
                e.preventDefault();
                var userId = e.target.dataset.userid;
                fetchUserDetails(userId);
                document.getElementById("userDetailsModal").style.display = "block";
            });
        }

        // Function to fetch user details and populate the modal
        function fetchUserDetails(userId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var userDetails = JSON.parse(xhr.responseText);
                        populateUserDetails(userDetails);
                    } else {
                        console.error("Error fetching user details");
                    }
                }
            };

            xhr.open("GET", "fetch_user_details.php?user_id=" + userId, true);
            xhr.send();
        }

        // Function to populate the user details in the modal
        function populateUserDetails(userDetails) {
            var userDetailsBody = document.getElementById("userDetailsBody");
            userDetailsBody.innerHTML = ""; // Clear existing data

            if (userDetails) {
                var row = document.createElement("tr");


                row = document.createElement("tr");
                row.innerHTML = "<td>Username</td><td>" + userDetails.username + "</td>";
                userDetailsBody.appendChild(row);

                row = document.createElement("tr");
                row.innerHTML = "<td>Email</td><td>" + userDetails.email + "</td>";
                userDetailsBody.appendChild(row);

                row = document.createElement("tr");
                row.innerHTML = "<td>Phone Number</td><td>" + userDetails.phone_number + "</td>";
                userDetailsBody.appendChild(row);

                row = document.createElement("tr");
                row.innerHTML = "<td>Home Address</td><td>" + userDetails.home_address + "</td>";
                userDetailsBody.appendChild(row);
            } else {
                var row = document.createElement("tr");
                row.innerHTML = "<td colspan='2'>User details not found</td>";
                userDetailsBody.appendChild(row);
            }
        }

        // Close the modal when the user clicks the close button
        var closeButton = document.getElementsByClassName("close")[0];
        closeButton.addEventListener("click", function() {
            document.getElementById("userDetailsModal").style.display = "none";
        });

        // When the user clicks the release payment button, update the admin_status column
        // When the user clicks the release payment button, update the admin_status column
        var releasePaymentButtons = document.getElementsByClassName("release-payment");
        for (var i = 0; i < releasePaymentButtons.length; i++) {
            releasePaymentButtons[i].addEventListener("click", function(e) {
                var orderId = e.target.dataset.orderid;
                updateAdminStatus(orderId);
            });
        }

        // Function to update the admin_status column
        function updateAdminStatus(orderId) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Successful update
                        // Display an alert message
                        alert("Payment release was done for Order ID: " + orderId);
                        // You can optionally perform any additional actions here
                        console.log("Payment released for Order ID: " + orderId);
                        location.reload(); // Reload the page to reflect the updated admin_status
                    } else {
                        // Error occurred
                        console.error("Error updating admin_status for Order ID: " + orderId);
                    }
                }
            };

            xhr.open("POST", "update_admin_status.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("order_id=" + orderId);
        }
    </script>

    <?php
    if (isset($_POST['Logout'])) {
        session_destroy();
        header("Location:admin_login.php");
    }
    ?>

</body>

</html>