<?php
$data = http_build_query([
    'submit' => '1',
    'name' => 'Test Player',
    'age' => '18',
    'phone' => '9876543210',
    'email' => 'test@c11cl.com',
    'speciality' => 'Batsman',
    'state' => 'Delhi',
    'city' => 'New Delhi',
    'ref' => '',
    'source' => 'Website'
]);
$ctx = stream_context_create(['http' => [
    'method'  => 'POST',
    'header'  => 'Content-Type: application/x-www-form-urlencoded',
    'content' => $data,
    'ignore_errors' => true
]]);
$result = file_get_contents('http://localhost:8000/submit.php', false, $ctx);
if (strpos($result, 'Registration Secured') !== false) {
    echo "SUCCESS: Registration form worked!\n";
} elseif (strpos($result, 'Fatal') !== false || strpos($result, 'Error') !== false) {
    preg_match('/((?:Fatal|Parse) error[^<]+)/i', $result, $m);
    echo "ERROR: " . ($m[1] ?? strip_tags($result)) . "\n";
} else {
    echo "RESPONSE (first 300 chars): " . substr(strip_tags($result), 0, 300) . "\n";
}
