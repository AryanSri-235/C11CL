<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');

header('Content-Type: application/json; charset=utf-8');

$is_ajax = isset($_POST['ajax']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

if (!isset($_POST['submit'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
    exit;
}

include __DIR__ . '/db.php';

$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit;
}

$now = date('Y-m-d H:i:s');
$stmt = $con->prepare("INSERT INTO email_subscriptions (email, subscribed_at) VALUES (?, ?)");

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'DB error. Please try again.']);
    exit;
}

$stmt->bind_param('ss', $email, $now);
$result = $stmt->execute();
$stmt->close();

if ($result) {
    echo json_encode(['status' => 'success', 'message' => 'Thank you for subscribing! You will receive updates in your inbox.']);
} else {
    // Check for duplicate
    if ($con->error && strpos($con->error, 'Duplicate') !== false) {
        echo json_encode(['status' => 'success', 'message' => 'You are already subscribed! Thank you.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not subscribe. Please try again.']);
    }
}

$con->close();
?>
