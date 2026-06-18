<?php
session_start();

/* 🔒 Login check */
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

/* 🔐 Role check */
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'superadmin') {

    $currentStatus = $_SESSION['status'] ?? 'Unknown';

    echo "
    <div style='
        margin: 80px auto;
        max-width: 500px;
        padding: 25px;
        border-radius: 10px;
        background: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
        font-family: Arial;
        text-align: center;
    '>
        <h3>Access Denied 🚫</h3>
        <p>
            Aapka status <strong>{$currentStatus}</strong> hai.<br>
            Aapko is page ka access nahi hai.
        </p>
        <a href='dashboard.php' style='
            display:inline-block;
            margin-top:15px;
            padding:8px 15px;
            background:#0f172a;
            color:#fff;
            text-decoration:none;
            border-radius:5px;
        '>Go Back</a>
    </div>";
    exit();
}

include 'head.php';
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<style>
/* 🛠️ Global override: #94a3b8 ko black karne ke liye */

/* Agar aapne class use ki hai to */
.p-sub, .text-muted, div[style*="color:#94a3b8"], div[style*="color: #94a3b8"] {
    color: #000000 !important;
}

/* Sabhi elements par check karne ke liye (Sabse effective) */
[style*="color:#94a3b8"], [style*="color: #94a3b8"] {
    color: #000000 !important;
}
</style>

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
       <div class="page-breadcrumb d-flex align-items-center" style="margin-bottom: 10px; background: #fff; padding: 5px 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
    <div class="breadcrumb-title" style="border-right: 2px solid #e2e8f0; padding-right: 10px; font-weight: 700; font-size: 13px; color: #475569; text-transform: uppercase;">
        Submission
    </div>
    <div class="ps-2" style="flex-grow: 1;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="margin-bottom: 0; padding: 0; background: transparent; display: flex; align-items: center; list-style: none; gap: 8px;">
                <li class="breadcrumb-item" style="display: flex; align-items: center;">
                    <a href="dashboard.php" style="color: #2563eb; text-decoration: none; font-size: 16px;">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li style="color: #94a3b8; font-size: 12px;">/</li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #64748b; font-size: 13px; font-weight: 600; white-space: nowrap;">
                    Player Registrations
                </li>
            </ol>
        </nav>
    </div>
</div>
<style>
    .filter-card { background: #fff; padding: 15px; border-radius: 10px; border: 1px solid #e0e0e0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .f-grid { display: flex; flex-wrap: nowrap; gap: 8px; align-items: center; }
    .f-field { height: 35px; padding: 5px 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 13px; outline: none; flex: 1; min-width: 0; }
    .f-search { flex: 2; }
    .btn-apply { background: #007bff; color: #fff; border: none; padding: 0 15px; height: 35px; border-radius: 5px; font-weight: bold; cursor: pointer; }
    .btn-clear { background: #dc3545; color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-weight: bold; font-size: 12px; }
    
   

    @media (max-width: 1100px) { .f-grid { flex-wrap: wrap; } .f-field { flex: 1 1 30%; } .f-search { flex: 1 1 100%; } }
</style>
        
        <hr />
        <!-- Table Card -->
        <div class="card bg">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                   <thead>
    <tr>
        <th class="text-center" style="width:40px;">#</th>
        <th>Player Info</th>
        <th>Age</th>
        <th>Reg. Code</th>
        <th>Role</th>
        <th>Mobile</th>
        <th>Timing</th>
        <th>Mail</th>
        <th>Location</th>
        <th>Ref</th>
        <th>Attem</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>
                        <tbody>
                         <?php
// --- Logic: Filters & Sorting ---
$datef = $_POST['datef'] ?? '';
$datel = $_POST['datel'] ?? '';
$searchText = trim($_POST['universal'] ?? '');
$stateFilter = $_POST['state'] ?? '';
$playerFilter = $_POST['player'] ?? '';
$statusFilter = $_POST['status'] ?? '';
$quick_filter = $_POST['quick_filter'] ?? '';
$filterApplied = false;
$filterNotice = [];

// Quick Date Range Logic
if (!empty($quick_filter)) {
    $filterApplied = true;
    if ($quick_filter == 'today') { $datef = $datel = date('Y-m-d'); $filterNotice[] = "Today"; }
    elseif ($quick_filter == 'yesterday') { $datef = $datel = date('Y-m-d', strtotime("-1 days")); $filterNotice[] = "Yesterday"; }
    elseif ($quick_filter == 'this_week') { $datef = date('Y-m-d', strtotime("monday this week")); $datel = date('Y-m-d', strtotime("sunday this week")); $filterNotice[] = "This Week"; }
    elseif ($quick_filter == 'this_month') { $datef = date('Y-m-01'); $datel = date('Y-m-t'); $filterNotice[] = "This Month"; }
}

$sql = "SELECT * FROM register WHERE 1";

if (!empty($datef)) { $sql .= " AND DATE(`date`) >= '$datef'"; if(!$quick_filter) $filterNotice[] = "From $datef"; $filterApplied = true; }
if (!empty($datel)) { $sql .= " AND DATE(`date`) <= '$datel'"; if(!$quick_filter) $filterNotice[] = "To $datel"; $filterApplied = true; }

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
    $filterNotice[] = "Search: " . htmlspecialchars($searchText);
    $filterApplied = true;
}
if (!empty($stateFilter)) { $sql .= " AND state = '".$con->real_escape_string($stateFilter)."'"; $filterNotice[] = "State: $stateFilter"; $filterApplied = true; }
if (!empty($playerFilter)) { $sql .= " AND player = '".$con->real_escape_string($playerFilter)."'"; $filterNotice[] = "Role: $playerFilter"; $filterApplied = true; }
if (!empty($statusFilter)) { $sql .= " AND status = '".$con->real_escape_string($statusFilter)."'"; $filterNotice[] = "Status: $statusFilter"; $filterApplied = true; }

// Smart Sorting: Greatest of Update or Created At
$sql .= " ORDER BY GREATEST(COALESCE(`up`, '1000-01-01 00:00:00'), `created_at`) DESC LIMIT 3000";
$result = $con->query($sql);

$roleShorts = ['Batsman'=>'BAT', 'Bowler'=>'BWL', 'All Rounder'=>'AR', 'Wicketkeeper/Batsman'=>'WK'];

?>

 <div class="filter-card">
            <form method="post" class="f-grid">
                <input type="text" name="universal" class="f-field f-search" placeholder="🔍 Search Player..." value="<?= $searchText ?>">
                <select name="quick_filter" class="f-field" onchange="this.form.submit()" style="background:#f1f5f9; font-weight:bold;">
                    <option value="">⏱️ Quick Range</option>
                    <option value="today" <?= $quick_filter == 'today' ? 'selected' : '' ?>>Today</option>
                    <option value="yesterday" <?= $quick_filter == 'yesterday' ? 'selected' : '' ?>>Yesterday</option>
                    <option value="this_week" <?= $quick_filter == 'this_week' ? 'selected' : '' ?>>This Week</option>
                    <option value="this_month" <?= $quick_filter == 'this_month' ? 'selected' : '' ?>>This Month</option>
                </select>
                <input type="date" name="datef" class="f-field" value="<?= $datef ?>">
                <input type="date" name="datel" class="f-field" value="<?= $datel ?>">
                <select name="state" class="f-field">
                    <option value="">📍 State</option>
                    <?php
                    $stateRes = $con->query("SELECT DISTINCT state FROM register WHERE state != '' ORDER BY state");
                    while ($s = $stateRes->fetch_assoc()) { echo "<option value='{$s['state']}' ".($s['state']==$stateFilter?'selected':'').">{$s['state']}</option>"; }
                    ?>
                </select>
                <select name="player" class="f-field">
                    <option value="">🏏 Role</option>
                     <?php
            $roles = ["Batsman", "Bowler", "All Rounder", "Wicketkeeper/Batsman"];
            foreach ($roles as $role) {
                $sel = ($role === $playerFilter) ? 'selected' : '';
                echo "<option value=\"$role\" $sel>$role</option>";
            }
            ?>
                </select>
                 <select name="status" class="f-field">
                    <option value="">All Statuses</option>
            <option value="Success" <?= $statusFilter == 'Success' ? 'selected' : '' ?>>Success</option>
            <option value="Pending" <?= $statusFilter == 'Pending' ? 'selected' : '' ?>>Pending</option>
                </select>
                <button type="submit" class="btn-apply">Apply</button>
                <?php if ($filterApplied): ?> <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn-clear">Clear</a> <?php endif; ?>
                <button type="button" onclick="exportToExcel()" class="btn-export" style="background:#16a34a; color:#fff; border:none; padding:0 15px; height:35px; border-radius:5px; font-weight:bold; cursor:pointer; margin-left:5px;">
    <i class='bx bx-spreadsheet'></i> Excel Export
</button>
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

// Status Button and Action Buttons
$statusButton = '';
$actionButtons = '';
$isSuccess = $row['status'] === 'Success';

if ($isSuccess) {
    $statusButton = '<button class="btn btn-success btn-sm" disabled>Success</button>';
} else {
    $statusButton = '<a href="../send.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm" onclick="return confirm(\'Are you sure you want to mark this as Success?\')">Mark Success</a>';
    $actionButtons = '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $row['id'] . '">Delete</button>';
}
// loop ke andar...
$isSuccess = $row['status'] === 'Success';
$shortRole = $roleShorts[$row['player']] ?? $row['player'];
$regCount = $row['regCount'] ?? 0;

// 1. Success Row Highlight
$rowStyle = $isSuccess ? "style='background-color: #dcfce7 !important;'" : "";

// 2. Updated State Color Logic with Diverse Palette
$stateColors = [
    'Andhra Pradesh'   => '#0284c7', // Ocean Blue
    'Assam'            => '#059669', // Emerald Green
    'Bihar'            => '#b91c1c', // Deep Red
    'Chandigarh'       => '#4b5563', // Slate Gray
    'Chhattisgarh'     => '#d97706', // Amber
    'Delhi'            => '#2563eb', // Royal Blue
    'Goa'              => '#db2777', // Pink/Magenta
    'Gujarat'          => '#ea580c', // Bright Orange
    'Haryana'          => '#16a34a', // Forest Green
    'Himachal Pradesh' => '#0891b2', // Cyan/Sky
    'Jammu and Kashmir'=> '#4f46e5', // Indigo
    'Jharkhand'        => '#84cc16', // Lime
    'Karnataka'        => '#7c3aed', // Purple
    'Madhya Pradesh'   => '#9333ea', // Deep Purple
    'Maharashtra'      => '#f97316', // Orange
    'Odisha'           => '#0d9488', // Teal
    'Punjab'           => '#dc2626', // Red
    'Rajasthan'        => '#be123c', // Crimson
    'Tamil Nadu'       => '#4338ca', // Dark Indigo
    'Telangana'        => '#c026d3', // Fuchsia
    'Uttar Pradesh'    => '#7c2d12', // Brown/Rust
    'Uttarakhand'      => '#0369a1', // Dark Blue
    'West Bengal'      => '#be185d'  // Rose
];

// 1. Dono dates ko compare karke Latest nikalne ka logic
$regTime = strtotime($row['created_at']);
$upTime = !empty($row['up']) ? strtotime($row['up']) : 0;

if ($upTime > $regTime) {
    // Agar Update (up) naya hai
    $displayTime = date("d M, h:i A", $upTime);
    $timeIcon = "<i class='bx bx-edit-alt' title='Updated Time' style='color:#2563eb;'></i>"; 
} else {
    // Agar Registration naya hai
    $displayTime = date("d M, h:i A", $regTime);
    $timeIcon = "<i class='bx bx-plus-circle' title='Registration Time' style='color:#10b981;'></i>";
}
// Database mein 'Uttar Pradesh' ho sakta hai ya 'UP', uska handle:
$currentState = $row['state'];
$stColor = $stateColors[$currentState] ?? '#64748b'; // Default Gray if not found

// 3. Text Shortener
$refText = htmlspecialchars($row['ref'] ?? '');
$shortRef = (strlen($refText) > 12) ? substr($refText, 0, 12) . "..." : $refText;

// 4. Time Formatting
$formattedTime = date("d M, h:i A", strtotime($row['created_at']));

echo "<tr $rowStyle>
    <td class='text-center text-muted' style='font-size:11px;'>" . ++$count . "</td>
    
    <td data-export-name='".htmlspecialchars($row['name'])."' data-export-email='".htmlspecialchars($row['email'])."'>
        <div style='font-weight:700; color:#1e293b; line-height:1.2;'>" . htmlspecialchars($row['name']) . "</div>
        <div style='font-size:10px; color:#94a3b8;'>" . htmlspecialchars($row['email']) . "</div>
    </td>

    <td class='text-center'><strong>" . $row['age'] . "</strong></td>

    <td>
        <a href='#' class='openModal' style='font-family:monospace; font-weight:700; color:#2563eb; background:#f1f5f9; padding:2px 5px; border-radius:4px; text-decoration:none;' data-details='" . htmlspecialchars(json_encode($row), ENT_QUOTES) . "'>
            " . $row['reg'] . "
        </a>
    </td>

    <td><span class='badge-role'>$shortRole</span></td>

    <td style='font-weight:600; font-size:12px;'>" . $row['mobile'] . "</td>

    <td style='white-space:nowrap;' data-export-time='$displayTime'>
        <div style='display: flex; align-items: center; gap: 5px;'>
            $timeIcon
            <div style='line-height: 1;'>
                <div style='font-size: 11px; font-weight: 700; color: #000;'>$displayTime</div>
                <div style='font-size: 9px; color: #64748b; text-transform: uppercase; margin-top: 2px;'>Latest Activity</div>
            </div>
        </div>
    </td>

    <td class='text-center'>
        " . ($row['mailsent'] 
            ? "<i class='bx bxs-check-circle text-success' title='Mail Sent' style='font-size:18px;'></i>" 
            : "<i class='bx bxs-x-circle text-danger' title='Not Sent' style='font-size:18px;'></i>") . "
    </td>

    <td data-export-state='".htmlspecialchars($row['state'])."' data-export-city='".htmlspecialchars($row['city'])."'>
        <span style='color:#fff; background:$stColor; padding:1px 5px; border-radius:4px; font-size:10px; font-weight:700; text-transform:uppercase; display:inline-block;'>" . $row['state'] . "</span>
        <div style='font-size:10px; color:#94a3b8; margin-top:2px;'><i class='bx bx-map-pin' style='font-size:9px;'></i> " . $row['city'] . "</div>
    </td>

    <td>
        <div style='font-size:11px; font-weight:600; color:#2563eb;' title='$refText'>$shortRef</div>
        <div style='font-size:10px; color:#94a3b8;'>".$row['source']."</div>
    </td>

    <td class='text-center'>
        <span class='badge bg-light text-dark border'>" . ($regCount > 0 ? $regCount - 1 : 0) . "</span>
    </td>

    <td class='text-center'>
        " . ($isSuccess 
            ? "<span class='badge bg-success shadow-sm' style='padding:5px 10px; font-size:10px;'><i class='bx bx-check-double'></i> Success</span>" 
            : "<a href='../send.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")' class='btn btn-xs btn-warning' style='font-size:10px; font-weight:800; padding:2px 8px; border-radius:4px; text-transform:uppercase;'>Mark Success</a>") . "
    </td>

    <td class='text-end' style='width:50px;'>
        " . (!$isSuccess 
            ? "<button class='btn btn-link text-danger p-0 delete-btn' data-id='" . $row['id'] . "'><i class='bx bx-trash' style='font-size:18px;'></i></button>" 
            : "<span class='text-muted' style='font-size:10px;'>-</span>") . "
    </td>
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this player's record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
            </div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Main logic for opening the view modal (unchanged)
    document.querySelectorAll('.openModal').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const data = JSON.parse(this.dataset.details);

            // ... (View Modal HTML generation logic remains here) ...

            const isSuccess = data.status === 'Success';
            const modalStyle = isSuccess
                ? 'background-color:#e6ffe6; border: 2px solid #28a745; padding:15px; border-radius:10px;'
                : '';

            let html = `<div style="${modalStyle}"><table class="table table-bordered">`;
            const datetime = data.created_at ?? '';
            let formattedDate = '', formattedTime = '';

            if (datetime) {
                const dt = new Date(datetime);
                formattedDate = dt.toLocaleDateString('en-IN', { day: '2-digit', month: '2-digit', year: 'numeric' });
                formattedTime = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', hour12: true });
            }

            html += `<tr><th>Reg. Code</th><td><span style="font-weight:bold; font-size:16px; color:#007bff;">${data.reg ?? ''}</span></td></tr>`;
            html += `<tr><th>Name</th><td>${data.name ?? ''}</td></tr>`;
            html += `<tr><th>Age</th><td>${data.age ?? ''}</td></tr>`;
            html += `<tr><th>Role</th><td>${data.player ?? ''}</td></tr>`;
            html += `<tr><th>Registration Date</th><td>${formattedDate} at ${formattedTime}</td></tr>`;
            html += `<tr><th>Payment Date</th><td>${data.date ?? ''}</td></tr>`;
            html += `<tr><th>Email</th><td>${data.email ?? ''}</td></tr>`;
            html += `<tr><th>Mobile</th><td>${data.mobile ?? ''}</td></tr>`;
            html += `<tr><th>Mail Sent</th><td>${data.mailsent == 1 ? 'Yes' : 'No'}</td></tr>`;
            html += `<tr><th>State</th><td>${data.state ?? ''}</td></tr>`;
            html += `<tr><th>City</th><td>${data.city ?? ''}</td></tr>`;
            html += `<tr><th>Reference</th><td>${data.ref ?? ''}</td></tr>`;
            html += `<tr><th>Source</th><td>${data.source ?? ''}</td></tr>`;
            html += `<tr><th>Status</th><td><strong style="color: ${isSuccess ? 'green' : 'red'}">${data.status ?? ''}</strong></td></tr>`;
            html += '</table>';

            html += `<div class="text-end mt-3">`;

            if (isSuccess) {
                html += `<a href="../pdf1.php?reg=${encodeURIComponent(data.reg)}" target="_blank" class="btn btn-success me-2">
                            <i class="bx bxs-file-pdf"></i> Download PDF
                          </a>`;
            }

            html += `<button class="btn btn-warning" id="editButton">
                        <i class="bx bxs-edit"></i> Edit
                      </button>`;
            html += `</div></div>`;

            document.getElementById('modalContent').innerHTML = html;
            const playerModal = new bootstrap.Modal(document.getElementById('playerModal'));
            playerModal.show();

            // Handle the edit button click after the modal is shown
            document.getElementById('editButton').addEventListener('click', function() {
                playerModal.hide(); // Hide the view modal
                window.openEditModal(data); // Call the function to open the edit modal
            });
        });
    });

    // New logic for Delete button (unchanged)
    let playerIdToDelete;
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            playerIdToDelete = this.dataset.id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (playerIdToDelete) {
            // ... (Delete logic remains here) ...
            fetch('delete_player.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + playerIdToDelete,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Record deleted successfully!');
                    location.reload(); // Reload the page to show the updated table
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during deletion.');
            });
        }
    });
});


/**
 * यह फ़ंक्शन Edit Modal के State ड्रॉपडाउन के बदलने पर City ड्रॉपडाउन को डायनेमिक रूप से पॉपुलेट (populate) करता है।
 * @param {string} initialState - डेटा से लोड करने के लिए प्रारंभिक State.
 * @param {string} initialCity - डेटा से लोड करने के लिए प्रारंभिक City.
 */
function setupDynamicCityLoad(initialState, initialCity) {
    const stateDropdown = $("#editState");
    const cityDropdown = $("#editCity");

    // 1. City ड्रॉपडाउन को पॉपुलेट करने के लिए एक reusable फ़ंक्शन
    const populateCityDropdown = (selectedState, selectedCity) => {
        cityDropdown.empty().append('<option value="">Select City</option>');
        
        if (selectedState) {
            // AJAX request to fetch city data. Path updated to "../city_data.json"
            $.getJSON("../city_data.json", function(cityData) { 
                const cities = cityData[selectedState];

                if (cities) {
                    $.each(cities, function(index, city) {
                        const isSelected = city === selectedCity ? "selected" : "";
                        cityDropdown.append(
                            $("<option></option>").attr("value", city).prop("selected", isSelected).text(city)
                        );
                    });
                } else if (selectedCity) {
                    // अगर State में कोई City नहीं है, लेकिन City डेटा मौजूद है
                    cityDropdown.append($("<option></option>").attr("value", selectedCity).prop("selected", true).text(selectedCity));
                }
            }).fail(function() {
                 console.error("Error loading city_data.json. Check path!");
                 // यदि JSON लोड नहीं होता है, तो केवल पहले से चयनित City को दिखाएं
                 if (selectedCity) {
                     cityDropdown.empty().append($("<option></option>").attr("value", selectedCity).prop("selected", true).text(selectedCity));
                 }
            });
        } else if (selectedCity) {
            // यदि कोई State चयनित नहीं है, तो भी पहले से चयनित City को दिखाएं
            cityDropdown.empty().append($("<option></option>").attr("value", selectedCity).prop("selected", true).text(selectedCity));
        }
    };

    // 2. State बदलने पर City ड्रॉपडाउन को अपडेट करें (Change Event)
    stateDropdown.off('change').on('change', function() {
        const selectedState = $(this).val();
        populateCityDropdown(selectedState, ''); // नया State, City खाली
    });
    
    // 3. Modal लोड होने पर (Initial Load)
    // तुरंत प्रारंभिक State और City के साथ ड्रॉपडाउन पॉपुलेट करें
    if (initialState) {
        populateCityDropdown(initialState, initialCity);
    } else if (initialCity) {
        // यदि State खाली है लेकिन City है, तो City को एक विकल्प के रूप में जोड़ें
        cityDropdown.empty().append($("<option></option>").attr("value", initialCity).prop("selected", true).text(initialCity));
    }
}


// The openEditModal function is defined globally to be accessible from the DOMContentLoaded handler
window.openEditModal = function(data) {
    const html = `
        <input type="hidden" name="id" value="${data.id}">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="${data.name}" class="form-control" required>
        </div>
        <div class="form-group mt-2">
            <label>Age Group</label>
            <select name="age" id="age" class="form-control" required>
                <option value="">Your Category</option>
                <option value="Under 14" ${data.age === "Under 14" ? "selected" : ""}>Under 14</option>
                <option value="Under 16" ${data.age === "Under 16" ? "selected" : ""}>Under 16</option>
                <option value="Under 19" ${data.age === "Under 19" ? "selected" : ""}>Under 19</option>
                <option value="19 above" ${data.age === "19 above" ? "selected" : ""}>19 above</option>
                <option value="Corporate" ${data.age === "Corporate" ? "selected" : ""}>Corporate</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>Role</label>
            <select name="player" id="player" class="form-control" required>
                <option value="">Your Speciality</option>
                <option value="Bowler" ${data.player === "Bowler" ? "selected" : ""}>Bowler</option>
                <option value="Batsman" ${data.player === "Batsman" ? "selected" : ""}>Batsman</option>
                <option value="Wicketkeeper/Batsman" ${data.player === "Wicketkeeper/Batsman" ? "selected" : ""}>Wicketkeeper/Batsman</option>
                <option value="All Rounder" ${data.player === "All Rounder" ? "selected" : ""}>All Rounder</option>
            </select>
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
            <label>State</label>
            <select name="state" id="editState" class="form-control" required>
                <option value="">Select State</option>
                <option value="Andaman and Nicobar Islands" ${data.state === "Andaman and Nicobar Islands" ? "selected" : ""}>Andaman and Nicobar Islands</option>
                <option value="Andhra Pradesh" ${data.state === "Andhra Pradesh" ? "selected" : ""}>Andhra Pradesh</option>
                <option value="Arunachal Pradesh" ${data.state === "Arunachal Pradesh" ? "selected" : ""}>Arunachal Pradesh</option>
                <option value="Assam" ${data.state === "Assam" ? "selected" : ""}>Assam</option>
                <option value="Bihar" ${data.state === "Bihar" ? "selected" : ""}>Bihar</option>
                <option value="Chandigarh" ${data.state === "Chandigarh" ? "selected" : ""}>Chandigarh</option>
                <option value="Chhattisgarh" ${data.state === "Chhattisgarh" ? "selected" : ""}>Chhattisgarh</option>
                <option value="Dadra and Nagar Haveli" ${data.state === "Dadra and Nagar Haveli" ? "selected" : ""}>Dadra and Nagar Haveli</option>
                <option value="Delhi" ${data.state === "Delhi" ? "selected" : ""}>Delhi</option>
                <option value="Goa" ${data.state === "Goa" ? "selected" : ""}>Goa</option>
                <option value="Gujarat" ${data.state === "Gujarat" ? "selected" : ""}>Gujarat</option>
                <option value="Haryana" ${data.state === "Haryana" ? "selected" : ""}>Haryana</option>
                <option value="Himachal Pradesh" ${data.state === "Himachal Pradesh" ? "selected" : ""}>Himachal Pradesh</option>
                <option value="Jammu and Kashmir" ${data.state === "Jammu and Kashmir" ? "selected" : ""}>Jammu and Kashmir</option>
                <option value="Jharkhand" ${data.state === "Jharkhand" ? "selected" : ""}>Jharkhand</option>
                <option value="Karnataka" ${data.state === "Karnataka" ? "selected" : ""}>Karnataka</option>
                <option value="Kerala" ${data.state === "Kerala" ? "selected" : ""}>Kerala</option>
                <option value="Madhya Pradesh" ${data.state === "Madhya Pradesh" ? "selected" : ""}>Madhya Pradesh</option>
                <option value="Maharashtra" ${data.state === "Maharashtra" ? "selected" : ""}>Maharashtra</option>
                <option value="Manipur" ${data.state === "Manipur" ? "selected" : ""}>Manipur</option>
                <option value="Meghalaya" ${data.state === "Meghalaya" ? "selected" : ""}>Meghalaya</option>
                <option value="Mizoram" ${data.state === "Mizoram" ? "selected" : ""}>Mizoram</option>
                <option value="Nagaland" ${data.state === "Nagaland" ? "selected" : ""}>Nagaland</option>
                <option value="Odisha" ${data.state === "Odisha" ? "selected" : ""}>Odisha</option>
                <option value="Puducherry" ${data.state === "Puducherry" ? "selected" : ""}>Puducherry</option>
                <option value="Punjab" ${data.state === "Punjab" ? "selected" : ""}>Punjab</option>
                <option value="Rajasthan" ${data.state === "Rajasthan" ? "selected" : ""}>Rajasthan</option>
                <option value="Sikkim" ${data.state === "Sikkim" ? "selected" : ""}>Sikkim</option>
                <option value="Tamil Nadu" ${data.state === "Tamil Nadu" ? "selected" : ""}>Tamil Nadu</option>
                <option value="Telangana" ${data.state === "Telangana" ? "selected" : ""}>Telangana</option>
                <option value="Tripura" ${data.state === "Tripura" ? "selected" : ""}>Tripura</option>
                <option value="Uttar Pradesh" ${data.state === "Uttar Pradesh" ? "selected" : ""}>Uttar Pradesh</option>
                <option value="Uttarakhand" ${data.state === "Uttarakhand" ? "selected" : ""}>Uttarakhand</option>
                <option value="West Bengal" ${data.state === "West Bengal" ? "selected" : ""}>West Bengal</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>City</label>
            <select name="city" id="editCity" class="form-control" required>
                <option value="${data.city ?? ''}" selected>${data.city || 'Select City'}</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>Reference</label>
            <input type="text" name="ref" value="${data.ref}" class="form-control">
        </div>
    `;
    document.getElementById('editModalContent').innerHTML = html;
    new bootstrap.Modal(document.getElementById('editModal')).show();

    // Call the function to set up dynamic city loading for the new modal content
    setupDynamicCityLoad(data.state, data.city);
};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
function exportToExcel() {
    try {
        if (typeof XLSX === 'undefined') {
            alert('Excel Library missing!');
            return;
        }

        // 1. DataTable instance ko pakadna
        // Agar aap 'datatable-buttons' id use kar rahe hain to:
        var table = $('#datatable-buttons').DataTable();
        
        // 2. Saara data nikalna (All Pages + Filtered)
        // 'search: applied' ka matlab hai ki jo search filter laga hai wahi aayega
        // 'page: all' ka matlab saare pages ka data aayega
        var allData = table.rows({ search: 'applied' }).nodes();

        let workbookData = [];
        // Header definition
        workbookData.push(["#", "Name", "Email", "Age", "Reg. Code", "Role", "Mobile", "Timing", "Mail Status", "State", "City", "Ref", "Attempt", "Status"]);

        // 3. Loop through all rows (Even hidden ones)
        allData.to$().each(function(index, row) {
            const cells = row.cells;
            
            // Attributes se value nikalna
            const name = cells[1].getAttribute('data-export-name') || '';
            const email = cells[1].getAttribute('data-export-email') || '';
            const time = cells[6].getAttribute('data-export-time') || '';
            const state = cells[8].getAttribute('data-export-state') || '';
            const city = cells[8].getAttribute('data-export-city') || '';

            workbookData.push([
                index + 1,
                name,
                email,
                cells[2].innerText.trim(),
                cells[3].innerText.trim(),
                cells[4].innerText.trim(),
                cells[5].innerText.trim(),
                time,
                cells[7].innerText.trim() || (cells[7].querySelector('.text-success') ? "Sent" : "Not Sent"),
                state,
                city,
                cells[9].innerText.trim(),
                cells[10].innerText.trim(),
                cells[11].innerText.trim()
            ]);
        });

        if (workbookData.length <= 1) {
            alert("Export ke liye koi data nahi mila!");
            return;
        }

        // 4. Excel File Creation
        const ws = XLSX.utils.aoa_to_sheet(workbookData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Full_Report");

        const safeDate = new Date().toISOString().slice(0, 10);
        XLSX.writeFile(wb, "Full_Player_Report_" + safeDate + ".xlsx");

    } catch (error) {
        console.error("Export Error:", error);
        alert("Export failed! Make sure DataTable is initialized.");
    }
}
</script>




<?php include 'searchbar.php'; ?>