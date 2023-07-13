<!-- This code is written by Eng Jing Yi (CSD21005) -->

<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    @include 'add_product_config.php';

    // Get seller information
    $sellerId = $_SESSION['seller_id'];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Retrieve form data
        $currentPassword = $_POST["seller_current_password"];
        $newPassword = $_POST["seller_new_password"];
        $confirmPassword = $_POST["seller_confirm_password"];

        // Validate form data (add your own validation rules)
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {

            $error = "Please fill in all fields.";

        } elseif ($newPassword != $confirmPassword) {

            $error = "New password and confirm password do not match.";

        } else {

            // Retrieve current password from the database
            $query = "SELECT password FROM users
                    INNER JOIN seller ON seller.user_id = users.user_id
                    WHERE seller.seller_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $sellerId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (!$row) {

                $error = "Seller not found.";

            } elseif ($currentPassword != $row["password"]) {

                $error = "Invalid current password.";

            } else {

                // Update password
                $updateQuery = "UPDATE users
                                INNER JOIN seller ON seller.user_id = users.user_id
                                SET users.password = ?
                                WHERE seller.seller_id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $newPassword, $sellerId);
                $updateStmt->execute();

                // Password change successful
                $success = "Password changed successfully.";

            }

        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

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
        

        <h2 class="sprofile_title">Reset Your Password</h2>

        <div class="sprofile_container">
            <div class="form_container">
                <div class="reset-seller-password-form-container">

                    <form name="reset-seller-password-form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data"
                        onsubmit="return confirmResetPassword();">

                        <!-- message -->
                        <?php 
                        
                            if (isset($error)) { 
                            
                        ?>

                            <p class="error-message"><?php echo $error; ?></p>

                        <?php 
                    
                            } elseif (isset($success)) { 
                        
                        ?>

                            <p class="success-message"><?php echo $success; ?></p>

                        <?php 
                    
                            } 
                        
                        ?>

                        <div class="s_current_password">
                            <label for="seller-current-password" class="l_current_password">Current Password:</label><br>
                            <input type="password" placeholder="Enter Current Password" name="seller_current_password" class="current_password" 
                                required oninvalid="this.setCustomValidity('Please fill in your current password.')" 
                                    oninput="this.setCustomValidity('')"><br>
                        </div>

                        <div class="s_new_password">
                            <label for="seller-new-password" class="l_new_password">New Password:</label><br>
                            <input type="password" placeholder="Enter New Password" name="seller_new_password" class="new_password" 
                                required oninvalid="this.setCustomValidity('Please fill in your new password.')" 
                                    oninput="this.setCustomValidity('')"><br>
                        </div>

                        <div class="s_confirm_password">
                            <label for="seller-confirm-password" class="l_confirm_password">Confirm Password:</label><br>
                            <input type="password" placeholder="Enter Confirm Password" name="seller_confirm_password" class="confirm_password" 
                                required oninvalid="this.setCustomValidity('Please fill in your confirm password.')" 
                                    oninput="this.setCustomValidity('')"><br>
                        </div>

                        <!-- Button -->
                        <div class="reset">
                            <button type="submit" class="reset-button"><i class="fas fa-save"></i> Reset</button>
                        </div>

                        <div class="reset_back">
                            <a href="edit_seller_profile.php" class="reset-back-button"><i class="fa fa-arrow-left"></i> Back</a>
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
        <script src="seller_reset_password_javascript.js"></script>
    </div>
<!-- End Script -->

</body>

</html>