<?php
session_start();
include 'db.php';

$denied = '';
if (isset($_POST['login'])) {
    $uname = trim($_POST['uname'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if ($con) {
        // Parameterized login check
        $stmt = $con->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $uname, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['stoper'] == 'Stop') {
                    $denied = 'Access denied: your account has been suspended.';
                } else {
                    date_default_timezone_set('Asia/Kolkata');
                    $logout = date("Y-m-d h:i:s A");
                    
                    // Mark previous active session as logged out
                    $upHistory = $con->prepare("UPDATE history SET logout = ? WHERE username = ? AND logout = 'Active'");
                    if ($upHistory) {
                        $upHistory->bind_param("ss", $logout, $uname);
                        $upHistory->execute();
                        $upHistory->close();
                    }
                    
                    // Set sessions
                    $_SESSION['uname'] = $row['username'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['status'] = $row['status'];
                    $_SESSION['picture'] = $row['picture'];
                    $_SESSION['last-active'] = time();
                    
                    $login = date("Y-m-d h:i:s A");
                    $ip = $_SERVER['REMOTE_ADDR'];
                    
                    // Log new active session
                    $insHistory = $con->prepare("INSERT INTO history (username, password, status, ip, login, logout) VALUES (?, ?, ?, ?, ?, 'Active')");
                    if ($insHistory) {
                        $insHistory->bind_param("sssss", $_SESSION['uname'], $_SESSION['password'], $_SESSION['status'], $ip, $login);
                        $insHistory->execute();
                        $insHistory->close();
                    }
                    
                    // Update active status
                    $upUser = $con->prepare("UPDATE user SET isActive = 1 WHERE username = ?");
                    if ($upUser) {
                        $upUser->bind_param("s", $_SESSION['uname']);
                        $upUser->execute();
                        $upUser->close();
                    }
                    
                    // Role based redirection logic
                    switch ($_SESSION['status']) {
                        case 'developer':
                        case 'admin':
                        case 'superadmin':
                            header('location: dashboard.php');
                            break;
                        case 'sale-leader':
                            header('location: phase1data_user.php');
                            break;
                        default:
                            header('location: dashboard.php');
                            break;
                    }
                    exit();
                }
            } else {
                $_SESSION['wrong'] = "WRONG USERNAME AND PASSWORD";
            }
            $stmt->close();
        } else {
            $_SESSION['wrong'] = "Database Statement Error.";
        }
    } else {
        // Fallback for local sandbox testing when database is offline
        if ($uname === 'admin' && $password === 'admin123') {
            $_SESSION['uname'] = 'admin';
            $_SESSION['name'] = 'Administrator';
            $_SESSION['password'] = 'admin123';
            $_SESSION['status'] = 'superadmin';
            $_SESSION['picture'] = '';
            $_SESSION['last-active'] = time();
            header('location: dashboard.php');
            exit();
        } else if ($uname === 'coach' && $password === 'coach123') {
            $_SESSION['uname'] = 'coach';
            $_SESSION['name'] = 'Coach Member';
            $_SESSION['password'] = 'coach123';
            $_SESSION['status'] = 'coach';
            $_SESSION['picture'] = '';
            $_SESSION['last-active'] = time();
            header('location: user-profile.php');
            exit();
        } else {
            $_SESSION['wrong'] = "Database Connection Offline. Try 'admin' / 'admin123' or 'coach' / 'coach123'.";
        }
    }
}

// Logout logic
if (isset($_GET['logout'])) {
    if (isset($_SESSION['uname']) && $con) {
        date_default_timezone_set('Asia/Kolkata');
        $logout = date("Y-m-d h:i:s A");
        
        $upHistory = $con->prepare("UPDATE history SET logout = ? WHERE username = ? AND logout = 'Active'");
        if ($upHistory) {
            $upHistory->bind_param("ss", $logout, $_SESSION['uname']);
            $upHistory->execute();
            $upHistory->close();
        }
        
        $upUser = $con->prepare("UPDATE user SET isActive = 0 WHERE username = ?");
        if ($upUser) {
            $upUser->bind_param("s", $_SESSION['uname']);
            $upUser->execute();
            $upUser->close();
        }
    }
    
    unset($_SESSION['uname']);
    unset($_SESSION['password']);
    unset($_SESSION['name']);
    unset($_SESSION['status']);
    unset($_SESSION['picture']);
    unset($_SESSION['last-active']);
    
    header('location:../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C11CL Administrative Panel Login</title>
    <!-- Favicon -->
    <link rel="icon" href="assets/images/fevikondashoard.png" type="image/png" />
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styling for premium aesthetic -->
    <style>
        :root {
            --navy: #002244;
            --navy-dark: #00152b;
            --crimson: #CC0000;
            --crimson-hover: #b30000;
            --light-navy: #003366;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(rgba(0, 21, 43, 0.85), rgba(0, 15, 30, 0.9)), url('../wp-content/uploads/2025/05/cricket-background-6612flqfx69kwfoz.jpg') no-repeat center center / cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin: 0;
            padding: 20px;
        }

        /* Ambient glowing circles */
        .ambient-glow {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            z-index: 1;
        }
        .glow-1 {
            background: var(--crimson);
            top: -100px;
            left: -100px;
        }
        .glow-2 {
            background: var(--light-navy);
            bottom: -150px;
            right: -100px;
        }

        /* Abstract grid pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 2;
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
        }

        .login-card {
            background: rgba(10, 20, 40, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 45px 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-2px);
            border-color: rgba(204, 0, 0, 0.25);
            box-shadow: 0 25px 60px rgba(204, 0, 0, 0.08);
        }

        .brand-logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }

        .brand-logo {
            width: 110px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
            transition: transform 0.5s ease;
        }

        .brand-logo:hover {
            transform: rotateY(180deg);
        }

        .login-title {
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
            text-align: center;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #8c9bb0;
            font-size: 13.5px;
            font-weight: 500;
            text-align: center;
            margin-bottom: 35px;
        }

        .form-group-custom {
            position: relative;
            margin-bottom: 24px;
        }

        .form-group-custom label {
            display: block;
            color: #b0c0d8;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #5d6e87;
            font-size: 18px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-control-custom {
            width: 100%;
            background: rgba(2, 6, 12, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 13px 16px 13px 46px;
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            outline: none;
        }

        .form-control-custom:focus {
            background: rgba(2, 6, 12, 0.6);
            border-color: var(--crimson);
            box-shadow: 0 0 12px rgba(204, 0, 0, 0.25);
            color: #ffffff;
        }

        .form-control-custom:focus + .input-icon {
            color: var(--crimson);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--crimson) 0%, #aa0000 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            padding: 14px 20px;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(204, 0, 0, 0.25);
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--crimson-hover) 0%, #990000 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(204, 0, 0, 0.35);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        .alert-custom {
            background: rgba(220, 53, 69, 0.12);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 12px;
            color: #ff6b7e;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 24px;
        }

        .copyright-text {
            color: #5d6e87;
            font-size: 11.5px;
            font-weight: 500;
            text-align: center;
            margin-top: 25px;
        }
    </style>
    <!-- Boxicons for premium icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <!-- Background Ambient Glows -->
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="login-container">
        <div class="login-card">
            
            <!-- Brand Logo -->
            <div class="brand-logo-container">
                <img src="https://c11cl.com/wp-content/uploads/2025/05/favicon-3.png" alt="C11CL Logo" class="brand-logo">
            </div>

            <!-- Header Titles -->
            <div class="login-title">C11CL ADMINISTRATIVE</div>
            <div class="login-subtitle">Secured System Access Portal</div>

            <!-- Error Alerts -->
            <?php if (isset($_SESSION['wrong'])) { ?>
                <div class="alert-custom">
                    <i class="bx bx-error-circle" style="vertical-align: middle; margin-right: 6px; font-size: 16px;"></i>
                    <?= $_SESSION['wrong']; unset($_SESSION['wrong']); ?>
                </div>
            <?php } ?>
            <?php if (!empty($denied)) { ?>
                <div class="alert-custom">
                    <i class="bx bx-lock-alt" style="vertical-align: middle; margin-right: 6px; font-size: 16px;"></i>
                    <?= $denied; ?>
                </div>
            <?php } ?>

            <!-- Login Form -->
            <form method="POST" action="login.php">
                
                <!-- Username Input -->
                <div class="form-group-custom">
                    <label for="username">Username / ID</label>
                    <div class="input-wrapper">
                        <input type="text" name="uname" class="form-control-custom" id="username" placeholder="Enter username" autocomplete="username" required>
                        <i class="bx bx-user input-icon"></i>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="form-group-custom">
                    <label for="password">Security Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" class="form-control-custom" id="password" placeholder="Enter password" autocomplete="current-password" required>
                        <i class="bx bx-key input-icon"></i>
                    </div>
                </div>

                <!-- Action Button -->
                <button type="submit" name="login" class="btn-login">
                    Authorize & Sign In
                </button>

            </form>

            <!-- Copyright footer inside card -->
            <div class="copyright-text">
                &copy; <?= date('Y') ?> C11CL Platform. All rights reserved.
            </div>

        </div>
    </div>

</body>
</html>