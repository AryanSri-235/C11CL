<?php
// Enable error reporting
error_reporting(E_ALL); 
ini_set('display_errors', '1'); 

session_start();
include '../db.php';

if (!isset($_SESSION['payreg'])) {
    header('location:../failure.php');
    exit(); 
}
    
date_default_timezone_set("Asia/Kolkata");
    
// CHANGE 1: Query mein 'payable_amount' add kiya taaki coupon wala price mile
$sql = "SELECT reg, name, email, mobile, player, ref, regCount, date, status, payable_amount FROM register WHERE reg= '{$_SESSION['payreg']}' ";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    $reg = $row['reg'];
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $player = $row['player'];
    $ref = $row['ref'];
    $regCount = $row['regCount'];
    $status = $row['status'];
    $db_amount = $row['payable_amount']; // Database se amount uthaya
    
    $date = date('Y-m-d H:i:s', strtotime($row['date']));
    $date1 = date('Y-m-d H:i:s', strtotime('-20 seconds'));
    
    // =========================================================
    // CHANGE 2: Coupon Logic Here
    // =========================================================
    
    // Agar DB me amount hai (matlab coupon laga tha ya base price set hua tha)
    if (!empty($db_amount) && $db_amount > 0) {
        $pmt = $db_amount;  // Ye 1500 hoga agar coupon laga tha, warna 1850
    } else {
        $pmt = 1800; // Agar koi error ho ya amount na mile to default 1800
    }
    
    // =========================================================
    
    if ($status == 'Pending') {
        if ($date <= $date1) {
            $regCount++;
        }
        
        $date = date('Y-m-d H:i:s');
        
        // Yahan updated $pmt use kar rahe hain
        $sqlupdate = "UPDATE register SET date = '$date', amount = '$pmt', regCount = '$regCount' WHERE reg = '$reg'";
        $con->query($sqlupdate);
    }

} else {
    header('location:../failure.php');
    exit(); 
}

$con->close();

require('config.php');
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

$orderData = [
    'receipt'         => $reg,
    'amount'          => $pmt * 100, // Amount dynamic aayega yahan
    'currency'        => 'INR',
    'payment_capture' => 1 
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
    "name"              => "C11CL Registration",
    "description"       => "Player Registration Fee",
    "image"             => "",
    "prefill"           => [
        "name"              => $name,
        "email"             => $email,
        "contact"           => $mobile,
    ],
    "notes"             => [
        "regid"             => $reg,
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
            width: 50vw; 
            height: auto; 
            max-width: 100px; 
            max-height: 100px; 
        }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
   
    $('#loadingMessage').show(); // Display loading message
});
</script>
</head>
<body>
<div id="loadingMessage">
    <p>
        Processing payment of ₹<?php echo $pmt; ?>...<br>
        Please do not refresh or press the back button.
    </p>
    <img class="loading-spinner" style="width: 200px;" src="https://i.gifer.com/ZZ5H.gif" alt="Loading Spinner">
</div>

    
   
</body>
</html>