<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../db.php';

// ✅ Timezone fix — match IST (Asia/Kolkata)
date_default_timezone_set('Asia/Kolkata');
$cutoff = date('Y-m-d H:i:s', strtotime('-3 minutes'));

// ✅ AiSensy setup
$apiUrl       = "https://backend.aisensy.com/campaign/t1/api/v2";
$apiKey       = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY4ZDE0YTNkNGM4ZDliM2Q3ZGYzYTU4YiIsIm5hbWUiOiJDaGFtcGlvbnMgMTEgQ3JpY2tldCBMZWFndWUgKEMxMUNMKSIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2OGQxNGEzYzRjOGQ5YjNkN2RmM2E1ODMiLCJhY3RpdmVQbGFuIjoiRlJFRV9GT1JFVkVSIiwiaWF0IjoxNzU4NTQ2NDkzfQ.UJHbGJShjYAY9foWtzHWaI7YPUUA7y45M5l5-PbjeNY";
$campaignName = "Meta_status_pending_Utility_with_stop"; // must exactly match AiSensy campaign name

// ✅ Fetch pending leads older than 15 minutes and not yet messaged
$sql = "
SELECT id, name, mobile, source
FROM register
WHERE UPPER(status) = 'PENDING'
  AND wasent = 0
  AND created_at <= '$cutoff'
ORDER BY id ASC";

$result = $con->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "No eligible pending leads found.\n";
    exit;
}

while ($row = $result->fetch_assoc()) {
    $id     = (int)$row['id'];
    $name   = trim($row['name']);
    $mobile = preg_replace('/\D/', '', $row['mobile']);
    $source = $row['source'] ?: 'Website';

    // 🟠 Validation
    if (empty($mobile)) {
        echo "⚠️ Skipped lead #$id (no mobile number)\n";
        continue;
    }

    // ✅ Ensure correct phone format (+91 prefix)
    if (strpos($mobile, '+91') !== 0) {
        $mobile = '+91' . $mobile;
    }

    // ✅ Prepare AiSensy payload
   $payload = [
    "apiKey"         => $apiKey,
    "campaignName"   => $campaignName,
    "destination"    => $mobile,
    "userName"       => $name,
    "source"         => $source,
    "templateParams" => [],
    "tags"           => ["Website Lead"],
    "attributes"     => [],

];


    // 🧠 Send API request
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT        => 10,
    ]);

    $response = curl_exec($ch);
    $http     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);

    // ✅ Handle API response
    if ($curlErr) {
        echo "⚠️ CURL Error for $name ($mobile): $curlErr\n";
        continue;
    }

    if ($http === 200 && stripos($response, 'success') !== false) {
        $con->query("UPDATE register SET wasent = 1, up = NOW() WHERE id = $id");
        echo "✅ Sent WhatsApp message to $name ($mobile)\n";
    } else {
        echo "❌ Failed for $name ($mobile): $response\n";
    }

    // ⏳ Small delay to avoid API throttling (0.2s)
    usleep(200000);
}

$con->close();
echo "✅ Job completed successfully.\n";
?>