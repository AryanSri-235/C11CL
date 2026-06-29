<?php
ini_set('display_errors', 0);
error_reporting(0);

session_start();
if (!isset($_SESSION['password']) || !isset($_SESSION['uname'])) {
    http_response_code(403);
    exit("Unauthorized access.");
}

include 'db.php';
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publish_post'])) {

    $created_by = $_SESSION['name'] ?? 'admin';
    $created_at = date('Y-m-d H:i:s');

    $title          = $_POST['title'] ?? '';
    $slug           = $_POST['slug'] ?? '';
    $excerpt        = $_POST['excerpt'] ?? '';
    $content        = $_POST['content'] ?? '';
    $category       = $_POST['category'] ?? '';
    $alt_tag        = $_POST['alt_tag'] ?? '';
    $tags           = $_POST['tags'] ?? '';
    $author         = $_POST['author_name'] ?? 'Admin';
    $meta_title     = $_POST['meta_title'] ?? '';
    $meta_desc      = $_POST['meta_desc'] ?? '';
    $focus_keyword  = $_POST['focus_keyword'] ?? '';
    $canonical_url  = $_POST['canonical_url'] ?? '';
    $robots         = $_POST['robots'] ?? 'index, follow';
    $schema_markup  = $_POST['schema_markup'] ?? '';
    $og_title       = $_POST['og_title'] ?? '';
    $og_desc        = $_POST['og_desc'] ?? '';
    $status         = $_POST['status'] ?? 'Draft';
    $publish_date   = !empty($_POST['publish_date']) ? $_POST['publish_date'] : $created_at;
    $allow_comments = isset($_POST['allow_comments']) ? 1 : 0;
    $is_featured    = isset($_POST['is_featured']) ? 1 : 0;

    function uploadBlogFile($fileKey) {
        if (!empty($_FILES[$fileKey]['name'])) {
            $folder = '../wp-content/uploads/2026/blog/';
            if (!is_dir($folder)) mkdir($folder, 0777, true);
            $ext = strtolower(pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif','webp'];
            if (!in_array($ext, $allowed)) return '';
            $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES[$fileKey]['name']));
            $path = $folder . $filename;
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $path)) {
                return ltrim($path, '../');
            }
        }
        return '';
    }

    $featured_img = uploadBlogFile('featured_img');
    $og_img       = uploadBlogFile('og_img');

    $sql = "INSERT INTO blog (
        title, slug, excerpt, content, category, alt_tag, tags, author,
        meta_title, meta_desc, focus_keyword, canonical_url, robots, schema_markup,
        og_title, og_desc, featured_img, og_img, status, publish_date,
        created_by, created_at, allow_comments, is_featured
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);

    if (!$stmt) {
        die("DB prepare failed: " . $con->error);
    }

    $stmt->bind_param("ssssssssssssssssssssssii",
        $title, $slug, $excerpt, $content, $category, $alt_tag, $tags, $author,
        $meta_title, $meta_desc, $focus_keyword, $canonical_url, $robots, $schema_markup,
        $og_title, $og_desc, $featured_img, $og_img, $status, $publish_date,
        $created_by, $created_at, $allow_comments, $is_featured
    );

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: blog_list.php?success=1");
        exit();
    } else {
        $err = $stmt->error;
        $stmt->close();
        die("DB insert failed: " . $err);
    }

} else {
    header("Location: blog_list.php");
    exit();
}
?>
