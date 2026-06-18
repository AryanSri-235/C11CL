<?php
session_start();

if(isset($_SESSION['payreg'])){
     //unset($_SESSION['payreg']);
    }
    
// Include the mpdf library

use Mpdf\Mpdf;

if(isset($_GET["pdf"])){
      include 'dashboard/db.php';
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

$pdf->SetTitle('YSCL PDF');

$pdf->AddPage();

// CSS-like styling using TCPDF methods
$pdf->SetFont('helvetica', 'B', 15);
$pdf->SetFillColor(200, 220, 255);
$pdf->SetTextColor(50, 50, 50);
$pdf->SetDrawColor(128, 0, 0);
// $pdf->SetLineWidth(0.01);
$html = '
  <div style="color: white; padding: 8px; text-align: center;">
           <img src="/dashboard/assets/images/mail.jpg" alt="">
        </div>
        <div style="padding-top:400px;">
            <table style="font-size:17px;">
             <tr>
             <td></td>
                    <td rowspan="6" style="text-align:right;"> <img src="' . $PNG_TEMP_DIR . basename($filename) . '" style="width:150px;"></td>
                </tr>
                <tr>
                    <td>To,</td>
                </tr>
                <tr>
                    <td><span style="text-transform: capitalize;">'.$name.'</span></td>
                </tr>
                
                <tr>
                    <td>'.$age.' Years  | '.$sp.'</td>
                </tr>
                <tr>
                    <td>'.$date.'</td>
                </tr>
                <tr>
                    <td><span style="text-transform: uppercase;">' . $time . '</span></td>
                </tr>
                
            </table>
            <p style="color: #122955; font-weight: 600; font-size: 12px;  text-align:center;">Congratulations! You are Registered for the Young Stars Cricket League </p>
            <p style=" text-align:center;">Your YSCLeague Trial Registration Number</p>
            <p style="color: #122955; font-weight: 700; font-size: 25px; text-transform: uppercase;  text-align:center;"> ' . $reg . '</p>
            <p style="color: #122955; font-weight: 600; text-align:center;">Cheers!!</p>
            <p style="font-size: 12px; text-align:center;">Keep an eye out for your trial details – they will be coming your way soon! When you get them, just click on the link below to see where and when you will be playing. Get ready for some fun!</p>
            <a style="font-size: 12px; text-align:center;" href="https://youngstarscricketleague.com/profile/login.php">www.youngstarscricketleague.com/profile</a>
        </div>
';

// Write the HTML content to PDF
$pdf->writeHTML($html);

// Output the PDF to browser (inline display)
$pdf->Output('YSCL Registration.pdf','D');

?>