<?php
session_start();

if(isset($_SESSION['payreg'])){
     //unset($_SESSION['payreg']);
    }
    
// Include the mpdf library

use Mpdf\Mpdf;

if(isset($_GET["pdf"])){
      include 'db.php';
  $reg = $_GET["pdf"];
    $sql = "SELECT * FROM register WHERE reg= '$reg' ";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
      $name = $row["name"];
      $age = $row["age"];
      $sp = $row["player"];
      $reg = $row["reg"];
      $date = $row["paydate"];
      $time = $row["paytime"];
      }
    }
//  else {
//       header('location:failure.php');
//     }
}
// else{
//           header('location:failure.php');
//     }

// qr code=====================================
include 'phpqrcode/qrlib.php';

$PNG_TEMP_DIR = 'temp/';
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);
$filename = $PNG_TEMP_DIR . 'test.pmg';

//$codeString = $name."\n";
//$codeString .= $age."\n";
//$codeString .= $sp."\n";
$codeString .= $reg."\n";

$filename = $PNG_TEMP_DIR . 'test' .
    md5($codeString) . '.png';
QRcode::png($codeString, $filename);

// pdf s=============================================
require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);

$pdf->SetTitle('C11CLRegistration PDF');


$pdf->AddPage();

// CSS-like styling using TCPDF methods
$pdf->SetFont('helvetica', 'B', 15);
$pdf->SetFillColor(200, 220, 255);
$pdf->SetTextColor(50, 50, 50);
$pdf->SetDrawColor(128, 0, 0);
// $pdf->SetLineWidth(0.01);
  // HTML content for the PDF

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



// Write the HTML content to PDF
$pdf->writeHTML($html);

// Output the PDF to browser (inline display)
$pdf->Output('C11CL Registration.pdf','D');

?>