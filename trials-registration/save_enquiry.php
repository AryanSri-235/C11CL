<?php
// save_enquiry.php
include "../db.php"; // Check karein ki path sahi hai

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Security ke liye real_escape_string use karein
    $name = $con ? $con->real_escape_string($_POST['name']) : addslashes($_POST['name']);
    $email = $con ? $con->real_escape_string($_POST['email']) : addslashes($_POST['email']);
    $phone = $con ? $con->real_escape_string($_POST['phone']) : addslashes($_POST['phone']);
    $state = $con ? $con->real_escape_string($_POST['state']) : addslashes($_POST['state']);
    $city = isset($_POST['city']) ? ($con ? $con->real_escape_string($_POST['city']) : addslashes($_POST['city'])) : "";

    if (!$con) {
        echo "Error: Database connection is not available.";
        exit;
    }

    $query = "INSERT INTO regdata (name, email, phone, state, city) VALUES ('$name', '$email', '$phone', '$state', '$city')";
    
    if($con->query($query)) {
        echo "Success"; // Yeh AJAX ko response jayega
    } else {
        echo "Error: " . db_error();
    }
    exit; // Bahut zaroori hai taaki aur koi HTML output na jaye
}
?>