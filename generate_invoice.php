<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        .receipt-content .logo a:hover {
            text-decoration: none;
            color: #7793C4;
        }

        .receipt-content .invoice-wrapper {
            background: #FFF;
            border: 1px solid #CDD3E2;
            box-shadow: 0px 0px 1px #CCC;
            padding: 40px 40px 60px;
            margin-top: 40px;
            border-radius: 4px;
        }

        .receipt-content .invoice-wrapper .payment-details span {
            color: #A9B0BB;
            display: block;
        }

        .receipt-content .invoice-wrapper .payment-details a {
            display: inline-block;
            margin-top: 5px;
        }

        .receipt-content .invoice-wrapper .line-items .print a {
            display: inline-block;
            border: 1px solid #9CB5D6;
            padding: 13px 13px;
            border-radius: 5px;
            color: #708DC0;
            font-size: 13px;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        .receipt-content .invoice-wrapper .line-items .print a:hover {
            text-decoration: none;
            border-color: #333;
            color: #333;
        }

        .receipt-content {
            background: #ECEEF4;
        }

        @media (min-width: 1200px) {
            .receipt-content .container {
                width: 900px;
            }
        }

        .receipt-content .logo {
            text-align: center;
            margin-top: 50px;
        }

        .receipt-content .logo a {
            font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
            font-size: 36px;
            letter-spacing: .1px;
            color: #555;
            font-weight: 300;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        .receipt-content .invoice-wrapper .intro {
            line-height: 25px;
            color: #444;
        }

        .receipt-content .invoice-wrapper .payment-info {
            margin-top: 25px;
            padding-top: 15px;
        }

        .receipt-content .invoice-wrapper .payment-info span {
            color: #A9B0BB;
        }

        .receipt-content .invoice-wrapper .payment-info strong {
            display: block;
            color: #444;
            margin-top: 3px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-info .text-right {
                text-align: left;
                margin-top: 20px;
            }
        }

        .receipt-content .invoice-wrapper .payment-details {
            border-top: 2px solid #EBECEE;
            margin-top: 30px;
            padding-top: 20px;
            line-height: 22px;
        }


        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-details .text-right {
                text-align: left;
                margin-top: 20px;
            }
        }

        .receipt-content .invoice-wrapper .line-items {
            margin-top: 40px;
        }

        .receipt-content .invoice-wrapper .line-items .headers {
            color: #A9B0BB;
            font-size: 13px;
            letter-spacing: .3px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 4px;
        }

        .receipt-content .invoice-wrapper .line-items .items {
            margin-top: 8px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 8px;
        }

        .receipt-content .invoice-wrapper .line-items .items .item {
            padding: 10px 0;
            color: #000;
            font-size: 15px;
            text-align: right;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item {
                font-size: 13px;
            }
        }

        .receipt-content .invoice-wrapper .line-items .items .item .amount {
            letter-spacing: 0.1px;
            color: #84868A;
            font-size: 16px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item .amount {
                font-size: 13px;
            }
        }

        .receipt-content .invoice-wrapper .line-items .total {
            margin-top: 30px;
        }

        .receipt-content .invoice-wrapper .line-items .total .extra-notes {
            float: left;
            width: 40%;
            text-align: left;
            font-size: 13px;
            color: #7A7A7A;
            line-height: 20px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .total .extra-notes {
                width: 100%;
                margin-bottom: 30px;
                float: none;
            }
        }

        .receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
            display: block;
            margin-bottom: 5px;
            color: #454545;
        }

        .receipt-content .invoice-wrapper .line-items .total .field {
            margin-bottom: 7px;
            font-size: 14px;
            color: #555;
        }

        .receipt-content .invoice-wrapper .line-items .total.field.grand-total {
            margin-top: 10px;
            font-size: 16px;
            font-weight: 500;
            text-align: right;
            color: #000;
        }

        .receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
            color: #20A720;
            font-size: 16px;
        }

        .receipt-content .invoice-wrapper .line-items .total .field span {
            display: inline-block;
            margin-left: 20px;
            min-width: 85px;
            color: #84868A;
            font-size: 15px;
        }

        .receipt-content .invoice-wrapper .line-items .print {
            margin-top: 50px;
            text-align: right;
        }

        .receipt-content .invoice-wrapper .line-items .print a i {
            margin-right: 3px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <?php
    require_once 'config.php';

    if (isset($_GET['order_id'])) {
        $orderId = $_GET['order_id'];
        // Retrieve the order details from the database based on the provided order ID
        $query = "SELECT * FROM test_order WHERE order_id = $orderId";
        $result = mysqli_query($conn, $query);
        $order = mysqli_fetch_assoc($result);
        if ($order) {
            $buyerStatus = $order['buyer_status'];
            if ($buyerStatus === null) {
                echo 'null';
            } else {
                // Start building the invoice content
                $invoiceContent = '
                <div class="receipt-content">
                    <div class="invoice-wrapper">
                        <div class="payment-info">
                            <div class="row">
                                <div class="col-sm-6">
                                    <span>Order No.</span>
                                    <strong>' . $order['order_id'] . '</strong>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <span>Purchased Date</span>
                                    <strong>' . $order['order_date'] . '</strong>
                                </div>
                            </div>
                        </div>
                        <div class="payment-details">
                            <div class="row">
                            </div>
                        </div>
                        <div class="line-items">
                            <div class="headers clearfix">
                                <div class="row">
                                    <div class="field grand-total"><strong>Product Name </strong>' . $order['name'] . ' </div>
                                    <div class="col-xs-3 text-right"><strong>Quantity </strong>' . $order['quantity'] . '</div>
                                    <div class="col-xs-5 text-right"><strong>Price <strong>RM ' . $order['price'] . '</div>
                                </div>
                            </div>
                            <div class="items">
                                <div class="row item">
                                    <div class="field grand-total">
                                        Total <span>RM' . $order['total'] . '</span>
                                    </div> 
                                </div>
                            </div>
                            <div class="total text-right">
                            </div>
                            <div class="print">
                                <a href="#" onclick="window.print(); return false;">
                                    <i class="fa fa-print"></i>
                                    Print this invoice
                                </a>
                            </div>
                        </div>
                    </div>
                </div>';

                // Output the invoice content
                echo $invoiceContent;
            }
        } else {
            echo "Invalid order ID. The order does not exist.";
        }
    } else {
        echo "Order ID not provided.";
    }
    ?>
</body>

</html>