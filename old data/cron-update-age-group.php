<?php
include "db.php";

// Debug logging (important)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Better condition: covers NULL, '', '   '
$sql = "SELECT rs.reg, r.age 
        FROM `register-second` rs
        LEFT JOIN `register` r ON rs.reg = r.reg
        WHERE (rs.`age-group` IS NULL 
            OR rs.`age-group` = '' 
            OR TRIM(rs.`age-group`) = '')
        AND r.age IS NOT NULL";

$result = $conn->query($sql);

$updated = 0;

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $reg = $row['reg'];
        $ageGroup = trim($row['age']); // trim for safety

        // Update statement
        $update = $conn->prepare(
            "UPDATE `register-second` 
             SET `age-group` = ? 
             WHERE reg = ?"
        );

        if (!$update) {
            echo "Prepare failed: " . $conn->error;
            exit;
        }

        $update->bind_param("ss", $ageGroup, $reg);

        if ($update->execute()) {
            $updated++;
        }
    }
} else {
    echo "No rows found to update at " . date("Y-m-d H:i:s");
    exit;
}

echo "Updated age-group for $updated records at " . date("Y-m-d H:i:s");

$conn->close();
?>
