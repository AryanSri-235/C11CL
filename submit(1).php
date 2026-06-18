<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(isset($_POST['submit'])){

  include "db.php";

    $name = $_POST['name'];
    $age = $_POST['age'];
    $mobile = $_POST['phone'];
    $email = $_POST['email'];
    $player = $_POST['speciality'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    
    
    $ref = $_POST['ref'];
    $source = $_POST['source'];
    
    // Convert the name to lowercase first
    $name = strtolower($name);
    
    // Capitalize each word
    $name = ucwords($name);
    
    
    
    // Set the Mobile number to 10 digit number
            $mobile = str_replace('+', '', $mobile);
            // Remove '0' if it exists at the beginning of the number
            if (substr($mobile, 0, 1) === '0') {
                $mobile = substr($mobile, 1);
            }
            // Remove '91' if it exists at the beginning of the number
            if ((substr($mobile, 0, 2) === '91') && (preg_match('/^\d{12}$/', $mobile))) {
                $mobile = substr($mobile, 2);
            }
            
// Check if Player details Already Exists
    $sqlCheck = "SELECT reg, name, mobile, email, regCount, status FROM register WHERE name = '$name' AND mobile = '$mobile' AND email = '$email' ORDER BY id DESC LIMIT 1";
    $resultCheck = $con->query($sqlCheck);
    
    if ($resultCheck->num_rows > 0) {
        $rowCheck = $resultCheck->fetch_assoc();
        $status = $rowCheck['status'];
        if( $status == 'Pending') {
            // $reg = $rowCheck['reg'];
            // $_SESSION['login1'] = array('reg' => $reg, 'ph' => $mobile);
            // header ('Location: https://abcd.in/already_registered.php');
            // exit();
            
            $reg = $rowCheck['reg'];
       
        //   date and time--------------------------
    date_default_timezone_set("Asia/Kolkata");
    $date = date('Y-m-d H:i:s');
$sql = "UPDATE register SET age = '$age', player = '$player', up = '$date', state = '$state', city = '$city', ref = '$ref', source = '$source'  WHERE reg = '$reg'";
        $con->query($sql);
        $_SESSION['payreg'] = $reg;
        //echo $reg . $age . $player;
       header('Location: ../payment/pay.php');
        exit(); 
        } 
    }


// registration_no.______________________

// Retrieve the last registration number from the database
$sql = "SELECT reg FROM register ORDER BY id DESC LIMIT 1";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastRegistration = $row["reg"];
    $lastNumber = substr($lastRegistration, -4); // Get the last 4 digits
    $count = (int)$lastNumber + 1; // Convert to integer and increment
} else {
    $count = 1;
}

$count = sprintf('%05d', $count); // Format as 5 digits

// Generate the new registration number
$letters = "C11CL";
$numbers = $count;
$date = date("dmy");

$reg = "$letters$date$numbers";

// player ref_no.______________________


// Tried Registration for the 1st Time So 
$regCount = 1;
  
//   date and time--------------------------
    date_default_timezone_set("Asia/Kolkata");
    $date = date('Y-m-d H:i:s');
    
    // Check if $ref contains the character '@'
if (strpos($ref, '@') !== false) {
    // If '@' is found in $ref, set its value to empty
    $ref = '';
}
            
// Set timestamps and default values
date_default_timezone_set("Asia/Kolkata");
$created_at = date('Y-m-d H:i:s');
$paydate = NULL;
$paytime = NULL;
$mailsent = 0;
$wasent = 0;

$sql = "INSERT INTO register 
(name, reg, age, mobile, email, player, state, city, ref, paydate, paytime, created_at, mailsent, up, wasent, regCount, source, status) 
VALUES 
('$name', '$reg', '$age', '$mobile', '$email', '$player', '$state', '$city', '$ref', 
 NULL, NULL, '$created_at', '$mailsent', '$created_at', '$wasent', '$regCount', '$source', 'Pending')";

       
 if ($con->query($sql) === TRUE) {
     
     
     
        $_SESSION['payreg'] = $reg;
        header('Location: ../payment/pay.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>