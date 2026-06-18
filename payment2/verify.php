<?php
require('config.php');
session_start();
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// Check if the required POST variables are set
if (isset($_POST['razorpay_payment_id']) && isset($_SESSION['payreg2'])) {

    // Initialize Razorpay API
    $api = new Api($keyId, $keySecret);
    
    try {
        // Verify payment signature
        $attributes = array(
            'razorpay_order_id'   => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature'  => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        // Handle signature verification error
        $error = 'Razorpay Error: ' . $e->getMessage();
        header('Location: ../failure.php?error=' . urlencode($error));
        exit();
    }

    // Extract payment ID
    $Paymentid = $_POST['razorpay_payment_id'];

    // Include database connection
    include '../db.php';

    // Query to update payment status from register-second table
    $sql = "SELECT reg2, status, ref FROM `register-second` WHERE reg2 = '{$_SESSION['payreg2']}'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row    = $result->fetch_assoc();
        $status = $row['status'];
        $ref    = $row['ref'];

        if ($status == 'Pending') {
            // Update payment status
            date_default_timezone_set("Asia/Kolkata");
            $date = date('Y-m-d');
            $time = date('h:i:s A');
            $update_sql = "UPDATE `register-second` 
                           SET status='Success', Paymentid='$Paymentid', paydate='$date', paytime='$time' 
                           WHERE reg2 = '{$_SESSION['payreg2']}' ";
            if ($con->query($update_sql) === TRUE) {
                // Redirect to success process
                $_SESSION["complete_reg2"] = $_SESSION['payreg2'];
                header('Location: ../send-second.php');
                exit();
            } else {
                $error = "Error updating record: " . $con->error;
                header('Location: ../failure.php?error=' . urlencode($error));
                exit();
            }
        } elseif ($status == 'Success') {
            // Already success, redirect to success page
            $_SESSION["complete_reg2"] = $_SESSION['payreg2'];
            header('Location: ../success-second.php');
            exit();
        } else {
            // Redirect to failure page
            header('Location: ../failure.php');
            exit();
        }
    } else {
        // No record found
        header('Location: ../failure.php');
        exit();
    }

    $con->close();
} else {
    // Invalid request
    header('Location: ../failure.php');
    exit();
}
?>
