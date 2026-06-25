<?php
// PHP Error reporting enabled for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>Testing DB Connection from Panel Folder</h3>";

$db_file = __DIR__ . '/db.php';
echo "Checking if Panel/db.php exists: " . (file_exists($db_file) ? "YES" : "NO") . "<br>";

$root_db_file = __DIR__ . '/../db.php';
echo "Checking if root db.php exists: " . (file_exists($root_db_file) ? "YES" : "NO") . "<br>";

$env_file = __DIR__ . '/../.env.php';
echo "Checking if root .env.php exists: " . (file_exists($env_file) ? "YES" : "NO") . "<br>";

include "db.php";

echo "Database variable \$con is: ";
var_dump($con);

if (isset($con) && $con) {
    echo "<br><span style='color:green'>✅ SUCCESS: \$con is active.</span><br>";
    
    // Test a basic query
    $res = $con->query("SHOW TABLES");
    if ($res) {
        echo "Successfully ran query. Tables found:<br>";
        while ($row = $res->fetch_assoc()) {
            echo "- " . reset($row) . "<br>";
        }
    } else {
        echo "<span style='color:red'>❌ Query failed: " . db_error() . "</span><br>";
    }
} else {
    echo "<br><span style='color:red'>❌ FAILED: \$con is null or undefined.</span><br>";
}
?>
