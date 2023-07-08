<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/templatemo.css">
  <link rel="stylesheet" href="assets/css/custom.css">

  <!-- Load fonts style after rendering the layout styles -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
  <link rel="stylesheet" href="assets/css/fontawesome.min.css">
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

    .bg-light {
      background-color: black;
    }

    .bg-light,
    .bg-light * {
      color: black;
    }


    .rounded-circle {
      border-radius: 50% !important;
    }

    img {
      max-width: 100%;
      height: auto;
      vertical-align: top;
    }

    .sub-info {
      font-weight: 600;
      font-family: 'Poppins', sans-serif;
      color: #004975;
    }

    .display-30 {
      font-size: 0.9rem;
    }

    /*container 2 */
    
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



  <div class="container py-5 mt-4">
    <div class="text-center mb-2-8 mb-lg-6">
      <h2 class="display-18 display-md-16 display-lg-14 font-weight-700">About <strong class="text-primary font-weight-700">Thrifts Depot</strong></h2>
      <span></span>
      <span></span>
    </div>
    <div class="row align-items-center">
      <div class="col-sm-6 col-lg-4 mb-2-9 mb-sm-0">
        <div class="pr-md-3">
          <div class="text-center text-sm-right mb-2-9">
            <div class="mb-4">

            </div>
            <h4 class="sub-info">Commision as low as 10% per order</h4>
            <p class="display-30 mb-0">For every succesfull purchased order seller will receive 90% of the total amount of the order whereas we get the remaining 10%.</p>
          </div>
          <div class="text-center text-sm-right">
            <div class="mb-4">

            </div>
            <h4 class="sub-info">No extra fees or hidden charges</h4>
            <p class="display-30 mb-0">There is no extra charges or hidden fees for all users.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 d-none d-lg-block">
        <div class="why-choose-center-image">
          <img src="image/tdlogo.png" alt="logo" class="rounded-circle">
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="pl-md-3">
          <div class="text-center text-sm-left mb-2-9">
            <div class="mb-4">

            </div>
            <h4 class="sub-info">Sign up is for FREE</h4>
            <p class="display-30 mb-0">To sign up for our website is totally FREE for all users.</p>
          </div>

          <div class="text-center text-sm-left">
            <div class="mb-4">

            </div>
            <h4 class="sub-info">Top 4 categories to shop</h4>
            <p class="display-30 mb-0">Buyers & Sellers can buy or sell upto 4 categories such as Clothes,Books,Stationaries and Electronic Items.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <section id="about-section" class="pt-5 pb-5">
    <div class="container wrapabout">
      <div class="red"></div>
      <div class="row">
        <div class="col-lg-6 align-items-center justify-content-center d-flex mb-5 mb-lg-0">
          <div class="blockabout">
            <div class="blockabout-inner text-center text-sm-start mx-auto">
              <div class="title-big pb-3 mb-3">
                <h3>Learn More About Us</h3>
              </div>
              <p class="description-p text-muted pe-0 pe-lg-0">
                Follow us on our social media platforms to get in touch with us.
              </p>
              <p class="description-p text-muted pe-0 pe-lg-0">Get instants updates about our website and service.</p>
              <div class="sosmed-horizontal pt-3 pb-3">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <footer>
    <p>Thrifts Depot 2023<br>
      <a href="thriftsdepot@gmail.com">thriftsdepot@gmail.com</a> ||
      <a href="index.php">Homepage</a>
    </p>
  </footer>


</body>

</html>