<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Ubuntu', sans-serif;
            overflow-x: hidden;
            /* Prevent horizontal scrollbar */
        }

        div.header {
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 60px;
            color: black;
        }

        div.header button {
            font-size: 16px;
            padding: 8px 12px;
            border: 2px solid black;
            border-radius: 5px;
            color: white;
            background-color: black;
        }



        @import url('https://fonts.googleapis.com/css2?family=Poppins&family=Ubuntu:wght@300;700&display=swap');

        .navbar {
            background-color: #222;
            display: flex;
            justify-content: space-around;
            align-items: center;
            line-height: 5rem;
        }

        h2 {
            text-align: center;
        }

        .left h1 {
            font-size: 2.5rem;
            cursor: pointer;
            color: white;
        }

        .right ul {
            display: flex;
            list-style: none;
        }

        .right ul li a {
            padding: 10px 20px;
            font-size: 1.2rem;
            color: white;
            cursor: pointer;
            text-decoration: none;
            transition: all 1s;
        }

        .right ul li a:hover {
            background-color: #fff;
            border-radius: 7px;
            color: rgb(22, 7, 36);
        }

        @media screen and (max-width: 805px) {
            .right ul {
                flex-direction: column;
                position: fixed;
                top: 5rem;
                left: 0;
                width: 100%;
                background-color: rgb(22, 7, 36);
                transition: all 1s;
                padding: 1rem 0;
            }

            .right ul li a {
                display: block;
                padding: 10px 20px;
                font-size: 1.2rem;
                color: white;
                cursor: pointer;
                text-decoration: none;
                transition: all 1s;
            }
        }


        /*footer */
        footer {
            background-color: #222;
            color: #fff;
            font-size: 14px;
            text-align: center;
            padding: 20px;
            position: relative;
            /* Add this line */
            bottom: 0;
            /* Add this line */
            width: 100%;
            /* Add this line */
        }

        footer p {
            margin: 10px 0;
        }

        footer a {
            color: #3c97bf;
            text-decoration: none;
        }

        /* Adjust the container width and margins for the contact form */
        .contact-form-container {
            max-width: 500px;
            margin: 0 auto;
        }

        /* Adjust the input and textarea width */
        .contact-form-container input,
        .contact-form-container textarea {
            width: 100%;
        }

        .bg-light-gray {
            background-color: #f8f9fa;
            /* Adjust the background color as needed */
        }

        

        /* About Me */
        @media (max-width: 991px) {
            .about-text {
                margin-top: 40px;
            }
        }

        .about-text h3 {
            font-size: 45px;
            font-weight: 700;
            margin: 0 0 10px;
        }

        @media (max-width: 767px) {
            .about-text h3 {
                font-size: 35px;
            }
        }

        .about-text h4 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        @media (max-width: 767px) {
            .about-text h4 {
                font-size: 18px;
            }
        }

        .about-text p {
            font-size: 18px;
        }

        .about-text p mark {
            font-weight: 600;
            color: #3a3973;
        }

        .about-text .btn-bar {
            padding-top: 8px;
        }

        .about-text .btn-bar a {
            min-width: 150px;
            text-align: center;
            margin-right: 10px;
        }

        .about-list {
            padding-top: 10px;
        }

        .about-list .media {
            padding: 5px 0;
        }

        .about-list label {
            color: #3a3973;
            font-weight: 600;
            width: 88px;
            margin: 0;
            position: relative;
        }

        .about-list label:after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            right: 11px;
            width: 1px;
            height: 12px;
            background: #3a3973;
            -moz-transform: rotate(15deg);
            -o-transform: rotate(15deg);
            -ms-transform: rotate(15deg);
            -webkit-transform: rotate(15deg);
            transform: rotate(15deg);
            margin: auto;
            opacity: 0.5;
        }

        .about-list p {
            margin: 0;
            font-size: 15px;
        }

        
        @media (max-width: 991px) {
            .about-img {
                margin-top: 30px;
            }
        }

        .counter-section {
            padding: 40px 20px;
        }

        .counter-section .count-data {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .counter-section .count {
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 10px;
        }

        .counter-section p {
            font-weight: 500;
            margin: 0;
            color: #fe4f6c;
        }

        
        .section {
            padding: 100px 0;
            position: relative;
        }

        .gray-bg {
            background-color: #F7F0EF;
        }

        
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="left">
            <h1>Thrifts Depot</h1>
        </div>

        <div class="right">
            <ul class="list">
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li><a href="faqs.php">FAQs</a></li>
            </ul>
        </div>
    </nav>
    <section class="section about-section gray-bg" id="about">
        <div class="container">
            <div class="row align-items-center justify-content-around flex-row-reverse">
                <div class="col-lg-6">
                    <div class="about-text">
                        <h3 class="dark-color">Your opinion , feedbacks and queries will help us to improve our service.</h3>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!--Section: Contact v.2-->
    <section class="mb-4">

        <!--Section heading-->
        <h2 class="h1-responsive font-weight-bold text-center my-4">Hi , How can we help you ?</h2>
        <!--Section description-->
        <p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please Don't Hesitate</p>
        <p class="text-center w-responsive mx-auto mb-5">Kindly fill in the form and our admin will contact you through email.</p>
        <div class="row">

            <!--Grid column-->
            <div class="col-md-9 mb-md-0 mb-5 contact-form-container">
                <form id="contact-form" name="contact-form" action="process_contact.php" method="POST">

                    <!--Grid row-->
                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-6">
                            <div class="md-form mb-0">
                                <label for="name">Your name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-md-6">
                            <div class="md-form mb-0">
                                <label for="email">Your email</label>
                                <input type="text" id="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <!--Grid column-->

                    </div>
                    <!--Grid row-->

                    <!--Grid row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form mb-0">
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <!--Grid row-->

                    <!--Grid row-->
                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-12">

                            <div class="md-form">
                                <label for="message">Your message</label>
                                <textarea id="message" name="message" rows="2" class="form-control md-textarea" required></textarea><br>
                            </div>

                        </div>
                    </div>
                    <!--Grid row-->

                    <div class="text-center text-md-left">
                        <button type="submit" class="btn btn-primary">Send</button><br>
                    </div>
                    <div class="status"></div>
                </form>
            </div>
            <!--Grid column-->




        </div>

    </section>
    <!--Section: Contact v.2-->
    <footer>
    <p>Thrifts Depot 2023<br>
      <a href="thriftsdepot@gmail.com">thriftsdepot@gmail.com</a> ||
      <a href="index.php">Homepage</a> ||
      <a href="about_us.php">About Us</a> ||
      <a href="contact_us.php">Contact Us</a> ||
      <a href="faqs.php">FAQs</a> 
    </p>
  </footer>

</body>

</html>