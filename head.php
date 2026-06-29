<?php
if (!defined('BASE_URL')) {
    // InfinityFree (and many shared hosts) sit behind a proxy — fix HTTPS detection
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        $_SERVER['HTTPS'] = 'on';
    }
    // Detect protocol
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    
    // Detect host
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
    
    // Resolve relative path to root:
    // head.php is ALWAYS located in the project root folder.
    // The current script filename is $_SERVER['SCRIPT_FILENAME'].
    // Document root is $_SERVER['DOCUMENT_ROOT'].
    // We want the web path of head.php relative to the document root!
    
    $doc_root = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
    $proj_root = str_replace('\\', '/', realpath(dirname(__FILE__)));
    
    // Let's compute the difference path
    if (strpos($proj_root, $doc_root) === 0) {
        $web_path = substr($proj_root, strlen($doc_root));
        $web_path = '/' . ltrim(str_replace('\\', '/', $web_path), '/');
        $web_path = rtrim($web_path, '/') . '/';
    } else {
        // Fallback to domain root if we cannot match it
        $web_path = '/';
    }
    
    define('BASE_URL', $protocol . $host . $web_path);
}

// Include the modular header component
include dirname(__FILE__) . '/layout/header.php';

// Keep the breadcrumbs function definition
if (!function_exists('get_breadcrumbs')) {
    function get_breadcrumbs() {
        $home = 'Home';
        $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        $base_url = BASE_URL;
        $breadcrumbs = array("<a href=\"$base_url\">$home</a>");

        $tmp_path = '';
        foreach ($path as $key => $value) {
            $tmp_path .= $value . '/';
            $title = ucwords(str_replace(array('.php', '_', '-'), array('', ' ', ' '), $value));
            
            if ($key == count($path)) {
                $breadcrumbs[] = "<span>$title</span>";
            } else {
                $breadcrumbs[] = "<a href=\"{$base_url}{$tmp_path}\">$title</a>";
            }
        }

        return implode(' » ', $breadcrumbs);
    }
}
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PHSBK2RF');</script>
<!-- End Google Tag Manager -->