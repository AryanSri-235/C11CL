<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_id = $con ? $con->real_escape_string($_POST['reg_id']) : addslashes($_POST['reg_id']);
    $name = $con ? $con->real_escape_string($_POST['name']) : addslashes($_POST['name']);
    $phone = $con ? $con->real_escape_string($_POST['phone']) : addslashes($_POST['phone']);
    $email = $con ? $con->real_escape_string($_POST['email']) : addslashes($_POST['email']);
    $state = $con ? $con->real_escape_string($_POST['state']) : addslashes($_POST['state']);

    if ($con) {
        $con->query("UPDATE register SET name='$name', mobile='$phone', email='$email', state='$state' WHERE reg='$reg_id'");
    }
    header("Location: payments?status=details&reg_id=" . urlencode($reg_id));
    exit;
}
?>
