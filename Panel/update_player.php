<?php
$is_backend_script = true;
include 'head.php';

include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $player = $_POST['player'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $state = $_POST['state'] ?? '';
    $city = $_POST['city'] ?? '';
    $ref = $_POST['ref'] ?? '';

    // Check if ID is provided
    if (empty($id)) {
        die("Error: Player ID is missing.");
    }

    // Build the SQL update query securely
    $sql = "UPDATE register SET 
            name = ?,
            age = ?,
            player = ?,
            email = ?,
            mobile = ?,
            state = ?,
            city = ?,   
            ref = ?
            WHERE id = ?";

    $stmt = $con->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('ssssssssi', $name, $age, $player, $email, $mobile, $state, $city, $ref, $id);
        if ($stmt->execute()) {
            $stmt->close();
            $con->close();
            header('location: phase1data.php?status=success');
            exit();
        } else {
            $stmt->close();
            $con->close();
            header('location: phase1data.php?status=error');
            exit();
        }
    } else {
        $con->close();
        header('location: phase1data.php?status=error');
        exit();
    }
} else {
    header('location: phase1data.php');
    exit();
}
?>