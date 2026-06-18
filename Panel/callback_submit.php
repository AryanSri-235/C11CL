<?php
if (isset($_POST['submit'])) {
    include "db.php"; // DB connection

    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO callback_requests (name, phone) VALUES ('$name', '$phone')";

    if ($conn->query($sql) === TRUE) {
        header("Location: https://c11cl.com/status=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
