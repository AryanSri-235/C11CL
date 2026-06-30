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
    $stmt = $con->prepare("DELETE FROM matches WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        echo $stmt->execute() ? '{"status":"success"}' : '{"status":"error"}';
        $stmt->close();
    } else { echo '{"status":"error"}'; }
    exit();
}

$msg = ''; $msg_type = '';

// ── POST: Add ───────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $city         = trim($_POST['city'] ?? '');
    $ground       = trim($_POST['ground_name'] ?? '');
    $subtitle     = trim($_POST['subtitle'] ?? 'Official Phase-2 Matches');
    $status_label = trim($_POST['status_label'] ?? 'Fixtures Confirmed');
    $date_display = trim($_POST['date_display'] ?? '');
    $sort         = intval($_POST['sort_order'] ?? 0);

    if (empty($city) || empty($ground) || empty($date_display)) {
        $msg = 'City, Ground Name and Date are required.'; $msg_type = 'danger';
    } else {
        $stmt = $con->prepare("INSERT INTO matches (city, ground_name, subtitle, status_label, date_display, sort_order) VALUES (?,?,?,?,?,?)");
        if ($stmt) {
            $stmt->bind_param("sssssi", $city, $ground, $subtitle, $status_label, $date_display, $sort);
            if ($stmt->execute()) { $msg = 'Match added!'; $msg_type = 'success'; }
            else { $msg = 'Failed to add match.'; $msg_type = 'danger'; }
            $stmt->close();
        }
    }
}

// ── POST: Edit ──────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id           = intval($_POST['match_id'] ?? 0);
    $city         = trim($_POST['city'] ?? '');
    $ground       = trim($_POST['ground_name'] ?? '');
    $subtitle     = trim($_POST['subtitle'] ?? '');
    $status_label = trim($_POST['status_label'] ?? '');
    $date_display = trim($_POST['date_display'] ?? '');
    $sort         = intval($_POST['sort_order'] ?? 0);

    if (empty($city) || empty($ground) || empty($date_display)) {
        $msg = 'City, Ground Name and Date are required.'; $msg_type = 'danger';
    } else {
        $stmt = $con->prepare("UPDATE matches SET city=?, ground_name=?, subtitle=?, status_label=?, date_display=?, sort_order=? WHERE id=?");
        if ($stmt) {
            $stmt->bind_param("sssssii", $city, $ground, $subtitle, $status_label, $date_display, $sort, $id);
            if ($stmt->execute()) { $msg = 'Match updated!'; $msg_type = 'success'; }
            else { $msg = 'Failed to update match.'; $msg_type = 'danger'; }
            $stmt->close();
        }
    }
}

// ── Fetch all matches ───────────────────────────────────────────────────────
$matches = [];
$table_exists = false;
$check = $con->query("SHOW TABLES LIKE 'matches'");
if ($check && $check->num_rows > 0) {
    $table_exists = true;
    $res = $con->query("SELECT * FROM matches ORDER BY sort_order ASC, id ASC");
    if ($res) { while ($row = $res->fetch_assoc()) { $matches[] = $row; } }
}

include 'head.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="page-wrapper">
<div class="page-content">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 text-uppercase fw-bold">Match Management</h5>
    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bx bx-plus me-1"></i> Add New Match
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
    <strong>Table not found.</strong> Run this SQL in phpMyAdmin first:
    <pre class="mt-2 mb-0" style="background:#fff;padding:12px;border-radius:6px;font-size:0.8rem;">CREATE TABLE `matches` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `city` VARCHAR(100) NOT NULL,
  `ground_name` VARCHAR(255) NOT NULL,
  `subtitle` VARCHAR(255) DEFAULT 'Official Phase-2 Matches',
  `status_label` VARCHAR(100) DEFAULT 'Fixtures Confirmed',
  `date_display` VARCHAR(100) NOT NULL,
  `sort_order` INT DEFAULT 0
);

INSERT INTO `matches` (`city`,`ground_name`,`subtitle`,`status_label`,`date_display`,`sort_order`) VALUES
('Noida','The SoulSport Ground','Official Phase-2 Matches','Fixtures Confirmed','26 May – 30 May',1),
('Mumbai','Ghevra Cricket Ground','Official Phase-2 Matches','Fixtures Confirmed','1 June – 5 June',2),
('Ahmedabad','Shivay, The Cricketing Hub, Karai','Official Phase-2 Matches','Fixtures Confirmed','8 June – 12 June',3),
('Hyderabad','Hyderabad Cricket Ground','Official Phase-2 Matches','Fixtures Confirmed','15 June – 17 June',4);</pre>
</div>
<?php else: ?>

<div class="alert alert-info py-2 mb-3">
    <i class="bx bx-trophy me-1"></i>
    <strong><?php echo count($matches); ?></strong> match<?php echo count($matches) !== 1 ? 'es' : ''; ?> in database
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>City</th>
                        <th>Ground</th>
                        <th>Subtitle</th>
                        <th>Status Label</th>
                        <th>Dates</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($matches)): ?>
                    <tr><td colspan="8" class="text-center text-muted py-4">No matches yet. Click "Add New Match".</td></tr>
                <?php else: ?>
                    <?php foreach ($matches as $i => $m): ?>
                    <tr id="row-<?php echo $m['id']; ?>">
                        <td class="text-muted"><?php echo $i + 1; ?></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($m['city']); ?></td>
                        <td><?php echo htmlspecialchars($m['ground_name']); ?></td>
                        <td><small class="text-muted"><?php echo htmlspecialchars($m['subtitle']); ?></small></td>
                        <td>
                            <span class="badge bg-success" style="font-size:0.72rem;">
                                <?php echo htmlspecialchars($m['status_label']); ?>
                            </span>
                        </td>
                        <td class="fw-semibold text-danger"><?php echo htmlspecialchars($m['date_display']); ?></td>
                        <td><span class="badge bg-secondary"><?php echo $m['sort_order']; ?></span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1"
                                onclick="openEdit(<?php echo $m['id']; ?>,
                                    '<?php echo htmlspecialchars($m['city'], ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($m['ground_name'], ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($m['subtitle'], ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($m['status_label'], ENT_QUOTES); ?>',
                                    '<?php echo htmlspecialchars($m['date_display'], ENT_QUOTES); ?>',
                                    <?php echo intval($m['sort_order']); ?>)">
                                <i class="bx bx-edit"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="deleteMatch(<?php echo $m['id']; ?>, this)">
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
                <h5 class="modal-title fw-bold">Add New Match</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <?php echo matchFormFields(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4"><i class="bx bx-plus me-1"></i> Add Match</button>
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
                <h5 class="modal-title fw-bold">Edit Match</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editForm">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="match_id" id="edit_match_id">
                <div class="modal-body">
                    <?php echo matchFormFields('edit_'); ?>
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
function deleteMatch(id, btn) {
    Swal.fire({
        title: 'Delete this match?',
        text: 'It will be removed from the website immediately.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e31e24',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete'
    }).then(result => {
        if (!result.isConfirmed) return;
        btn.disabled = true;
        fetch('manage_matches.php?delete_id=' + id)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    const row = document.getElementById('row-' + id);
                    row.style.opacity = '0';
                    row.style.transition = 'opacity 0.3s';
                    setTimeout(() => row.remove(), 300);
                    Swal.fire('Deleted!', 'Match removed.', 'success');
                } else {
                    Swal.fire('Error', 'Could not delete. Try again.', 'error');
                    btn.disabled = false;
                }
            })
            .catch(() => { Swal.fire('Error', 'Network error.', 'error'); btn.disabled = false; });
    });
}

function openEdit(id, city, ground, subtitle, statusLabel, dateDisplay, sortOrder) {
    document.getElementById('edit_match_id').value    = id;
    document.getElementById('edit_city').value        = city;
    document.getElementById('edit_ground_name').value = ground;
    document.getElementById('edit_subtitle').value    = subtitle;
    document.getElementById('edit_status_label').value= statusLabel;
    document.getElementById('edit_date_display').value= dateDisplay;
    document.getElementById('edit_sort_order').value  = sortOrder;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

<?php if ($msg && $msg_type === 'danger'): ?>
window.addEventListener('DOMContentLoaded', () => {
    new bootstrap.Modal(document.getElementById('addModal')).show();
});
<?php endif; ?>
</script>

<?php include 'foot.php'; ?>
<?php

function matchFormFields($prefix = '') {
    $c = htmlspecialchars($prefix);
    return <<<HTML
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
        <input type="text" name="city" id="{$c}city" class="form-control" placeholder="e.g. Noida" required maxlength="100">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Sort Order</label>
        <input type="number" name="sort_order" id="{$c}sort_order" class="form-control" value="0" min="0">
    </div>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Ground Name <span class="text-danger">*</span></label>
    <input type="text" name="ground_name" id="{$c}ground_name" class="form-control" placeholder="e.g. The SoulSport Ground" required maxlength="255">
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Subtitle</label>
    <input type="text" name="subtitle" id="{$c}subtitle" class="form-control" value="Official Phase-2 Matches" maxlength="255">
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Status Label</label>
        <input type="text" name="status_label" id="{$c}status_label" class="form-control" value="Fixtures Confirmed" maxlength="100">
        <div class="form-text">Shown as the green badge on the website.</div>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Date Display <span class="text-danger">*</span></label>
        <input type="text" name="date_display" id="{$c}date_display" class="form-control" placeholder="e.g. 26 May – 30 May" required maxlength="100">
        <div class="form-text">Shown in red on the website exactly as typed.</div>
    </div>
</div>
HTML;
}
?>
