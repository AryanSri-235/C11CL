<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
session_start();
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

function jsonOut($status, $message) {
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonOut('error', 'Invalid request.');
}

$name     = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$position = trim($_POST['position'] ?? '');

if (!$name || !$email || !$phone || !$position) {
    jsonOut('error', 'All fields are required.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonOut('error', 'Please enter a valid email address.');
}
if (!preg_match('/^\d{10}$/', $phone)) {
    jsonOut('error', 'Please enter a valid 10-digit phone number.');
}

// Handle CV upload
$cvPath = null;
if (!empty($_FILES['cv']['name'])) {
    $ext = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
    if ($ext !== 'pdf') {
        jsonOut('error', 'Only PDF files are accepted for the CV.');
    }
    if ($_FILES['cv']['size'] > 5 * 1024 * 1024) {
        jsonOut('error', 'CV file must be under 5MB.');
    }
    $uploadDir = __DIR__ . '/Panel/uploads/cvs/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $safeFilename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['cv']['name']));
    $dest = $uploadDir . $safeFilename;
    if (!move_uploaded_file($_FILES['cv']['tmp_name'], $dest)) {
        jsonOut('error', 'CV upload failed. Please try again.');
    }
    $cvPath = 'Panel/uploads/cvs/' . $safeFilename;
}

// Save to DB
include __DIR__ . '/db.php';

$now = date('Y-m-d H:i:s');
$stmt = $con->prepare(
    "INSERT INTO careers_applications (fullname, email, phone, position, cv_path, submitted_at)
     VALUES (?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    jsonOut('error', 'DB prepare failed: ' . $con->error);
}

$stmt->bind_param('ssssss', $name, $email, $phone, $position, $cvPath, $now);

if (!$stmt->execute()) {
    jsonOut('error', 'DB insert failed: ' . $stmt->error);
}

$stmt->close();
$con->close();
jsonOut('success', 'Application submitted successfully!');
?>
