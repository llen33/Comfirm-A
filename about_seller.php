<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    @include 'add_product_config.php';

    // Retrieve the seller_id from the URL parameter
    if (isset($_GET['seller_id'])) {

        $seller_id = $_GET['seller_id'];

        // Construct the SQL query to fetch seller information
        $sql = "SELECT * FROM seller
                JOIN users ON seller.user_id = users.user_id
                WHERE seller.seller_id = $seller_id";

        // Execute the query
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetch the seller information
            $seller = $result->fetch_assoc();

            $firstname = $seller['firstname'];
            $lastname = $seller['lastname'];
            $gender = $seller['gender'];
            $email = $seller['email'];
            $phoneNumber = $seller['phone_number'];
            $bio = $seller['bio'];
            $school = $seller['school'];

        } else {

            echo "Seller not found.";

        }

    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Seller</title>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- custom css file link -->
        <link rel="stylesheet" href="about_seller_style.css" type="text/css">

        <!-- javascript link -->
        <script src="about_seller_javascript.js"></script>

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
                    <li><a href="#">Products</a></li>
                    <li><a href="seller_profile.php">Profile</a></li>
                    <li><a href="index.php">Logout</a></li>

                </ul>

            </div>

        </nav>

        <h2 class="title">About Seller</h2>

        <div class="container">

            <div class="about-seller-container">

                <div class="seller-name">

                    <p class="label">Seller Name: </p>
                    <p class="info"><?php echo $firstname; ?><?php echo " " ?><?php echo $lastname; ?></p><br>

                </div>

                <div class="gender">

                    <p class="label">Gender: </p>
                    <p class="info"><?php echo $gender; ?></p><br>

                </div>

                <div class="email">

                    <p class="label">Email: </p>
                    <p class="info"><?php echo $email; ?></p><br>

                </div>

                <div class="phone-number">

                    <p class="label">Phone Number: </p>
                    <p class="info"><?php echo $phoneNumber; ?></p><br>

                </div>

                <div class="bio">

                    <p class="label">Bio: </p>
                    <p class="info"><?php echo $bio; ?></p><br>

                </div>

                <div class="school">

                    <p class="label">School: </p>
                    <p class="info"><?php echo $school; ?></p><br>

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
