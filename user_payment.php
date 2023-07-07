<?php
session_start();
if (!isset($_SESSION['AdminLoginId'])) {
    header("Locatioadmin_login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Thrifts Depot</title>
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


    <footer>
        <p>Thrifts Depot 2023<br>
            <a href="thriftsdepot@gmail.com"> thriftsdepot@gmail.com || </a>
            <a href="/Homepage_Thiviyaa/index.php"> Homepage || </a>
            <a href="admin_login.php">Admin Panel</a>
        </p>
    </footer>


    <?php
    if (isset($_POST['Logout'])) {
        session_destroy();
        header("Location:/admin_login/admin_login.php");
    }
    ?>

</body>

</html>