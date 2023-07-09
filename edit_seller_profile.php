<!-- This code is written by Eng Jing Yi (CSD21005) -->

<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    @include 'add_product_config.php';

    // Get seller information
    $sellerId = $_SESSION['seller_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Process the form submission
        // Retrieve the updated profile data from the form
        $firstname = $_POST['seller_firstname'];
        $lastname = $_POST['seller_lastname'];
        $gender = $_POST['seller_gender'];
        $birthdate = $_POST['seller_birthdate'];
        $username = $_POST['seller_username'];
        $email = $_POST['seller_email'];
        $phoneNumber = $_POST['seller_phone_number'];
        $homeAddress = $_POST['seller_home_address'];
        $bio = $_POST['seller_bio'];
        $school = $_POST['seller_school'];

        // Update the seller profile in the database
        $updateQuery = "UPDATE seller
                        INNER JOIN users ON seller.user_id = users.user_id
                        SET users.firstname = ?,
                            users.lastname = ?,
                            users.gender = ?,
                            users.birthdate = ?,
                            users.username = ?,
                            users.email = ?,
                            users.phone_number = ?,
                            users.home_address = ?,
                            users.bio = ?,
                            users.school = ?
                        WHERE seller.seller_id = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $updateQuery);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "ssssssssssi", $firstname, $lastname, $gender, $birthdate, $username, $email, $phoneNumber, $homeAddress, $bio, $school, $sellerId);

        // Execute the statement
        $updateResult = mysqli_stmt_execute($stmt);

        if (!$updateResult) {
            die("Error: " . mysqli_error($conn));
        }

        // Redirect to the seller profile page after the update
        header("Location: seller_profile.php?seller_id=$sellerId");
        exit();

    } else {

        // Retrieve the seller's current profile information from the database
        $query = "SELECT * FROM seller
                INNER JOIN users ON seller.user_id = users.user_id
                WHERE seller.seller_id = $sellerId";

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

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

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
                <a class="text-light text-decoration-none" href="logout.php"><i class="bi bi-box-arrow-right"></i></a>
            </li>
        </ul>
    </div>

</nav>
<!-- End Nav Bar -->
   
        <h2 class="sprofile_title">Edit My Profile</h2>

        <div class="sprofile_container">

            <div class="form_container">
                <div class="edit-seller-profile-form-container">

                    <form name="edit-seller-profile-form" method="POST" action="" enctype="multipart/form-data" 
                        onsubmit="return confirmEditProfile();">
                        <!-- required field -->
                        <div class="s_firstname">     <!-- s_firstname = seller firstname-->
                            <label for="seller-firstname" class="l_firstname">First Name:</label><br>      <!-- l_firstname = label for seller firstname-->
                            <input type="text" placeholder="Enter First Name" value="<?php echo $firstname; ?>" name="seller_firstname" 
                                class="firstname" required oninvalid="this.setCustomValidity('Please fill in your first name.')" 
                                    oninput="this.setCustomValidity('')"><br>
                        </div>

                        <!-- required field -->
                        <div class="s_lastname">
                            <label for="seller-lastname" class="l_lastname">Last Name:</label><br>
                            <input type="text" placeholder="Enter Last Name" value="<?php echo $lastname; ?>" name="seller_lastname" 
                                class="lastname" required oninvalid="this.setCustomValidity('Please fill in your last name.')" 
                                    oninput="this.setCustomValidity('')"><br>
                        </div>

                        <!-- optional field -->
                        <div class="s_gender">
                            <label for="seller-gender" class="l_gender">Gender:</label><br>
                            <select name="seller_gender" class="gender">
                                <option value=""        <?php if($row['gender']=="") echo 'selected="selected"'; ?> 
                                    selected disabled hidden>Select Your Gender</option>
                                <option value="Male"    <?php if($row['gender']=="Male") echo 'selected="selected"'; ?>     >Male</option>
                                <option value="Female"  <?php if($row['gender']=="Female") echo 'selected="selected"'; ?>   >Female</option>
                                <option value="Other"   <?php if($row['gender']=="Other") echo 'selected="selected"'; ?>    >Other</option>
                            </select><br>
                        </div>

                        <!-- optional field -->
                        <div class="s_birthdate">
                            <label for="seller_birthdate" class="l_birthdate">Birth Date:</label><br>
                            <input type="date" value="<?php echo $birthdate; ?>" name="seller_birthdate" class="birthdate"><br>
                        </div>

                        <!-- disabled field -->
                        <div class="s_username">
                            <label for="seller-username" class="l_username">Username:</label><br>
                            <input type="text" value="<?php echo $username; ?>" name="seller_username" class="username" readonly><br>
                        </div>

                        <!-- required field -->
                        <div class="s_email">
                            <label for="seller-email" class="l_email">Email:</label><br>
                            <input type="email" placeholder="Enter Email" value="<?php echo $email; ?>" name="seller_email" 
                                class="email" required oninvalid="this.setCustomValidity('Please fill in your email.')" 
                                    oninput="this.setCustomValidity('')"><br>                     
                        </div>

                        <!-- required field -->
                        <div class="s_phone_number">
                            <label for="seller-phone-number" class="l_phone_number">Phone Number:</label><br>
                            <input type="tel" placeholder="Enter Phone Number" value="<?php echo $phoneNumber; ?>" pattern="[0-9]{7,15}" 
                                name="seller_phone_number" class="phone_number" required 
                                    oninvalid="this.setCustomValidity('Please fill in your phone number.')" 
                                        oninput="this.setCustomValidity('')"><br>
                        </div>

                        <!-- required field -->
                        <div class="s_home_address">
                            <label for="seller-home-address" class="l_home_address">Home Address:</label><br>
                            <input type="text" placeholder="Enter Home Address" value="<?php echo $homeAddress; ?>" name="seller_home_address" 
                                class="home_address" required oninvalid="this.setCustomValidity('Please fill in your home address.')" 
                                    oninput="this.setCustomValidity('')"><br>
                        </div>

                        <!-- optional field -->
                        <div class="s_bio">
                            <label for="seller-bio" class="l_bio">Bio:</label><br>
                            <textarea placeholder="Enter Bio..." name="seller_bio" class="bio"><?php echo $bio; ?></textarea><br>
                        </div>

                        <!-- optional field -->
                        <div class="s_school">
                            <label for="seller-school" class="l_school">School:</label><br>
                            <input type="text" placeholder="Enter School" value="<?php echo $school; ?>" name="seller_school" class="school"><br>
                        </div>

                        <!-- optional field -->
                        <div class="s_password">
                            <p class="reset_password">Reset password? <a href="seller_reset_password.php" class="reset_button"> Reset</a></p>
                        </div>

                        <!-- Button -->
                        <div class="save">
                            <button type="submit" class="save-button"><i class="fas fa-save"></i> Save</button>
                        </div>

                        <div class="back">
                            <a href="seller_profile.php" class="edit-back-button"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </form>

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
    <script src="edit_seller_profile_javascript.js"></script>
</div>
<!-- End Script -->
</body>

</html>