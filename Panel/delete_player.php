<?php
// Ensure this script is accessed via a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

// Start session and check for authentication, as in your main file
session_start();
if (!isset($_SESSION['password'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

// Include database connection
include 'db.php';

// Check if 'id' is provided and is a valid integer
$id = $_POST['id'] ?? null;
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID provided.']);
    exit();
}

// Prepare and execute the DELETE statement
$sql = "DELETE FROM register WHERE id = ? AND status != 'Success'";
$stmt = $con->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $con->error]);
    exit();
}

$stmt->bind_param("i", $id);
$stmt->execute();

// Check if the deletion was successful
if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    // This could mean the ID wasn't found or the status was 'Success'
    echo json_encode(['success' => false, 'message' => 'Record not found or cannot be deleted.']);
}

$stmt->close();
$con->close();
?>