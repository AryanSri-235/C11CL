<?php
// Enable error reporting
error_reporting(E_ALL); // Report all PHP errors
ini_set('display_errors', '1'); // Display errors on the screen

?><?php                        
session_start();
include '../db.php';

if (!isset($_SESSION['payreg'])) {
    header('location:../failure.php');
    exit(); // Added exit after header redirect
}
    
date_default_timezone_set("Asia/Kolkata");
    
    
$sql = "SELECT reg, name, email, mobile, player, ref, regCount, date, status FROM register WHERE reg= '{$_SESSION['payreg']}' ";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    $reg = $row['reg'];
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $player = $row['player'];
    $ref = $row['ref'];
    // $discount = $row['coupon'];
    $regCount = $row['regCount'];
    $status = $row['status'];
    $date = date('Y-m-d H:i:s', strtotime($row['date']));
    $date1 = date('Y-m-d H:i:s', strtotime('-20 seconds'));
    
    
     
    // Set default payment amount based on player type
    if ($player === 'All Rounder' || $player === 'Wicketkeeper/Batsman') {
        $pmt = 1850;
    } else {
        $pmt = 1850;
    }
    
   
    
    if ($status == 'Pending') {
            if ($date <= $date1) {
        $regCount++;
            }
         //   date and time--------------------------
    
    $date = date('Y-m-d H:i:s');
$sqlupdate = "UPDATE register SET date = '$date', amount = '$pmt', regCount = '$regCount' WHERE reg = '$reg'";
        $con->query($sqlupdate);
    }

//    echo "Payment Amount: $pmt"; 
} else {
    header('location:../failure.php');
    exit(); // Added exit after header redirect
}

$con->close();


require('config.php');
require('razorpay-php/Razorpay.php');
// session_start();

// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => $reg,
    'amount'          => $pmt * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
}

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "",
    "description"       => "",
    "image"             => "",
    "prefill"           => [
    "name"              => $name,
    "email"             => $email,
    "contact"           => $mobile,
    ],
    "notes"             => [
    "regid"             => $reg,
    "address"           => "",
    
        "merchant_order_id" => $reg,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

require("checkout/{$checkout}.php");
?>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  
  window.onload = function(){
  document.getElementById('rzp-button1').click();
}
</script>

<!DOCTYPE html>
<html lang="en">
<head>
   
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Processing</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    
    #loadingMessage {
        display: none;
        text-align: center;
        margin-top: 50px;
    }
    
    #loadingMessage p {
        font-size: 16px;
        margin-bottom: 20px;
    }
    
    #loadingMessage img {
        width: 50px;
    }
    
    @media only screen and (max-width: 600px) {
        #loadingMessage {
            margin-top: 50px;
        }
        
        #loadingMessage p {
                font-size: 25px;
    padding: 20px;

        }
        
        #loadingMessage img {
            width: 40px;
        }
    }
    .loading-spinner {
            width: 50vw;  /* 50% of the viewport width */
            height: auto;  /* Maintain the aspect ratio */
            max-width: 100px;  /* Optional: Maximum width */
            max-height: 100px;  /* Optional: Maximum height */
        }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
   
    $('#loadingMessage').show(); // Display loading message
});
</script>

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '727837786776844');
fbq('track', 'PageView');
</script>

<noscript>
<img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=727837786776844&ev=PageView&noscript=1"/>
</noscript>
<!-- End Meta Pixel Code -->
</head>
<body>
<div id="loadingMessage">
    <p>
        Processing your registration...<br>
        Please do not refresh or press the back button.
    </p>
    <img class="loading-spinner" style="width: 200px;" src="https://i.gifer.com/ZZ5H.gif" alt="Loading Spinner">
</div>

    
   
</body>
</html>

