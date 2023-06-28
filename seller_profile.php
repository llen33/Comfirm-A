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

    $row = mysqli_fetch_assoc($result);
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $gender = $row['gender'];
    $birthdate = $row['birthdate'];
    $username = $row['username'];
    $email = $row['email'];
    $phoneNumber = $row['phone_number'];
    $homeAddress = $row['home_address'];
    $bio = $row['bio'];
    $school = $row['school'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Seller Profile</title>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- custom css file link -->
        <link rel="stylesheet" href="seller_profile_style.css" type="text/css">

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

        <h2 class="title">My Seller Profile</h2>

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

            <div class="seller-profile-container">

                <div class="first-name">

                    <p class="label">First Name: </p>
                    <p class="info"><?php echo $firstname; ?></p><br>

                </div>

                <div class="last-name">

                    <p class="label">Last Name: </p>
                    <p class="info"><?php echo $lastname; ?></p><br>

                </div>

                <div class="gender">

                    <p class="label">Gender: </p>
                    <p class="info"><?php echo $gender; ?></p><br>

                </div>

                <div class="birth-date">

                    <p class="label">Birth Date: </p>
                    <p class="info"><?php echo $birthdate; ?></p><br>

                </div>

                <div class="username">

                    <p class="label">Username: </p>
                    <p class="info"><?php echo $username; ?></p><br>

                </div>

                <div class="email">

                    <p class="label">Email: </p>
                    <p class="info"><?php echo $email; ?></p><br>

                </div>

                <div class="phone-number">

                    <p class="label">Phone Number: </p>
                    <p class="info"><?php echo $phoneNumber; ?></p><br>

                </div>

                <div class="home-address">

                    <p class="label">Home Address: </p>
                    <p class="info"><?php echo $homeAddress; ?></p><br>

                </div>

                <div class="bio">

                    <p class="label">Bio: </p>
                    <p class="info"><?php echo $bio; ?></p><br>

                </div>

                <div class="school">

                    <p class="label">School: </p>
                    <p class="info"><?php echo $school; ?></p><br>

                </div>

                <div class="edit">

                    <a href="edit_seller_profile.php?seller_id=<?php echo $sellerId; ?>" class="edit-seller-profile-button">
                        <i class="fas fa-edit"></i> Edit</a><br>

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