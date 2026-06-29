<?php
session_start();

$isAjax = !empty($_POST['ajax']);

function jsonResponse($status, $message) {
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['reg'])) {
    include "db.php";

    $reg = trim(strtoupper($_POST['reg']));

    // Fetch Phase 1 record — must exist AND be shortlisted (status = 'Success')
    $sqlFetch = "SELECT name, age, mobile, email, player, state, city, ref, status
                 FROM register
                 WHERE reg = ? LIMIT 1";
    $stmtFetch = $con->prepare($sqlFetch);
    if (!$stmtFetch) {
        if ($isAjax) jsonResponse('error', 'Database error. Please try again.');
        header('Location: /careers/?error=db'); exit();
    }
    $stmtFetch->bind_param('s', $reg);
    $stmtFetch->execute();
    $resFetch = $stmtFetch->get_result();

    if (!$resFetch || $resFetch->num_rows === 0) {
        $stmtFetch->close(); $con->close();
        if ($isAjax) jsonResponse('error', 'Registration ID not found. Please check and try again.');
        header('Location: /careers/?error=notfound'); exit();
    }

    $row = $resFetch->fetch_assoc();
    $stmtFetch->close();

    // Only shortlisted Phase 1 candidates (status = 'Success') can proceed to Phase 2
    if ($row['status'] !== 'Success') {
        $con->close();
        if ($isAjax) jsonResponse('error', 'You are not shortlisted for Phase 2. Only shortlisted Phase 1 candidates can register.');
        header('Location: /careers/?error=notshortlisted'); exit();
    }

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
    if (strpos($ref, '@') !== false) {
        $ref = '';
    }

    // Check if Phase 2 record already exists (Pending → resume payment)
    $sqlCheck = "SELECT reg2, status FROM `register-second`
                 WHERE mobile = ? AND email = ?
                 ORDER BY id DESC LIMIT 1";
    $stmtCheck = $con->prepare($sqlCheck);
    if (!$stmtCheck) {
        $con->close();
        if ($isAjax) jsonResponse('error', 'Database error. Please try again.');
        header('Location: /careers/?error=db'); exit();
    }
    $stmtCheck->bind_param('ss', $mobile, $email);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck && $resultCheck->num_rows > 0) {
        $rowCheck = $resultCheck->fetch_assoc();
        if ($rowCheck['status'] === 'Pending') {
            $_SESSION['payreg2'] = $rowCheck['reg2'];
            $stmtCheck->close(); $con->close();
            if ($isAjax) jsonResponse('success', 'Application submitted successfully! Our team will reach out to you shortly.');
            header('Location: /payment2/pay.php'); exit();
        } elseif ($rowCheck['status'] === 'Success') {
            $stmtCheck->close(); $con->close();
            if ($isAjax) jsonResponse('error', 'You have already completed Phase 2 registration.');
            header('Location: /careers/?error=alreadypaid'); exit();
        }
    }
    $stmtCheck->close();

    // Generate new reg2
    date_default_timezone_set("Asia/Kolkata");
    $sqlLast = "SELECT reg2 FROM `register-second` ORDER BY id DESC LIMIT 1";
    $resultLast = $con->query($sqlLast);
    if ($resultLast && $resultLast->num_rows > 0) {
        $rowLast = $resultLast->fetch_assoc();
        $count = (int)substr($rowLast['reg2'], -5) + 1;
    } else {
        $count = 1;
    }
    $reg2 = "C11CL2" . date("dmy") . sprintf('%05d', $count);

    $created_at = date('Y-m-d H:i:s');

    $sqlInsert = "INSERT INTO `register-second`
    (name, reg, reg2, age, mobile, email, player, state, city, ref, paydate, paytime, created_at, mailsent, up, wasent, regCount, status)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, NULL, ?, 0, 0, 0, 1, 'Pending')";

    $stmtInsert = $con->prepare($sqlInsert);
    if (!$stmtInsert) {
        $con->close();
        if ($isAjax) jsonResponse('error', 'Database error. Please try again.');
        header('Location: /careers/?error=db'); exit();
    }

    $stmtInsert->bind_param('ssssssssssss',
        $name, $reg, $reg2, $age, $mobile, $email, $player, $state, $city, $ref,
        $created_at, $created_at
    );

    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        $con->close();
        $_SESSION['payreg2'] = $reg2;
        if ($isAjax) jsonResponse('success', 'Application submitted successfully! Our team will reach out to you shortly.');
        header('Location: /payment2/pay.php'); exit();
    } else {
        $stmtInsert->close();
        $con->close();
        if ($isAjax) jsonResponse('error', 'Could not submit application. Please try again.');
        header('Location: /careers/?error=db'); exit();
    }
} else {
    if ($isAjax) jsonResponse('error', 'Invalid request.');
    header('Location: /careers/'); exit();
}
?>
