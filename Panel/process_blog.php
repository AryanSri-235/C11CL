<?php
session_start();
// Check if the user is authorized to perform administrative actions
if (!isset($_SESSION['password']) || !isset($_SESSION['uname'])) {
    http_response_code(403);
    exit("Unauthorized access.");
}

// 1. Forceful Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Check DB Connection
if (!$con) {
    die("❌ Connection Failed: " . db_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publish_post'])) {
    
    echo "<h1>Debugging...</h1>";
    
    // Check if POST data is actually received
    if(empty($_POST['title'])) { die("❌ Error: Title is empty. Check form submission."); }

    $created_by = $_SESSION['name'] ?? 'admin';
    $created_at = date('Y-m-d H:i:s');

    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $short_desc = $_POST['short_desc'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $alt_tag = $_POST['alt_tag'];
     $tags = $_POST['tags'];
    $author = $_POST['author_name'];
    $meta_title = $_POST['meta_title'];
    $meta_desc = $_POST['meta_desc'];
    $focus_keyword = $_POST['focus_keyword'];
    $canonical_url = $_POST['canonical_url'];
    $robots = $_POST['robots'];
    $schema_markup = $_POST['schema_markup'];
    $og_title = $_POST['og_title'];
    $og_desc = $_POST['og_desc'];
    $status = $_POST['status'];
    $publish_date = !empty($_POST['publish_date']) ? $_POST['publish_date'] : $created_at;
    $allow_comments = isset($_POST['allow_comments']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Image Upload Logic
    function uploadFile($fileKey) {
        if (!empty($_FILES[$fileKey]['name'])) {
            $folder = '../wp-content/uploads/2026/blog/';
            if (!is_dir($folder)) mkdir($folder, 0777, true);
            $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES[$fileKey]['name']));
            $path = $folder . $filename;
            if(move_uploaded_file($_FILES[$fileKey]['tmp_name'], $path)) {
                return $path;
            } else {
                echo "⚠️ Image upload failed for: $fileKey<br>";
            }
        }
        return '';
    }

    $featured_img = uploadFile('featured_img');
    $og_img = uploadFile('og_img');

    // Prepare SQL
    $sql = "INSERT INTO blog (
        title, slug, short_desc, content, category, alt_tag, tags, author,
        meta_title, meta_desc, focus_keyword, canonical_url, robots, schema_markup,
        og_title, og_desc, featured_img, og_img, status, publish_date,
        created_by, created_at, allow_comments, is_featured
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    
    if ($stmt === false) {
        die("❌ SQL Prepare Failed: " . $con->error);
    }

    // Bind parameters (21 strings, 2 integers)
    $stmt->bind_param("ssssssssssssssssssssssii", 
        $title, $slug, $short_desc, $content, $category, $alt_tag, $tags, $author,
        $meta_title, $meta_desc, $focus_keyword, $canonical_url, $robots, $schema_markup,
        $og_title, $og_desc, $featured_img, $og_img, $status, $publish_date,
        $created_by, $created_at, $allow_comments, $is_featured
    );

    if ($stmt->execute()) {
        echo "✅ Success! Blog ID: " . $con->insert_id;
        echo "<br><a href='blog_list.php'>Click here to go back</a>";
        // Success hone par automatic redirect ke liye:
        header("refresh:2;url=blog_list.php");
    } else {
        echo "❌ Execute Failed: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ Direct access or wrong button name.";
}
?>