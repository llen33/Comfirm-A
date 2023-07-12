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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            text-align: center;
            padding: 20px;
            margin-top: auto;
            width: 100%;
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

        .card {
            border: none;
            margin-bottom: 24px;
            -webkit-box-shadow: 0 0 13px 0 rgba(236, 236, 241, .44);
            box-shadow: 0 0 13px 0 rgba(236, 236, 241, .44);
        }

        .avatar-xs {
            height: 2.3rem;
            width: 2.3rem;
        }

        /*sales chart */
        .sales-chart-container {
            position: relative;
            width: 100%;
            max-width: 900px;
            height: 400px;
            margin: 0 auto;
            border: 1px solid #eaeaea;
            border-radius: 4px;
            padding: 70px;
            box-sizing: content-box;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .calendar-container {
            position: absolute;
            top: 0;
            left: 0;
            padding: 20px;
            z-index: 1;
            background-color: #fff;
        }

        .calendar-container select,
        .calendar-container input[type="number"],
        .calendar-container button {
            margin-right: 10px;
        }

        #salesChart {
            margin-top: 70px;
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
            <li><a href="get_buyer_details.php">Buyer</a></li>
            <li><a href="get_seller_details.php">Seller </a></li>
            <li><a href="prod_data_admin.php">Products Database</a></li>
            <li><a href="user_payment.php">Payment</a></li>
            <li><a href="user_profile.php">Contact Panel</a></li>
        </ul>
    </nav>

    <div class="content">
        <!-- Content section -->
        <h2>Admin Panel Content</h2>
        <p>Check Out Sales Info Using Bar Chart Below</p>
        <div class="sales-chart-container">
            <div class="calendar-container">
                <form id="calendarForm">
                    <label for="month">Month:</label>
                    <select id="month" name="month">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>

                    <label for="year">Year:</label>
                    <input type="number" id="year" name="year" min="2000" max="2100" value="2023">

                    <button type="submit">Show Sales Data</button> <a href="#" onclick="window.print(); return false;">
                <i class="fa fa-print"></i>
                Print the chart
            </a>
                </form>
            </div>

            <canvas id="salesChart"></canvas>
        </div>

        <script>
            function updateSalesData(month, year) {
                // Retrieve sales data for the specified month and year
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var salesData = JSON.parse(xhr.responseText);

                        // Process the sales data
                        var dates = salesData.dates;
                        var sales = salesData.sales;

                        // Update the chart with new data
                        chart.data.labels = dates;
                        chart.data.datasets[0].data = sales;
                        chart.update();
                    }
                };

                xhr.open("GET", "get_sales_data.php?month=" + month + "&year=" + year, true);
                xhr.send();
            }

            // Retrieve the initial sales data
            var currentDate = new Date();
            var currentMonth = currentDate.getMonth() + 1;
            var currentYear = currentDate.getFullYear();
            updateSalesData(currentMonth, currentYear);

            // Handle form submission
            var form = document.getElementById('calendarForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                var month = document.getElementById('month').value;
                var year = document.getElementById('year').value;

                // Update sales data based on selected month and year
                updateSalesData(month, year);
            });

            // Create the chart
            var ctx = document.getElementById('salesChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Sales Count',
                        data: [],
                        backgroundColor: 'rgb(0, 82, 204)',
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales Count'
                            },
                            beginAtZero: true,
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            });
        </script>

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


    <?php
    if (isset($_POST['Logout'])) {
        session_destroy();
        header("Location:admin_login.php");
    }
    ?>

</body>

</html>