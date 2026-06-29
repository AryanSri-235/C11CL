<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Security ke liye data clean karein
    $name = $con->real_escape_string($_POST['name']);
    $email = $con->real_escape_string($_POST['email']);
    $phone = trim($_POST['phone'] ?? '');
    $subject = $con->real_escape_string($_POST['subject']);
    $message = $con->real_escape_string($_POST['message']);

    // Validate mobile number
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo json_encode(["status" => "error", "message" => "Mobile number must be exactly 10 digits."]);
        exit();
    }
    $phone = $con->real_escape_string($phone);

    $now = date('Y-m-d H:i:s');
    $sql = "INSERT INTO contact_queries (name, email, phone, subject, message, created_at)
            VALUES ('$name', '$email', '$phone', '$subject', '$message', '$now')";

    if ($con->query($sql) === TRUE) {
       echo json_encode([
    "status" => "success", 
    "message" => "Message received! We will get back to you shortly."
]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $con->error]);
    }
    
    $con->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>