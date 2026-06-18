<?php
session_start();

// TCPDF और QR Code library को include करें
require_once('tcpdf/tcpdf.php');
include 'phpqrcode/qrlib.php';
include 'db.php';

if (!isset($_GET["pdf"]) || empty($_GET["pdf"])) {
    die("Invalid or missing registration ID.");
}

$reg = mysqli_real_escape_string($con, $_GET["pdf"]);

// Database से details लाना
$sql = "SELECT * FROM register WHERE reg= '$reg' ";
$result = $con->query($sql);

if ($result->num_rows == 0) {
    die("❌ No registration found.");
}

$row = $result->fetch_assoc();
$name = $row["name"];
$age = $row["age"];
$sp = $row["player"];
$date = $row["paydate"];
$time = $row["paytime"];

// QR Code Generate करना
$PNG_TEMP_DIR = 'temp/';
if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);
$codeString = $reg . "\n";
$filename = $PNG_TEMP_DIR . 'qr_' . md5($codeString) . '.png';
QRcode::png($codeString, $filename);

// PDF बनाना
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetTitle('C11CL Registration PDF');
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// HTML Content for PDF
$html = '
<div style="padding:5px; font-family:sans-serif; font-size:14px; line-height:1.6; color:#333;">
    <div style="text-align:center;">
        <img src="uploads/img/pdf.png" height="70" alt="C11CL Logo">
    </div>

    <table width="100%" style="margin-top:15px;">
        <tr>
            <td>
                <strong>To,</strong><br>
                <span style="text-transform:capitalize;">' . htmlspecialchars($name) . '</span><br>
                ' . htmlspecialchars($age) . ' Years | ' . htmlspecialchars($sp) . '<br>
                ' . htmlspecialchars($date) . '<br>
                <span style="text-transform:uppercase;">' . htmlspecialchars($time) . '</span>
            </td>
            <td align="right">
                <img src="' . $filename . '" style="width:110px; border:1px solid #444; border-radius:8px;">
            </td>
        </tr>
    </table>

    <div style="text-align:center; margin: 30px 0;">
        <h2 style="color:#0D1B2A;">🎉 Congratulations!</h2>
        <p>You’ve successfully registered for <strong>Champions 11 Cricket League</strong>.</p>
        <p style="font-size:16px; margin:20px 0;">Your Trial Registration No:</p>
        <div style="background:#4CAF50; color:#fff; padding:10px 25px; border-radius:25px; font-size:20px; font-weight:bold; display:inline-block;">
            ' . htmlspecialchars($reg) . '
        </div>
        <p style="margin-top:25px;">
            📢 <strong>Trial details</strong> (date, time & venue) will be shared soon.<br>
            Stay updated on our social media!
        </p>
    </div>

    <div style="text-align:center; margin-top:30px;">
        <p><strong>Follow us:</strong></p>
        <p>
            <a href="https://www.instagram.com/champions11cricketleague"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" width="28"></a>
            <a href="https://www.facebook.com/profile.php?id=61575926537950"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="28"></a>
            <a href="https://x.com/champions11cl"><img src="https://cdn-icons-png.flaticon.com/512/5968/5968830.png" width="28"></a>
            <a href="https://www.linkedin.com/company/champions11cricketleague/posts/?feedView=all"><img src="https://cdn-icons-png.flaticon.com/512/145/145807.png" width="28"></a>
            <a href="https://www.youtube.com/@champions11cricketleague"><img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" width="28"></a>
        </p>
    </div>

    <hr style="margin:25px 0; border:none; border-top:1px solid #999;">

    <div style="text-align:center; font-size:13px; color:#555;">
        For any queries or trial updates:<br>
        🌐 <strong>www.c11cl.com</strong> | 📧 <strong>info@c11cl.com</strong> | 📞 <strong>+91 9599505213</strong>
    </div>
</div>';

// HTML को PDF में रेंडर करें
$pdf->writeHTML($html);

// PDF को ब्राउज़र में इनलाइन ओपन करें
$pdf->Output('C11CL-Registration-' . $reg . '.pdf', 'I');
?>
