<?php
header('Content-Type: application/json');
include "db.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $position = $_POST['position'] ?? '';
    
    // Validate phone number (exactly 10 digits)
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo json_encode(["status" => "error", "message" => "Phone number must be exactly 10 digits."]);
        exit();
    }
    
    // Check if CV is uploaded
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
        $cv_file = $_FILES['cv']['name'];
        $temp_name = $_FILES['cv']['tmp_name'];
        
        $unique_file_name = time() . "_" . basename($cv_file);
        $target_dir = "../uploads/cv/";
        $target_file = $target_dir . $unique_file_name;

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($temp_name, $target_file)) {
            $stmt = $con->prepare("INSERT INTO job_applications (name, email, phone, position, cv_file) VALUES (?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param('sssss', $name, $email, $phone, $position, $unique_file_name);
                if ($stmt->execute()) {
                    echo json_encode([
                        "status" => "success", 
                        "message" => "Application submitted! If your CV is shortlisted, our team will contact you."
                    ]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Database Error: " . $stmt->error]);
                }
                $stmt->close();
            } else {
                echo json_encode(["status" => "error", "message" => "SQL Preparation Error."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "File upload failed."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Please upload your CV (PDF)."]);
    }

    $con->close();
}
?>