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
                            users.birth_date = ?,
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
        $birthdate = $row['birth_date'];
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

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- custom css file link -->
        <link rel="stylesheet" href="edit_seller_profile_style.css" type="text/css">

        <!-- javascript link -->
        <script src="edit_seller_profile_javascript.js"></script>

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
        
        <h2 class="title">Edit My Seller Profile</h2>

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

                        <label for="seller-birthdate" class="l_birthdate">Birth Date:</label><br>

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

                        <a href="seller_profile.php" class="back-button"><i class="fa fa-arrow-left"></i> Back</a>

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