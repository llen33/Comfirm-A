<?php

session_start();
include "config.php";

// check whether the user enters username and password
if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username)) {
        header("Location: login.php?error=Username is required");
        exit();
    } elseif (empty($password)) {
        header("Location: login.php?error=Password is required");
        exit();
    } else {
        // Scan the database
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'seller') {
                // Fetch the seller ID from the seller table
                $seller_id_query = "SELECT seller_id FROM seller WHERE user_id = " . $row['user_id'];
                $seller_id_result = mysqli_query($conn, $seller_id_query);

                if (mysqli_num_rows($seller_id_result) === 1) {
                    $seller = mysqli_fetch_assoc($seller_id_result);
                    $_SESSION['seller_id'] = $seller['seller_id'];
                } else {
                    $_SESSION['seller_id'] = null; // Set seller_id to null instead of redirecting
                }

                // Redirect to seller homepage
                header('Location: index_seller.php');
                exit();
            } elseif ($row['role'] === 'buyer') {
                // Fetch the buyer ID from the buyer table
                $buyer_id_query = "SELECT buyer_id FROM buyer WHERE user_id = " . $row['user_id'];
                $buyer_id_result = mysqli_query($conn, $buyer_id_query);

                if (mysqli_num_rows($buyer_id_result) === 1) {
                    $buyer = mysqli_fetch_assoc($buyer_id_result);
                    $_SESSION['buyer_id'] = $buyer['buyer_id'];
                } else {
                    $_SESSION['buyer_id'] = null; // Set buyer_id to null instead of redirecting
                }

                // Redirect to buyer homepage
                header('Location: index_buyer.php');
                exit();
            }
        }

        // Redirect to login page with error message for all failure cases
        header("Location: login.php?error=Incorrect username or password");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

?>
