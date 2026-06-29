<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');

// Force HTTPS on InfinityFree (proxy may not set HTTPS server var)
if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// We need to return JSON if AJAX is requested
$is_ajax = isset($_POST['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

if (isset($_POST['submit'])) {
    include "db.php"; // your database connection

    $email = trim($_POST['email'] ?? '');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if ($is_ajax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
            exit();
        } else {
            echo "Invalid email format.";
            exit();
        }
    }

    // Save email to database
    $now = date('Y-m-d H:i:s');
    $sql = "INSERT INTO email_subscriptions (email, subscribed_at) VALUES ('$email', '$now')";
    if ($con->query($sql) === TRUE) {
        // Include PHPMailer files
        $phpmailer_dir = file_exists(__DIR__ . '/PHPMailer/src/PHPMailer.php') ? __DIR__ . '/PHPMailer/src' : __DIR__ . '/../PHPMailer/src';
        require_once $phpmailer_dir . '/PHPMailer.php';
        require_once $phpmailer_dir . '/SMTP.php';
        require_once $phpmailer_dir . '/Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port = SMTP_PORT;

            // Sender and receiver
            $mail->setFrom(SMTP_USER, 'Champions 11 Cricket League (C11CL)');
            $mail->addAddress($email); // Recipient

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to C11CL – You are Subscribed!';
            $mail->Body = '
                Hi there,<br><br>

                👋 Thank you for subscribing to <strong>Champions 11 Cricket League (C11CL)</strong>!<br><br>

                🎯 You will now receive the latest updates, important notifications, and exclusive announcements directly in your inbox.<br><br>

                📰 From match schedules to registration news, we’ve got you covered. Stay tuned for exciting updates!<br><br>

                Regards,<br>
                <strong>Team C11CL</strong><br>
                <i>Champions 11 Cricket League</i>
            ';

            $mail->addReplyTo(SMTP_USER, 'C11CL Support');
            $mail->send(); // Try sending mail
        } catch (Exception $e) {
            // Log or echo error if needed
        }

        if ($is_ajax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'success', 'message' => 'Thank you for subscribing! You will receive updates in your inbox.']);
            if ($con) { $con->close(); }
            exit();
        } else {
            // Redirect to same page with success flag
            $redirectURL = $_SERVER['HTTP_REFERER'] ?? '/';
            $redirectURL .= (parse_url($redirectURL, PHP_URL_QUERY)) ? '&status=success' : '?status=success';
            header("Location: $redirectURL");
            exit();
        }
    } else {
        $err = $con->error;
        if (strpos($err, 'Duplicate entry') !== false) {
            if ($is_ajax) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'success', 'message' => 'You are already subscribed to our newsletter! Thank you.']);
                if ($con) { $con->close(); }
                exit();
            } else {
                $redirectURL = $_SERVER['HTTP_REFERER'] ?? '/';
                header("Location: $redirectURL");
                exit();
            }
        } else {
            if ($is_ajax) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $err]);
                if ($con) { $con->close(); }
                exit();
            } else {
                echo "Database Error: " . $err;
            }
        }
    }

    if ($con) { $con->close(); }
} else {
    if ($is_ajax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
        exit();
    }
}
?>
