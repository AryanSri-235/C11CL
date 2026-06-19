<?php
$url = "https://c11cl.com/unified-pathway-for-young-cricketers-india/";
$html = file_get_contents($url);
if ($html === false) {
    echo "Failed to fetch. Check if it's 404 or something.\n";
} else {
    echo "Length: " . strlen($html) . "\n";
    // Check if class="entry-content exists
    if (strpos($html, 'class="entry-content') !== false) {
        echo "Found entry-content class!\n";
    } else {
        echo "entry-content class not found!\n";
    }
}
?>
