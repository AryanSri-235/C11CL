<?php
ini_set('display_errors', 0);
error_reporting(0);

if (session_status() === PHP_SESSION_NONE) { session_start(); }

include 'db.php';

// ── AJAX: Delete image ──────────────────────────────────────────────────────
if (isset($_GET['delete_id'])) {
    header('Content-Type: application/json');
    $id = intval($_GET['delete_id']);
    $stmt = $con->prepare("DELETE FROM gallery WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        echo $stmt->execute() ? '{"status":"success"}' : '{"status":"error"}';
        $stmt->close();
    } else {
        echo '{"status":"error"}';
    }
    exit();
}

// ── POST: Add new image ─────────────────────────────────────────────────────
$msg = '';
$msg_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_image'])) {
    $url      = trim($_POST['image_url'] ?? '');
    $caption  = trim($_POST['caption'] ?? '');
    $category = trim($_POST['category'] ?? 'General');
    $sort     = intval($_POST['sort_order'] ?? 0);

    if (empty($url)) {
        $msg = 'Image URL is required.';
        $msg_type = 'danger';
    } else {
        $stmt = $con->prepare("INSERT INTO gallery (image_url, caption, category, sort_order) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssi", $url, $caption, $category, $sort);
            if ($stmt->execute()) {
                $msg = 'Image added successfully!';
                $msg_type = 'success';
            } else {
                $msg = 'Failed to add image.';
                $msg_type = 'danger';
            }
            $stmt->close();
        }
    }
}

// ── Fetch all images ────────────────────────────────────────────────────────
$images = [];
$res = $con->query("SELECT id, image_url, caption, category, sort_order FROM gallery ORDER BY sort_order ASC, id ASC");
if ($res) { while ($row = $res->fetch_assoc()) { $images[] = $row; } }

include 'head.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="page-wrapper">
<div class="page-content">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 text-uppercase fw-bold">Manage Gallery</h5>
    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bx bx-plus me-1"></i> Add New Image
    </button>
</div>

<?php if ($msg): ?>
<div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($msg); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Stats Bar -->
<div class="alert alert-info py-2 mb-4">
    <i class="bx bx-images me-1"></i>
    <strong><?php echo count($images); ?></strong> image<?php echo count($images) !== 1 ? 's' : ''; ?> in gallery
</div>

<!-- Gallery Grid -->
<?php if (empty($images)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bx bx-image-add" style="font-size:3rem;color:#ccc;"></i>
        <p class="text-muted mt-3">No images in gallery yet. Click "Add New Image" to get started.</p>
    </div>
</div>
<?php else: ?>
<div class="row g-3" id="galleryGrid">
    <?php foreach ($images as $img): ?>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3" id="card-<?php echo $img['id']; ?>">
        <div class="card h-100 shadow-sm">
            <div style="height:180px;overflow:hidden;background:#111;border-radius:6px 6px 0 0;">
                <img src="<?php echo htmlspecialchars($img['image_url']); ?>"
                     alt="<?php echo htmlspecialchars($img['caption']); ?>"
                     style="width:100%;height:100%;object-fit:cover;display:block;"
                     onerror="this.src='https://via.placeholder.com/300x180?text=Broken+URL'">
            </div>
            <div class="card-body p-2">
                <p class="mb-1 fw-semibold" style="font-size:0.82rem;line-height:1.3;">
                    <?php echo htmlspecialchars($img['caption'] ?: '—'); ?>
                </p>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <span class="badge bg-secondary" style="font-size:0.7rem;">
                        <?php echo htmlspecialchars($img['category']); ?>
                    </span>
                    <span class="text-muted" style="font-size:0.7rem;">Order: <?php echo $img['sort_order']; ?></span>
                </div>
            </div>
            <div class="card-footer p-2 bg-transparent border-top d-flex gap-2">
                <button class="btn btn-sm btn-outline-info flex-fill"
                        onclick="previewImg('<?php echo htmlspecialchars($img['image_url'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($img['caption'], ENT_QUOTES); ?>')">
                    <i class="bx bx-show"></i> Preview
                </button>
                <button class="btn btn-sm btn-outline-danger flex-fill"
                        onclick="deleteImage(<?php echo $img['id']; ?>, this)">
                    <i class="bx bx-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

</div><!-- page-content -->
</div><!-- page-wrapper -->

<!-- ── Add Image Modal ─────────────────────────────────────────────── -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New Gallery Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="addForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Image URL <span class="text-danger">*</span></label>
                        <input type="url" name="image_url" id="previewUrl" class="form-control"
                               placeholder="https://c11cl.com/wp-content/uploads/..." required
                               oninput="livePreview(this.value)">
                        <div class="form-text">Enter the full URL of the image (e.g. from c11cl.com or your uploads folder).</div>
                    </div>

                    <!-- Live Preview -->
                    <div id="imgPreviewBox" class="mb-3" style="display:none;">
                        <label class="form-label fw-semibold">Preview</label>
                        <div style="height:180px;background:#111;border-radius:6px;overflow:hidden;">
                            <img id="livePreviewImg" src="" alt="" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Caption</label>
                        <input type="text" name="caption" class="form-control" placeholder="e.g. C11CL State-Wise Trials" maxlength="255">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category" class="form-select">
                                <option value="General">General</option>
                                <option value="Matches">Matches</option>
                                <option value="Trials">Trials</option>
                                <option value="Training">Training</option>
                                <option value="Events">Events</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="<?php echo count($images) + 1; ?>" min="0">
                            <div class="form-text">Lower number = shown first.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_image" class="btn btn-primary px-4">
                        <i class="bx bx-plus me-1"></i> Add to Gallery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ── Preview Modal ───────────────────────────────────────────────── -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-0">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title" id="previewCaption"></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-2">
                <img id="previewModalImg" src="" alt="" style="max-width:100%;max-height:70vh;object-fit:contain;border-radius:4px;">
            </div>
        </div>
    </div>
</div>

<script>
function deleteImage(id, btn) {
    Swal.fire({
        title: 'Delete this image?',
        text: 'This will remove it from the gallery permanently.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e31e24',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it'
    }).then(result => {
        if (!result.isConfirmed) return;
        btn.disabled = true;
        fetch('manage_gallery.php?delete_id=' + id)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    const card = document.getElementById('card-' + id);
                    card.style.transition = 'opacity 0.3s';
                    card.style.opacity = '0';
                    setTimeout(() => card.remove(), 300);
                    Swal.fire('Deleted!', 'Image removed from gallery.', 'success');
                } else {
                    Swal.fire('Error', 'Could not delete. Try again.', 'error');
                    btn.disabled = false;
                }
            })
            .catch(() => { Swal.fire('Error', 'Network error.', 'error'); btn.disabled = false; });
    });
}

function previewImg(url, caption) {
    document.getElementById('previewModalImg').src = url;
    document.getElementById('previewCaption').textContent = caption || 'Preview';
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}

function livePreview(url) {
    const box = document.getElementById('imgPreviewBox');
    const img = document.getElementById('livePreviewImg');
    if (url.length > 10) {
        img.src = url;
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
}

// Open add modal if page reloaded with success/error (form was submitted)
<?php if ($msg && $msg_type === 'danger'): ?>
window.addEventListener('DOMContentLoaded', () => {
    new bootstrap.Modal(document.getElementById('addModal')).show();
});
<?php endif; ?>
</script>

<?php include 'foot.php'; ?>
