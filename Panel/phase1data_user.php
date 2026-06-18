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
    $sql .= " AND (name LIKE '%$escapedSearch%' OR reg LIKE '%$escapedSearch%' OR email LIKE '%$escapedSearch%' OR mobile LIKE '%$escapedSearch%' OR state LIKE '%$escapedSearch%')";
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
$stateColors = [
    'Andhra Pradesh' => '#0284c7', 'Assam' => '#059669', 'Bihar' => '#b91c1c', 'Chandigarh' => '#4b5563', 'Delhi' => '#2563eb', 
    'Gujarat' => '#ea580c', 'Haryana' => '#16a34a', 'Karnataka' => '#7c3aed', 'Maharashtra' => '#f97316', 'Punjab' => '#dc2626', 
    'Rajasthan' => '#be123c', 'Uttar Pradesh' => '#7c2d12', 'West Bengal' => '#be185d'
];
?>

<style>
    .filter-card { background: #fff; padding: 15px; border-radius: 10px; border: 1px solid #e0e0e0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .f-grid { display: flex; flex-wrap: nowrap; gap: 8px; align-items: center; }
    .f-field { height: 35px; padding: 5px 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 13px; outline: none; flex: 1; min-width: 0; }
    .f-search { flex: 2; }
    .btn-apply { background: #007bff; color: #fff; border: none; padding: 0 15px; height: 35px; border-radius: 5px; font-weight: bold; cursor: pointer; }
    .btn-clear { background: #dc3545; color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-weight: bold; font-size: 12px; }
    
    /*.table thead th { background: #f8fafc; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 11px; padding: 12px; border: none; }*/
    .p-name { font-weight: 700; color: #1e293b; display: block; }
    .p-sub { font-size: 11px; color: #000; font-weight: 500; } /* Black text as requested */
    .st-success { color: #10b981; background: #dcfce7; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 11px; }
    .st-pending { color: #f59e0b; background: #fffbeb; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 11px; }

    @media (max-width: 1100px) { .f-grid { flex-wrap: wrap; } .f-field { flex: 1 1 30%; } .f-search { flex: 1 1 100%; } }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <div class="d-flex align-items-center mb-3" style="background: #fff; padding: 8px 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <div style="border-right: 2px solid #e2e8f0; padding-right: 10px; font-weight: 700; font-size: 13px; color: #475569;">SUBMISSION</div>
            <div class="ps-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="list-style: none; display: flex; gap: 8px; align-items: center; font-size: 13px;">
                        <li><a href="dashboard.php" style="color: #2563eb;"><i class="bx bx-home-alt"></i></a></li>
                        <li style="color: #94a3b8;">/</li>
                        <li style="font-weight: 600; color: #64748b;">Player Registrations</li>
                    </ol>
                </nav>
            </div>
        </div>

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
            </form>
        </div>

        <?php if($filterApplied && !empty($filterNotice)): ?>
            <div class="alert alert-light border mb-3 py-2" style="font-size: 12px;">Active Filters: <?= implode(' | ', $filterNotice) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Player Details</th>
                                <th>Age</th>
                                <th>Reg. Code</th>
                                <th>Role</th>
                                <th>Mobile</th>
                                <th>Latest Timing</th>
                                <th>Mail</th>
                                <th>Location</th>
                                <th>Ref/Source</th>
                                <th>Att.</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            $count = 0;
                            while ($row = $result->fetch_assoc()) {
                                $isSuccess = $row['status'] === 'Success';
                                $stColor = $stateColors[$row['state']] ?? '#64748b';
                                $refText = htmlspecialchars($row['ref'] ?? '');
                                $shortRef = (strlen($refText) > 12) ? substr($refText, 0, 12) . "..." : $refText;
                                
                                // Timing Logic
                                $regT = strtotime($row['created_at']);
                                $upT = !empty($row['up']) ? strtotime($row['up']) : 0;
                                $displayTime = ($upT > $regT) ? date("d M, h:i A", $upT) : date("d M, h:i A", $regT);
                                $rowStyle = $isSuccess ? "style='background-color: #dcfce7 !important;'" : "";

                                echo "<tr $rowStyle>
                                    <td class='text-center text-muted'>". ++$count ."</td>
                                    <td>
                                        <span class='p-name'>". $row['name'] ."</span>
                                        <span class='p-sub'>". $row['email'] ."</span>
                                    </td>
                                    <td class='text-center'><strong>". $row['age'] ."</strong></td>
                                    <td>
                                        <a href='#' class='openModal' style='font-family:monospace; font-weight:700; color:#2563eb; background:#f1f5f9; padding:2px 5px; border-radius:4px; text-decoration:none;' data-details='". htmlspecialchars(json_encode($row), ENT_QUOTES) ."'>
                                            ". $row['reg'] ."
                                        </a>
                                    </td>
                                    <td><span class='badge-role'>". ($roleShorts[$row['player']] ?? $row['player']) ."</span></td>
                                    <td style='font-weight:700;'>". $row['mobile'] ."</td>
                                    <td class='p-sub' style='white-space:nowrap;'>". $displayTime ."</td>
                                    <td class='text-center'>". ($row['mailsent'] ? "<i class='bx bxs-check-circle text-success' style='font-size:18px;'></i>" : "<i class='bx bxs-x-circle text-danger' style='font-size:18px;'></i>") ."</td>
                                    <td>
                                        <span style='color:#fff; background:$stColor; padding:1px 5px; border-radius:4px; font-size:10px; font-weight:700; text-transform:uppercase;'>". $row['state'] ."</span>
                                        <div class='p-sub' style='font-size:10px; margin-top:2px;'>". $row['city'] ."</div>
                                    </td>
                                    <td>
                                        <div class='p-sub' style='font-weight:700; color:#2563eb;' title='$refText'>$shortRef</div>
                                        <div class='p-sub' style='font-size:10px;'>". $row['source'] ."</div>
                                    </td>
                                    <td class='text-center'><span class='badge bg-light text-dark border'>". (($row['regCount']??1)-1) ."</span></td>
                                    <td><span class='". ($isSuccess ? 'st-success' : 'st-pending') ."'>". $row['status'] ."</span></td>
                                </tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="playerModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Player Details</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="modalContent"></div></div></div></div>

<script>
document.querySelectorAll('.openModal').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const data = JSON.parse(this.dataset.details);

        // Style for modal if status is 'Success'
        const isSuccess = data.status === 'Success';
        const modalStyle = isSuccess ? 'background-color:#e6ffe6; border: 2px solid #28a745; padding:15px; border-radius:10px;' : '';

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

html += `<tr><th>Reg. Code</th><td><span style="font-weight:bold; font-size:16px; color:#007bff;">${data.reg ?? ''}</span></td></tr>`;
html += `<tr><th>Name</th><td>${data.name ?? ''}</td></tr>`;
html += `<tr><th>Age</th><td>${data.age ?? ''}</td></tr>`;
html += `<tr><th>Role</th><td>${data.player ?? ''}</td></tr>`;
html += `<tr><th>Registration Date</th><td>${formattedDate} at ${formattedTime}</td></tr>`;
html += `<tr><th>Email</th><td>${data.email ?? ''}</td></tr>`;
html += `<tr><th>Mobile</th><td>${data.mobile ?? ''}</td></tr>`;
html += `<tr><th>Mail Sent</th><td>${data.mailsent == 1 ? 'Yes' : 'No'}</td></tr>`;
html += `<tr><th>State</th><td>${data.state ?? ''}</td></tr>`;
html += `<tr><th>City</th><td>${data.city ?? ''}</td></tr>`;
html += `<tr><th>Reference</th><td>${data.ref ?? ''}</td></tr>`;
html += `<tr><th>Status</th><td><strong style="color: ${isSuccess ? 'green' : 'red'}">${data.status ?? ''}</strong></td></tr>`;
html += '</table>';


        // Show download PDF button only if Success
        if (isSuccess) {
            html += `<div class="text-end mt-3">
                        <a href="../pdf1.php?reg=${encodeURIComponent(data.reg)}" target="_blank" class="btn btn-success">
                            <i class="bx bxs-file-pdf"></i> Download PDF
                        </a>
                     </div>`;
        }

        html += '</div>'; // Close modal style wrapper
        document.getElementById('modalContent').innerHTML = html;
        new bootstrap.Modal(document.getElementById('playerModal')).show();
    });
});
</script>


<?php include 'foot.php'; ?>