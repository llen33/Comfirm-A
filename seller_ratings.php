<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

@include 'config.php';

// Check if the seller is logged in
if (!isset($_SESSION['seller_id'])) {
    header('Location: login.php');
    exit();
}

// Check if the product ID is provided in the URL
if (!isset($_GET['product_id'])) {
    header('Location: product_list.php');
    exit();
}

$product_id = $_GET['product_id'];

// Fetch the product details from the database
$productQuery = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
$product = mysqli_fetch_assoc($productQuery);

// Check if the product belongs to the logged-in seller
if ($product['seller_id'] != $_SESSION['seller_id']) {
    header('Location: product_list.php');
    exit();
}

// Fetch the rating details from the database for the current product ID
$ratingQuery = mysqli_query($conn, "SELECT br.rating_date,br.rating, br.description, br.buyer_id, u.username
FROM buyer_rate br
INNER JOIN buyer b ON br.buyer_id = b.buyer_id
INNER JOIN users u ON b.user_id = u.user_id
INNER JOIN test_order ord ON br.order_id = ord.order_id
WHERE ord.product_id = $product_id");

// Fetch all ratings
$ratings = mysqli_fetch_all($ratingQuery, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Seller - View My Ratings</title>
    <style>
        /* CSS styles for seller_ratings.css file */

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .ratings {
            margin-bottom: 20px;
        }

        .rating {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .rating h4 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .stars {
            margin-bottom: 10px;
        }

        .gold-star,
        .white-star {
            font-size: 24px;
        }

        .rating-date {
            font-size: 14px;
            color: #888;
        }

        .gold-star {
            color: gold;
        }

        .white-star {
            font-size: 24px;
            color: white;
            border: 1px solid #ccc;
            padding: 2px;
            display: inline-block;
            position: relative;
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
            -webkit-clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Seller Ratings for <?php echo $product['name']; ?></h2>
        <div class="ratings">
            <?php if (!empty($ratings)) { ?>
                <?php foreach ($ratings as $rating) { ?>
                    <div class="rating">
                        <h4>
                            <p class="rating-date">Rated by : <?php echo $rating['username']; ?></p>

                        </h4>
                        <div class="stars">
                            <?php
                            $ratingValue = $rating['rating'];


                            // Calculate the number of filled stars (full stars)
                            $fullStars = floor($ratingValue);

                            // Calculate the remaining decimal part for half star
                            $decimalPart = $ratingValue - $fullStars;

                            // Display full stars
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '<i class="fas fa-star gold-star"></i>';
                            }

                            // Display half star if there is a decimal part greater than 0
                            if ($decimalPart > 0) {
                                echo '<i class="fas fa-star-half-alt gold-star"></i>';
                            }

                            // Calculate the remaining empty stars
                            $emptyStars = 5 - $fullStars - ceil($decimalPart);

                            // Display empty stars
                            for ($i = 0; $i < $emptyStars; $i++) {
                                echo '<i class="far fa-star white-star"></i>';
                            }
                            ?>
                        </div>

                        <p class="rating-date">Buyer About the Product : <?php echo $rating['description']; ?></p>
                        <p class="rating-date">Rated on: <?php echo $rating['rating_date']; ?></p>


                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No ratings available for this product.</p>
            <?php } ?>
        </div>
    </div>
</body>

</html>