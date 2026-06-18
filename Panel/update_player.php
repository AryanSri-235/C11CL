<?php
session_start();
// Security check
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input data
    $id = $_POST['id'] ?? '';
    $name = $con->real_escape_string($_POST['name'] ?? '');
    $age = $con->real_escape_string($_POST['age'] ?? '');
    $player = $con->real_escape_string($_POST['player'] ?? '');
    $email = $con->real_escape_string($_POST['email'] ?? '');
    $mobile = $con->real_escape_string($_POST['mobile'] ?? '');
    $state = $con->real_escape_string($_POST['state'] ?? '');
    
    // ✨ CITY फ़ील्ड को यहाँ प्राप्त करें ✨
    $city = $con->real_escape_string($_POST['city'] ?? '');
    
    $ref = $con->real_escape_string($_POST['ref'] ?? '');

    // Check if ID is provided
    if (empty($id)) {
        die("Error: Player ID is missing.");
    }

    // Build the SQL update query
    $sql = "UPDATE register SET 
            name = '$name',
            age = '$age',
            player = '$player',
            email = '$email',
            mobile = '$mobile',
            state = '$state',
            city = '$city',   
            ref = '$ref'
            WHERE id = '$id'";

    // Execute the query
    if ($con->query($sql) === TRUE) {
        // Redirect back to the main page with a success message
        header('location: phase1data.php?status=success');
        exit();
    } else {
        // Redirect back with an error message
        header('location: phase1data.php?status=error');
        exit();
    }
    
    $con->close();
} else {
    // If not a POST request, redirect back
    header('location: phase1data.php');
    exit();
}
?>