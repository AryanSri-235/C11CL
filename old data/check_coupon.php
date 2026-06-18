<?php
include "db.php";  // DB connection

$coupon = mysqli_real_escape_string($con, $_POST['coupon']);

$query = "SELECT * FROM coupon_name WHERE coupon_code = '$coupon' AND status='active'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    
    $row = mysqli_fetch_assoc($result);

    echo json_encode([
        "status" => "valid",
        "discount" => $row['discount_percent']
    ]);

} else {
    echo json_encode([
        "status" => "invalid"
    ]);
}
?>
