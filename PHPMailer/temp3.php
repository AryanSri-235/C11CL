<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('location:failure.php');
}
else{
    $email = $_SESSION['email'];
}
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // Corrected SMTP host
$mail->SMTPAuth = true;
$mail->Username = 'mrbarthwalji103@gmail.com'; // Your Gmail username
$mail->Password = 'bgrmbslssvdrkgfq'; // Your Gmail password
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('mrbarthwalji103@gmail.com', 'FCC');
$mail->addAddress($email, ''); // Replace with recipient's email address and name

$mail->isHTML(true);
$mail->Subject = 'Registration Successful';
$mail->Body = 'Please find the attached PDF.';

if ($mail->send()) {
    echo 'Email sent successfully!';
    header('location:feedetail.php');
} else {
    echo 'Error: ' . $mail->ErrorInfo;
}


?>