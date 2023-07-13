<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="sigup_login style.css" />
</head>
<body>

<div class="login_container">
    <div class="login_form">

        <div class="left-column">
        <img class="login_image" src="disted2.png" alt="Image">
        </div>

        <div class="right-column">  
            <h1 class="tittle">Log In</h1>

            <div class="loginbox">

                <form action="loginn.php" method="post" name="login">

                <?php if (isset($_GET['error'])) { ?>
                    <p class='error'><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <div class="loginform">
                    <label for="username"><b>Username</b></label><br>
                    <input type="text" name="username" placeholder="Username"><br>

                    <label for="password"><b>Password</b></label><br>
                    <input type="password" name="password" placeholder="Password"><br>

                    <input name="submit" type="submit" value="Login">
                </div>

                </form>
        
                <p>Not registered yet? <a href='signup.php'>Register Here</a></p>

            </div>
        </div>

    </div>
</div>


</body>
</html>
