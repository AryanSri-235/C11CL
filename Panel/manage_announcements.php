<?php
ini_set('display_errors', 0);
error_reporting(0);

if (session_status() === PHP_SESSION_NONE) { session_start(); }

include 'db.php';

// ── AJAX: Delete ────────────────────────────────────────────────────────────
if (isset($_GET['delete_id'])) {
    header('Content-Type: application/json');
    if (empty($_SESSION['uname'])) { echo '{"status":"auth"}'; exit(); }
    $id = intval($_GET['delete_id']);
    $stmt = $con->prepare("DELETE FROM announcements WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        echo $stmt->execute() ? '{"status":"success"}' : '{"status":"error"}';
        $stmt->close();
    } else { echo '{"status":"error"}'; }
    exit();
}

$msg = ''; $msg_type = '';

// ── POST: Add ───────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    $title        = trim($_POST['title'] ?? '');
    $publish_date = trim($_POST['publish_date'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $link         = trim($_POST['link'] ?? '');
    $is_new       = isset($_POST['is_new']) ? 1 : 0;
    $sort         = intval($_POST['sort_order'] ?? 0);

    if (empty($title) || empty($publish_date)) {
        $msg = 'Title and Publish Date are required.'; $msg_type = 'danger';
    } else {
        $stmt = $con->prepare("INSERT INTO announcements (title, publish_date, description, link, is_new, sort_order) VALUES (?,?,?,?,?,?)");
        if ($stmt) {
            $stmt->bind_param("ssssii", $title, $publish_date, $description, $link, $is_new, $sort);
            if ($stmt->execute()) { $msg = 'Announcement added!'; $msg_type = 'success'; }
            else { $msg = 'Failed to add.'; $msg_type = 'danger'; }
            $stmt->close();
        }
    }
}

// ── POST: Edit ──────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit') {
    $id           = intval($_POST['ann_id'] ?? 0);
    $title        = trim($_POST['title'] ?? '');
    $publish_date = trim($_POST['publish_date'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $link         = trim($_POST['link'] ?? '');
    $is_new       = isset($_POST['is_new']) ? 1 : 0;
    $sort         = intval($_POST['sort_order'] ?? 0);

    if (empty($title) || empty($publish_date)) {
        $msg = 'Title and Publish Date are required.'; $msg_type = 'danger';
    } else {
        $stmt = $con->prepare("UPDATE announcements SET title=?, publish_date=?, description=?, link=?, is_new=?, sort_order=? WHERE id=?");
        if ($stmt) {
            $stmt->bind_param("ssssiij", $title, $publish_date, $description, $link, $is_new, $sort, $id);
            if ($stmt->execute()) { $msg = 'Announcement updated!'; $msg_type = 'success'; }
            else { $msg = 'Failed to update.'; $msg_type = 'danger'; }
            $stmt->close();
        }
    }
}

// ── Fetch all ───────────────────────────────────────────────────────────────
$rows = [];
$table_exists = false;
$check = $con->query("SHOW TABLES LIKE 'announcements'");
if ($check && $check->num_rows > 0) {
    $table_exists = true;
    $res = $con->query("SELECT * FROM announcements ORDER BY sort_order ASC, id DESC");
    if ($res) { while ($r = $res->fetch_assoc()) { $rows[] = $r; } }
}

include 'head.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="page-wrapper">
<div class="page-content">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 text-uppercase fw-bold">Manage Announcements</h5>
    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bx bx-plus me-1"></i> Add Announcement
    </button>
</div>

<?php if ($msg): ?>
<div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show">
    <?php echo htmlspecialchars($msg); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (!$table_exists): ?>
<div class="alert alert-warning">
    <strong>Table not found.</strong> Run this SQL in phpMyAdmin:
    <pre class="mt-2 mb-0" style="background:#fff;padding:12px;border-radius:6px;font-size:0.8rem;">CREATE TABLE `announcements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `publish_date` DATE NOT NULL,
  `description` TEXT,
  `link` VARCHAR(255) DEFAULT '',
  `is_new` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0
);

INSERT INTO `announcements` (`title`,`publish_date`,`description`,`link`,`is_new`,`sort_order`) VALUES
('Important Update for T20 Participants','2026-06-19',
 'Crucial guidelines, schedule timeline shifts, mandatory document checklists, and registration verification updates for all players participating in the upcoming T20 tournament.',
 'important-update-for-t20-participants/',1,1);</pre>
</div>
<?php else: ?>

<div class="alert alert-info py-2 mb-3">
    <i class="bx bx-broadcast me-1"></i>
    <strong><?php echo count($rows); ?></strong> announcement<?php echo count($rows) !== 1 ? 's' : ''; ?>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Badge</th>
                        <th>Link</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($rows)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">No announcements yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($rows as $i => $a): ?>
                    <tr id="row-<?php echo $a['id']; ?>">
                        <td class="text-muted"><?php echo $i + 1; ?></td>
                        <td class="fw-semibold"><?php echo htmlspecialchars($a['title']); ?></td>
                        <td><?php echo date('d M Y', strtotime($a['publish_date'])); ?></td>
                        <td>
                            <?php if ($a['is_new']): ?>
                            <span class="badge bg-danger">NEW</span>
                            <?php else: ?>
                            <span class="badge bg-secondary">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($a['link']): ?>
                            <small class="text-muted"><?php echo htmlspecialchars($a['link']); ?></small>
                            <?php else: ?>
                            <small class="text-muted">—</small>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge bg-secondary"><?php echo $a['sort_order']; ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1"
                                onclick="openEdit(
                                    <?php echo $a['id']; ?>,
                                    '<?php echo htmlspecialchars($a['title'], ENT_QUOTES); ?>',
                                    '<?php echo $a['publish_date']; ?>',
                                    '<?php echo htmlspecialchars($a['description'], ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($a['link'], ENT_QUOTES); ?>',
                                    <?php echo (int)$a['is_new']; ?>,
                                    <?php echo (int)$a['sort_order']; ?>)">
                                <i class="bx bx-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="deleteAnn(<?php echo $a['id']; ?>, this)">
                                <i class="bx bx-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

</div><!-- page-content -->
</div><!-- page-wrapper -->

<!-- ── Add Modal ────────────────────────────────────────────────────── -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <?php echo annFormFields(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bx bx-plus me-1"></i> Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ── Edit Modal ───────────────────────────────────────────────────── -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="ann_id" id="edit_ann_id">
                <div class="modal-body">
                    <?php echo annFormFields('edit_'); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning px-4"><i class="bx bx-save me-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteAnn(id, btn) {
    Swal.fire({
        title: 'Delete this announcement?',
        text: 'It will be removed from the website immediately.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e31e24',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete'
    }).then(result => {
        if (!result.isConfirmed) return;
        btn.disabled = true;
        fetch('manage_announcements.php?delete_id=' + id)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    const row = document.getElementById('row-' + id);
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 300);
                    Swal.fire('Deleted!', 'Announcement removed.', 'success');
                } else {
                    Swal.fire('Error', 'Could not delete. Try again.', 'error');
                    btn.disabled = false;
                }
            })
            .catch(() => { Swal.fire('Error', 'Network error.', 'error'); btn.disabled = false; });
    });
}

function openEdit(id, title, date, desc, link, isNew, sortOrder) {
    document.getElementById('edit_ann_id').value        = id;
    document.getElementById('edit_title').value         = title;
    document.getElementById('edit_publish_date').value  = date;
    document.getElementById('edit_description').value   = desc;
    document.getElementById('edit_link').value          = link;
    document.getElementById('edit_is_new').checked      = isNew == 1;
    document.getElementById('edit_sort_order').value    = sortOrder;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<?php include 'foot.php'; ?>
<?php
function annFormFields($p = '') {
    $today = date('Y-m-d');
    return <<<HTML
<div class="mb-3">
    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
    <input type="text" name="title" id="{$p}title" class="form-control"
           placeholder="e.g. Important Update for T20 Participants" required maxlength="255">
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Publish Date <span class="text-danger">*</span></label>
        <input type="date" name="publish_date" id="{$p}publish_date" class="form-control" value="{$today}" required>
        <div class="form-text">Shown as day + month/year on the website.</div>
    </div>
    <div class="col-md-3 mb-3 d-flex align-items-center pt-3">
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_new" id="{$p}is_new" checked>
            <label class="form-check-label fw-semibold" for="{$p}is_new">Show "NEW" badge</label>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" name="sort_order" id="{$p}sort_order" class="form-control" value="0" min="0">
    </div>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Description</label>
    <textarea name="description" id="{$p}description" class="form-control" rows="3"
              placeholder="Brief summary shown on the announcements list page..."></textarea>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Link (Read Full Details URL)</label>
    <input type="text" name="link" id="{$p}link" class="form-control"
           placeholder="important-update-for-t20-participants/" maxlength="255">
    <div class="form-text">Relative path to the full announcement page. Leave blank to hide the button.</div>
</div>
HTML;
}
?>
