<?php
$files = [
    'c:/Users/aryan/Downloads/Public/Public/index.php',
    'c:/Users/aryan/Downloads/Public/Public/new.php',
    'c:/Users/aryan/Downloads/Public/Public/layout/footer.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    echo "=== $file ===\n";
    $lines = file($file);
    foreach ($lines as $i => $line) {
        if (stripos($line, 'chaty') !== false || stripos($line, 'c11-chat-btn') !== false || stripos($line, 'chat-widget') !== false) {
            $start = max(0, $i - 5);
            $end = min(count($lines) - 1, $i + 15);
            echo "Line " . ($i + 1) . ":\n";
            for ($k = $start; $k <= $end; $k++) {
                echo "  " . ($k + 1) . ": " . $lines[$k];
            }
            echo "\n-------------------\n";
        }
    }
}
?>
