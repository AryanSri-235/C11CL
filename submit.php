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
    $name = ucwords(strtolower($_POST['name']));
    $age = $_POST['age'];
    $mobile = $_POST['phone'];
    $email = $_POST['email'];
    $player = $_POST['speciality'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $ref = (strpos($_POST['ref'], '@') !== false) ? '' : $_POST['ref'];
    $source = $_POST['source'];

    // Mobile Formatting
    $mobile = str_replace('+', '', $mobile);
    if (substr($mobile, 0, 1) === '0') { $mobile = substr($mobile, 1); }
    if ((substr($mobile, 0, 2) === '91') && (strlen($mobile) >= 12)) { $mobile = substr($mobile, 2); }

    date_default_timezone_set("Asia/Kolkata");
    $date = date('Y-m-d H:i:s');

    // 2. Check if already exists
    $sqlCheck = "SELECT reg, status FROM register WHERE name = '$name' AND mobile = '$mobile' AND email = '$email' ORDER BY id DESC LIMIT 1";
    $resultCheck = $con->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        $rowCheck = $resultCheck->fetch_assoc();
        $reg = $rowCheck['reg'];
        if($rowCheck['status'] == 'Pending') {
            $con->query("UPDATE register SET age = '$age', player = '$player', up = '$date', date = '$date', state = '$state', city = '$city', ref = '$ref', source = '$source' WHERE reg = '$reg'");
        }
    } else {
        // 3. Generate New Registration No
        $sqlLast = "SELECT reg FROM register ORDER BY id DESC LIMIT 1";
        $resLast = $con->query($sqlLast);
        $count = ($resLast->num_rows > 0) ? (int)substr($resLast->fetch_assoc()["reg"], -5) + 1 : 1;
        $reg = "C11CL" . date("dmy") . sprintf('%05d', $count);

        // 4. Insert New Lead
        $sqlInsert = "INSERT INTO register (name, reg, age, mobile, email, player, state, city, ref, created_at, up, date, regCount, source, status) 
                      VALUES ('$name', '$reg', '$age', '$mobile', '$email', '$player', '$state', '$city', '$ref', '$date', '$date', '$date', 1, '$source', 'Pending')";
        $con->query($sqlInsert);
    }

    $_SESSION['payreg'] = $reg;
    $registrationID = $reg;
    $showLoader = true; // Ye trigger karega loading screen ko
    $con->close();
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
    <div style="font-size:60px;margin-bottom:10px;">✅</div>

    <span class="loader-text">Registration Successful!</span>

    <p class="status-msg">
        Thank you for registering with C11CL.
        Your registration has been submitted successfully.
    </p>

    <div class="progress-container">
        <div id="bar"></div>
    </div>

    <p id="countdown" style="font-size:14px;color:#64748b;">
        Redirecting to homepage in 3 seconds...
    </p>
</div>

<script>
    // Progress Bar
    let width = 0;
    const bar = document.getElementById('bar');

    const progress = setInterval(() => {
        width += 1;
        bar.style.width = width + '%';

        if (width >= 100) {
            clearInterval(progress);
        }
    }, 30);

    // Countdown
    let seconds = 3;
    const countdown = document.getElementById("countdown");

    const timer = setInterval(() => {
        seconds--;

        if (seconds > 0) {
            countdown.innerHTML =
                `Redirecting to homepage in ${seconds} second${seconds > 1 ? 's' : ''}...`;
        } else {
            clearInterval(timer);
            window.location.href = "/";
        }
    }, 1000);
</script>
<?php endif; ?>
</div>

<noscript>
<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=727837786776844&ev=PageView&noscript=1"/>
</noscript>

</body>
</html>