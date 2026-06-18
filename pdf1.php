<?php
session_start();
require_once('tcpdf/tcpdf.php');
include 'db.php';
include 'phpqrcode/qrlib.php';

use Mpdf\Mpdf;



$reg = $_GET["reg"];

// Fetch player details
$sql = "SELECT * FROM register WHERE reg = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $reg);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Data not found");
}

// Assign values
$name = $row["name"];
$age = $row["age"];
$sp = $row["player"];
$date = $row["paydate"];
$time = $row["paytime"];

// Generate QR Code
$PNG_TEMP_DIR = 'temp/';
if (!file_exists($PNG_TEMP_DIR)) {
    mkdir($PNG_TEMP_DIR);
}

$codeString = $reg;
$filename = $PNG_TEMP_DIR . 'qr_' . md5($codeString) . '.png';
QRcode::png($codeString, $filename);

// Create PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 11);

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
            <strong>' . htmlspecialchars($name) . '</strong><br>
            ' . htmlspecialchars($age) . ' Years | ' . htmlspecialchars($sp) . '<br>
            ' . htmlspecialchars($date) . '<br>
            ' . htmlspecialchars($time) . '
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
             Congratulations!
        </td>
    </tr>

    <!-- Sub Title -->
    <tr>
        <td align="center" style="font-size:13pt; font-weight:normal; color:#000000;">
            You’ve successfully registered for <strong style="color:#0D1B2A;">Champions 11 Cricket League</strong>.
        </td>
    </tr>

    <!-- Section Heading -->
    <tr>
        <td align="center" style="font-size:20pt; font-weight:bold; padding-top:15px; color:#000000;">
            Your Trial Registration Number:
        </td>
    </tr>

    <!-- Registration Code Badge -->
    <tr>
        <td align="center">
            <div style="display:inline-block; background-color:#4CAF50; color:white; font-size:18pt; font-weight:bold; padding:12px 35px; border-radius:25px; border: 2px solid #388E3C;">
                ' . strtoupper(htmlspecialchars($reg)) . '
            </div>
        </td>
    </tr>

    <!-- Info Message -->
    <tr>
        <td align="center" style="font-size:15pt; padding-top:25px; line-height:1.5;">
            <strong style="color:#0D1B2A;">Trial Details:</strong> <br>
            <span style="color:#000000;">Date, Time & Venue will be shared soon.</span><br><br>
            Stay updated by following our official social media channels listed below.
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


// Output
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('C11CL_Registration_' . $reg . '.pdf', 'D');
?>
