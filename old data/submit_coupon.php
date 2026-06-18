<?php
// ================= ERROR REPORTING =================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================= SESSION & DB =================
session_start();
include "db.php";

// ================== FORM SUBMISSION =================
if (isset($_POST['submit'])) {

    // ================== FORM DATA ==================
    $name   = $_POST['name'];
    $age    = $_POST['age'];
    $mobile = $_POST['phone'];
    $email  = $_POST['email'];
    $player = $_POST['speciality'];
    $state  = $_POST['state'];
    $city   = $_POST['city'];
    $ref    = $_POST['ref'] ?? '';
    $source = $_POST['source'] ?? '';
    $appliedCoupon  = $_POST['applied_coupon'] ?? '';

    // ================== BASE AMOUNT ==================
    $baseAmount = 1850;
    $finalAmount = $baseAmount;

    // ================== COUPON VALIDATION ==================
    if (!empty($appliedCoupon)) {
        $couponCode = mysqli_real_escape_string($con, $appliedCoupon);

        $couponSql = "
            SELECT 1 
            FROM coupon_name 
            WHERE coupon_code='$couponCode'
            AND status='active'
            LIMIT 1
        ";

        $couponRes = $con->query($couponSql);

        if ($couponRes && $couponRes->num_rows > 0) {
            // Valid coupon → force ₹1500
            $finalAmount = 1500;
        }
    }

    // 🔐 SESSION STORE (ignore frontend tampering)
    $_SESSION['pay_amount'] = $finalAmount;
    $_SESSION['coupon_code'] = $appliedCoupon;

    // ================== NAME FORMAT ==================
    $name = ucwords(strtolower($name));

    // ================== MOBILE CLEAN ==================
    $mobile = str_replace(['+', ' '], '', $mobile);
    if (substr($mobile, 0, 1) === '0') $mobile = substr($mobile, 1);
    if (substr($mobile, 0, 2) === '91' && strlen($mobile) === 12) $mobile = substr($mobile, 2);

    // ================== EXISTING USER CHECK ==================
    $sqlCheck = "
        SELECT reg, status 
        FROM register 
        WHERE name='$name' AND mobile='$mobile' AND email='$email'
        ORDER BY id DESC LIMIT 1
    ";

    $resultCheck = $con->query($sqlCheck);

    if ($resultCheck && $resultCheck->num_rows > 0) {
        $rowCheck = $resultCheck->fetch_assoc();

        if ($rowCheck['status'] === 'Pending') {
            $reg = $rowCheck['reg'];
            $date = date('Y-m-d H:i:s');

            $updateSql = "
                UPDATE register SET
                    age='$age',
                    player='$player',
                    state='$state',
                    city='$city',
                    ref='$appliedCoupon',
                    source='$source',
                    amount='$finalAmount',
                    payable_amount='$finalAmount',
                    up='$date'
                WHERE reg='$reg'
            ";

            $con->query($updateSql);
            $_SESSION['payreg'] = $reg;

            header("Location: ../payment_coupon/pay.php");
            exit();
        }
    }

    // ================== NEW REGISTRATION ==================
    $res = $con->query("SELECT reg FROM register ORDER BY id DESC LIMIT 1");
    $count = ($res && $res->num_rows > 0)
        ? ((int)substr($res->fetch_assoc()['reg'], -5) + 1)
        : 1;

    $count = sprintf('%05d', $count);
    $reg = "C11CL" . date("dmy") . $count;

    $created_at = date('Y-m-d H:i:s');

    $insertSql = "
       INSERT INTO register
            (name, reg, age, mobile, email, player, state, city, ref, created_at, up, regCount, source, status, amount, payable_amount)
       VALUES
            ('$name','$reg','$age','$mobile','$email','$player','$state','$city','$appliedCoupon',
             '$created_at','$created_at',1,'$source','Pending','$finalAmount','$finalAmount')
    ";

    if ($con->query($insertSql)) {
        $_SESSION['payreg'] = $reg;
        header("Location: ../payment_coupon/pay.php");
        exit();
    } else {
        echo $con->error;
    }

    $con->close();
}
?>
