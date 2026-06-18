<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

include 'head.php';
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<style>
.badge-success {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
.badge-danger {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
.modal-background {
    backdrop-filter: blur(5px);
}
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Submission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Player Registrations</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Registered Players</h6>
        <hr />



        <!-- Table Card -->
        <div class="card bg">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Reg. Code</th>
                                <th>Age</th>
                                <th>Role</th>
                                <th>Reg Date</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Mail Sent</th>
                                <th>State</th>
                                <th>Reference</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
// Initialize variables
$datef = $_POST['datef'] ?? '';
$datel = $_POST['datel'] ?? '';
$searchText = trim($_POST['universal'] ?? '');
$stateFilter = $_POST['state'] ?? '';
$playerFilter = $_POST['player'] ?? '';
$statusFilter = $_POST['status'] ?? '';
$filterApplied = false;
$filterNotice = [];

// Base query
$sql = "SELECT * FROM register WHERE 1";

// Apply filters
if (!empty($datef)) {
    $sql .= " AND DATE(`date`) >= '$datef'";
    $filterNotice[] = "From <strong>$datef</strong>";
    $filterApplied = true;
}
if (!empty($datel)) {
    $sql .= " AND DATE(`date`) <= '$datel'";
    $filterNotice[] = "To <strong>$datel</strong>";
    $filterApplied = true;
}
if (!empty($searchText)) {
    $escapedSearch = $con->real_escape_string($searchText);
    $sql .= " AND (
        name LIKE '%$escapedSearch%' OR
        reg LIKE '%$escapedSearch%' OR
        email LIKE '%$escapedSearch%' OR
        mobile LIKE '%$escapedSearch%' OR
        state LIKE '%$escapedSearch%' OR
        ref LIKE '%$escapedSearch%' OR
        player LIKE '%$escapedSearch%'
    )";
    $filterNotice[] = "Search: <strong>" . htmlspecialchars($searchText) . "</strong>";
    $filterApplied = true;
}
if (!empty($stateFilter)) {
    $sql .= " AND state = '" . $con->real_escape_string($stateFilter) . "'";
    $filterNotice[] = "State: <strong>" . htmlspecialchars($stateFilter) . "</strong>";
    $filterApplied = true;
}
if (!empty($playerFilter)) {
    $sql .= " AND player = '" . $con->real_escape_string($playerFilter) . "'";
    $filterNotice[] = "Role: <strong>" . htmlspecialchars($playerFilter) . "</strong>";
    $filterApplied = true;
}
if (!empty($statusFilter)) {
    $sql .= " AND status = '" . $con->real_escape_string($statusFilter) . "'";
    $filterNotice[] = "Status: <strong>" . htmlspecialchars($statusFilter) . "</strong>";
    $filterApplied = true;
}

$sql .= " ORDER BY 
    CASE 
        WHEN `date` IS NULL OR `date` = '' THEN 1 
        ELSE 0 
    END,
    `date` DESC,
    `created_at` DESC 
    LIMIT 2000";
$result = $con->query($sql);

// Role short form
$roleShorts = [
    'Batsman' => 'BAT',
    'Bowler' => 'BWL',
    'All Rounder' => 'AR',
    'Wicketkeeper/Batsman' => 'WK',
];
?>

<div class="search-cont mb-3">
    <form method="post" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; background: #f9f9f9; padding: 15px; border-radius: 6px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
        <input type="date" name="datef" value="<?= htmlspecialchars($datef) ?>" style="flex: 1 1 150px; padding: 5px;">
        <input type="date" name="datel" value="<?= htmlspecialchars($datel) ?>" style="flex: 1 1 150px; padding: 5px;">
        <input type="text" name="universal" placeholder="Search by Name, Reg Code, etc." value="<?= htmlspecialchars($searchText) ?>" style="flex: 2 1 200px; padding: 5px;">

        <select name="state" style="flex: 1 1 150px; padding: 5px;">
            <option value="">All States</option>
            <?php
            $stateRes = $con->query("SELECT DISTINCT state FROM register WHERE state IS NOT NULL AND state != '' ORDER BY state");
            while ($s = $stateRes->fetch_assoc()) {
                $sel = ($s['state'] === $stateFilter) ? 'selected' : '';
                echo "<option value=\"{$s['state']}\" $sel>{$s['state']}</option>";
            }
            ?>
        </select>

        <select name="player" style="flex: 1 1 150px; padding: 5px;">
            <option value="">All Roles</option>
            <?php
            $roles = ["Batsman", "Bowler", "All Rounder", "Wicketkeeper/Batsman"];
            foreach ($roles as $role) {
                $sel = ($role === $playerFilter) ? 'selected' : '';
                echo "<option value=\"$role\" $sel>$role</option>";
            }
            ?>
        </select>

        <select name="status" style="flex: 1 1 150px; padding: 5px;">
            <option value="">All Statuses</option>
            <option value="Success" <?= $statusFilter == 'Success' ? 'selected' : '' ?>>Success</option>
            <option value="Pending" <?= $statusFilter == 'Pending' ? 'selected' : '' ?>>Pending</option>
        </select>

        <input type="submit" value="Apply Filter" class="btn btn-primary btn-sm" style="flex: 0 0 auto; padding: 6px 12px;">

        <?php if ($filterApplied): ?>
            <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-danger btn-sm" style="flex: 0 0 auto; padding: 6px 12px;">Clear Filter</a>
        <?php endif; ?>
    </form>
</div>

<!-- Filter Applied Notice -->
<?php if (!empty($filterNotice)): ?>
    <div class="alert alert-info"><?= implode(' &nbsp;|&nbsp; ', $filterNotice) ?></div>
<?php endif; ?>

<!-- Table Rows -->
<?php
if ($result && $result->num_rows > 0) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $shortRole = $roleShorts[$row['player']] ?? $row['player'];

        // Status Badge
        if ($row['status'] === 'Success') {
            $statusBadge = '<button class="btn btn-success btn-sm" disabled>Success</button>';
        } else {
            $statusBadge = '<a href="../send.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm" onclick="return confirm(\'Are you sure you want to mark this as Success?\')">Mark Success</a>';
        }

        echo "<tr>
            <td>" . ++$count . "</td>
            <td>" . htmlspecialchars($row['name'] ?? '', ENT_QUOTES) . "</td>
            <td>
                <a href=\"#\" class=\"openModal\" data-details='" . htmlspecialchars(json_encode($row), ENT_QUOTES) . "'>
                    " . htmlspecialchars($row['reg'] ?? '', ENT_QUOTES) . "
                </a>
            </td>
            <td>" . htmlspecialchars($row['age'] ?? '', ENT_QUOTES) . "</td>  
            <td>" . htmlspecialchars($shortRole ?? '', ENT_QUOTES) . "</td>
            <td>" . htmlspecialchars($row['date'] ?? '', ENT_QUOTES) . "</td>       
            <td>" . htmlspecialchars($row['email'] ?? '', ENT_QUOTES) . "</td>
            <td>" . htmlspecialchars($row['mobile'] ?? '', ENT_QUOTES) . "</td>
            <td>" . ($row['mailsent'] ? 'Yes' : 'No') . "</td>
            <td>" . htmlspecialchars($row['state'] ?? '', ENT_QUOTES) . "</td>
            <td>" . htmlspecialchars($row['ref'] ?? '', ENT_QUOTES) . "</td>
            <td>" . $statusBadge . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='14' style='text-align:center;'>No Results Found</td></tr>";
}
$con->close();
?>

                        <!-- PHP code block to render rows goes here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="playerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-background" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Player Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent"></div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-background" role="document">
    <div class="modal-content">
      <form method="post" action="update_player.php">
        <div class="modal-header">
          <h5 class="modal-title">Edit Player Details</h5>
          <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body" id="editModalContent"></div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.openModal').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const data = JSON.parse(this.dataset.details);

        // Style for modal if status is 'Success'
        const isSuccess = data.status === 'Success';
        const modalStyle = isSuccess
            ? 'background-color:#e6ffe6; border: 2px solid #28a745; padding:15px; border-radius:10px;'
            : '';

        // Start HTML content
        let html = `<div style="${modalStyle}"><table class="table table-bordered">`;
               // Parse created_at datetime
const datetime = data.created_at ?? '';
let formattedDate = '', formattedTime = '';

if (datetime) {
    const dt = new Date(datetime);
    formattedDate = dt.toLocaleDateString('en-IN', { day: '2-digit', month: '2-digit', year: 'numeric' });
    formattedTime = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', hour12: true });
}

        // Reg Code highlighted
        html += `<tr><th>Reg. Code</th><td><span style="font-weight:bold; font-size:16px; color:#007bff;">${data.reg ?? ''}</span></td></tr>`;
        html += `<tr><th>Name</th><td>${data.name ?? ''}</td></tr>`;
        html += `<tr><th>Age</th><td>${data.age ?? ''}</td></tr>`;
        html += `<tr><th>Role</th><td>${data.player ?? ''}</td></tr>`;
        html += `<tr><th>Registration Date</th><td>${formattedDate} at ${formattedTime}</td></tr>`;
        html += `<tr><th>Payment Date Date</th><td>${data.date ?? ''}</td></tr>`;
        html += `<tr><th>Email</th><td>${data.email ?? ''}</td></tr>`;
        html += `<tr><th>Mobile</th><td>${data.mobile ?? ''}</td></tr>`;
        html += `<tr><th>Mail Sent</th><td>${data.mailsent == 1 ? 'Yes' : 'No'}</td></tr>`;
        html += `<tr><th>State</th><td>${data.state ?? ''}</td></tr>`;
        html += `<tr><th>City</th><td>${data.city ?? ''}</td></tr>`;
        html += `<tr><th>Reference</th><td>${data.ref ?? ''}</td></tr>`;
        html += `<tr><th>Status</th><td><strong style="color: ${isSuccess ? 'green' : 'red'}">${data.status ?? ''}</strong></td></tr>`;
        html += '</table>';

        html += `<div class="text-end mt-3">`;

        // Show PDF button only if Success
        if (isSuccess) {
            html += `<a href="../pdf1.php?reg=${encodeURIComponent(data.reg)}" target="_blank" class="btn btn-success me-2">
                        <i class="bx bxs-file-pdf"></i> Download PDF
                     </a>`;
        }

        // Edit button
        html += `<button class="btn btn-warning" onclick="openEditModal(${JSON.stringify(data).replace(/"/g, '&quot;')})">
                    <i class="bx bxs-edit"></i> Edit
                 </button>`;

        html += `</div></div>`;

        document.getElementById('modalContent').innerHTML = html;
        new bootstrap.Modal(document.getElementById('playerModal')).show();
    });
});


function openEditModal(data) {
    const html = `
        <input type="hidden" name="id" value="${data.id}">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="${data.name}" class="form-control" required>
        </div>
        <div class="form-group mt-2">
            <label>Age</label>
            <input type="number" name="age" value="${data.age}" class="form-control" required>
        </div>
        <div class="form-group mt-2">
            <label>Reg Code</label>
            <input type="text" name="reg" value="${data.reg}" class="form-control" readonly>
        </div>
        <div class="form-group mt-2">
            <label>Email</label>
            <input type="email" name="email" value="${data.email}" class="form-control">
        </div>
        <div class="form-group mt-2">
            <label>Mobile</label>
            <input type="text" name="mobile" value="${data.mobile}" class="form-control">
        </div>
        <div class="form-group mt-2">
            <label>Reference</label>
            <input type="text" name="ref" value="${data.ref}" class="form-control">
        </div>
    `;
    document.getElementById('editModalContent').innerHTML = html;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>




<?php include 'searchbar.php'; ?>