<?php
$is_backend_script = true;
include 'head.php';
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit();
}

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID.']);
    exit();
}

// Only superadmin, admin, developer can mark success
$allowed = ['superadmin', 'admin', 'developer'];
if (!in_array($_SESSION['status'] ?? '', $allowed)) {
    echo json_encode(['status' => 'error', 'message' => 'Permission denied.']);
    exit();
}

// Fetch the player record first
$stmt = $con->prepare("SELECT id, name, reg, email, mobile, status FROM register WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
if (!$result || $result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
    exit();
}
$row = $result->fetch_assoc();
$stmt->close();

if ($row['status'] === 'Success') {
    echo json_encode(['status' => 'already', 'message' => 'Already marked as Success.']);
    exit();
}

// Update status to Success + record current date/time as paydate/paytime
date_default_timezone_set('Asia/Kolkata');
$paydate = date('d-m-Y');
$paytime = date('h:i A');

$upd = $con->prepare(
    "UPDATE register SET status = 'Success', paydate = ?, paytime = ? WHERE id = ?"
);
$upd->bind_param('ssi', $paydate, $paytime, $id);
if (!$upd->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'DB update failed: ' . $upd->error]);
    exit();
}
$upd->close();
$con->close();

echo json_encode([
    'status'  => 'success',
    'message' => 'Player marked as Success.',
    'name'    => $row['name'],
    'reg'     => $row['reg'],
]);
exit();
?>
