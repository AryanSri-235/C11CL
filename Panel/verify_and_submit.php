<?php
include "db.php"; // DB connection

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $reg = $_POST['reg'];

    // First verify phone and reg_id in registered_names table
    $checkSql = "SELECT * FROM register WHERE phone = '$phone' AND reg = '$reg'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        // Validated - Now insert into submissions table or any other action
        $insertSql = "INSERT INTO verified_submissions (name, phone, reg) VALUES ('$name', '$phone', '$reg')";
        if ($con->query($insertSql) === TRUE) {
            header("Location: ../payments?status=success");
            exit();
        } else {
            echo "Insert Error: " . $con->error;
        }
    } else {
        // Not matched
        header("Location: ../payments?status=invalid");
        exit();
    }

    $con->close();
}
?>
