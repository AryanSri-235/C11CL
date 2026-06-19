<?php
$url = "https://c11cl.com/cricket-was-a-dream-expensive-to-chase/";
$html = file_get_contents($url);
if ($html !== false) {
    $pos = strpos($html, '<div class="entry-content">');
    if ($pos !== false) {
        // Let's count open/close divs to find the matching closing div
        $content_start = $pos + strlen('<div class="entry-content">');
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
        echo "Found content of length: " . strlen($content) . "\n";
        echo "End of content:\n" . substr($content, -300) . "\n";
    }
}
?>
