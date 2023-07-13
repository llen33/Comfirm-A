<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

@include "config.php";

// Function to check if a username exists in the database
function isUsernameExists($username, $conn) {
    $query = "SELECT COUNT(*) as count FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" type="text/css" href="sigup_login style.css" title="style" />
</head>

<body>

<div class="login_container">
    <div class="login_form">

        <div class="left-column">
            <img class="login_image" src="disted2.png" alt="Image">
        </div>

        <div class="right-column">  
            <?php

                if (isset($_POST['submit'])) {
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];
                    $phone_number = $_POST['phone_number'];
                    $home_address = $_POST['home_address'];
                    $role = $_POST['role'];

                    // Check if username already exists
                    if (isUsernameExists($username, $conn)) {
                        $error[] = 'Username already exists. Please choose a different username.';
                    } else {
                        $insert = "INSERT INTO users (firstname, lastname, username, password, email, phone_number, home_address, role) VALUES('$firstname', '$lastname', '$username', '$password', '$email', '$phone_number', '$home_address', '$role')";
                        $upload = mysqli_query($conn, $insert);

                        $user_id = mysqli_insert_id($conn);

                        if ($role == 'seller') {
                            // Insert seller details into the Seller table
                            $query = "INSERT INTO Seller (user_id) VALUES ($user_id)";
                            mysqli_query($conn, $query);
                        } elseif ($role == 'buyer') {
                            // Insert buyer details into the Buyer table
                            $query = "INSERT INTO Buyer (user_id) VALUES ($user_id)";
                            mysqli_query($conn, $query);
                        }

                        if ($upload) {
                            $message[] = 'Successfully saved.';
                        } else {
                            $error[] = 'There was an error while saving data.';
                        }
                    }
                }

            ?>

            <h1 class="tittle">Sign Up</h1>

            <div class="regisbox">
                <form name="registration" action="signup.php" method="post">

                        <!-- message -->
                        <?php 
                            if (isset($error)) {   
                        ?>
                            <p class="error-message">
                                <?php foreach ($error as $errorMessage): ?>
                                    <?php echo $errorMessage; ?><br>
                                <?php endforeach; ?>
                            </p>
                        <?php                    
                            } elseif (isset($message)) {                       
                        ?>
                            <p class="success-message">
                                <?php foreach ($message as $successMessage): ?>
                                    <?php echo $successMessage; ?><br>
                                <?php endforeach; ?>
                            </p>
                        <?php                  
                            }                        
                        ?>

                        <div class="regisform">
                            <label for="firstname"><b>First Name</b></label><br>
                            <input type="text" name="firstname" placeholder="First name" required><br>

                            <label for="lastname"><b>Last Name</b></label><br>
                            <input type="text" name="lastname" placeholder="Last name" required><br>

                            <label for="username"><b>Username</b></label><br>
                            <input type="text" name="username" placeholder="Username" required><br>

                            <label for="email"><b>Email Address</b></label><br>
                            <input type="email" name="email" placeholder="Email" required><br>

                            <label for="password"><b>Password</b></label><br>
                            <input type="password" name="password" placeholder="Password" required><br>

                            <label for="phone_number"><b>Contact Number</b></label><br>
                            <input type="text" name="phone_number" placeholder="Contact Number" required><br>

                            <label for="home_address"><b>Home Address</b></label><br>
                            <input type="text" name="home_address" placeholder="Home address" required><br>

                            <label for="role"><b>Register for: </b></label><br>
                            <input type="radio" name="role" value="seller"> Seller
                            <input type="radio" name="role" value="buyer" required> Buyer
                            <br><br>

                            <input type="submit" name="submit" value="Sign Up">
                        </div>
                </form>

                <p>Already have a member? <a href='login.php'>Login Here</a></p>
            </div>
            
        </div>
    </div>

</div>



</body>

</html>
