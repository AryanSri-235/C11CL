<?php
include 'db.php';
if (!$con) { die("No connection"); }
$result = $con->query("SELECT id, reg, name, mobile, email, state, status, created_at FROM `register` ORDER BY id DESC LIMIT 10");
echo "<pre>Registrations in DB:\n";
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo str_pad($row['id'],4) . " | " . str_pad($row['reg'],20) . " | " . str_pad($row['name'],20) . " | " . $row['mobile'] . " | " . $row['status'] . " | " . $row['created_at'] . "\n";
    }
} else {
    echo "No records found.\n";
}
echo "</pre>";
