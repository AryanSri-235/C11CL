<?php
// ============================================================
// MAIL TOGGLE — set to true once Hostinger SMTP is ready
// ============================================================
define('MAIL_ENABLED', false);
// ============================================================

ini_set('display_errors', 0);
session_start();

// Handle ?id=... (admin "Mark Success" button)
if (isset($_GET['id'])) {
    if (!isset($_SESSION['password']) || !isset($_SESSION['uname'])) {
        header("Location: Panel/login.php");
        exit();
    }
    $_SESSION['id'] = intval($_GET['id']);
    $_SESSION['complete_reg'] = true;
    header("Location: send.php");
    exit();
}

if (!isset($_SESSION['complete_reg'])) {
    exit("Direct access not allowed.");
}
unset($_SESSION['complete_reg']);

include 'db.php';

// Determine which registration to process
if (isset($_SESSION['payreg'])) {
    $regVal = $con->real_escape_string($_SESSION['payreg']);
    $sql = "SELECT * FROM register WHERE reg = '$regVal'";
} elseif (isset($_SESSION['id'])) {
    $sql = "SELECT * FROM register WHERE id = " . intval($_SESSION['id']);
} elseif (isset($_SESSION['remsgphase1'])) {
    $sql = "SELECT * FROM register WHERE id = " . intval($_SESSION['remsgphase1']);
} else {
    exit("No valid session data found.");
}

$result = $con->query($sql);
if (!$result || $result->num_rows === 0) {
    exit("No matching record found.");
}

$row      = $result->fetch_assoc();
$name     = $row["name"];
$age      = $row["age"];
$sp       = $row["player"];
$date     = $row["paydate"];
$time     = $row["paytime"];
$email    = $row["email"];
$phone    = $row["mobile"];
$reg      = $row["reg"];
$mailsent = (int)$row["mailsent"];

if (MAIL_ENABLED) {
    // Format phone
    if (preg_match('/^\d{10}$/', $phone)) {
        $phone = '91' . $phone;
    }

    // QR Code
    include 'phpqrcode/qrlib.php';
    $PNG_TEMP_DIR = 'temp/';
    if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);
    $codeString = $reg . "\n";
    $filename = $PNG_TEMP_DIR . 'test' . md5($codeString) . '.png';
    QRcode::png($codeString, $filename);

    // PDF
    require_once('tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->SetTitle('C11CL PDF');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 10);

    $html = '
<table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr><td align="center"><img src="uploads/img/pdf.png"></td></tr>
</table>
<br>
<table cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <td width="50%">
            <strong>To,</strong><br>
            <strong>' . htmlspecialchars($name ?? '') . '</strong><br>
            ' . htmlspecialchars($age ?? '') . ' Years | ' . htmlspecialchars($sp ?? '') . '<br>
            ' . htmlspecialchars($date ?? '') . '<br>
            ' . htmlspecialchars($time ?? '') . '
        </td>
        <td align="right"><img src="' . $filename . '" width="100" /></td>
    </tr>
</table>
<br><br>
<table cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="font-size:20pt; font-weight:bold; color:#0D1B2A;">Congratulations!</td>
    </tr>
    <tr>
        <td align="center" style="font-size:13pt; color:#000000;">
            You\'ve successfully registered for <strong style="color:#0D1B2A;">Champions 11 Cricket League</strong>.
        </td>
    </tr>
    <tr>
        <td align="center" style="font-size:20pt; font-weight:bold; padding-top:15px; color:#000000;">
            Your Trial Registration Number:
        </td>
    </tr>
    <tr>
        <td align="center">
            <div style="display:inline-block; background-color:#4CAF50; color:white; font-size:18pt; font-weight:bold; padding:12px 35px; border-radius:25px; border:2px solid #388E3C;">
                ' . strtoupper(htmlspecialchars($reg)) . '
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" style="font-size:15pt; padding-top:25px; line-height:1.5;">
            <strong style="color:#0D1B2A;">Trial Details:</strong><br>
            <span style="color:#000000;">Date, Time &amp; Venue will be shared soon.</span><br><br>
            Stay updated by following our official social media channels.
        </td>
    </tr>
</table>
<br><br>
<table align="center" cellpadding="5" cellspacing="0" border="0">
    <tr>
        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" width="20"><br><a href="https://www.instagram.com/c11clofficial/">Instagram</a></td>
        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="20"><br><a href="https://www.facebook.com/profile.php?id=61575926537950">Facebook</a></td>
        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/5968/5968830.png" width="20"><br><a href="https://x.com/champions11cl">Twitter</a></td>
        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/145/145807.png" width="20"><br><a href="https://www.linkedin.com/company/champions11cricketleague/">LinkedIn</a></td>
        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" width="20"><br><a href="https://www.youtube.com/@champions11cricketleague">YouTube</a></td>
    </tr>
</table>
<br><br><hr><br>
<table cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="font-size:17pt; font-weight:bold;">
            www.c11cl.com &nbsp;|&nbsp; info@c11cl.com &nbsp;|&nbsp; +91 9599505213
        </td>
    </tr>
</table>';

    $pdf->writeHTML($html);
    $pdfcontent = $pdf->Output('C11CL_Registration.pdf', 'S');

    // Email — update SMTP credentials in .env.php when ready
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host       = defined('SMTP_HOST') ? SMTP_HOST : 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = defined('SMTP_USER') ? SMTP_USER : 'info@c11cl.com';
    $mail->Password   = defined('SMTP_PASS') ? SMTP_PASS : '';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = defined('SMTP_PORT') ? SMTP_PORT : 587;

    $mail->setFrom('info@c11cl.com', 'Champions 11 Cricket League (C11CL)');
    $mail->addAddress($email, $name);
    $mail->addReplyTo('info@c11cl.com', 'C11CL Support');
    $mail->isHTML(true);
    $mail->Subject = 'C11CL Registration Successful – Welcome to the League!';
    $mail->Body    = 'Hi ' . $name . ',<br><br>
        🎉 <strong>Congratulations!</strong><br><br>
        Your registration for <strong>C11CL</strong> is successful.<br>
        Registration ID: <strong>' . $reg . '</strong><br><br>
        📎 Attached is your registration slip.<br><br>
        Best wishes,<br><strong>Team C11CL</strong>';

    $mail->addStringAttachment($pdfcontent, 'C11CL_Registration.pdf', 'base64', 'application/pdf');

    if ($mail->send()) {
        $mailsent++;
        $con->query("UPDATE register SET mailsent = $mailsent WHERE reg = '$reg'");
        $_SESSION['mail_sent'] = true;
        $_SESSION['mail_to']   = $email;
    } else {
        error_log('C11CL PHPMailer Error: ' . $mail->ErrorInfo);
        $_SESSION['mail_sent'] = false;
    }

} else {
    // Mail disabled — set session flags for success page display
    $_SESSION['mail_sent'] = false;
    $_SESSION['mail_to']   = $email ?? '';
}

// Always redirect — check user payment flow first, then admin flows
if (isset($_SESSION['payreg'])) {
    header('Location: /success.php');
    exit();
} elseif (isset($_SESSION['id'])) {
    unset($_SESSION['id']);
    header('Location: /Panel/phase1data.php');
    exit();
} elseif (isset($_SESSION['remsgphase1'])) {
    header("Location: /dashboard/trials-players-data.php?id={$_SESSION['remsgphase1']}");
    exit();
}
?>
