<?php
error_reporting(0);
include 'db.php'; 
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg = $_POST['reg'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (!$con) {
        echo json_encode(['status' => 'not_found']);
        exit;
    }

    // Check Reg ID and Phone securely using prepared statements
    $query = "SELECT * FROM register WHERE reg = ? AND mobile = ? LIMIT 1";
    $stmt = $con->prepare($query);
    if ($stmt) {
        $stmt->bind_param('ss', $reg, $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            $stmt->close();
            echo json_encode(['status' => 'not_found']);
            exit;
        }

        $data = $result->fetch_assoc();
        $stmt->close();

        // Status Check
        if (strtolower($data['status'] ?? '') !== 'success') {
            echo json_encode(['status' => 'pending']);
            exit;
        }

        // Success
        echo json_encode($data);
    } else {
        echo json_encode(['status' => 'not_found', 'error' => 'SQL Preparation error.']);
    }
}
?>