<?php
$url = "https://c11cl.com/cricket-was-a-dream-expensive-to-chase/";
$html = file_get_contents($url);
if ($html !== false) {
    $pos = strpos($html, 'class="entry-content');
    if ($pos !== false) {
        echo "Found class=\"entry-content at position $pos\n";
        echo substr($html, $pos - 100, 500) . "\n";
        
        // Let's also search for comment after entry-content end
        $end_pos = strpos($html, 'entry-content', $pos + 20);
        if ($end_pos !== false) {
            echo "Found second occurrence at position $end_pos\n";
            echo substr($html, $end_pos - 50, 150) . "\n";
        }
    } else {
        echo "class=\"entry-content not found!\n";
    }
}
?>
