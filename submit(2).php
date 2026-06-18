<?php
// 1. Session start with check to avoid notices
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$showSuccess = false; 

if(isset($_POST['submit'])){
    include "db.php";

    // Form inputs
    $name = $_POST['name'];
    $age = $_POST['age'];
    $mobile = $_POST['phone'];
    $email = $_POST['email'];
    $player = $_POST['speciality'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $ref = $_POST['ref'];
    $source = $_POST['source'];

    // --- Data save logic ---
    date_default_timezone_set("Asia/Kolkata");
    $raw_created_at = date('Y-m-d H:i:s');
    
    $stmt_raw = $con->prepare("INSERT INTO reg_data (name, age, mobile, email, player, state, city, ref, source, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_raw->bind_param("ssssssssss", $name, $age, $mobile, $email, $player, $state, $city, $ref, $source, $raw_created_at);
    $stmt_raw->execute();
    $stmt_raw->close();

    $name = ucwords(strtolower($name));
    $mobile = str_replace('+', '', $mobile);
    if (substr($mobile, 0, 1) === '0') { $mobile = substr($mobile, 1); }
    if ((substr($mobile, 0, 2) === '91') && (preg_match('/^\d{12}$/', $mobile))) { $mobile = substr($mobile, 2); }
            
    $sqlCheck = "SELECT reg, status FROM register WHERE name = '$name' AND mobile = '$mobile' AND email = '$email' ORDER BY id DESC LIMIT 1";
    $resultCheck = $con->query($sqlCheck);
    
    if ($resultCheck->num_rows > 0) {
        $rowCheck = $resultCheck->fetch_assoc();
        if( $rowCheck['status'] == 'Pending') {
            $reg = $rowCheck['reg'];
            $date = date('Y-m-d H:i:s');
            $sql = "UPDATE register SET age = '$age', player = '$player', up = '$date', state = '$state', city = '$city', ref = '$ref', source = '$source' WHERE reg = '$reg'";
            $con->query($sql);
            $_SESSION['payreg'] = $reg;
            $showSuccess = true; 
        } 
    } else {
        $sql = "SELECT reg FROM register ORDER BY id DESC LIMIT 1";
        $result = $con->query($sql);
        $count = ($result->num_rows > 0) ? (int)substr($result->fetch_assoc()["reg"], -4) + 1 : 1;
        $reg = "C11CL" . date("dmy") . sprintf('%05d', $count);
        $created_at = date('Y-m-d H:i:s');
        if (strpos($ref, '@') !== false) { $ref = ''; }

        $sql = "INSERT INTO register (name, reg, age, mobile, email, player, state, city, ref, created_at, up, regCount, source, status) 
                VALUES ('$name', '$reg', '$age', '$mobile', '$email', '$player', '$state', '$city', '$ref', '$created_at', '$created_at', 1, '$source', 'Pending')";

        if ($con->query($sql) === TRUE) {
            $_SESSION['payreg'] = $reg;
            $showSuccess = true; 
        }
    }
    $con->close();
}

// Function to mask Registration Number (Hides middle digits)
function maskRegNo($regNo) {
    if (strlen($regNo) < 10) return $regNo;
    return substr($regNo, 0, 5) . "XXXXX" . substr($regNo, -4);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Registration</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f0f4f8; margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        
        .card { background: #fff; padding: 40px; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); max-width: 450px; width: 90%; text-align: center; border: 1px solid #e1e8ed; }
        
        /* Step Badge */
        .step-badge { background: #e8f5e9; color: #2e7d32; padding: 6px 16px; border-radius: 50px; font-weight: bold; font-size: 13px; display: inline-block; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
        
        /* Success Icon */
        .check-container { width: 70px; height: 70px; background: #27ae60; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 35px; margin: 0 auto 20px; box-shadow: 0 10px 20px rgba(39, 174, 96, 0.2); }
        
        h2 { color: #1a2b3c; margin-bottom: 10px; font-size: 24px; }
        p { color: #5a6b7c; line-height: 1.6; margin-bottom: 25px; font-size: 15px; }

        .reg-no-box { background: #f1f5f9; padding: 12px; border-radius: 12px; border: 1px solid #cbd5e1; font-family: 'Courier New', monospace; font-weight: bold; color: #334155; display: inline-block; margin-bottom: 30px; letter-spacing: 1px; }

        .proceed-btn { background: #2563eb; color: white; padding: 18px 40px; border-radius: 12px; text-decoration: none; font-weight: bold; font-size: 16px; display: block; transition: 0.3s; box-shadow: 0 8px 15px rgba(37, 99, 235, 0.2); }
        .proceed-btn:hover { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 12px 20px rgba(37, 99, 235, 0.3); }

        /* Form Styling */
        input { width: 100%; padding: 14px; margin: 10px 0; border: 1px solid #d1d5db; border-radius: 10px; box-sizing: border-box; font-size: 14px; transition: 0.2s; }
        input:focus { border-color: #2563eb; outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .submit-btn { width: 100%; background: #10b981; color: white; border: none; padding: 16px; border-radius: 10px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; transition: 0.3s; }
        .submit-btn:hover { background: #059669; }
        
        #loader { display: none; }
        .loader-text { font-weight: bold; color: #1e293b; margin-bottom: 15px; display: block; }
    </style>
</head>
<body>

<div class="card">
    <?php if(!$showSuccess): ?>
        <div id="form-box">
            <span class="step-badge">Step 1 of 4</span>
            <h2>Player Registration</h2>
            <p>Please provide your accurate details to proceed.</p>
            
            <form id="regForm" method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="text" name="age" placeholder="Age" required>
                <input type="text" name="phone" placeholder="Mobile Number" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="text" name="speciality" placeholder="Speciality (e.g. All Rounder)" required>
                <input type="text" name="state" placeholder="State" required>
                <input type="text" name="city" placeholder="City" required>
                <input type="text" name="ref" placeholder="Reference Code (Optional)">
                <input type="text" name="source" placeholder="How did you hear about us?">
                <button type="submit" name="submit" class="submit-btn">Register & Continue</button>
            </form>
        </div>

        <div id="loader">
            <span class="loader-text">Securing your profile...</span>
            <div style="width: 100%; background: #e2e8f0; height: 10px; border-radius: 10px; overflow: hidden;">
                <div id="bar" style="width: 0%; height: 100%; background: #10b981; transition: 0.3s;"></div>
            </div>
        </div>

    <?php else: ?>
        <span class="step-badge" style="background: #dcfce7; color: #15803d;">Step 1 Completed</span>
        <div class="check-container">✔</div>
        <h2>Registration Successful!</h2>
        <p>Your application has been recorded. Please proceed to the next step to complete your payment.</p>
        
        <div class="reg-no-box">
            ID: <?php echo maskRegNo($_SESSION['payreg']); ?>
        </div>
        
        <a href="../payment/pay.php" class="proceed-btn">Proceed to Next Step (Payment) →</a>
    <?php endif; ?>
</div>

<script>
    const form = document.getElementById('regForm');
    if(form) {
        form.onsubmit = function() {
            document.getElementById('form-box').style.display = 'none';
            document.getElementById('loader').style.display = 'block';
            let w = 0;
            const bar = document.getElementById('bar');
            const progress = setInterval(() => {
                if(w < 98) { 
                    w += 2; 
                    bar.style.width = w + '%'; 
                } else {
                    clearInterval(progress);
                }
            }, 50);
            return true;
        };
    }
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

</body>
</html>