<?php
$is_backend_script = true;
include 'head.php';

// Ensure this script is accessed via a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
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

// Prepare and execute the DELETE statement securely
$sql = "DELETE FROM register WHERE id = ? AND status != 'Success'";
$stmt = $con->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $con->error]);
    exit();
}

$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Record cannot be deleted.']);
}

$stmt->close();
$con->close();
?>