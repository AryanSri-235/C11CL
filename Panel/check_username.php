<?php
session_start();
if (!isset($_SESSION['uname'])) {
    http_response_code(403);
    exit('forbidden');
}

include 'db.php';

$username = trim($_POST['username'] ?? '');
if ($username === '') {
    echo 'empty';
    exit;
}

$stmt = $con->prepare("SELECT id FROM user WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
echo ($result->num_rows > 0) ? 'exists' : 'available';
$stmt->close();
