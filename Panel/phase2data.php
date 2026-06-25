<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

include 'head.php';
include 'db.php'; // Database connection

// Error Reporting Enable
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ---- 1. EDIT/UPDATE LOGIC (NEW) ----
if (isset($_POST['update_record'])) {
    $u_id = intval($_POST['edit_id']);
    $u_name = $_POST['edit_name'];
    $u_mobile = $_POST['edit_mobile'];
    $u_amount = $_POST['edit_amount'];
    $u_state = $_POST['edit_state'];
    $u_age = $_POST['edit_age'];

    // Prepared statement for security
    $upStmt = $con->prepare("UPDATE `register-second` SET name=?, mobile=?, amount=?, state=?, `age`=? WHERE id=?");
    $upStmt->bind_param("sssssi", $u_name, $u_mobile, $u_amount, $u_state, $u_age, $u_id);

    if ($upStmt->execute()) {
        echo "<script>alert('Record Updated Successfully!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
    } else {
        echo "<script>alert('Failed to Update Record.');</script>";
    }
    $upStmt->close();
}

// ---- DELETE LOGIC ----
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $delQuery = $con->prepare("DELETE FROM `register-second` WHERE id = ?");
    $delQuery->bind_param("i", $deleteId);
    if ($delQuery->execute()) {
        echo "<script>alert('Record deleted successfully!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    } else {
        echo "<script>alert('Error deleting record.');</script>";
    }
    $delQuery->close();
}

// Initialize filters
$datef = $_POST['datef'] ?? '';
$datel = $_POST['datel'] ?? '';
$searchText = trim($_POST['universal'] ?? '');
$stateFilter = $_POST['state'] ?? '';
$statusFilter = $_POST['status'] ?? '';
$ageGroupFilter = $_POST['age_group'] ?? '';
$tshirt = htmlspecialchars($row['tshirt_size'] ?? 'N/A');
$food = htmlspecialchars($row['food_pref'] ?? 'N/A');

$filterApplied = false;
$filterNotice = [];

// Base Query
$sql = "SELECT * FROM `register-second` WHERE 1";

// Apply filters
if (!empty($datef)) {
    $sql .= " AND DATE(`created_at`) >= '" . $con->real_escape_string($datef) . "'";
    $filterNotice[] = "From <strong>$datef</strong>";
    $filterApplied = true;
}
if (!empty($datel)) {
    $sql .= " AND DATE(`created_at`) <= '" . $con->real_escape_string($datel) . "'";
    $filterNotice[] = "To <strong>$datel</strong>";
    $filterApplied = true;
}
if (!empty($searchText)) {
    $esc = $con->real_escape_string($searchText);
    $sql .= " AND (
        name LIKE '%$esc%' OR
        reg LIKE '%$esc%' OR
        reg2 LIKE '%$esc%' OR
        email LIKE '%$esc%' OR
        mobile LIKE '%$esc%' OR
        state LIKE '%$esc%' OR
        player LIKE '%$esc%'
    )";
    $filterNotice[] = "Search: <strong>" . htmlspecialchars($searchText) . "</strong>";
    $filterApplied = true;
}
if (!empty($stateFilter)) {
    $sql .= " AND state='" . $con->real_escape_string($stateFilter) . "'";
    $filterNotice[] = "State: <strong>" . htmlspecialchars($stateFilter) . "</strong>";
    $filterApplied = true;
}
if (!empty($statusFilter)) {
    $sql .= " AND status='" . $con->real_escape_string($statusFilter) . "'";
    $filterNotice[] = "Status: <strong>" . htmlspecialchars($statusFilter) . "</strong>";
    $filterApplied = true;
}
if (!empty($ageGroupFilter)) {
    $sql .= " AND age='" . $con->real_escape_string($ageGroupFilter) . "'";
    $filterNotice[] = "Age Group: <strong>" . htmlspecialchars($ageGroupFilter) . "</strong>";
    $filterApplied = true;
}
$mailFilter = $_POST['mail_status'] ?? '';
if (!empty($mailFilter)) {
    if ($mailFilter === 'sent') {
        $sql .= " AND mailsent = 1";
        $filterNotice[] = "Mail: <strong>Sent</strong>";
    } elseif ($mailFilter === 'not_sent') {
        $sql .= " AND (mailsent = 0 OR mailsent IS NULL)";
        $filterNotice[] = "Mail: <strong>Not Sent</strong>";
    }
    $filterApplied = true;
}

$sql .= " ORDER BY created_at DESC LIMIT 2000";
$result = $con ? $con->query($sql) : null;
?>

<style>
    /* Full screen overlay */
    #processing-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    
    .loader {
        border: 8px solid #f3f3f3;
        border-radius: 50%;
        border-top: 8px solid #3498db;
        width: 60px;
        height: 60px;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .loading-text {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    /* Simple Modal Style (If bootstrap modal fails or just simple override) */
    .modal-header { background: #f1f1f1; }
</style>

<div id="processing-overlay">
    <div class="loader"></div>
    <div class="loading-text">Processing... Please Wait</div>
</div>

<div class="page-wrapper">
    <div class="page-content">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Submission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Verified Callback Requests</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Verified Callback Submissions</h6>
        <hr />

        <div class="search-cont mb-3">
            <form method="post" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; background: #f9f9f9; padding: 15px; border-radius: 6px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                <input type="date" name="datef" value="<?= htmlspecialchars($datef) ?>" style="flex: 1 1 150px; padding: 5px;">
                <input type="date" name="datel" value="<?= htmlspecialchars($datel) ?>" style="flex: 1 1 150px; padding: 5px;">
                <input type="text" name="universal" placeholder="Search by Name, Reg ID, Mobile..." value="<?= htmlspecialchars($searchText) ?>" style="flex: 2 1 200px; padding: 5px;">

                <select name="state" style="flex: 1 1 150px; padding: 5px;">
                    <option value="">All States</option>
                    <?php
                    $stateRes = $con ? $con->query("SELECT DISTINCT state FROM `register-second` WHERE state!='' ORDER BY state") : null;
                    if ($stateRes) {
                        while ($s = $stateRes->fetch_assoc()) {
                            $sel = ($s['state'] === $stateFilter) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($s['state']) . "' $sel>" . htmlspecialchars($s['state']) . "</option>";
                        }
                    }
                    ?>
                </select>

                <select name="status" style="flex: 1 1 150px; padding: 5px;">
                    <option value="">All Payments</option>
                    <option value="Success" <?= $statusFilter == 'Success' ? 'selected' : '' ?>>Paid (Success)</option>
                    <option value="Pending" <?= $statusFilter == 'Pending' ? 'selected' : '' ?>>Unpaid (Pending)</option>
                </select>
                <select name="mail_status" style="flex: 1 1 150px; padding: 5px;">
                    <option value="">All Mail Status</option>
                    <option value="sent" <?= $mailFilter == 'sent' ? 'selected' : '' ?>>Mail Sent</option>
                    <option value="not_sent" <?= $mailFilter == 'not_sent' ? 'selected' : '' ?>>Mail Not Sent</option>
                </select>
                
                <select name="age_group" style="flex: 1 1 150px; padding: 5px;">
                    <option value="">All Age Groups</option>
                    <?php
                    $ageRes = $con ? $con->query("SELECT DISTINCT `age` as ag FROM `register-second` WHERE `age`!='' ORDER BY `age`") : null;
                    if ($ageRes) {
                        while ($a = $ageRes->fetch_assoc()) {
                            $ageValue = htmlspecialchars($a['ag']);
                            $sel = ($ageValue === $ageGroupFilter) ? 'selected' : '';
                            echo "<option value='{$ageValue}' $sel>{$ageValue}</option>";
                        }
                    }
                    ?>
                </select>

                <input type="submit" value="Apply Filter" class="btn btn-primary btn-sm" style="flex: 0 0 auto; padding: 6px 12px;">
                <?php if ($filterApplied): ?>
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-danger btn-sm" style="flex: 0 0 auto; padding: 6px 12px;">Clear Filter</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if (!empty($filterNotice)): ?>
            <div class="alert alert-info"><?= implode(' &nbsp;|&nbsp; ', $filterNotice) ?></div>
        <?php endif; ?>

        <div class="card bg">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Reg IDs</th>
                                <th>Player</th>
                                <th>State</th>
                                <th>T-Shirt</th>
<th>Food</th>
                                <th>Amount</th>
                                <th>Age Group</th>
                                <th>Payment ID</th>
                                <th>Pay Date</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    // Status Badge logic
                                    if (($row['status'] ?? '') === 'Success') {
                                        $statusBadge = '<button class="btn btn-success btn-sm" disabled>Success</button>';
                                    } else {
                                        $targetUrl = "../send-second.php?id=" . ($row['id'] ?? '');
                                        $statusBadge = '<button class="btn btn-warning btn-sm" onclick="confirmAndProcessing(\'' . $targetUrl . '\')">Mark Success</button>';
                                    }

                                    // PDF Button
                                    $pdfBtn = '';
                                    if (($row['status'] ?? '') === 'Success') {
                                        $pdfBtn = '<a href="../pdf_second.php?reg=' . urlencode($row['reg']) . '" 
                                                target="_blank" class="btn btn-success btn-sm me-1">PDF</a>';
                                    }

                                    // Delete Button
                                    $deleteBtn = '';
                                    if (($row['status'] ?? '') !== 'Success') {
                                        $deleteBtn = '<a href="?delete=' . ($row['id'] ?? '') . '" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="return confirm(\'Are you sure you want to delete this record?\')">Delete</a>';
                                    }

                                    // ---- 2. EDIT BUTTON (NEW) ----
                                    // We store data in data-attributes to pass to the modal easily
                                    $editDataParams = "
                                        data-id='" . $row['id'] . "' 
                                        data-name='" . htmlspecialchars($row['name'] ?? '', ENT_QUOTES) . "' 
                                        data-mobile='" . htmlspecialchars($row['mobile'] ?? '', ENT_QUOTES) . "' 
                                        data-amount='" . htmlspecialchars($row['amount'] ?? '', ENT_QUOTES) . "' 
                                        data-state='" . htmlspecialchars($row['state'] ?? '', ENT_QUOTES) . "' 
                                        data-age='" . htmlspecialchars($row['age'] ?? '', ENT_QUOTES) . "'
                                    ";
                                    
                                    $editBtn = '<button type="button" class="btn btn-primary btn-sm me-1" 
                                                ' . $editDataParams . ' 
                                                onclick="openEditModal(this)">Edit</button>';

                                    echo "<tr>
                                            <td>" . ++$count . "</td>
                                            <td>" . htmlspecialchars($row['name'] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row['mobile'] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row['email'] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row['reg'] ?? '') . "<br>" . htmlspecialchars($row['reg2'] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row['player'] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row['state'] ?? '') . "</td>
                                             <td>" . htmlspecialchars($row['tshirt_size'] ?? '') . "</td>
                                              <td>" . htmlspecialchars($row['food_pref'] ?? '') . "</td>
                                            
                                            <td>" . htmlspecialchars($row['amount'] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row['age'] ?? 'N/A') . "</td>
                                            <td>" . htmlspecialchars($row['Paymentid'] ?? '') . "</td>
                                            <td>" . htmlspecialchars($row['paydate'] ?? '') . "</td>
                                            <td>$statusBadge</td>
                                            <td>" . htmlspecialchars($row['created_at'] ?? '') . "</td>
                                            <td style='white-space:nowrap;'>
                                                $editBtn
                                                $pdfBtn
                                                $deleteBtn
                                            </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='14' style='text-align:center;'>No Results Found</td></tr>";
                            }

                            if (isset($ageRes)) $ageRes->close();
                            if (isset($stateRes)) $stateRes->close();
                            if (isset($result)) $result->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'searchbar.php'; ?>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="modal_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="edit_name" id="modal_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mobile</label>
                        <input type="text" class="form-control" name="edit_mobile" id="modal_mobile" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="text" class="form-control" name="edit_amount" id="modal_amount">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="edit_state" id="modal_state">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Age Group</label>
                        <input type="text" class="form-control" name="edit_age" id="modal_age">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_record" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Logic for Processing Overlay
function confirmAndProcessing(url) {
    if (confirm('Are you sure you want to mark this as Success?')) {
        document.getElementById('processing-overlay').style.display = 'flex';
        window.location.href = url;
    }
}

// Logic for Edit Modal (NEW)
function openEditModal(btn) {
    // 1. Get data from button attributes
    var id = btn.getAttribute('data-id');
    var name = btn.getAttribute('data-name');
    var mobile = btn.getAttribute('data-mobile');
    var amount = btn.getAttribute('data-amount');
    var state = btn.getAttribute('data-state');
    var age = btn.getAttribute('data-age');

    // 2. Set values in Modal Inputs
    document.getElementById('modal_id').value = id;
    document.getElementById('modal_name').value = name;
    document.getElementById('modal_mobile').value = mobile;
    document.getElementById('modal_amount').value = amount;
    document.getElementById('modal_state').value = state;
    document.getElementById('modal_age').value = age;

    // 3. Show Modal (Using Bootstrap 5 syntax)
    var myModal = new bootstrap.Modal(document.getElementById('editModal'));
    myModal.show();
}
</script>