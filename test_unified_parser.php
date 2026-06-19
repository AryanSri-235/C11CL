<?php
// Test unified parser on a few local blogs and dynamic ones

function extract_entry_content($html) {
    $pos = -1;
    $start_tag_len = 0;
    
    if (preg_match('/<div[^>]*class=["\']entry-content[^>]*>/i', $html, $matches, PREG_OFFSET_CAPTURE)) {
        $pos = $matches[0][1];
        $start_tag_len = strlen($matches[0][0]);
    }
    
    if ($pos === -1) {
        return '';
    }
    
    $content_start = $pos + $start_tag_len;
    $depth = 1;
    $curr = $content_start;
    $len = strlen($html);
    
    while ($depth > 0 && $curr < $len) {
        $next_open = strpos($html, '<div', $curr);
        $next_close = strpos($html, '</div', $curr);
        
        if ($next_close === false) {
            break;
        }
        
        if ($next_open !== false && $next_open < $next_close) {
            $depth++;
            $curr = $next_open + 4;
        } else {
            $depth--;
            $curr = $next_close + 5;
        }
    }
    
    $content = substr($html, $content_start, $curr - 6 - $content_start);
    return trim($content);
}

$base_dir = "C:/Users/aryan/Downloads/Public/Public";
$test_slugs = [
    'behind-every-cricketer-is-a-parent-who-believed-first', // Static local
    'cricket-was-a-dream-expensive-to-chase',               // Dynamic local
    'unified-pathway-for-young-cricketers-india'             // Dynamic local
];

foreach ($test_slugs as $slug) {
    echo "========================================\n";
    echo "Slug: $slug\n";
    $file = $base_dir . '/' . $slug . '/index.php';
    if (!file_exists($file)) {
        echo "Local file not found.\n";
        continue;
    }
    
    $html = file_get_contents($file);
    $content = extract_entry_content($html);
    
    echo "Local parsed content length: " . strlen($content) . "\n";
    
    // Check if it's dynamic
    $is_dynamic = false;
    if (strpos($content, '<?php') !== false || strpos($content, '$blog[') !== false || strlen($content) < 100) {
        $is_dynamic = true;
    }
    
    echo "Is Dynamic: " . ($is_dynamic ? "Yes" : "No") . "\n";
    
    if ($is_dynamic) {
        echo "Fetching from live site...\n";
        $url = "https://c11cl.com/" . $slug . "/";
        $live_html = @file_get_contents($url);
        if ($live_html !== false) {
            $live_content = extract_entry_content($live_html);
            echo "Live content fetched! Length: " . strlen($live_content) . "\n";
            echo "Snippet: " . substr(strip_tags($live_content), 0, 100) . "...\n";
        } else {
            echo "Failed to fetch from live site.\n";
        }
    } else {
        echo "Snippet: " . substr(strip_tags($content), 0, 100) . "...\n";
    }
}
?>
