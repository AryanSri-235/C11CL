<?php
ini_set('display_errors', 0);
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');

session_start();
require('config.php');
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// Session may be lost during Razorpay redirect — fall back to POST field
$payreg = $_SESSION['payreg'] ?? $_POST['shopping_order_id'] ?? '';

if (!isset($_POST['razorpay_payment_id']) || empty($payreg)) {
    $reason = '';
    if (!isset($_POST['razorpay_payment_id'])) $reason .= 'no_payment_id,';
    if (empty($payreg))                        $reason .= 'no_session_payreg';
    header('Location: /failure.php?reason=' . urlencode(trim($reason, ',')));
    exit();
}

$api     = new Api($keyId, $keySecret);
$orderId = $_POST['razorpay_order_id'] ?? $_SESSION['razorpay_order_id'] ?? '';

try {
    $api->utility->verifyPaymentSignature([
        'razorpay_order_id'   => $orderId,
        'razorpay_payment_id' => $_POST['razorpay_payment_id'],
        'razorpay_signature'  => $_POST['razorpay_signature'],
    ]);
} catch (SignatureVerificationError $e) {
    header('Location: /failure.php?reason=sig_fail');
    exit();
}

$paymentId = $_POST['razorpay_payment_id'];

include '../db.php';

$stmt = $con->prepare("SELECT reg, status FROM register WHERE reg = ?");
$stmt->bind_param('s', $payreg);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    header('Location: /failure.php?reason=no_db_record');
    exit();
}

$row    = $result->fetch_assoc();
$status = $row['status'];

if ($status === 'Pending') {
    $date = date('Y-m-d');
    $time = date('h:i:s A');

    $upd = $con->prepare("UPDATE register SET status='Success', Paymentid=?, paydate=?, paytime=? WHERE reg=?");
    $upd->bind_param('ssss', $paymentId, $date, $time, $payreg);
    $upd->execute();
    $upd->close();

    unset($_SESSION['id'], $_SESSION['remsgphase1']);
    $_SESSION['complete_reg'] = $payreg;
    header('Location: /send.php');
    exit();

} elseif ($status === 'Success') {
    unset($_SESSION['id'], $_SESSION['remsgphase1']);
    $_SESSION['complete_reg'] = $payreg;
    header('Location: /success.php');
    exit();

} else {
    header('Location: /failure.php?reason=wrong_status');
    exit();
}
?>
