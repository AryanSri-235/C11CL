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

$sql .= " ORDER BY created_at DESC LIMIT 2000";
$result = $con->query($sql);
?>

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
                    $stateRes = $con->query("SELECT DISTINCT state FROM `register-second` WHERE state!='' ORDER BY state");
                    if ($stateRes) {
                        while ($s = $stateRes->fetch_assoc()) {
                            $sel = ($s['state'] === $stateFilter) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($s['state']) . "' $sel>" . htmlspecialchars($s['state']) . "</option>";
                        }
                    }
                    ?>
                </select>

                <select name="status" style="flex: 1 1 150px; padding: 5px;">
                    <option value="">All Status</option>
                    <option value="Success" <?= $statusFilter == 'Success' ? 'selected' : '' ?>>Success</option>
                    <option value="Pending" <?= $statusFilter == 'Pending' ? 'selected' : '' ?>>Pending</option>
                </select>
                
                <select name="age_group" style="flex: 1 1 150px; padding: 5px;">
                    <option value="">All Age Groups</option>
                    <?php
                    $ageRes = $con->query("SELECT DISTINCT age FROM `register-second` WHERE age!='' ORDER BY age");
                    if ($ageRes) {
                        while ($a = $ageRes->fetch_assoc()) {
                            $ageValue = htmlspecialchars($a['age']);
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
                                        $statusBadge = '<a href="../send-second.php?id=' . ($row['reg2'] ?? '') . '" class="btn btn-warning btn-sm" onclick="return confirm(\'Are you sure you want to mark this as Success?\')">Mark Success</a>';
                                    }

                                    // PDF Button only for Success
$pdfBtn = '';
if (($row['status'] ?? '') === 'Success') {
    $pdfBtn = '<a href="../pdf_second.php?reg=' . urlencode($row['reg']) . '" 
                target="_blank"
                class="btn btn-success btn-sm me-2">PDF</a>';
}

// Delete Button only if NOT Success
if (($row['status'] ?? '') === 'Success') {
    $deleteBtn = '';
} else {
    $deleteBtn = '<a href="?delete=' . ($row['id'] ?? '') . '" 
                    class="btn btn-danger btn-sm" 
                    onclick="return confirm(\'Are you sure you want to delete this record?\')">
                    Delete
                 </a>';
}


                                    echo "<tr>
                                        <td>" . ++$count . "</td>
                                        <td>" . htmlspecialchars($row['name'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['mobile'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['email'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['reg'] ?? '') . "<br>" . htmlspecialchars($row['reg2'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['player'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['state'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['amount'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['age'] ?? 'N/A') . "</td>
                                        <td>" . htmlspecialchars($row['Paymentid'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['paydate'] ?? '') . "</td>
                                        <td>$statusBadge</td>
                                        <td>" . htmlspecialchars($row['created_at'] ?? '') . "</td>
                                        <td>$pdfBtn $deleteBtn</td>

                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='14' style='text-align:center;'>No Results Found</td></tr>";
                            }

                            if (isset($ageRes)) $ageRes->close();
                            if (isset($stateRes)) $stateRes->close();
                            if (isset($result)) $result->close();
                            $con->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'searchbar.php'; ?>
