<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    @include 'add_product_config.php';

    // Get the order ID from the URL parameter
    $order_id = $_GET['order_id'];

    // Retrieve buyer details based on the order ID
    $buyerQuery = "SELECT * FROM users WHERE user_id IN (SELECT user_id FROM test_order WHERE order_id = $order_id)";
    $buyerResult = mysqli_query($conn, $buyerQuery);

    if (!$buyerResult) {
        die("Error: " . mysqli_error($conn));
    }

    // Check if any rows were returned
    if ($buyerResult->num_rows > 0) {
        // Fetch the seller information
        $buyer = $buyerResult->fetch_assoc();

        $firstname = $buyer['firstname'];
        $lastname = $buyer['lastname'];
        $homeAddress = $buyer['home_address'];
        $email = $buyer['email'];
        $phoneNumber = $buyer['phone_number'];

    } else {

        echo "Seller not found.";

    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Buyer's Details</title>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- custom css file link -->
        <link rel="stylesheet" href="seller_get_buyer_details_style.css" type="text/css">

        <!-- javascript link -->
        <script src="seller_get_buyer_details_javascript.js"></script>

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
                    <li><a href="index.php">Logout</a></li>

                </ul>

            </div>

        </nav>

        <h2 class="title">Buyer's Details</h2>

        <div class="container">

            <div class="about-buyer-container">

                <div class="buyer-name">

                    <p class="label">Buyer Name: </p>
                    <p class="info"><?php echo $firstname; ?><?php echo " " ?><?php echo $lastname; ?></p><br>

                </div>

                <div class="home-address">

                    <p class="label">Home Address: </p>
                    <p class="info"><?php echo $homeAddress; ?></p><br>

                </div>

                <div class="email">

                    <p class="label">Email: </p>
                    <p class="info"><?php echo $email; ?></p><br>

                </div>

                <div class="phone-number">

                    <p class="label">Phone Number: </p>
                    <p class="info"><?php echo $phoneNumber; ?></p><br>

                </div>

                <div class="back">

                    <button class="back-button" onclick="goBack()"><i class="fa fa-arrow-left"></i> Back</button>
                    
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