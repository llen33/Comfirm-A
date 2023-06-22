<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    @include 'config.php';

    // Get seller information
    $buyerId = $_SESSION['buyer_id'];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Retrieve form data
        $currentPassword = $_POST["buyer_current_password"];
        $newPassword = $_POST["buyer_new_password"];
        $confirmPassword = $_POST["buyer_confirm_password"];

        // Validate form data (add your own validation rules)
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {

            $error = "Please fill in all fields.";

        } elseif ($newPassword != $confirmPassword) {

            $error = "New password and confirm password do not match.";

        } else {

            // Retrieve current password from the database
            $query = "SELECT password FROM users
                    INNER JOIN buyer ON buyer.user_id = users.user_id
                    WHERE buyer.buyer_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $buyerId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (!$row) {

                $error = "Buyer not found.";

            } elseif ($currentPassword != $row["password"]) {

                $error = "Invalid current password.";

            } else {

                // Update password
                $updateQuery = "UPDATE users
                                INNER JOIN buyer ON buyer.user_id = users.user_id
                                SET users.password = ?
                                WHERE buyer.buyer_id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $newPassword, $buyerId);
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

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- custom css file link -->
        <link rel="stylesheet" href="buyer_reset_password_style.css" type="text/css">

        <!-- javascript link -->
        <script src="buyer_reset_password_javascript.js"></script>

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
        
        <h2 class="title">Reset Your Password</h2>

        <div class="container">

            <!-- left navigation bar -->
            <div class="left-nav-bar">

                <ul class="seller-menu">

                    <li><a href="add_product.php">Add Product</a></li>
                    <li><a href="product_list.php">Product Added List</a></li>
                    <li><a href="seller_profile.php">Profile</a></li>
                    <li><a href="#">Payment</a></li>

                </ul>

            </div>

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

                        <input type="password" placeholder="Enter Current Password" name="buyer_current_password" class="current_password"
                            required oninvalid="this.setCustomValidity('Please fill in your current password.')" 
                                oninput="this.setCustomValidity('')"><br>

                    </div>

                    <div class="s_new_password">

                        <label for="seller-new-password" class="l_new_password">New Password:</label><br>

                        <input type="password" placeholder="Enter New Password" name="buyer_new_password" class="new_password"
                            required oninvalid="this.setCustomValidity('Please fill in your new password.')" 
                                oninput="this.setCustomValidity('')"><br>

                    </div>

                    <div class="s_confirm_password">

                        <label for="seller-confirm-password" class="l_confirm_password">Confirm Password:</label><br>

                        <input type="password" placeholder="Enter Confirm Password" name="buyer_confirm_password" class="confirm_password"
                            required oninvalid="this.setCustomValidity('Please fill in your confirm password.')" 
                                oninput="this.setCustomValidity('')"><br>

                    </div>

                    <!-- Button -->
                    <div class="reset">

                        <button type="submit" class="reset-button"><i class="fas fa-save"></i> Reset</button>

                    </div>

                    <div class="back">

                        <a href="edit_buyer_profile.php" class="back-button"><i class="fa fa-arrow-left"></i> Back</a>

                    </div>

                </form>

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
