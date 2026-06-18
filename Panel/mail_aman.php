<?php
session_start();

// Check if the 'complete_reg' session variable is set
if (isset($_SESSION['complete_reg'])) {
    unset($_SESSION['complete_reg']);
    // Check if 'payreg' session variable is set
    if (isset($_SESSION['payreg'])) {
        include 'dashboard/db.php';
        $sql = "SELECT name, age, player, paydate, paytime, email, mobile, reg, mailsent FROM register WHERE reg = '{$_SESSION['payreg']}' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row["name"];
                $age = $row["age"];
                $sp = $row["player"];
                $date = $row["paydate"];
                $time = $row["paytime"];
                $email = $row["email"];
                $phone = $row["mobile"];
                $reg = $row["reg"];
                $mailsent = $row["mailsent"];
            }
        } else {
            header('location:failure.php');
            exit();
        }
    } elseif (isset($_SESSION['id'])) {
        include 'dashboard/db.php';
        $sql = "SELECT name, age, player, paydate, paytime, email, mobile, reg, mailsent FROM register WHERE id = '{$_SESSION['id']}' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row["name"];
                $age = $row["age"];
                $sp = $row["player"];
                $date = $row["paydate"];
                $time = $row["paytime"];
                $email = $row["email"];
                $phone = $row["mobile"];
                $reg = $row["reg"];
                $mailsent = $row["mailsent"];
            }
        } else {
            header('location:failure.php');
            exit();
        }
    } elseif ($_SESSION['remsgphase1']) {
        include 'dashboard/db.php';
        $sql = "SELECT name, age, player, paydate, paytime, email, mobile, reg, mailsent FROM register WHERE id = '{$_SESSION['remsgphase1']}' ";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row["name"];
                $age = $row["age"];
                $sp = $row["player"];
                $date = $row["paydate"];
                $time = $row["paytime"];
                $email = $row["email"];
                $phone = $row["mobile"];
                $reg = $row["reg"];
                $mailsent = $row["mailsent"];
            }
        } else {
            header('location:failure.php');
            exit();
        }
    } else    {
        header('location:failure.php');
        exit();
    }
    // Check if the Phone number is exactly 10 digits then add 91 before it for Whatsapp Api
    if (preg_match('/^\d{10}$/', $phone)) {
    // Add country code '91' before the number
    $phone = '91' . $phone;
    }
    // Send Player Registration Details To Whatsapp Api
    $datetime = date("h:i:s A");
    // Prepare the data to be sent
    $data = array(
        'name' => $name,
        'reg' => $reg,
        'phone' => $phone
    );
    
    // Initialize cURL
    $curl = curl_init();
    
    // Set the URL (Webhook Name : Trial Registration)
    curl_setopt($curl, CURLOPT_URL, "https://app.wtbotbuilder.com/webhook/whatsapp-workflow/65278.40817.59835.1709020630");
    
    // Set the request method
    curl_setopt($curl, CURLOPT_POST, true);
    
    // Set the request data
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    
    // Set the content type
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: multipart/form-data"
    ));
    
    // Return the response instead of outputting it
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    // Execute the request
    $response = curl_exec($curl);
    
    // Check for errors
    if(curl_errno($curl)){
        echo 'Curl error: ' . curl_error($curl);
    }
    
    // Close cURL
    curl_close($curl);
    
    // Process the response
    if ($response) {
        // Handle the response here
        var_dump($response);
    } else {
        // Handle the case where there is no response
        echo "No response received.";
     }
                //whatsapp api ending
                
    // QR code generation
    include 'phpqrcode/qrlib.php';
    $PNG_TEMP_DIR = 'temp/';
    if (!file_exists($PNG_TEMP_DIR)) {
        mkdir($PNG_TEMP_DIR);
    }

    $codeString = $reg . "\n";

    $filename = $PNG_TEMP_DIR . 'test' . md5($codeString) . '.png';
    QRcode::png($codeString, $filename);

    // PDF generation
    require_once('tcpdf/tcpdf.php');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->SetTitle('YSCL PDF');
    $pdf->AddPage();

    // CSS-like styling using TCPDF methods
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->SetTextColor(50, 50, 50);
    $pdf->SetDrawColor(128, 0, 0);
    $pdf->SetLineWidth(0.01);

    // HTML content for the PDF
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
    $pdfcontent = $pdf->Output('YSCL Registration.pdf', 'S');

    // Email sending
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.hostinger.com'; // Corrected SMTP host
$mail->SMTPAuth = true;
$mail->Username = 'info@youngstarscricketleague.com'; // Your Gmail username
$mail->Password = 'Trustnoone@6487'; // Your Gmail password
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('info@youngstarscricketleague.com', 'Young Stars Cricket League');
$mail->addAddress($email, $name); // Replace with recipient's email address and name

    $mail->isHTML(true);
    $mail->Subject = 'YSCLeague Trial Registration Successful';
    $mail->Body = 'Hi '.$name.',<br><br>Congratulations! Your YSCL Trial registration is successful. Your registration ID is '. $reg .'.<br>    You can check your trial details on your profile page. If the details are not visible yet, Please wait as they will be updated soon.<br><a href="https://youngstarscricketleague.com/profile/login.php?reg='.$reg.' "class="btn btn-outline-primary" target="_blank"><i class="bx bx-log-in-circle me-0"></i>Click Here to Go to Your Profile</a><br>Make sure to mark your calendar and prepare yourself for the upcoming trial. We wish you the best of luck!
<br><br>
Warm regards,<br> Young Stars Cricket League';
    $mail->addStringAttachment($pdfcontent, 'YSCL Registration.pdf', 'base64', 'application/pdf');
    $mail->addReplyTo('noreply@youngstarscricketleague.com', 'No Reply');

    if ($mail->send()) {
        $mailsent++;
        $sql1 = "UPDATE register SET mailsent = $mailsent WHERE reg = '$reg' ";
        $con->query($sql1);
        if (isset($_SESSION['id'])) {
            unset($_SESSION['id']);
            header('location:dashboard/trials.php');
            exit();
        } elseif ($_SESSION['remsgphase1']) {
            $_SESSION['update'] = $_SESSION['update'];
                header("Location: dashboard/trials-players-data.php?id={$_SESSION['remsgphase1']}");
                exit();
            
        } elseif (isset($_SESSION['payreg'])) {
           // $_SESSION['mail_send'] = $_SESSION['complete_reg'];
            header('location:success.php');
            exit();
        
        }
    } else {
        echo 'Error: ' . $mail->ErrorInfo;
    }
} else {
    header('location:failure.php');
    exit();
}
?>