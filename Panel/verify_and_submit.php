<?php
include "db.php"; // DB connection

if (isset($_POST['submit'])) {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $reg = $_POST['reg'] ?? '';

    // First verify phone and reg_id securely
    $checkSql = "SELECT * FROM register WHERE phone = ? AND reg = ?";
    $stmt = $con->prepare($checkSql);
    if ($stmt) {
        $stmt->bind_param('ss', $phone, $reg);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $stmt->close();
            // Validated - Now insert into verified_submissions table securely
            $insertSql = "INSERT INTO verified_submissions (name, phone, reg) VALUES (?, ?, ?)";
            $insertStmt = $con->prepare($insertSql);
            if ($insertStmt) {
                $insertStmt->bind_param('sss', $name, $phone, $reg);
                if ($insertStmt->execute()) {
                    $insertStmt->close();
                    $con->close();
                    header("Location: ../payments?status=success");
                    exit();
                } else {
                    echo "Insert Error: " . $insertStmt->error;
                    $insertStmt->close();
                }
            } else {
                echo "SQL Preparation Error on insert.";
            }
        } else {
            if ($stmt) {
                $stmt->close();
            }
            $con->close();
            header("Location: ../payments?status=invalid");
            exit();
        }
    } else {
        echo "SQL Preparation Error on check.";
    }

    $con->close();
}
?>
