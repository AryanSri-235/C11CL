<?php
// Database connection
include 'db.php'; // यहाँ तुम्हारा mysqli $con variable होना चाहिए

if (!isset($_GET['reg_id']) || empty($_GET['reg_id'])) {
    echo json_encode(['error' => 'No registration ID provided']);
    exit;
}

$reg_id = $con ? $con->real_escape_string($_GET['reg_id']) : addslashes($_GET['reg_id']);

if (!$con) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$query = "SELECT name, mobile, email, state, reg, status 
          FROM register 
          WHERE reg = '$reg_id' LIMIT 1";

$result = $con->query($query);

if (!$result) {
    echo json_encode(['error' => 'Database query failed: ' . db_error()]);
    exit;
}

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Registration ID not found']);
    exit;
}

$data = $result->fetch_assoc();

// JSON output
echo json_encode($data);
?>
