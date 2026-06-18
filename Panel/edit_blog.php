<?php
session_start();
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

$success_flag = false;
$error_msg = "";

// 1. URL se ID get karna aur Data Fetch karna
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = $con->query("SELECT * FROM blog WHERE id = $id");
    $blog = $res ? $res->fetch_assoc() : null;
    if (!$blog) { die("Blog not found!"); }
} else {
    header('location:blog_list.php');
    exit();
}

// 2. Form Update Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_post'])) {
    
    $title = $_POST['title'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $short_desc = $_POST['short_desc'] ?? '';
    $content = $_POST['content'] ?? '';
    $category = $_POST['category'] ?? '';
    $tags = $_POST['tags'] ?? ''; // Fixed
    $author = $_POST['author_name'] ?? '';
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_desc = $_POST['meta_desc'] ?? '';
    $focus_keyword = $_POST['focus_keyword'] ?? ''; // Fixed
    $canonical_url = $_POST['canonical_url'] ?? ''; // Fixed
    $robots = $_POST['robots'] ?? ''; // Fixed
    $schema_markup = $_POST['schema_markup'] ?? '';
    $og_title = $_POST['og_title'] ?? '';
    $og_desc = $_POST['og_desc'] ?? '';
    $status = $_POST['status'] ?? 'Draft';
    $publish_date = $_POST['publish_date'] ?? date('Y-m-d H:i:s');
    $allow_comments = isset($_POST['allow_comments']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // File Upload Function
    function updateUpload($fileKey, $oldFile) {
        if (!empty($_FILES[$fileKey]['name'])) {
            $folder = '../wp-content/uploads/2026/blog/';
            if (!is_dir($folder)) mkdir($folder, 0777, true);
            if (!empty($oldFile) && file_exists($oldFile)) unlink($oldFile);
            $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES[$fileKey]['name']));
            $path = $folder . $filename;
            move_uploaded_file($_FILES[$fileKey]['tmp_name'], $path);
            return $path;
        }
        return $oldFile;
    }

    $featured_img = updateUpload('featured_img', $blog['featured_img']);
    $og_img = updateUpload('og_img', $blog['og_img']);

    $update_sql = "UPDATE blog SET 
        title=?, slug=?, short_desc=?, content=?, category=?, tags=?, author=?, 
        meta_title=?, meta_desc=?, focus_keyword=?, canonical_url=?, robots=?, schema_markup=?, 
        og_title=?, og_desc=?, featured_img=?, og_img=?, status=?, publish_date=?, 
        allow_comments=?, is_featured=? WHERE id=?";

    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("sssssssssssssssssssiii", 
        $title, $slug, $short_desc, $content, $category, $tags, $author,
        $meta_title, $meta_desc, $focus_keyword, $canonical_url, $robots, $schema_markup,
        $og_title, $og_desc, $featured_img, $og_img, $status, $publish_date,
        $allow_comments, $is_featured, $id
    );

    if ($stmt->execute()) {
        $success_flag = true;
        // Data refresh karein taaki form mein naya data dikhe
        $res = $con->query("SELECT * FROM blog WHERE id = $id");
        $blog = $res ? $res->fetch_assoc() : null;
    } else {
        $error_msg = $stmt->error;
    }
}

include 'head.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="page-wrapper">
    <div class="page-content">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 text-uppercase">Edit Blog Post</h6>
                <div>
                    <a href="blog_list.php" class="btn btn-secondary px-3 me-2">Back</a>
                    <button type="submit" name="update_post" class="btn btn-success px-5">Save Changes</button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#contentTab">Content</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seoTab">SEO & Meta</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#advancedTab">Settings</a></li>
                    </ul>

                    <div class="tab-content py-3">
                        <div class="tab-pane fade show active" id="contentTab">
                            <div class="mb-3">
                                <label class="form-label">Blog Title*</label>
                                <input type="text" name="title" id="blog_title" class="form-control" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">URL Slug</label>
                                <input type="text" name="slug" id="blog_slug" class="form-control" value="<?php echo $blog['slug']; ?>" readonly style="background:#f4f4f4">
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select">
                                        <option <?php if($blog['category']=='C11CL News') echo 'selected'; ?>>C11CL News</option>
                                        <option <?php if($blog['category']=='Cricket Tips') echo 'selected'; ?>>Cricket Tips</option>
                                        <option <?php if($blog['category']=='Trials Update') echo 'selected'; ?>>Trials Update</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Author Name</label>
                                    <input type="text" name="author_name" class="form-control" value="<?php echo $blog['author']; ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tags (comma separated)</label>
                                    <input type="text" name="tags" class="form-control" value="<?php echo $blog['tags']; ?>" placeholder="cricket, news, trials">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_desc" class="form-control" rows="2"><?php echo $blog['short_desc']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Main Content</label>
                                <textarea name="content" id="editor"><?php echo $blog['content']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Featured Image</label>
                                <input type="file" name="featured_img" class="form-control mb-2">
                                <img src="<?php echo $blog['featured_img']; ?>" width="120" class="rounded border shadow-sm">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="seoTab">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($blog['meta_title']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Focus Keyword</label>
                                    <input type="text" name="focus_keyword" class="form-control" value="<?php echo $blog['focus_keyword']; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Meta Description</label>
                                <textarea name="meta_desc" class="form-control" rows="3"><?php echo $blog['meta_desc']; ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Canonical URL</label>
                                    <input type="url" name="canonical_url" class="form-control" value="<?php echo $blog['canonical_url']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Robots (e.g. index, follow)</label>
                                    <input type="text" name="robots" class="form-control" value="<?php echo $blog['robots']; ?>">
                                </div>
                            </div>
                            <hr>
                            <h6>Social Media (OG Tags)</h6>
                            <div class="mb-3"><label>OG Title</label><input type="text" name="og_title" class="form-control" value="<?php echo htmlspecialchars($blog['og_title']); ?>"></div>
                            <div class="mb-3"><label>OG Description</label><textarea name="og_desc" class="form-control"><?php echo $blog['og_desc']; ?></textarea></div>
                            <div class="mb-3">
                                <label>OG Image (Social Sharing Image)</label>
                                <input type="file" name="og_img" class="form-control mb-2">
                                <img src="<?php echo $blog['og_img']; ?>" width="120" class="rounded border shadow-sm">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="advancedTab">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-select">
                                        <option value="Published" <?php if($blog['status']=='Published') echo 'selected'; ?>>Published</option>
                                        <option value="Draft" <?php if($blog['status']=='Draft') echo 'selected'; ?>>Draft</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Publish Date</label>
                                    <input type="datetime-local" name="publish_date" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($blog['publish_date'])); ?>">
                                </div>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="allow_comments" id="ac" <?php echo ($blog['allow_comments']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="ac">Allow Comments</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="if" <?php echo ($blog['is_featured']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="if">Featured Post (Slider)</label>
                            </div>
                            <div class="mt-3">
                                <label>Schema Markup (JSON-LD)</label>
                                <textarea name="schema_markup" class="form-control" rows="4"><?php echo $blog['schema_markup']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let myEditor;
    ClassicEditor.create(document.querySelector('#editor'))
        .then(editor => { myEditor = editor; })
        .catch(err => { console.error(err); });

    document.getElementById('blog_title').addEventListener('input', function() {
        let slug = this.value.toLowerCase().trim().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        document.getElementById('blog_slug').value = slug;
    });

    document.getElementById('editForm').addEventListener('submit', function(e) {
        if (myEditor) myEditor.updateSourceElement();
    });

    <?php if($success_flag): ?>
        Swal.fire('Updated!', 'Blog updated successfully.', 'success').then(() => {
            window.location.href = 'blog_list.php';
        });
    <?php endif; ?>

    <?php if(!empty($error_msg)): ?>
        Swal.fire('Error!', '<?php echo addslashes($error_msg); ?>', 'error');
    <?php endif; ?>
</script>

<?php include 'foot.php'; ?>