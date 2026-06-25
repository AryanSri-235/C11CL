<?php
session_start();

// 🔴 Full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🔴 Alert function
function showAlert($msg) {
    echo "<script>alert(" . json_encode($msg) . ");</script>";
}

if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

include 'db.php'; 

// 🔴 DB connection check
if (!$con) {
    showAlert("Database connection failed: " . db_error());
    exit();
}

$success_flag = false;
$new_id = 0;
$error_msg = ""; // Initialized error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publish_post'])) {
    
    $created_by = $_SESSION['name'] ?? 'admin';
    $created_at = date('Y-m-d H:i:s');

    // 🔴 Safe POST handling
    $title = $_POST['title'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $short_desc = $_POST['short_desc'] ?? '';
    $content = $_POST['content'] ?? ''; // CKEditor data
    $category = $_POST['category'] ?? '';
    $tags = $_POST['tags'] ?? '';
    $author = $_POST['author_name'] ?? '';

    $meta_title = $_POST['meta_title'] ?? '';
    $meta_desc = $_POST['meta_desc'] ?? '';
    $focus_keyword = $_POST['focus_keyword'] ?? '';
    $canonical_url = $_POST['canonical_url'] ?? '';
    $robots = $_POST['robots'] ?? '';
    $schema_markup = $_POST['schema_markup'] ?? '';

    $og_title = $_POST['og_title'] ?? '';
    $og_desc = $_POST['og_desc'] ?? '';

    $status = $_POST['status'] ?? 'Draft';
    $publish_date = !empty($_POST['publish_date']) ? $_POST['publish_date'] : $created_at;

    $allow_comments = isset($_POST['allow_comments']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // 🔴 File upload function
    function uploadFile($fileKey) {
        if (!empty($_FILES[$fileKey]['name'])) {
            $folder = 'uploads/';
            
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES[$fileKey]['name']));
            $path = $folder . $filename;

            if(move_uploaded_file($_FILES[$fileKey]['tmp_name'], $path)) {
                return $path;
            }
        }
        return '';
    }

    $featured_img = uploadFile('featured_img');
    $og_img = uploadFile('og_img');

    // ✅ SQL Query
    $sql = "INSERT INTO blog (
        title, slug, short_desc, content, category, tags, author,
        meta_title, meta_desc, focus_keyword, canonical_url, robots, schema_markup,
        og_title, og_desc, featured_img, og_img, status, publish_date,
        created_by, created_at, allow_comments, is_featured
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        $error_msg = "Prepare Failed: " . $con->error;
    } else {
        // ✅ bind_param (21 strings 's', 2 integers 'i')
        if (!$stmt->bind_param("sssssssssssssssssssssii", 
            $title, $slug, $short_desc, $content, $category, $tags, $author,
            $meta_title, $meta_desc, $focus_keyword, $canonical_url, $robots, $schema_markup,
            $og_title, $og_desc, $featured_img, $og_img, $status, $publish_date,
            $created_by, $created_at, $allow_comments, $is_featured
        )) {
            $error_msg = "Bind Failed: " . $stmt->error;
        } else {
            if ($stmt->execute()) {
                $success_flag = true;
                $new_id = $con->insert_id;
            } else {
                $error_msg = "Execute Failed: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

include 'head.php';
?>

<style>
    .ck-editor__editable { min-height: 300px !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="page-wrapper">
    <div class="page-content">
        <div class="progress mb-3" style="height: 5px; display:none;" id="mainProgress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>

        <form id="blogForm" method="POST" enctype="multipart/form-data" action="">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 text-uppercase">Create Professional Blog</h6>
                <button type="submit" name="publish_post" id="submitBtn" class="btn btn-primary px-5">
                    <span id="btnText">Publish Now</span>
                    <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                </button>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#contentTab">Content</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seoTab">SEO Guide</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#socialTab">Social Media</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#advancedTab">Advanced</a></li>
                    </ul>

                    <div class="tab-content py-3">
                        <div class="tab-pane fade show active" id="contentTab">
                            <div class="mb-3">
                                <label class="form-label font-weight-bold">Blog Title*</label>
                                <input type="text" name="title" id="blog_title" class="form-control" placeholder="Enter title" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SEO URL (Slug)</label>
                                <input type="text" name="slug" id="blog_slug" class="form-control" readonly style="background: #f4f4f4;">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select">
                                        <option>C11CL News</option>
                                        <option>Cricket Tips</option>
                                        <option>Trials Update</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Display Author Name</label>
                                    <input type="text" name="author_name" class="form-control" value="<?php echo $_SESSION['name'] ?? ''; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tags</label>
                                    <input type="text" name="tags" class="form-control" placeholder="cricket, trials">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Short Intro</label>
                                <textarea name="short_desc" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Main Content*</label>
                                <textarea name="content" id="editor"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Featured Image</label>
                                <input type="file" name="featured_img" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="seoTab">
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_desc" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Focus Keyword</label>
                                <input type="text" name="focus_keyword" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Canonical URL</label>
                                <input type="url" name="canonical_url" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Robots Policy</label>
                                <select name="robots" class="form-select">
                                    <option value="index, follow">Index, Follow</option>
                                    <option value="noindex, follow">No-Index</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Schema Markup</label>
                                <textarea name="schema_markup" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="socialTab">
                            <div class="mb-3">
                                <label class="form-label">OG Title</label>
                                <input type="text" name="og_title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">OG Description</label>
                                <textarea name="og_desc" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Social Image (OG Image)</label>
                                <input type="file" name="og_img" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="advancedTab">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="Published">Published</option>
                                        <option value="Draft">Draft</option>
                                        <option value="Scheduled">Scheduled</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Schedule Date</label>
                                    <input type="datetime-local" name="publish_date" class="form-control">
                                </div>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="allow_comments" id="c1" checked>
                                <label class="form-check-label" for="c1">Enable Comments</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="f1">
                                <label class="form-check-label" for="f1">Highlight in Slider</label>
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

    // 1. Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => { 
            myEditor = editor; 
        })
        .catch(err => { console.error(err); });

    // 2. Slug generator
    document.getElementById('blog_title').addEventListener('input', function() {
        let slug = this.value.toLowerCase().trim()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('blog_slug').value = slug;
    });

    // 3. Handle Submit
    document.getElementById('blogForm').addEventListener('submit', function(e) {
        // ✅ CRITICAL: Sync CKEditor data back to textarea
        if (myEditor) {
            const editorData = myEditor.getData();
            if(editorData.trim() === '') {
                Swal.fire('Error', 'Content field is empty!', 'warning');
                e.preventDefault();
                return false;
            }
            // Manually sync before submit
            myEditor.updateSourceElement(); 
        }

        // Show UI loading
        document.getElementById('mainProgress').style.display = "flex";
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('btnText').innerText = "Uploading Blog...";
        document.getElementById('btnSpinner').style.display = "inline-block";
    });

    // 4. Success Popup
    <?php if($success_flag): ?>
        Swal.fire({
            title: 'Success!',
            text: 'Blog published successfully!',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Preview 👁️',
            cancelButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open('../blog-details.php?id=<?php echo $new_id; ?>', '_blank');
            }
            window.location.href='blog.php';
        });
    <?php endif; ?>

    // 5. Error Popup
    <?php if(!empty($error_msg)): ?>
        Swal.fire('Database Error', '<?php echo addslashes($error_msg); ?>', 'error');
        document.getElementById('mainProgress').style.display = "none";
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('btnText').innerText = "Publish Now";
        document.getElementById('btnSpinner').style.display = "none";
    <?php endif; ?>
</script>

<?php include 'foot.php'; ?>