<?php
// --- PHP Error Display Engine Active ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

// PHPMailer Files Include Karna
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// --- OTP Generation and Sending Function (Isi Method Par Based) ---
function sendOTP($email, $number, $name) {
    $otp = rand(100000, 999999);
    $_SESSION['temp_otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 60; // 1 Minute Validity

    // 1. Send Email via PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@c11cl.com';
        $mail->Password = 'C11CLinfo@2025';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('info@c11cl.com', 'Champions 11 Cricket League (C11CL)');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'C11CL Login Verification - OTP';
        $mail->Body = "Hi $name,<br><br>Your OTP for logging into C11CL is: <b>$otp</b>.<br>This OTP is valid for 1 minute only.";
        $mail->send();
    } catch (Exception $e) {
        // Soft catch
    }

// 2. Send WhatsApp via AiSensy V2 Campaign API (Dynamic Button Structure Fixed)
    if (!empty($number)) {
        $number = preg_replace('/\D/', '', $number);
        
        if (strpos($number, '91') !== 0) {
            if (strlen($number) == 10) {
                $number = '91' . $number;
            }
        }

        $apiUrl       = "https://backend.aisensy.com/campaign/t1/api/v2";
        $apiKey       = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY4ZDE0YTNkNGM4ZDliM2Q3ZGYzYTU4YiIsIm5hbWUiOiJDaGFtcGlvbnMgMTEgQ3JpY2tldCBMZWFndWUgKEMxMUNMKSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2OGQxNGEzYzRjOGQ5YjNkN2RmM2E1ODMiLCJhY3RpdmVQbGFuIjoiRlJFRV9GT1JFVkVSIiwiaWF0IjoxNzU4NTQ2NDkzfQ.UJHbGJShjYAY9foWtzHWaI7YPUUA7y45M5l5-PbjeNY";
        $campaignName = "otp_verify"; 

        // Exact payload mapping according to your provided json structure
        $payload = [
            "apiKey"         => $apiKey,
            "campaignName"   => $campaignName,
            "destination"    => $number,
            "userName"       => $name,
            "templateParams" => [
                (string)$otp // Text body ke {{1}} variable ke liye dynamic OTP
            ],
            "source"         => "Portal Security",
            "media"          => new stdClass(), // Empty object as {}
            "buttons"        => [
                [
                    "type"       => "button",
                    "sub_type"   => "url",
                    "index"      => 0,
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => (string)$otp // Button ke dynamic URL parameter ke liye dynamic OTP
                        ]
                    ]
                ]
            ],
            "carouselCards"  => [],
            "location"       => new stdClass(),
            "attributes"     => new stdClass()
        ];

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
    }
    return true;
}

// --- AJAX Handle: Resend OTP ---
if (isset($_POST['action']) && $_POST['action'] == 'resend_otp') {
    header('Content-Type: application/json');
    if (isset($_SESSION['otp_user_data'])) {
        $udata = $_SESSION['otp_user_data'];
        $userNum = !empty($udata['number']) ? $udata['number'] : '';
        sendOTP($udata['email'], $userNum, $udata['name']);
        echo json_encode(['status' => 'success', 'message' => 'OTP has been resent successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Session expired. Please re-login.']);
    }
    exit;
}

// Global Flags
$show_welcome_modal = false;
$show_otp_modal = false;
$otp_error = null;
$welcome_name = "";

// --- Main Login Submission ---
if (isset($_POST['login'])) {
    $login_input = trim($con->real_escape_string($_POST['uname']));
    $password = trim($con->real_escape_string($_POST['password']));
    
    $sql = "SELECT * FROM user WHERE (username = '$login_input' OR email = '$login_input' OR number = '$login_input') AND password = '$password'";
    $result = $con->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['stoper'] == 'Stop') {
            $denied = '<span class="text-danger">Access denied you are not allowed to perform this operation</span>';
        } else {
            $_SESSION['otp_user_data'] = $row;
            $welcome_name = $row['name'];
            
            $userEmail = !empty($row['email']) ? $row['email'] : 'info@c11cl.com'; 
            $usernumber = !empty($row['number']) ? $row['number'] : ''; 
            
            sendOTP($userEmail, $usernumber, $row['name']);
            $show_welcome_modal = true; 
        }
    } else {
        $_SESSION['wrong'] = "WRONG USERNAME, EMAIL, MOBILE OR PASSWORD";
    }
}

// --- OTP Verification Submission ---
if (isset($_POST['verify_otp_btn'])) {
    $entered_otp = trim($_POST['otp_code']);
    
    if (!isset($_SESSION['otp_expiry']) || time() > $_SESSION['otp_expiry']) {
        $otp_error = "OTP Expired! Please click on Resend OTP.";
        $show_otp_modal = true;
    } else if (isset($_SESSION['temp_otp']) && $entered_otp == $_SESSION['temp_otp']) {
        $row = $_SESSION['otp_user_data'];
        
        date_default_timezone_set('Asia/Kolkata');
        $logout = date("Y-m-d h:i:s A");
        $uname = $row['username'];
        
        $sql = "UPDATE history SET logout = '$logout' WHERE username = '$uname' AND logout = 'Active'";
        $con->query($sql);

        $_SESSION['uname'] = $row['username'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['status'] = $row['status'];
        $_SESSION['picture'] = $row['picture'];
        $_SESSION['last-active'] = time();
        
        $login = date("Y-m-d h:i:s A");
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $sql = "INSERT INTO history (username, password, status, ip, login, logout) VALUES ('$_SESSION[uname]', '$_SESSION[password]', '$_SESSION[status]', '$ip', '$login', 'Active')";
        
        if ($con->query($sql) === TRUE) {
            $sql2 = "UPDATE user SET isActive = 1 WHERE username = '{$_SESSION['uname']}'";
            $con->query($sql2);
            
            unset($_SESSION['temp_otp']);
            unset($_SESSION['otp_expiry']);
            unset($_SESSION['otp_user_data']);
            
            switch ($_SESSION['status']) {
                case 'developer':
                case 'admin':
                    header('location: blog_list.php');
                    break;
                case 'sale-leader':
                    header('location: phase1data_user.php');
                    break;
                default:
                    header('location: phase1data.php');
                    break;
            }
            exit();
        }
    } else {
        $otp_error = "Invalid OTP! Please enter the correct code.";
        $show_otp_modal = true;
    }
}

// --- Logout ---
if (isset($_GET['logout']) && isset($_SESSION['uname'])) {
    date_default_timezone_set('Asia/Kolkata');
    $logout = date("Y-m-d h:i:s A");
    $sql = "UPDATE history SET logout = '$logout' WHERE username = '{$_SESSION['uname']}' AND logout = 'Active'";

    if ($con->query($sql) === TRUE) {
        $sql2 = "UPDATE user SET isActive = 0 WHERE username = '{$_SESSION['uname']}'";
        $con->query($sql2);
                
        unset($_SESSION['uname']);
        unset($_SESSION['password']);
        header('location: login.php');
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>C11CL Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: url('../wp-content/uploads/2026/banner/c11cl_login.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            position: relative;
            overflow: hidden;
        }
        .login-logo img {
            width: 100px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #0f172a;
            border-color: #0f172a;
        }
        .btn-primary:hover {
            background-color: #1e293b;
            border-color: #1e293b;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(31, 41, 55, 0.25);
            border-color: #1e293b;
        }
        .error-message {
            color: red;
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
        }
        .text-brand {
            color: #0f172a;
            font-weight: 700;
            font-size: 24px;
        }
        .password-wrapper {
            position: relative;
        }
        .password-toggle-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
            z-index: 10;
        }
        /* Top Horizontal Progress Loader CSS Bar */
        .progress-loader-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: #f1f5f9;
            display: none;
        }
        .progress-loader-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            animation: progressAnimation 2s ease-in-out infinite;
        }
        @keyframes progressAnimation {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
    </style>
</head>
<body>

  <div class="login-card">
    <!-- Top Progress Bar Container -->
    <div class="progress-loader-container" id="topProgressLoader">
        <div class="progress-loader-bar"></div>
    </div>

    <div class="text-center login-logo">
      <img src="https://c11cl.com/wp-content/uploads/2025/05/favicon-3.png" alt="C11CL Logo" />
    </div>
    <div class="text-center mb-3">
      <div class="text-brand">C11CL</div>
      <p class="text-muted">Please log in to your account</p>

      <?php if (isset($_SESSION['wrong'])) { ?>
        <div class="error-message"><?= $_SESSION['wrong']; unset($_SESSION['wrong']); ?></div>
      <?php } ?>
      <?php if (isset($denied)) { ?>
        <div class="error-message"><?= $denied; ?></div>
      <?php } ?>
    </div>

    <form method="post" id="mainLoginForm" onsubmit="return showProcessingLoader('signInSubmitBtn')">
      <div class="mb-3">
        <label for="username" class="form-label">Username, Email or Mobile</label>
        <input type="text" name="uname" class="form-control space-stripper" id="username" placeholder="Username / Email / Mobile" required />
      </div>
      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <div class="password-wrapper">
            <input type="password" name="password" class="form-control space-stripper" id="password" placeholder="Enter Password" required />
            <i class="bi bi-eye-slash password-toggle-eye" id="togglePassword"></i>
        </div>
      </div>
      <div class="d-grid">
        <!-- Hidden input field to preserve login post state safely -->
        <input type="hidden" name="login" value="1">
        <button type="submit" id="signInSubmitBtn" class="btn btn-primary">Sign In</button>
      </div>
    </form>
  </div>

  <!-- --- 1. Welcome Greeting Presentation Modal --- -->
  <div class="modal fade" id="welcomeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-dark text-center py-4">
        <div class="modal-body">
            <div class="mb-3 text-success">
                <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
            </div>
            <h4 style="font-weight: 700; color: #0f172a;">Welcome Back, <span id="welcomeUserName"><?= htmlspecialchars($welcome_name); ?></span>!</h4>
            <p class="text-muted mt-2">Login authorization verified successfully.</p>
            <div class="spinner-border text-primary mt-3" role="status">
                <span class="visually-hidden">Loading Security Key...</span>
            </div>
            <p class="text-secondary small mt-2">Generating secure 2FA authentication token...</p>
        </div>
      </div>
    </div>
  </div>

  <!-- --- 2. Modern OTP Verification Modal --- -->
  <div class="modal fade" id="otpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-dark">
        <div class="modal-header">
          <h5 class="modal-title" id="otpModalLabel" style="font-weight:700; color:#0f172a;">Two-Step Security Verification</h5>
        </div>
        <form method="post" onsubmit="return showProcessingLoader('verifyOtpSubmitBtn')">
          <div class="modal-body">
            <p class="text-muted small">We have sent a 6-digit verification code to your registered Email address and WhatsApp number. Code is active for <b>1 minute</b>.</p>
            
            <?php if (!empty($otp_error)) { ?>
                <div class="alert alert-danger py-2 small"><?= $otp_error; ?></div>
            <?php } ?>

            <div class="mb-3">
              <label for="otp_code" class="form-label fw-bold">Enter 6-Digit OTP</label>
              <input type="text" name="otp_code" class="form-control text-center fs-4 space-stripper" id="otp_code" maxlength="6" placeholder="000000" pattern="\d{6}" required autocomplete="off"/>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 small">
                <span class="text-secondary" id="timer-box">Resend in: <b id="countdown">15</b>s</span>
                <button type="button" class="btn btn-link p-0 text-decoration-none d-none" id="resendBtn" onclick="resendOTPProcess()">Resend OTP</button>
            </div>
          </div>
          <div class="modal-footer">
            <a href="login.php" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" name="verify_otp_btn" id="verifyOtpSubmitBtn" class="btn btn-primary btn-sm">Verify & Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let timeLeft = 15;
    let timerInterval;

    // Fixed Bug Handler: Form submit state preservation logic
    function showProcessingLoader(btnId) {
        document.getElementById('topProgressLoader').style.display = 'block';
        let targetBtn = document.getElementById(btnId);
        if (targetBtn) {
            // pointer-events used instead of disabled=true to prevent browser from ignoring post payload values
            targetBtn.style.pointerEvents = 'none';
            targetBtn.style.opacity = '0.7';
            targetBtn.innerText = "Processing Please Wait...";
        }
        return true; 
    }

    // Real-time Space Stripper engine logic
    document.querySelectorAll('.space-stripper').forEach(function(element) {
        ['input', 'paste', 'change'].forEach(function(evt) {
            element.addEventListener(evt, function() {
                this.value = this.value.replace(/\s+/g, '');
            });
        });
    });

    // Eye View/Hide toggle operation
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    if(togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    }

    function startTimer() {
        clearInterval(timerInterval);
        timeLeft = 15;
        document.getElementById('resendBtn').classList.add('d-none');
        document.getElementById('timer-box').classList.remove('d-none');
        document.getElementById('countdown').innerText = timeLeft;

        timerInterval = setInterval(function() {
            timeLeft--;
            document.getElementById('countdown').innerText = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                document.getElementById('timer-box').classList.add('d-none');
                document.getElementById('resendBtn').classList.remove('d-none');
            }
        }, 1000);
    }

    function resendOTPProcess() {
        const resendBtn = document.getElementById('resendBtn');
        resendBtn.innerText = "Sending...";
        resendBtn.style.pointerEvents = "none";
        document.getElementById('topProgressLoader').style.display = 'block';

        let formData = new URLSearchParams();
        formData.append('action', 'resend_otp');

        fetch('login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(response => response.json())
        .then(data => {
            resendBtn.innerText = "Resend OTP";
            resendBtn.style.pointerEvents = "auto";
            document.getElementById('topProgressLoader').style.display = 'none';
            if(data.status === 'success') {
                alert('A new secure OTP code has been dispatched!');
                startTimer();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            resendBtn.innerText = "Resend OTP";
            resendBtn.style.pointerEvents = "auto";
            document.getElementById('topProgressLoader').style.display = 'none';
            alert('Something went wrong. Please check connection.');
        });
    }

    // Modal triggering flow pipeline
    document.addEventListener("DOMContentLoaded", function() {
        <?php if ($show_welcome_modal === true) { ?>
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
            var otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
            
            welcomeModal.show();
            
            setTimeout(function() {
                welcomeModal.hide();
                setTimeout(function() {
                    document.getElementById('topProgressLoader').style.display = 'none';
                    otpModal.show();
                    startTimer();
                }, 400); 
            }, 1800);
        <?php } ?>

        <?php if ($show_otp_modal === true) { ?>
            var otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
            otpModal.show();
            startTimer();
        <?php } ?>
    });
  </script>
</body>
</html>