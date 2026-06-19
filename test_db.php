<?php
include 'db.php';
if (!$con) {
    die("Connection failed\n");
}
echo "Connection successful!\n";

$res = $con->query("SHOW TABLES");
if ($res) {
    echo "Tables in database:\n";
    while ($row = $res->fetch_assoc()) {
        echo "- " . reset($row) . "\n";
    }
} else {
    echo "Failed to list tables: " . $con->error . "\n";
}

$res = $con->query("SELECT COUNT(*) as count FROM blog");
if ($res) {
    $row = $res->fetch_assoc();
    echo "Number of blogs: " . $row['count'] . "\n";
    
    $res2 = $con->query("SELECT * FROM blog");
    while ($row2 = $res2->fetch_assoc()) {
        print_r($row2);
    }
} else {
    echo "Failed to query blog table: " . $con->error . "\n";
}
?>
