<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></script>
    <style>
        * {
            margin: 0px;
            padding: auto;
            box-sizing: border-box;
            font-family: 'Ubuntu', sans-serif;
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

        @media screen and (max-width:805px) {
            .list {
                width: 100%;
                height: 100vh;
                background-color: rgb(22, 7, 36);
                text-align: center;
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 4rem;
                left: 100%;
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



        /* Rounded tabs */

        @media (min-width: 576px) {
            .rounded-nav {
                border-radius: 50rem !important;
            }
        }

        @media (min-width: 576px) {
            .rounded-nav .nav-link {
                border-radius: 50rem !important;
            }
        }




        body {
            background: #304352;
            background: -webkit-linear-gradient(to right, #b0c2d1, #d7d2cc);
            background: linear-gradient(to right, #b0c2d1, #d7d2cc);
            min-height: 100vh;
        }

        .nav-pills .nav-link {
            color: #555;
        }

        .text-uppercase {
            letter-spacing: 0.1em;
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
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-5">
            <div class="col-lg-8 text-white py-4 text-center mx-auto">
                <h1 class="display-4">Frequently Asked Questions</h1>
                <p class="lead mb-0">Do check out Thrifts Depot FAQs</p>
                <p class="lead">FAQs by Thiviyaa <a href="" class="text-white">
                    </a>
                </p>
            </div>
        </div>
        <!-- End -->

        <p class="lead mb-0">
        <h1>Seller's Guide</h1>
        </p>
        <div class="p-5 bg-white rounded shadow mb-5">
            <!-- Rounded tabs -->

            <ul id="myTab" role="tablist" class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
                <li class="nav-item flex-sm-fill">
                    <a id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" class="nav-link border-0 text-uppercase font-weight-bold active">Sellers Sign Up & Account</a>
                </li>
                <li class="nav-item flex-sm-fill">
                    <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">Sellers Payments and MyWallet</a>
                </li>
                <li class="nav-item flex-sm-fill">
                    <a id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">Terms & Conditions For Sellers</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div id="home" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade px-4 py-5 show active">
                    <p class="lead mb-0">
                    <h3>How do I sign up to be a seller at Thrifts Depot?</h3>
                    </p>
                    <p class="lead mb-0">You can go to register page and fill up your info then tick role as seller and you are ready to sell in our website.</p><br>
                    <p class="lead mb-0">
                    <h3>How do I sell my first item?</h3>
                    </p>
                    <p class="lead mb-0">You can go to my profile > add new product > sellect your item & click enter. It will automatically displayed in your profile and in our website under products page.</p>
                    <p class="lead mb-0">
                    <h3>How do I check my order details?</h3>
                    </p>
                    <p class="lead mb-0">You can go to my profile > order > review your items and ship out button available when you have shipped out the order.</p>

                </div>
                <div id="profile" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
                    <p class="lead mb-0">
                    <h3>How the fees for per order works?</h3>
                    </p>
                    <p class="lead mb-0">For every succesful pruchase we will deduct 10% from the total. let's day your order total in RM 10.00 then as a fees per order we will deduct RM 1. Remaining RM 9 is your revenue for the order and it will automatically store i MyWallet under your profile once user received the order.</p><br>
                    <p class="lead mb-0">
                    <h3>How can i transfer my money from MyWallet to my Bank Account?</h3>
                    </p>
                    <p class="lead mb-0">You can go to MyWallet option can click transfer money to your bank account.</p>
                </div>
                <div id="contact" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                    <p class="text-muted">
                    <p class="lead mb-0">
                        Click here to read our :
                        <a href="Thrifts Depot Terms & Conditions for Sellers.pdf">Terms & Conditions for Sellers</a>
                    </p>
                    </p>
                    <p class="text-muted">-</p>
                </div>
            </div>
            <!-- End rounded tabs -->
        </div>

        <p class="lead mb-0">
        <h1>Buyer's Guide</h1>
        </p>
        <div class="p-5 bg-white rounded shadow mb-5">
            <!-- Lined tabs-->
            <ul id="myTab2" role="tablist" class="nav nav-tabs nav-pills with-arrow lined flex-column flex-sm-row text-center">
                <li class="nav-item flex-sm-fill">
                    <a id="home2-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true" class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0 active">Buyers Sign Up & Account</a>
                </li>
                <li class="nav-item flex-sm-fill">
                    <a id="profile2-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false" class="nav-link text-uppercase font-weight-bold mr-sm-3 rounded-0">Sellers Payments Methods & etc.</a>
                </li>
                <li class="nav-item flex-sm-fill">
                    <a id="contact2-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact2" aria-selected="false" class="nav-link text-uppercase font-weight-bold rounded-0">Terms & Conditions For Buyers</a>
                </li>
            </ul>
            <div id="myTab2Content" class="tab-content">
                <div id="home2" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade px-4 py-5 show active">
                    <p class="leade font-italic">How do I sign up to be a buyer at Thrifts Depot?</p>
                    <p class="leade font-italic mb-0">You can go to register page and fill up your info then tick role as buyer and you are ready to buyer in our website.</p>
                    <p class="leade font-italic">How do I buy my thrift item?</p>
                    <p class="leade font-italic mb-0">You can go to products page > choose your desired item > add to cart > checkout > make payment > wait till seller ship out > received within 1 or 2 weeks.</p>
                </div>
                <div id="profile2" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5">
                    <p class="leade font-italic">What are the payment methods available for buyers?</p>
                    <p class="leade font-italic mb-0">There are three payments mathods one can choose to make the purchase. Such as COD , Online Banking & Credit and Debit Cards.</p>
                </div>
                <div id="contact2" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                    <p class="lead mb-0">
                        Click here to read our :
                        <a href="Thrifts Depot Buyers Terms & Conditions.pdf">Terms & Conditions for Buyers</a>
                    </p>
                </div>
            </div>
            <!-- End lined tabs -->
        </div>




    </div>

    </div>


    <footer>
        <p>Thrifts Depot 2023<br>
            <a href="thriftsdepot@gmail.com">thriftsdepot@gmail.com</a> ||
            <a href="index.php">Homepage</a>
        </p>
    </footer>

</body>

</html>