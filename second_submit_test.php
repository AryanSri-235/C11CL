<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();

echo "Step 1: Script started<br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['reg'])) {
    include "db.php";
    echo "Step 2: DB connected<br>";

    $reg = trim($_POST['reg']);
    echo "Step 3: Got reg = $reg<br>";

    // पहले phase के data fetch
    $sqlFetch = "SELECT name, age, mobile, email, player, state, city, ref 
                 FROM register 
                 WHERE reg = '$reg' LIMIT 1";
    $resFetch = $con->query($sqlFetch) or die("Query Error in sqlFetch: " . $con->error);

    if ($resFetch->num_rows === 0) {
        die("Error: पहले phase में यह registration नहीं मिला!");
    }
    echo "Step 4: Found first phase record<br>";

    $row = $resFetch->fetch_assoc();
    $name   = ucwords(strtolower($row['name']));
    $age    = $row['age'];
    $mobile = $row['mobile'];
    $email  = $row['email'];
    $player = $row['player'];
    $state  = $row['state'];
    $city   = $row['city'];
    $ref    = $row['ref'];

    // Mobile sanitize
    $mobile = str_replace('+', '', $mobile);
    if (substr($mobile, 0, 1) === '0') {
        $mobile = substr($mobile, 1);
    }
    if ((substr($mobile, 0, 2) === '91') && preg_match('/^\d{12}$/', $mobile)) {
        $mobile = substr($mobile, 2);
    }

    // अगर ref में '@' है तो empty कर दो
    if (strpos($ref, '@') !== false) {
        $ref = '';
    }

    echo "Step 5: Sanitized mobile = $mobile, email = $email<br>";

    // Check अगर second phase में पहले से entry है
    $sqlCheck = "SELECT reg2, status FROM `register-second` 
                 WHERE mobile = '$mobile' AND email = '$email' 
                 ORDER BY id DESC LIMIT 1";
    $resultCheck = $con->query($sqlCheck) or die("Query Error in sqlCheck: " . $con->error);

    if ($resultCheck->num_rows > 0) {
        $rowCheck = $resultCheck->fetch_assoc();
        echo "Step 6: Found existing second phase record<br>";
        if ($rowCheck['status'] === 'Pending') {
            $_SESSION['payreg2'] = $rowCheck['reg2'];
            echo "Redirecting to ../payment2_test/pay.php<br>";
            header('Location: ../payment2_test/pay.php');
            exit();
        }
    }

    // नया reg2 generate
    $sqlLast = "SELECT reg2 FROM `register-second` ORDER BY id DESC LIMIT 1";
    $resultLast = $con->query($sqlLast) or die("Query Error in sqlLast: " . $con->error);
    if ($resultLast->num_rows > 0) {
        $rowLast = $resultLast->fetch_assoc();
        $lastNumber = substr($rowLast['reg2'], -5);
        $count = (int)$lastNumber + 1;
    } else {
        $count = 1;
    }
    $count = sprintf('%05d', $count);
    $reg2 = "C11CL2" . date("dmy") . $count;

    echo "Step 7: Generated reg2 = $reg2<br>";

    $created_at = date('Y-m-d H:i:s');
    $mailsent = 0;
    $wasent = 0;
    $regCount = 1;

    // Insert second phase record
    $sqlInsert = "INSERT INTO `register-second` 
    (name, reg, reg2, age, mobile, email, player, state, city, ref, paydate, paytime, created_at, mailsent, up, wasent, regCount, status) 
    VALUES 
    ('$name', '$reg', '$reg2', '$age', '$mobile', '$email', '$player', '$state', '$city', '$ref', 
    NULL, NULL, '$created_at', '$mailsent', '$created_at', '$wasent', '$regCount', 'Pending')";

    if ($con->query($sqlInsert) === TRUE) {
        echo "Step 8: Insert successful, redirecting...<br>";
        $_SESSION['payreg2'] = $reg2;
        header('Location: ../payment2_test/pay.php');
        exit();
    } else {
        die("Insert Error: " . $con->error);
    }

    $con->close();
} else {
    echo "No form submission detected or reg missing!";
}
