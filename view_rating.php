<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "config.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the order ID from the URL parameter
if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
} else {
    header("Location: track_parcel.php");
    exit();
}

// Fetch the rating for the order and logged-in user
$userId = $_SESSION['user_id'];
$query = "SELECT r.* FROM buyer_rate r
          INNER JOIN buyer b ON b.buyer_id = r.buyer_id
          WHERE r.order_id = '$orderId' AND b.user_id = '$userId'";
$result = mysqli_query($conn, $query);

// Check if a rating was found for the order
if (mysqli_num_rows($result) > 0) {
    $rating = mysqli_fetch_assoc($result);
} else {
    header("Location: track_parcel.php");
    exit();
}

// Convert rating value to stars
$ratingValue = $rating['rating'];
$stars = '';
for ($i = 1; $i <= 5; $i++) {
    if ($i <= $ratingValue) {
        $stars .= '<i class="fas fa-star"></i>'; // Full star icon
    } else {
        $stars .= '<i class="far fa-star"></i>'; // Empty star icon
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Parcel</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .rating-stars {
            color: gold;
        }
    </style>
</head>

<body>
    <!-- Navigation section goes here -->

    <h1>View My Rating</h1>

    <table>
        <tr>
            <th>Order ID</th>
            <th>Rating</th>
            <th>Description</th>
        </tr>
        <tr>
            <td><?php echo $rating['order_id']; ?></td>
            <td>
                <div class="rating-stars">
                    <?php echo $stars; ?>
                </div>
            </td>
            <td><?php echo $rating['description']; ?></td>
        </tr>
    </table>

    <!-- Footer section goes here -->
</body>

</html>