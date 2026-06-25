<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

header('Content-Type: application/json; charset=utf-8');

include "../db.php";

if (!$con) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $a_name = trim($_POST['a_name'] ?? '');
    $o_name = trim($_POST['o_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $coach = trim($_POST['coach'] ?? '');
    $players = trim($_POST['players'] ?? '');
    $years = trim($_POST['years'] ?? '');
    $reg = trim($_POST['reg'] ?? '');

    if (empty($a_name) || empty($o_name) || empty($phone) || empty($location)) {
        echo json_encode(['status' => 'error', 'message' => 'All required fields must be filled.']);
        exit;
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo json_encode(['status' => 'error', 'message' => 'Contact number must be exactly 10 digits.']);
        exit;
    }

    // Escape values
    $a_name_esc = $con->real_escape_string($a_name);
    $o_name_esc = $con->real_escape_string($o_name);
    $phone_esc = $con->real_escape_string($phone);
    $location_esc = $con->real_escape_string($location);
    $coach_esc = $con->real_escape_string($coach);
    $players_esc = $con->real_escape_string($players);
    $years_esc = $con->real_escape_string($years);
    $reg_esc = $con->real_escape_string($reg);

    $sql = "INSERT INTO academy_partners (academy_name, owner_name, phone, location, coach_name, active_players, years_operation, registration_no)
            VALUES ('$a_name_esc', '$o_name_esc', '$phone_esc', '$location_esc', '$coach_esc', '$players_esc', '$years_esc', '$reg_esc')";

    if ($con->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Your Partnership Application has been submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $con->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request Method']);
}
if ($con) {
    $con->close();
}
?>
