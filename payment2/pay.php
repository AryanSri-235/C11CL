<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
include '../db.php';

// अगर session में reg2 नहीं है तो failure page भेज दो
if (!isset($_SESSION['payreg2'])) {
    header('location:../failure.php');
    exit();
}

date_default_timezone_set("Asia/Kolkata");

// register-second से data fetch
$sql = "SELECT reg2, name, email, mobile, player, ref, regCount, date, status 
        FROM `register-second` 
        WHERE reg2 = '{$_SESSION['payreg2']}'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    $reg2     = $row['reg2'];
    $name     = $row['name'];
    $email    = $row['email'];
    $mobile   = $row['mobile'];
    $player   = $row['player'];
    $ref      = $row['ref'];
    $regCount = $row['regCount'];
    $status   = $row['status'];
    $date     = date('Y-m-d H:i:s', strtotime($row['date']));
    $date1    = date('Y-m-d H:i:s', strtotime('-20 seconds'));
    
// Payment amount fixed to ₹1
$pmt = 8999;

    
    // अगर status pending है तो update करो
    if ($status == 'Pending') {
        if ($date <= $date1) {
            $regCount++;
        }
        $date = date('Y-m-d H:i:s');
        $sqlupdate = "UPDATE `register-second` 
                      SET date = '$date', amount = '$pmt', regCount = '$regCount' 
                      WHERE reg2 = '$reg2'";
        $con->query($sqlupdate);
    }
} else {
    header('location:../failure.php');
    exit();
}

$con->close();

// Razorpay setup
require('config.php');
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

// Razorpay Order create
$orderData = [
    'receipt'         => $reg2,
    'amount'          => $pmt * 100,
    'currency'        => 'INR',
    'payment_capture' => 1
];

$razorpayOrder = $api->order->create($orderData);
$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR') {
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);
    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'automatic';
if (isset($_GET['checkout']) && in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
    $checkout = $_GET['checkout'];
}

$data = [
    "key"         => $keyId,
    "amount"      => $amount,
    "name"        => "",
    "description" => "",
    "image"       => "",
    "prefill"     => [
        "name"    => $name,
        "email"   => $email,
        "contact" => $mobile,
    ],
    "notes"       => [
        "regid"   => $reg2,
        "address" => "",
        "merchant_order_id" => $reg2,
    ],
    "theme"       => [
        "color"   => "#F37254"
    ],
    "order_id"    => $razorpayOrderId,
];

if ($displayCurrency !== 'INR') {
    $data['display_currency'] = $displayCurrency;
    $data['display_amount']   = $displayAmount;
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
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    #loadingMessage { text-align: center; margin-top: 50px; }
    #loadingMessage p { font-size: 16px; margin-bottom: 20px; }
    .loading-spinner { width: 200px; }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#loadingMessage').show();
});
</script>
</head>
<body>
<div id="loadingMessage">
    <p>
        Processing your registration...<br>
        Please do not refresh or press the back button.
    </p>
    <img class="loading-spinner" src="https://i.gifer.com/ZZ5H.gif" alt="Loading Spinner">
</div>
</body>
</html>
