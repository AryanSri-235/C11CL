<?php
if (isset($_POST['submit'])) {
    include "db.php";
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    include 'db.php';
    date_default_timezone_set("Asia/Kolkata");
    $datetime = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO contactus (name, phone, email, message, datetime) 
                VALUES (?, ?, ?, ?, '$datetime')";

        // Prepare the SQL statement
        $stmt = $con->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssss", $name, $phone, $email, $message);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Close statement
            $stmt->close();
            $con->close();
            header('location: https://boardofsportsinindia.com/contact/?success=true');
        exit();
        }
        
    else {
            $stmt->close();
            $con->close();
    header('location: https://boardofsportsinindia.com/contact/?error=true');
        exit();
}


    
    
}

?>