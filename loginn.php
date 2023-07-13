<?php
session_start();
include "config.php";

// Check if user is already logged in, redirect if true
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] === 'seller') {
        header("Location: index_seller.php");
    } elseif ($_SESSION['role'] === 'buyer') {
        header("Location: index_buyer.php");
    }
    exit;
}

// Check whether the user enters a username and password
if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
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
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['password'] === $password) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['user_id'] = $row['user_id']; // Add user_id to the session

                if ($row['role'] === 'seller') {
                    // Fetch the seller ID from the seller table
                    $seller_id_query = "SELECT seller_id FROM seller WHERE user_id = " . $row['user_id'];
                    $seller_id_result = mysqli_query($conn, $seller_id_query);

                    if (mysqli_num_rows($seller_id_result) === 1) {
                        $seller = mysqli_fetch_assoc($seller_id_result);
                        $_SESSION['seller_id'] = $seller['seller_id'];
                    } else {
                        header("Location: login.php?error=Failed to fetch seller ID");
                        exit();
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
                        header("Location: login.php?error=Failed to fetch buyer ID");
                        exit();
                    }

                    // Redirect to buyer homepage
                    header('Location:index_buyer.php');
                    exit();
                }
            } else {
                header("Location: login.php?error=Incorrect password");
                exit();
            }
        } else {
            header("Location: login.php?error=Incorrect username");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
