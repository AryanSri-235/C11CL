<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<pre>";
echo "Testing PDO connection to Aiven MySQL...\n";
include 'db.php';
if ($con) {
    echo "SUCCESS: Connected!\n";
    $r = $con->query("SHOW TABLES");
    if ($r) {
        echo "Tables in database:\n";
        while ($row = $r->fetch_assoc()) {
            echo "  - " . implode(', ', $row) . "\n";
        }
    }
} else {
    echo "FAILED: Could not connect. Check the Aiven IP Allowlist.\n";
    echo "Error: " . db_error() . "\n";
}
echo "</pre>";
?>
