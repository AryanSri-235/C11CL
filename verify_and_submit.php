<?php
error_reporting(0);
include 'db.php'; // Ensure $con variable is here
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg = $con ? $con->real_escape_string($_POST['reg']) : addslashes($_POST['reg']);
    $phone = $con ? $con->real_escape_string($_POST['phone']) : addslashes($_POST['phone']);

    if (!$con) {
        echo json_encode(['status' => 'not_found']);
        exit;
    }

    // Check Reg ID and Phone together to prevent data mismatch
    $query = "SELECT * FROM register WHERE reg = '$reg' AND mobile = '$phone' LIMIT 1";
    $result = $con->query($query);

    if (!$result || $result->num_rows === 0) {
        // Registration ID or Phone mismatch
        echo json_encode(['status' => 'not_found']);
        exit;
    }

    $data = $result->fetch_assoc();

    // Status Check
    if (strtolower($data['status']) !== 'success') {
        echo json_encode(['status' => 'pending']);
        exit;
    }

    // Success - All Good
    echo json_encode($data);
}
?>