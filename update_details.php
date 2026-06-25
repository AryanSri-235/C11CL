<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_id = $_POST['reg_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $state = $_POST['state'] ?? '';

    if ($con) {
        $stmt = $con->prepare("UPDATE register SET name = ?, mobile = ?, email = ?, state = ? WHERE reg = ?");
        if ($stmt) {
            $stmt->bind_param('sssss', $name, $phone, $email, $state, $reg_id);
            $stmt->execute();
            $stmt->close();
        }
    }
    header("Location: payments?status=details&reg_id=" . urlencode($reg_id));
    exit;
}
?>
