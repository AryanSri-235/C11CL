<?php
ob_start();
require('config.php');
session_start();
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

if (isset($_POST['razorpay_payment_id']) && isset($_SESSION['payreg2'])) {

    $api = new Api($keyId, $keySecret);

    try {
        $attributes = [
            'razorpay_order_id'   => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature'  => $_POST['razorpay_signature'],
        ];
        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        ob_end_clean();
        header('Location: /failure.php?error=' . urlencode($e->getMessage()));
        exit();
    }

    $Paymentid = $_POST['razorpay_payment_id'];

    include '../db.php';

    $sql    = "SELECT reg2, status FROM `register-second` WHERE reg2 = '{$_SESSION['payreg2']}'";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $row    = $result->fetch_assoc();
        $status = $row['status'];

        if ($status === 'Pending') {
            date_default_timezone_set("Asia/Kolkata");
            $date = date('Y-m-d');
            $time = date('h:i:s A');
            $update_sql = "UPDATE `register-second` SET status='Success', Paymentid='$Paymentid', paydate='$date', paytime='$time' WHERE reg2 = '{$_SESSION['payreg2']}'";
            $con->query($update_sql);

            // Clear any admin session vars so send-second.php always treats this as a user payment
            unset($_SESSION['id'], $_SESSION['remsgphase2']);

            $_SESSION['complete_reg2'] = $_SESSION['payreg2'];
            ob_end_clean();
            header('Location: /send-second.php');
            exit();

        } elseif ($status === 'Success') {
            $_SESSION['complete_reg2'] = $_SESSION['payreg2'];
            ob_end_clean();
            header('Location: /success_second.php');
            exit();
        }
    }

    ob_end_clean();
    header('Location: /failure.php');
    exit();

} else {
    ob_end_clean();
    header('Location: /failure.php');
    exit();
}
?>
