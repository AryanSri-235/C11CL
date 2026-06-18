<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../db.php';
require('config.php');
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

// ================= CHECK SESSION =================
if (!isset($_SESSION['payreg'])) {
    header('location:../failure.php');
    exit();
}

$regSafe = mysqli_real_escape_string($con, $_SESSION['payreg']);

// ================= FETCH REGISTRATION =================
$sql = "SELECT reg, name, email, mobile, status, amount FROM register WHERE reg='$regSafe' LIMIT 1";
$result = $con->query($sql);
if (!$result || $result->num_rows == 0) {
    header('location:../failure.php'); exit();
}

$row = $result->fetch_assoc();
$finalAmount = (int)$row['amount']; // 💰 Verified amount from DB
$name = $row['name'];
$email = $row['email'];
$mobile = $row['mobile'];

// ================= RAZORPAY =================
$api = new Api($keyId, $keySecret);

$orderData = [
    'receipt' => $regSafe,
    'amount' => $finalAmount * 100, // amount in paise
    'currency' => 'INR',
    'payment_capture' => 1
];

$razorpayOrder = $api->order->create($orderData);
$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$data = [
    "key"      => $keyId,
    "amount"   => $orderData['amount'],
    "prefill"  => ["name"=>$name,"email"=>$email,"contact"=>$mobile],
    "notes"    => ["regid"=>$regSafe,"coupon"=>($_SESSION['coupon_code'] ?? '')],
    "theme"    => ["color"=>"#F37254"],
    "order_id" => $razorpayOrderId,
];

$json = json_encode($data);
require("checkout/automatic.php");
?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
window.onload = function () {
    document.getElementById('rzp-button1').click();
};
</script>
