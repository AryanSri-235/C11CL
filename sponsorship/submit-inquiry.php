<?php
// Enforce clean API JSON headers boundary
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Server dynamic configuration logs
error_reporting(0);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Execution Route Protocol.']);
    exit;
}

// Including your existing database connection file
include "../db.php"; 

// Safety check: Agar db.php mein connection variable $conn hai ya $con, dono ko auto-handle karega
if (!isset($con) && isset($conn)) {
    $con = $conn;
}

if (!$con) {
    echo json_encode(['status' => 'error', 'message' => 'Database link connection missing in db.php.']);
    exit;
}

// FIXED: Reading data directly from standard $_POST array
$name        = $con ? $con->real_escape_string(trim($_POST['name'] ?? '')) : addslashes(trim($_POST['name'] ?? ''));
$designation = $con ? $con->real_escape_string(trim($_POST['designation'] ?? '')) : addslashes(trim($_POST['designation'] ?? ''));
$brand_name  = $con ? $con->real_escape_string(trim($_POST['brand_name'] ?? '')) : addslashes(trim($_POST['brand_name'] ?? ''));
$phone       = $con ? $con->real_escape_string(trim($_POST['phone'] ?? '')) : addslashes(trim($_POST['phone'] ?? ''));
$email       = $con ? $con->real_escape_string(trim($_POST['email'] ?? '')) : addslashes(trim($_POST['email'] ?? ''));
$location    = $con ? $con->real_escape_string(trim($_POST['location'] ?? '')) : addslashes(trim($_POST['location'] ?? ''));
$package     = $con ? $con->real_escape_string(trim($_POST['package'] ?? '')) : addslashes(trim($_POST['package'] ?? ''));
$description = $con ? $con->real_escape_string(trim($_POST['description'] ?? '')) : addslashes(trim($_POST['description'] ?? ''));

// Absolute baseline checks mapping validation routes
if (empty($name) || empty($brand_name) || empty($phone) || empty($email) || empty($package)) {
    echo json_encode(['status' => 'error', 'message' => 'Mandatory fields missing. Check forms integrity fields.']);
    if ($con) {
        $con->close();
    }
    exit;
}

// Query mapping schema setup safely
$sql_insert_query = "INSERT INTO founding_owner_inquiries (player_name, user_designation, brand_company_name, contact_phone, contact_email, user_location, chosen_package, brand_brief) 
                     VALUES ('$name', '$designation', '$brand_name', '$phone', '$email', '$location', '$package', '$description')";

if ($con->query($sql_insert_query) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Inquiry registered. Welcome to the legacy loop.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'SQL Execution mismatch: ' . db_error()]);
}

if ($con) {
    $con->close();
}
exit;
?>