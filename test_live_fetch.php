<?php
// Test fetching a live blog page from c11cl.com to check structure and connectivity
$url = "https://c11cl.com/cricket-was-a-dream-expensive-to-chase/";
$html = file_get_contents($url);
if ($html === false) {
    echo "Failed to fetch live page.\n";
} else {
    echo "Fetched successfully! Length: " . strlen($html) . "\n";
    // Let's see if we can find entry-content
    if (preg_match('/<div[^>]*class=["\']entry-content[^>]*>(.*?)<\/div>\s*<!--\s*\.entry-content.*?-->/si', $html, $m)) {
        echo "Found entry-content! Length: " . strlen($m[1]) . "\n";
        echo "Snippet: " . substr(strip_tags($m[1]), 0, 200) . "...\n";
    } else {
        echo "Regex failed to find entry-content on live page.\n";
    }
}
?>
