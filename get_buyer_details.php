<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['AdminLoginId'])) {
    header("Location: admin_login.php");
    exit();
}

@include 'config.php'; // Assuming your config file is named config.php

// Fetch the buyers' data from the users table with the role column equal to 'buyer'
$query = "SELECT * FROM users WHERE role = 'buyer'";
$result = mysqli_query($conn, $query);

$buyers = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $buyers[] = $row;
    }
}

// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 5;
$totalBuyers = count($buyers);
$totalPages = ceil($totalBuyers / $perPage);
$offset = ($page - 1) * $perPage;

$buyersPerPage = array_slice($buyers, $offset, $perPage);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Seller Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />
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

        /* list */
        /* ===== Career ===== */
        .career-form {
            background-color: #4e63d7;
            border-radius: 5px;
            padding: 0 16px;
        }

        .career-form .form-control {
            background-color: rgba(255, 255, 255, 0.2);
            border: 0;
            padding: 12px 15px;
            color: #fff;
        }

        .career-form .form-control::-webkit-input-placeholder {
            /* Chrome/Opera/Safari */
            color: #fff;
        }

        .career-form .form-control::-moz-placeholder {
            /* Firefox 19+ */
            color: #fff;
        }

        .career-form .form-control:-ms-input-placeholder {
            /* IE 10+ */
            color: #fff;
        }

        .career-form .form-control:-moz-placeholder {
            /* Firefox 18- */
            color: #fff;
        }

        .career-form .custom-select {
            background-color: rgba(255, 255, 255, 0.2);
            border: 0;
            padding: 12px 15px;
            color: #fff;
            width: 100%;
            border-radius: 5px;
            text-align: left;
            height: auto;
            background-image: none;
        }

        .career-form .custom-select:focus {
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .career-form .select-container {
            position: relative;
        }

        .career-form .select-container:before {
            position: absolute;
            right: 15px;
            top: calc(50% - 14px);
            font-size: 18px;
            color: #ffffff;
            content: '\F2F9';
            font-family: "Material-Design-Iconic-Font";
        }

        .filter-result .job-box {
            background: #fff;
            -webkit-box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
            box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
            border-radius: 10px;
            padding: 10px 35px;
        }

        ul {
            list-style: none;
        }

        .list-disk li {
            list-style: none;
            margin-bottom: 12px;
        }

        .list-disk li:last-child {
            margin-bottom: 0;
        }

        .job-box .img-holder {
            height: 65px;
            width: 65px;
            background-color: #4e63d7;
            background-image: -webkit-gradient(linear, left top, right top, from(rgba(78, 99, 215, 0.9)), to(#5a85dd));
            background-image: linear-gradient(to right, rgba(78, 99, 215, 0.9) 0%, #5a85dd 100%);
            font-family: "Open Sans", sans-serif;
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-radius: 65px;
        }

        .career-title {
            background-color: #4e63d7;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            background-image: -webkit-gradient(linear, left top, right top, from(rgba(78, 99, 215, 0.9)), to(#5a85dd));
            background-image: linear-gradient(to right, rgba(78, 99, 215, 0.9) 0%, #5a85dd 100%);
        }

        .job-overview {
            -webkit-box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
            box-shadow: 0 0 35px 0 rgba(130, 130, 130, 0.2);
            border-radius: 10px;
        }

        @media (min-width: 992px) {
            .job-overview {
                position: -webkit-sticky;
                position: sticky;
                top: 70px;
            }
        }

        .job-overview .job-detail ul {
            margin-bottom: 28px;
        }

        .job-overview .job-detail ul li {
            opacity: 0.75;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .job-overview .job-detail ul li i {
            font-size: 20px;
            position: relative;
            top: 1px;
        }

        .job-overview .overview-bottom,
        .job-overview .overview-top {
            padding: 35px;
        }

        .job-content ul li {
            font-weight: 600;
            opacity: 0.75;
            border-bottom: 1px solid #ccc;
            padding: 10px 5px;
        }

        @media (min-width: 768px) {
            .job-content ul li {
                border-bottom: 0;
                padding: 0;
            }
        }

        .job-content ul li i {
            font-size: 20px;
            position: relative;
            top: 1px;
        }

        .mb-30 {
            margin-bottom: 30px;
        }

        .content-wrap {
            flex: 1;
            padding-bottom: 100px;
            /* Adjust the padding to account for the footer height */
        }

        footer {
            background-color: #222;
            color: #fff;
            font-size: 14px;
            text-align: center;
            padding: 20px;
            width: 100%;
        }

        footer p {
            margin: 10px 0;
        }

        footer a {
            color: #3c97bf;
            text-decoration: none;
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
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto mb-4">
                <div class="section-title text-center ">
                    <h3 class="top-c-sep">Registered Buyer Details From Database</h3>
                    <p class="mb-30 ff-montserrat"><?php echo count($buyers); ?> buyers found.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="career-search mb-60">
                    <div class="filter-result">

                        <?php foreach ($buyersPerPage as $buyer) {
                            $userId = $buyer['user_id'];
                            $query = "SELECT buyer_id FROM buyer WHERE user_id = '$userId'";
                            $result = mysqli_query($conn, $query);
                            $buyerData = mysqli_fetch_assoc($result);
                            $buyerId = ($buyerData !== null && isset($buyerData['buyer_id'])) ? $buyerData['buyer_id'] : '';
                        ?>

                            <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                                <div class="job-center my-4 d-md-flex align-items-center flex-auto">
                                    <div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">
                                        <i class="zmdi zmdi-account mr-2"></i><?php echo $buyerId; ?>
                                    </div>
                                    <div class="job-content ">
                                        <h5 class="text-center text-md-center"><?php echo 'Full Name: ' . $buyer['firstname'] . ' ' . $buyer['lastname']; ?></h5>
                                        <ul class="d-md-flex flex-wrap  ff-open-sans">
                                            <li class="mr-md-4">
                                                <i class="zmdi  zmdi-account mr-2"></i><?php echo $buyer['username']; ?>
                                            </li>
                                            <li class="mr-md-4">
                                                <i class="zmdi zmdi-email mr-2"></i><?php echo $buyer['email']; ?>
                                            </li>
                                            <li class="mr-md-4">
                                                <i class="zmdi zmdi-phone mr-2"></i><?php echo $buyer['phone_number']; ?>
                                            </li>
                                            <li class="mr-md-4">
                                                <i class="zmdi zmdi-account mr-2"></i><?php echo $buyer['role']; ?>
                                            </li>
                                            <li class="mr-md-4">
                                                <i class="zmdi zmdi-calendar mr-2"></i><?php echo $buyer['birthdate']; ?>
                                            </li>

                                        </ul>
                                        <li class="mr-md-4">
                                            <i class="zmdi zmdi-pin mr-2"></i><?php echo $buyer['home_address']; ?>
                                        </li>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                        <!-- Pagination -->
                        <div class="content-wrap">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php if ($page > 1) { ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a>
                                        </li>
                                    <?php } ?>
                                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($page < $totalPages) { ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
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
    <?php
    if (isset($_POST['Logout'])) {
        session_destroy();
        header("Location:admin_login.php");
    }
    ?>
</body>

</html>