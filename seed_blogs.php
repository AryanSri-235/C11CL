<?php
// ============================================================
//  C11CL BLOG SEEDER / MIGRATION SCRIPT
// ============================================================
include_once 'db.php';

if (!$con) {
    die("Database connection failed. Ensure credentials are correct.\n");
}

echo "Database connection successful!\n";


function extract_entry_content($html) {
    $pos = strpos($html, 'class="entry-content');
    if ($pos === false) {
        return '';
    }
    
    $div_start = strrpos(substr($html, 0, $pos), '<div');
    if ($div_start === false) {
        return '';
    }
    
    $bracket_end = strpos($html, '>', $pos);
    if ($bracket_end === false) {
        return '';
    }
    
    $content_start = $bracket_end + 1;
    $depth = 1;
    $curr = $content_start;
    $len = strlen($html);
    $matching_close = false;
    
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
            if ($depth === 0) {
                $matching_close = $next_close;
            }
            $curr = $next_close + 5;
        }
    }
    
    if ($matching_close !== false) {
        return trim(substr($html, $content_start, $matching_close - $content_start));
    }
    return '';
}

function parse_blog_html($html, $base_dir, $slug) {
    // 1. Title
    $title = '';
    if (preg_match('/<title>(.*?)<\/title>/si', $html, $m)) {
        $title = html_entity_decode(trim($m[1]));
    }
    $title = preg_replace('/\s*-\s*C11CL\s*$/i', '', $title);

    // 2. Excerpt
    $excerpt = '';
    if (preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/si', $html, $m)) {
        $excerpt = html_entity_decode(trim($m[1]));
    } elseif (preg_match('/<meta\s+property=["\']og:description["\']\s+content=["\'](.*?)["\']/si', $html, $m)) {
        $excerpt = html_entity_decode(trim($m[1]));
    }

    // 3. Featured Image
    $featured_img = '';
    if (preg_match('/<meta\s+property=["\']og:image["\']\s+content=["\'](.*?)["\']/si', $html, $m)) {
        $featured_img = trim($m[1]);
    }
    $featured_img = preg_replace('/^(https?:\/\/[^\/]+\/|\.\.\/)+/', '', $featured_img);
    if (preg_match('/\.jpe?g$/i', $featured_img)) {
        $jpg_path = preg_replace('/\.jpe?g$/i', '.jpg', $featured_img);
        $jpeg_path = preg_replace('/\.jpe?g$/i', '.jpeg', $featured_img);
        
        if (file_exists($base_dir . '/' . $jpg_path)) {
            $featured_img = $jpg_path;
        } elseif (file_exists($base_dir . '/' . $jpeg_path)) {
            $featured_img = $jpeg_path;
        } else {
            $featured_img = $jpg_path;
        }
    }

    // 4. Category
    $category = 'C11CL News';
    if (preg_match('/<meta\s+property=["\']article:section["\']\s+content=["\'](.*?)["\']/si', $html, $m)) {
        $category = trim($m[1]);
    }

    // 5. Author
    $author = 'Admin';
    if (preg_match('/<meta\s+property=["\']article:author["\']\s+content=["\'](.*?)["\']/si', $html, $m)) {
        $author = trim($m[1]);
        if (filter_var($author, FILTER_VALIDATE_URL)) {
            $author = 'Admin';
        }
    }

    // 6. Publish Date
    $publish_date = date('Y-m-d');
    if (preg_match('/<meta\s+property=["\']article:published_time["\']\s+content=["\'](.*?)["\']/si', $html, $m)) {
        $publish_date = date('Y-m-d', strtotime(trim($m[1])));
    } elseif (preg_match('/<meta\s+name=["\']dc.date.issued["\']\s+content=["\'](.*?)["\']/si', $html, $m)) {
        $publish_date = date('Y-m-d', strtotime(trim($m[1])));
    } elseif (preg_match('/<meta\s+property=["\']og:publish_date["\']\s+content=["\'](.*?)["\']/si', $html, $m)) {
        $publish_date = date('Y-m-d', strtotime(trim($m[1])));
    }

    // 7. Content
    $content = extract_entry_content($html);

    return [
        'title' => $title,
        'excerpt' => $excerpt,
        'featured_img' => $featured_img,
        'category' => $category,
        'author' => $author,
        'publish_date' => $publish_date,
        'content' => $content
    ];
}

// Base directory scan

$base_dir = dirname(__FILE__);
$dirs = scandir($base_dir);

$inserted_count = 0;
$updated_count = 0;

foreach ($dirs as $dir) {
    if ($dir === '.' || $dir === '..' || !is_dir($base_dir . '/' . $dir)) {
        continue;
    }

    $index_file = $base_dir . '/' . $dir . '/index.php';
    if (!file_exists($index_file)) {
        continue;
    }

    $html = file_get_contents($index_file);

    // Identify if this is a blog page by checking schema.org/Blog
    if (strpos($html, 'schema.org/Blog') === false) {
        continue;
    }

    echo "Processing blog: {$dir}...\n";

    $slug = $dir;

    // Detect if local file is dynamic
    $local_content = extract_entry_content($html);
    $is_dynamic = (empty($local_content) || strpos($local_content, '<?php') !== false || strpos($local_content, '$blog[') !== false);

    if ($is_dynamic) {
        // Mapping local slug to live site slug if they differ
        $slug_mapping = [
            'unified-pathway-for-young-cricketers-india' => 'from-gullies-to-glory-why-india-needs-a-unified-pathway-for-young-cricketers'
        ];
        $live_slug = isset($slug_mapping[$slug]) ? $slug_mapping[$slug] : $slug;
        
        echo "Local file is dynamic/empty. Fetching metadata and content from live site (slug: {$live_slug})...\n";
        $live_url = "https://c11cl.com/{$live_slug}/";
        
        $options = [
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n",
                'timeout' => 10
            ]
        ];
        $context = stream_context_create($options);
        $live_html = @file_get_contents($live_url, false, $context);
        
        if ($live_html !== false && strpos($live_html, 'Post Not Found!') === false) {
            $parsed = parse_blog_html($live_html, $base_dir, $slug);
            echo "Successfully fetched & parsed live post for {$slug} (content length: " . strlen($parsed['content']) . ")\n";
        } else {
            echo "Warning: Failed to fetch live content for {$slug} (URL: {$live_url})\n";
            $parsed = null;
        }
    } else {
        $parsed = parse_blog_html($html, $base_dir, $slug);
        echo "Successfully parsed local file for {$slug} (content length: " . strlen($parsed['content']) . ")\n";
    }

    if (!$parsed || empty($parsed['content']) || strpos($parsed['content'], '<?php') !== false || strlen($parsed['content']) < 50) {
        echo "ERROR: Valid content could not be extracted for slug {$slug}. Skipping DB write.\n";
        continue;
    }

    $title = $parsed['title'];
    $content = $parsed['content'];
    $excerpt = $parsed['excerpt'];
    $featured_img = $parsed['featured_img'];
    $category = $parsed['category'];
    $author = $parsed['author'];
    $publish_date = $parsed['publish_date'];
    $status = 'published';

    // Save to DB
    // Check if slug already exists
    $stmt = $con->prepare("SELECT id FROM blog WHERE slug = ?");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res && $res->num_rows > 0) {
        // Update
        $row = $res->fetch_assoc();
        $id = $row['id'];
        $stmt_up = $con->prepare("UPDATE blog SET title = ?, content = ?, excerpt = ?, featured_img = ?, category = ?, author = ?, publish_date = ?, status = ? WHERE id = ?");
        $stmt_up->bind_param('ssssssssi', $title, $content, $excerpt, $featured_img, $category, $author, $publish_date, $status, $id);
        if ($stmt_up->execute()) {
            $updated_count++;
        } else {
            echo "Error updating slug {$slug}: " . $stmt_up->error . "\n";
        }
        $stmt_up->close();
    } else {
        // Insert
        $created_at = date('Y-m-d H:i:s');
        $stmt_in = $con->prepare("INSERT INTO blog (title, slug, content, excerpt, featured_img, category, author, publish_date, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_in->bind_param('ssssssssss', $title, $slug, $content, $excerpt, $featured_img, $category, $author, $publish_date, $status, $created_at);
        if ($stmt_in->execute()) {
            $inserted_count++;
        } else {
            echo "Error inserting slug {$slug}: " . $stmt_in->error . "\n";
        }
        $stmt_in->close();
    }
    $stmt->close();
}

echo "\nMigration complete!\n";
echo "Inserted: {$inserted_count}\n";
echo "Updated: {$updated_count}\n";
?>
