<?php
include 'db.php';

if(isset($_POST['reg2'])){
    $reg2   = $con ? $con->real_escape_string($_POST['reg2']) : addslashes($_POST['reg2']);
    $tshirt = $con ? $con->real_escape_string($_POST['tshirt']) : addslashes($_POST['tshirt']);
    $lower  = $con ? $con->real_escape_string($_POST['lower']) : addslashes($_POST['lower']);
    $food   = $con ? $con->real_escape_string($_POST['food']) : addslashes($_POST['food']);

    if ($con) {
        $sql = "UPDATE `register-second` SET 
                tshirt_size = '$tshirt', 
                lower_size = '$lower', 
                food_pref = '$food' 
                WHERE reg2 = '$reg2'";

        if($con->query($sql)){
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}
?>