<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$showLoader = false;
$registrationID = "";

// Jab form submit hota hai
if(isset($_POST['submit'])){
    include "db.php";

    // 1. Data Processing
    $name   = ucwords(strtolower($_POST['name']));
    $age    = $_POST['age'];
    $mobile = $_POST['phone'];
    $email  = $_POST['email'];
    $player = $_POST['speciality'];
    $state  = $_POST['state'];
    $city   = $_POST['city'];
    $rawRef = isset($_POST['ref']) ? $_POST['ref'] : '';
    $ref    = (strpos($rawRef, '@') !== false) ? '' : $rawRef;
    $source = isset($_POST['source']) ? $_POST['source'] : 'Website';

    // Mobile Formatting
    $mobile = str_replace('+', '', $mobile);
    if (substr($mobile, 0, 1) === '0') { $mobile = substr($mobile, 1); }
    if ((substr($mobile, 0, 2) === '91') && (strlen($mobile) >= 12)) { $mobile = substr($mobile, 2); }

    // Validate 10 digits
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        if (isset($_POST['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'error', 'message' => 'Mobile number must be exactly 10 digits.']);
            exit;
        } else {
            echo "<script>alert('Mobile number must be exactly 10 digits.'); window.history.back();</script>";
            exit;
        }
    }

    date_default_timezone_set("Asia/Kolkata");
    $date = date('Y-m-d H:i:s');

    // Generate a local reg ID as fallback (used even if DB is down)
    $reg = "C11CL" . date("dmy") . sprintf('%05d', rand(1, 99999));

    // 2. DB operations — only run if connection succeeded
    if ($con) {
        // Check if already exists
        $sqlCheck = "SELECT reg, status FROM register WHERE name = '$name' AND mobile = '$mobile' AND email = '$email' ORDER BY id DESC LIMIT 1";
        $resultCheck = $con->query($sqlCheck);

        if ($resultCheck && $resultCheck->num_rows > 0) {
            $rowCheck = $resultCheck->fetch_assoc();
            $reg = $rowCheck['reg'];
            if($rowCheck['status'] == 'Pending') {
                $con->query("UPDATE register SET age = '$age', player = '$player', up = '$date', state = '$state', city = '$city', ref = '$ref', source = '$source' WHERE reg = '$reg'");
            }
        } else {
            // Generate New Registration No from DB sequence
            $sqlLast = "SELECT reg FROM register ORDER BY id DESC LIMIT 1";
            $resLast = $con->query($sqlLast);
            $count   = ($resLast && $resLast->num_rows > 0) ? (int)substr($resLast->fetch_assoc()["reg"], -5) + 1 : 1;
            $reg     = "C11CL" . date("dmy") . sprintf('%05d', $count);

            // Insert New Lead
            $sqlInsert = "INSERT INTO register (name, reg, age, mobile, email, player, state, city, ref, created_at, up, regCount, source, status) 
                          VALUES ('$name', '$reg', '$age', '$mobile', '$email', '$player', '$state', '$city', '$ref', '$date', '$date', 1, '$source', 'Pending')";
            $con->query($sqlInsert);
        }
        $con->close();
    }

    $_SESSION['payreg'] = $reg;
    $registrationID = $reg;
    
    if (isset($_POST['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $isLocal = ($host === 'localhost' || strpos($host, 'localhost:') === 0 || $host === '127.0.0.1');
        $redirect = $isLocal ? '/payment/pay.php' : '/success.php';
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status'   => 'success',
            'message'  => 'Registration Successful! Your ID is ' . $reg,
            'reg'      => $reg,
            'redirect' => $redirect
        ]);
        exit;
    }
    
    $showLoader = true; // Triggers the success + redirect screen
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Registration...</title>
    
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
    <?php if($showLoader): ?>
        // Lead track tabhi hoga jab data submit ho chuka hoga
        fbq('track', 'Lead', { content_name: 'Player Registration' });
    <?php endif; ?>
    </script>
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f0f4f8; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { background: #fff; padding: 40px; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); max-width: 450px; width: 90%; text-align: center; border: 1px solid #e1e8ed; }
        .loader-text { font-weight: bold; color: #1e293b; display: block; margin-bottom: 15px; font-size: 18px; }
        .progress-container { width: 100%; background: #e2e8f0; height: 12px; border-radius: 10px; overflow: hidden; margin: 20px 0; }
        #bar { width: 0%; height: 100%; background: #10b981; transition: 0.1s linear; }
        .status-msg { color: #64748b; font-size: 14px; }
        input { width: 100%; padding: 14px; margin: 10px 0; border: 1px solid #d1d5db; border-radius: 10px; box-sizing: border-box; }
        .submit-btn { width: 100%; background: #2563eb; color: white; border: none; padding: 16px; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 16px; }
    </style>
</head>
<body>

<div class="card">
    <?php if(!$showLoader): ?>
        <div id="form-container">
            <h2>Player Registration</h2>
            <p>Fill the details to continue</p>
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="text" name="age" placeholder="Age" required>
                <input type="text" name="phone" placeholder="Mobile Number" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="text" name="speciality" placeholder="Speciality" required>
                <input type="text" name="state" placeholder="State" required>
                <input type="text" name="city" placeholder="City" required>
                <input type="text" name="ref" placeholder="Reference Code">
                <input type="hidden" name="source" value="Website">
                <button type="submit" name="submit" class="submit-btn">Register Now</button>
            </form>
        </div>
    <?php else: ?>
        <div id="redirect-container">
            <div style="font-size: 50px; margin-bottom: 10px;">✅</div>
            <span class="loader-text">Registration Successful!</span>
            <p class="status-msg">Your details have been saved. You will be redirected to the homepage shortly.</p>
            
            <div class="progress-container">
                <div id="bar"></div>
            </div>
            
            <p style="font-size: 12px; color: #94a3b8;">Redirecting to homepage in 3 seconds...</p>
        </div>

        <script>
            // Progress Bar and Auto Redirect logic
            let width = 0;
            const bar = document.getElementById('bar');
            const interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);
                    window.location.href = "/";
                } else {
                    width += 1; 
                    bar.style.width = width + '%';
                }
            }, 30); // 30ms * 100 = 3000ms (3 seconds)
        </script>
    <?php endif; ?>
</div>

<noscript>
<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=727837786776844&ev=PageView&noscript=1"/>
</noscript>

</body>
</html>