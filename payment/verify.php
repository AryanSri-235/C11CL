<?php
ob_start();
require('config.php');
session_start();
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// Write debug log — appended on each attempt
$debugEntry = [
    'time'               => date('Y-m-d H:i:s'),
    'has_payment_id'     => isset($_POST['razorpay_payment_id']),
    'has_session_payreg' => isset($_SESSION['payreg']),
    'has_order_id_sess'  => isset($_SESSION['razorpay_order_id']),
    'has_order_id_post'  => isset($_POST['razorpay_order_id']),
    'payreg'             => $_SESSION['payreg'] ?? 'NOT SET',
    'order_id_sess'      => $_SESSION['razorpay_order_id'] ?? 'NOT SET',
    'order_id_post'      => $_POST['razorpay_order_id'] ?? 'NOT SET',
    'payment_id_post'    => $_POST['razorpay_payment_id'] ?? 'NOT SET',
    'post_keys'          => array_keys($_POST),
];
file_put_contents(__DIR__ . '/verify_debug.txt', json_encode($debugEntry, JSON_PRETTY_PRINT) . "\n---\n", FILE_APPEND);

if (isset($_POST['razorpay_payment_id']) && isset($_SESSION['payreg'])) {

    $api = new Api($keyId, $keySecret);

    // Use POST order_id if available, fall back to session
    $orderId = $_POST['razorpay_order_id'] ?? $_SESSION['razorpay_order_id'] ?? '';

    try {
        $attributes = [
            'razorpay_order_id'   => $orderId,
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature'  => $_POST['razorpay_signature'],
        ];
        $api->utility->verifyPaymentSignature($attributes);
        file_put_contents(__DIR__ . '/verify_debug.txt', "SIG_VERIFY: PASSED\n---\n", FILE_APPEND);
    } catch (SignatureVerificationError $e) {
        file_put_contents(__DIR__ . '/verify_debug.txt', "SIG_VERIFY: FAILED - " . $e->getMessage() . "\n---\n", FILE_APPEND);
        ob_end_clean();
        header('Location: /failure.php?reason=sig_fail&error=' . urlencode($e->getMessage()));
        exit();
    }

    $Paymentid = $_POST['razorpay_payment_id'];

    include '../db.php';

    $sql    = "SELECT reg, status FROM register WHERE reg = '{$_SESSION['payreg']}'";
    $result = $con->query($sql);
    file_put_contents(__DIR__ . '/verify_debug.txt', "DB_QUERY: rows=" . ($result ? $result->num_rows : 'QUERY_FAILED') . " con_err=" . ($con ? $con->error : 'CON_NULL') . "\n---\n", FILE_APPEND);

    if ($result && $result->num_rows > 0) {
        $row    = $result->fetch_assoc();
        $status = $row['status'];
        file_put_contents(__DIR__ . '/verify_debug.txt', "DB_STATUS: $status\n---\n", FILE_APPEND);

        if ($status === 'Pending') {
            date_default_timezone_set("Asia/Kolkata");
            $date = date('Y-m-d');
            $time = date('h:i:s A');
            $update_sql = "UPDATE register SET status='Success', Paymentid='$Paymentid', paydate='$date', paytime='$time' WHERE reg = '{$_SESSION['payreg']}'";
            $updateResult = $con->query($update_sql);
            file_put_contents(__DIR__ . '/verify_debug.txt', "UPDATE: " . ($updateResult ? 'OK' : 'FAILED - ' . $con->error) . "\n---\n", FILE_APPEND);

            unset($_SESSION['id'], $_SESSION['remsgphase1']);
            $_SESSION['complete_reg'] = $_SESSION['payreg'];
            ob_end_clean();
            header('Location: /send.php');
            exit();

        } elseif ($status === 'Success') {
            unset($_SESSION['id'], $_SESSION['remsgphase1']);
            $_SESSION['complete_reg'] = $_SESSION['payreg'];
            ob_end_clean();
            header('Location: /success.php');
            exit();
        } else {
            ob_end_clean();
            header('Location: /failure.php?reason=wrong_status&status=' . urlencode($status));
            exit();
        }
    } else {
        ob_end_clean();
        header('Location: /failure.php?reason=no_db_record');
        exit();
    }

} else {
    ob_end_clean();
    $r = '';
    if (!isset($_POST['razorpay_payment_id'])) $r .= 'no_payment_id,';
    if (!isset($_SESSION['payreg']))            $r .= 'no_session_payreg';
    header('Location: /failure.php?reason=' . urlencode(trim($r, ',')));
    exit();
}
?>
