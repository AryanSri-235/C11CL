<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if form submitted
if (isset($_POST['submit'])) {
    include "db.php"; // your database connection

    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Save email to database
    $sql = "INSERT INTO email_subscriptions (email) VALUES ('$email')";
    if ($con->query($sql) === TRUE) {
        // Include PHPMailer files
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';
        require '../PHPMailer/src/Exception.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@c11cl.com';
            $mail->Password = 'C11cl@#cricket2025';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Sender and receiver
            $mail->setFrom('info@c11cl.com', 'Champions 11 Cricket League (C11CL)');
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

           $mail->addReplyTo('info@c11cl.com', 'C11CL Support');


            $mail->send(); // Try sending mail
        } catch (Exception $e) {
            // Log or echo error if needed: $mail->ErrorInfo
        }

        // Redirect to same page with success flag
        $redirectURL = $_SERVER['HTTP_REFERER'] ?? '/';
        $redirectURL .= (parse_url($redirectURL, PHP_URL_QUERY)) ? '&status=success' : '?status=success';
        header("Location: $redirectURL");
        exit();
    } else {
        echo "Database Error: " . $con->error;
    }

    $con->close();
}
?>
