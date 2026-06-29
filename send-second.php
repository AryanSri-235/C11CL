<?php
// ============================================================
// MAIL TOGGLE — set to true once Hostinger SMTP is ready
// ============================================================
define('MAIL_ENABLED_2', false);
// ============================================================

ini_set('display_errors', 0);

session_start();

// Handle ?id=... for manual trigger (restricted to admin session)
if (isset($_GET['id'])) {
    if (!isset($_SESSION['password']) || !isset($_SESSION['uname'])) {
        header("Location: Panel/login.php");
        exit();
    }
    $_SESSION['id'] = intval($_GET['id']);
    $_SESSION['complete_reg2'] = true;
    header("Location: send-second.php"); 
    exit();
}

if (isset($_SESSION['complete_reg2'])) {
    unset($_SESSION['complete_reg2']);

    include 'db.php';

    if (isset($_SESSION['payreg2'])) {
        $reg2 = $con ? $con->real_escape_string($_SESSION['payreg2']) : addslashes($_SESSION['payreg2']);
        $sql = "SELECT * FROM `register-second` WHERE reg2 = '$reg2'";
    } elseif (isset($_SESSION['id'])) {
        $id = intval($_SESSION['id']);
        $sql = "SELECT * FROM `register-second` WHERE id = '$id'";
    } elseif (isset($_SESSION['remsgphase2'])) {
        $id = intval($_SESSION['remsgphase2']);
        $sql = "SELECT * FROM `register-second` WHERE id = '$id'";
    } else {
        exit("No valid session data found.");
    }

    $result = $con->query($sql);
    if ($result->num_rows === 0) {
        exit("No matching record found.");
    }

    $row = $result->fetch_assoc();

    $name = $row["name"];
    $age = $row["age"];
    $sp = $row["player"];
    $date = $row["paydate"];
    $time = $row["paytime"];
    $email = $row["email"];
    $phone = $row["mobile"];
    $reg2 = $row["reg2"];
    $mailsent = $row["mailsent"];

    if (!MAIL_ENABLED_2) {
        // Mail disabled — skip QR/PDF/email, go straight to success
        $_SESSION['mail_sent2'] = false;
        $_SESSION['mail_to2']   = $email ?? '';
        if (isset($_SESSION['id'])) {
            unset($_SESSION['id']);
            header('location:Panel/phase2data.php');
        } elseif (isset($_SESSION['remsgphase2'])) {
            header("Location: dashboard/phase2-players-data.php?id={$_SESSION['remsgphase2']}");
        } else {
            header('location:success_second.php');
        }
        exit();
    }

    // Format phone
    if (preg_match('/^\d{10}$/', $phone)) {
        $phone = '91' . $phone;
    }

    // QR Code
    include 'phpqrcode/qrlib.php';
    $PNG_TEMP_DIR = 'temp/';
    if (!file_exists($PNG_TEMP_DIR)) {
        mkdir($PNG_TEMP_DIR);
    }
    $codeString = $reg2 . "\n";
    $filename = $PNG_TEMP_DIR . 'phase2_' . md5($codeString) . '.png';
    QRcode::png($codeString, $filename);

    // PDF
    require_once('tcpdf/tcpdf.php');
    $pdf = new TCPDF();
    $pdf->setPrintHeader(false);
    $pdf->SetTitle('C11CL Phase 2 Registration');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 10);


$html = '
<table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr>
        <td align="center">
            <img src="uploads/img/pdf.png">
        </td>
    </tr>
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
        <td  align="right">
            <img src="' . $filename . '" width="100" />
        </td>
    </tr>
</table>

<br><br>

<table cellpadding="5" cellspacing="0" width="100%">
    <!-- Title -->
    <tr>
        <td align="center" style="font-size:20pt; font-weight:bold; color:#0D1B2A;">
             Phase 2 Registration Successful!
        </td>
    </tr>

    <!-- Sub Title -->
    <tr>
        <td align="center" style="font-size:13pt; font-weight:normal; color:#000000;">
            Congratulations! You’ve successfully completed <strong style="color:#0D1B2A;">Phase 2 Registration</strong> for the Champions 11 Cricket League.
        </td>
    </tr>



    <!-- Registration Code Badge -->
    <tr>
  <td align="center" style="font-size:15pt;">
                Trial Registration Number: 
                <span style="background-color:#4CAF50; color:#fff; padding:8px 20px; border-radius:25px;">
                    ' . strtoupper(htmlspecialchars($reg2)) . '
                </span>
            </td>
    </tr>

    <!-- Info Message -->
    <tr>
        <td align="center" style="font-size:15pt; padding-top:25px; line-height:1.5;">
            <strong style="color:#0D1B2A;">Next Steps:</strong> <br>
            <span style="color:#000000;">Your Phase 2 Match schedule, date, time & venue will be shared shortly via email and Call.</span><br><br>
            Please keep checking your inbox and stay updated through our official social media handles.
        </td>
    </tr>
</table>



<br><br>

<table align="center" cellpadding="5" cellspacing="0" border="0">
    <tr>
        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" width="20"><br>
        <a href="https://www.instagram.com/c11clofficial/">Instagram</a></td>

        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="20"><br>
        <a href="https://www.facebook.com/profile.php?id=61575926537950">Facebook</a></td>

        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/5968/5968830.png" width="20"><br>
        <a href="https://x.com/champions11cl">Twitter</a></td>

        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/145/145807.png" width="20"><br>
        <a href="https://www.linkedin.com/company/champions11cricketleague/">LinkedIn</a></td>

        <td align="center"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" width="20"><br>
        <a href="https://www.youtube.com/@champions11cricketleague">YouTube</a></td>
    </tr>
</table>

<br><br>

<hr>

<br>

<table cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="font-size:17pt; font-weight:bold;">
            www.c11cl.com &nbsp;&nbsp; | &nbsp;&nbsp; info@c11cl.com &nbsp;&nbsp; | &nbsp;&nbsp; +91 9599505213
        </td>
    </tr>
</table>

';

    $pdf->writeHTML($html);
    $pdfcontent = $pdf->Output('C11CL_Phase2.pdf', 'S');

    // Email
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

    $mail->setFrom('info@c11cl.com', 'Champions 11 Cricket League');
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    $mail->Subject = 'C11CL Phase 2 Registration Successful';
    $mail->Body = "
        Hi $name,<br><br>
        Congratulations! Your Phase 2 registration for C11CL is successful.<br>
        Registration ID: <strong>$reg2</strong><br><br>
        Please find attached your Phase 2 registration slip.
    ";
    $mail->addStringAttachment($pdfcontent, 'C11CL_Phase2.pdf', 'base64', 'application/pdf');

    if (MAIL_ENABLED_2) {
        if ($mail->send()) {
            $mailsent++;
            $con->query("UPDATE `register-second` SET mailsent = $mailsent WHERE reg2 = '$reg2'");
            $_SESSION['mail_sent2'] = true;
            $_SESSION['mail_to2']   = $email;
        } else {
            error_log('C11CL Phase2 PHPMailer Error: ' . $mail->ErrorInfo);
            $_SESSION['mail_sent2'] = false;
        }
    } else {
        $_SESSION['mail_sent2'] = false;
        $_SESSION['mail_to2']   = $email ?? '';
    }

    // Always redirect — check user payment flow first, then admin flows
    if (isset($_SESSION['payreg2'])) {
        header('Location: /success_second.php');
    } elseif (isset($_SESSION['id'])) {
        unset($_SESSION['id']);
        header('Location: /Panel/phase2data.php');
    } elseif (isset($_SESSION['remsgphase2'])) {
        header("Location: /dashboard/phase2-players-data.php?id={$_SESSION['remsgphase2']}");
    }
    exit();
} else {
    exit("Direct access not allowed.");
}
?>
