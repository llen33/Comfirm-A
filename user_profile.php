<?php
session_start();
if (!isset($_SESSION['AdminLoginId'])) {
    header("Location: /admin_login/admin_login.php");
    exit(); // Make sure to add this line to stop executing further code
}

include 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the verify button is clicked
    if (isset($_POST['verify'])) {
        // Get the username from the form
        $username = $_POST['username'];

        // Prepare and execute the query to update the verification status in the database
        $stmt = $conn->prepare("INSERT INTO verify (seller_id, verification_status) VALUES (?, ?)");
        $sellerId = $username; // Assuming the seller_id column in the verify table corresponds to the username
        $verificationStatus = 1; // Set the verification status to 1 for verified
        $stmt->bind_param("si", $sellerId, $verificationStatus);
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->affected_rows > 0) {
            echo "Seller verified successfully.";
        } else {
            echo "Unable to verify seller.";
        }

        // Close the statement
        $stmt->close();
    }
}

// Fetch the user details
$stmt = $conn->prepare("SELECT firstname, lastname, username, phone_number, home_address FROM users WHERE role = 'seller'");
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" type="image/x-icon" href="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Thrifts Depot-Seller Info</title>
    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #333;
            color: #fff;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            background-color: #ff5757;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .navbar {
            background-color: #222;
            color: #fff;
            padding: 10px 40px;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
        }

        .navbar ul li {
            display: inline-block;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .navbar ul li a:hover {
            background-color: #fff;
            color: #161B24;
        }

        .content {
            padding: 20px 40px;
        }

        footer {
            background-color: #222;
            color: #fff;
            font-size: 14px;
            bottom: 0;
            position: fixed;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 999;
            padding: 20px;
        }

        footer p {
            margin: 10px 0;
        }

        footer a {
            color: #3c97bf;
            text-decoration: none;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            border-radius: 7px;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-align: left;
        }

        td {
            text-align: left;
        }

        .verify-button {
            background-color: #2E8B57;
            /* Medium dark green color */
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }


    </style>
</head>

<body>
<header class="header">
        <h1>Welcome to the Admin Panel, <?php echo $_SESSION['AdminLoginId']; ?></h1>
        <form method="POST" action="admin_login.php">
            <button type="submit" name="Logout">Logout</button>
        </form>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="admin_panel.php">Home</a></li>
            <li><a href="user_profile.php">Verify Seller</a></li>
            <li><a href="prod_data_admin.php">Products Database</a></li>
            <li><a href="user_payment.php">Payment</a></li>
        </ul>
    </nav>

    <main>
        <!-- Table to get seller info -->
        <h1 style="text-align: center;">Seller Info</h1>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Phone Number</th>
                <th>Home Address</th>
                <th>Verify</th>
            </tr>
            <?php
            // Display the user details
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['home_address'] . "</td>";
                echo "<td><form method='post'><input type='hidden' name='username' value='" . $row['username'] . "'><button type='submit' name='verify' class=\"verify-button\">Verify Now</button></form></td>";
                echo "</tr>";
            }

            // Close the statement
            $stmt->close();
            ?>
        </table>
        <!-- End -->
    </main>
 

    <footer>
        <p>Thrifts Depot 2023<br>
            <a href="thriftsdepot@gmail.com">thriftsdepot@gmail.com</a> ||
            <a href="/Homepage_Thiviyaa/index.php">Homepage</a> ||
            <a href="admin_login.php">Admin Panel</a>
        </p>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>