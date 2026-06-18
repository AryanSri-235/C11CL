<?php
if (isset($_POST['submit'])) {
    include "db.php"; // Your DB connection file
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    $sql = "INSERT INTO regdata (name, email, phone, state, city)
            VALUES ('$name', '$email', '$phone', '$state', '$city')";

    if ($con->query($sql) === TRUE) {
        header("Location: ../register-now?status=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
    $con->close();
}
?>
