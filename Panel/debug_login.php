<?php
// TEMPORARY DEBUG - DELETE AFTER FIXING
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die('Access denied');
}

include 'db.php';

$test_username = $_GET['u'] ?? '';
$test_password = $_GET['p'] ?? '';

if (!$test_username) {
    echo "<p>Usage: <b>debug_login.php?u=USERNAME&p=PASSWORD</b></p>";
    exit;
}

echo "<style>body{font-family:monospace;padding:20px;} .pass{color:green;font-weight:bold;} .fail{color:red;font-weight:bold;} .warn{color:orange;font-weight:bold;}</style>";
echo "<h3>Login Debug</h3>";

// Check DB connection
echo "DB Connection: " . ($con ? "<span class='pass'>OK</span>" : "<span class='fail'>FAILED</span>") . "<br><br>";
if (!$con) exit;

// Fetch user
$stmt = $con->prepare("SELECT username, password, status, stoper FROM user WHERE username = ?");
$stmt->bind_param("s", $test_username);
$stmt->execute();
$result = $stmt->get_result();

echo "User found: ";
if ($result->num_rows === 0) {
    echo "<span class='fail'>NO - user does not exist in DB</span><br>";
    exit;
}
echo "<span class='pass'>YES</span><br>";

$row = $result->fetch_assoc();
$stored = $row['password'];

echo "Status: <b>" . htmlspecialchars($row['status']) . "</b><br>";
echo "Stoper: <b>" . htmlspecialchars($row['stoper'] ?? 'NULL') . "</b><br><br>";

echo "Stored password length: <b>" . strlen($stored) . " chars</b> ";
echo "(bcrypt needs 60) ";
echo strlen($stored) >= 60 ? "<span class='pass'>OK</span>" : "<span class='fail'>TOO SHORT — column truncated the hash!</span>";
echo "<br>";

echo "Is bcrypt hash (\$2y\$): ";
$is_bcrypt = str_starts_with($stored, '$2y$');
echo $is_bcrypt ? "<span class='pass'>YES</span>" : "<span class='fail'>NO — stored as plain text</span>";
echo "<br><br>";

if ($test_password) {
    echo "password_verify result: ";
    $verify = password_verify($test_password, $stored);
    echo $verify ? "<span class='pass'>PASS ✓</span>" : "<span class='fail'>FAIL ✗</span>";
    echo "<br>";

    echo "Plain text match: ";
    $plain = ($stored === $test_password);
    echo $plain ? "<span class='pass'>PASS ✓</span>" : "<span class='fail'>FAIL ✗</span>";
    echo "<br><br>";

    if (!$is_bcrypt && !$plain) {
        echo "<span class='warn'>→ Password is neither a valid bcrypt hash nor matches plain text.</span><br>";
        echo "<span class='warn'>→ Fix: ALTER TABLE user MODIFY password VARCHAR(255);</span><br>";
        echo "<span class='warn'>  Then re-create the user from add-user.php</span><br>";
    }
    if ($is_bcrypt && strlen($stored) < 60) {
        echo "<span class='fail'>→ Hash is truncated! Run: ALTER TABLE user MODIFY password VARCHAR(255) in phpMyAdmin</span><br>";
    }
} else {
    echo "<span class='warn'>Add ?p=YOURPASSWORD to also test password_verify</span><br>";
}
?>
