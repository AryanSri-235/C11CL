<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
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
$mailFilter = $_POST['mail_status'] ?? '';
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
$params = [];
$types = "";

if (!empty($datef)) { $sql .= " AND DATE(`date`) >= ?"; $params[] = $datef; if(!$quick_filter) $filterNotice[] = "From $datef"; $filterApplied = true; }
if (!empty($datel)) { $sql .= " AND DATE(`date`) <= ?"; $params[] = $datel; if(!$quick_filter) $filterNotice[] = "To $datel"; $filterApplied = true; }

if (!empty($searchText)) {
    $sql .= " AND (name LIKE ? OR reg LIKE ? OR email LIKE ? OR mobile LIKE ? OR state LIKE ?)";
    $like = "%$searchText%";
    for ($i = 0; $i < 5; $i++) { $params[] = $like; }
    $filterNotice[] = "Search: " . htmlspecialchars($searchText);
    $filterApplied = true;
}
if (!empty($stateFilter)) { $sql .= " AND state = ?"; $params[] = $stateFilter; $filterNotice[] = "State: $stateFilter"; $filterApplied = true; }
if (!empty($playerFilter)) { $sql .= " AND player = ?"; $params[] = $playerFilter; $filterNotice[] = "Role: $playerFilter"; $filterApplied = true; }
if (!empty($statusFilter)) { $sql .= " AND status = ?"; $params[] = $statusFilter; $filterNotice[] = "Status: $statusFilter"; $filterApplied = true; }
if (!empty($mailFilter)) {
    if ($mailFilter === 'sent') {
        $sql .= " AND mailsent = 1";
        $filterNotice[] = "Mail: Sent";
    } elseif ($mailFilter === 'not_sent') {
        $sql .= " AND (mailsent = 0 OR mailsent IS NULL)";
        $filterNotice[] = "Mail: Not Sent";
    }
    $filterApplied = true;
}

// Smart Sorting: Greatest of Update or Created At
$sql .= " ORDER BY GREATEST(COALESCE(`up`, '1000-01-01 00:00:00'), `created_at`) DESC LIMIT 3000";

$rows = [];
if ($con) {
    $stmt = $con->prepare($sql);
    if ($stmt) {
        if (count($params) > 0) {
            $types = str_repeat("s", count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
    }
}

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
    
    .p-name { font-weight: 700; color: #1e293b; display: block; }
    .p-sub { font-size: 11px; color: #000; font-weight: 500; }
    .st-success { color: #10b981; background: #dcfce7; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 11px; }
    .st-pending { color: #f59e0b; background: #fffbeb; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 11px; }

    .profile-details-card {
        border: 2px solid #22c55e;
        background-color: #f0fdf4;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.08);
    }
    .profile-details-card.pending {
        border: 2px solid #f59e0b;
        background-color: #fffbeb;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.08);
    }
    .profile-details-table {
        width: 100%;
        margin-bottom: 0;
    }
    .profile-details-table td {
        padding: 10px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 13.5px;
    }
    .profile-details-table tr:last-child td {
        border-bottom: none;
    }
    .profile-details-label {
        font-weight: 700;
        color: #475569;
        width: 40%;
    }
    .profile-details-value {
        color: #1e293b;
        font-weight: 500;
    }
    .btn-download-passport {
        background-color: #15803d;
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-download-passport:hover {
        background-color: #166534;
        color: #fff;
    }

    @media (max-width: 1100px) { .f-grid { flex-wrap: wrap; } .f-field { flex: 1 1 30%; } .f-search { flex: 1 1 100%; } }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
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

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0 text-dark fw-bold">Player Inquiries Log</h4>
            <span class="badge bg-primary text-white" style="font-size: 13px; font-weight: 700; padding: 6px 12px; border-radius: 20px;">
                Query Count: <?= count($rows) ?> Records Found
            </span>
        </div>

        <div class="filter-card">
            <form method="post" class="f-grid">
                <input type="text" name="universal" class="f-field f-search" placeholder="🔍 Search Player..." value="<?= htmlspecialchars($searchText) ?>">
                <select name="quick_filter" class="f-field" onchange="this.form.submit()" style="background:#f1f5f9; font-weight:bold;">
                    <option value="">⏱️ Quick Range</option>
                    <option value="today" <?= $quick_filter == 'today' ? 'selected' : '' ?>>Today</option>
                    <option value="yesterday" <?= $quick_filter == 'yesterday' ? 'selected' : '' ?>>Yesterday</option>
                    <option value="this_week" <?= $quick_filter == 'this_week' ? 'selected' : '' ?>>This Week</option>
                    <option value="this_month" <?= $quick_filter == 'this_month' ? 'selected' : '' ?>>This Month</option>
                </select>
                <input type="date" name="datef" class="f-field" value="<?= htmlspecialchars($datef) ?>">
                <input type="date" name="datel" class="f-field" value="<?= htmlspecialchars($datel) ?>">
                <select name="state" class="f-field">
                    <option value="">📍 State</option>
                    <?php
                    $stateRes = $con ? $con->query("SELECT DISTINCT state FROM register WHERE state != '' ORDER BY state") : null;
                    if ($stateRes) {
                        while ($s = $stateRes->fetch_assoc()) { echo "<option value='{$s['state']}' ".($s['state']==$stateFilter?'selected':'').">{$s['state']}</option>"; }
                    }
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
                    <option value="">All Payments</option>
                    <option value="Success" <?= $statusFilter == 'Success' ? 'selected' : '' ?>>Paid (Success)</option>
                    <option value="Pending" <?= $statusFilter == 'Pending' ? 'selected' : '' ?>>Unpaid (Pending)</option>
                </select>
                <select name="mail_status" class="f-field">
                    <option value="">All Mail Status</option>
                    <option value="sent" <?= $mailFilter == 'sent' ? 'selected' : '' ?>>Mail Sent</option>
                    <option value="not_sent" <?= $mailFilter == 'not_sent' ? 'selected' : '' ?>>Mail Not Sent</option>
                </select>
                <button type="submit" class="btn-apply">Apply</button>
                <?php if ($filterApplied): ?> <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn-clear">Clear</a> <?php endif; ?>
                <button type="button" onclick="exportToExcel()" class="btn-export" style="background:#16a34a; color:#fff; border:none; padding:0 15px; height:35px; border-radius:5px; font-weight:bold; cursor:pointer; margin-left:5px;">
                    <i class='bx bx-spreadsheet'></i> Excel Export
                </button>
            </form>
        </div>

        <?php if($filterApplied && !empty($filterNotice)): ?>
            <div class="alert alert-light border mb-3 py-2" style="font-size: 12px;">Active Filters: <?= implode(' | ', $filterNotice) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-hover table-striped">
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
                        $count = 0;
                        if (count($rows) > 0) {
                            foreach ($rows as $row) {
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
                                    <td data-export-name='".htmlspecialchars($row['name'])."'' data-export-email='".htmlspecialchars($row['email'])."'>
                                        <span class='p-name'>". htmlspecialchars($row['name']) ."</span>
                                        <span class='p-sub'>". htmlspecialchars($row['email']) ."</span>
                                    </td>
                                    <td class='text-center'><strong>". htmlspecialchars($row['age']) ."</strong></td>
                                    <td>
                                        <a href='#' class='openModal' style='font-family:monospace; font-weight:700; color:#2563eb; background:#f1f5f9; padding:2px 5px; border-radius:4px; text-decoration:none;' data-details='". htmlspecialchars(json_encode($row), ENT_QUOTES) ."'>
                                            ". htmlspecialchars($row['reg']) ."
                                        </a>
                                    </td>
                                    <td><span class='badge-role'>". htmlspecialchars($roleShorts[$row['player']] ?? $row['player']) ."</span></td>
                                    <td style='font-weight:700;'>". htmlspecialchars($row['mobile']) ."</td>
                                    <td class='p-sub' style='white-space:nowrap;'>". $displayTime ."</td>
                                    <td class='text-center'>". ($row['mailsent'] ? "<i class='bx bxs-check-circle text-success' style='font-size:18px;'></i>" : "<i class='bx bxs-x-circle text-danger' style='font-size:18px;'></i>") ."</td>
                                    <td data-export-state='".htmlspecialchars($row['state'])."' data-export-city='".htmlspecialchars($row['city'])."'>
                                        <span style='color:#fff; background:$stColor; padding:1px 5px; border-radius:4px; font-size:10px; font-weight:700; text-transform:uppercase;'>". htmlspecialchars($row['state']) ."</span>
                                        <div class='p-sub' style='font-size:10px; margin-top:2px;'>". htmlspecialchars($row['city']) ."</div>
                                    </td>
                                    <td>
                                        <div class='p-sub' style='font-weight:700; color:#2563eb;' title='$refText'>$shortRef</div>
                                        <div class='p-sub' style='font-size:10px;'>". htmlspecialchars($row['source']) ."</div>
                                    </td>
                                    <td class='text-center'><span class='badge bg-light text-dark border'>". (($row['regCount']??1)-1) ."</span></td>
                                    <td><span class='". ($isSuccess ? 'st-success' : 'st-pending') ."'>". htmlspecialchars($row['status']) ."</span></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12' class='text-center py-4 text-muted'>No Results Found</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="playerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class='bx bx-user-circle me-2' style='color:#2563eb'></i> Player Profile Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent"></div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
document.querySelectorAll('.openModal').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const data = JSON.parse(this.dataset.details);

        const isSuccess = data.status === 'Success';
        const cardClass = isSuccess ? 'profile-details-card' : 'profile-details-card pending';

        const datetime = data.created_at ?? '';
        let formattedDate = '', formattedTime = '';

        if (datetime) {
            const dt = new Date(datetime);
            formattedDate = dt.toLocaleDateString('en-IN', { day: '2-digit', month: '2-digit', year: 'numeric' });
            formattedTime = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', hour12: true });
        }

        let html = `
        <div class="${cardClass}">
            <table class="profile-details-table">
                <tr>
                    <td class="profile-details-label">Reg. Code</td>
                    <td class="profile-details-value">
                        <span style="font-family: monospace; font-weight: 700; color: #2563eb; background: #eff6ff; padding: 3px 8px; border-radius: 6px; border: 1px solid #bfdbfe;">
                            ${data.reg ?? ''}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="profile-details-label">Name</td>
                    <td class="profile-details-value" style="font-weight: 700; color: #0f172a;">${data.name ?? ''}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">Age</td>
                    <td class="profile-details-value">${data.age ?? ''}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">Role</td>
                    <td class="profile-details-value">${data.player ?? ''}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">Registration Date</td>
                    <td class="profile-details-value">${formattedDate} at ${formattedTime}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">Email Address</td>
                    <td class="profile-details-value">${data.email ?? ''}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">Mobile Channel</td>
                    <td class="profile-details-value" style="font-family: monospace; font-weight: 700;">${data.mobile ?? ''}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">Mail Sent</td>
                    <td class="profile-details-value">
                        ${data.mailsent == 1 
                            ? '<span style="color: #16a34a; font-weight: 700;">Yes</span>' 
                            : '<span style="color: #dc2626; font-weight: 700;">No</span>'}
                    </td>
                </tr>
                <tr>
                    <td class="profile-details-label">State Boundary</td>
                    <td class="profile-details-value">${data.state ?? ''}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">City Region</td>
                    <td class="profile-details-value">${data.city ?? ''}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">Reference</td>
                    <td class="profile-details-value" style="font-weight: 700; color: #2563eb;">${data.ref ?? ''}</td>
                </tr>
                <tr>
                    <td class="profile-details-label">Status State</td>
                    <td class="profile-details-value">
                        ${isSuccess 
                            ? '<span style="background-color: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; border: 1px solid #bbf7d0;">Success</span>' 
                            : '<span style="background-color: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; border: 1px solid #fde68a;">Pending</span>'}
                    </td>
                </tr>
            </table>
            <div class="text-end mt-4">`;

        if (isSuccess) {
            html += `
            <a href="../pdf1.php?reg=${encodeURIComponent(data.reg)}" target="_blank" class="btn-download-passport">
                <i class="bx bxs-file-pdf" style="font-size: 18px;"></i> Download PDF Passport
            </a>`;
        }

        html += `
            </div>
        </div>`;

        document.getElementById('modalContent').innerHTML = html;
        new bootstrap.Modal(document.getElementById('playerModal')).show();
    });
});

function exportToExcel() {
    try {
        if (typeof XLSX === 'undefined') {
            alert('Excel Library missing!');
            return;
        }

        let workbookData = [];
        workbookData.push(["#", "Name", "Email", "Age", "Reg. Code", "Role", "Mobile", "Latest Timing", "Mail Sent", "State", "City", "Reference", "Source", "Attempts", "Status"]);

        const rows = document.querySelectorAll("#datatable-buttons tbody tr");
        rows.forEach((row, index) => {
            const cells = row.cells;
            if (cells.length < 12 || cells[0].innerText.includes("No Results Found")) return;

            const nameCol = cells[1];
            const name = nameCol.getAttribute('data-export-name') || '';
            const email = nameCol.getAttribute('data-export-email') || '';

            const locationCol = cells[8];
            const state = locationCol.getAttribute('data-export-state') || '';
            const city = locationCol.getAttribute('data-export-city') || '';

            workbookData.push([
                index + 1,
                name,
                email,
                cells[2].innerText.trim(),
                cells[3].innerText.trim(),
                cells[4].innerText.trim(),
                cells[5].innerText.trim(),
                cells[6].innerText.trim(),
                cells[7].querySelector('i').title || '',
                state,
                city,
                cells[9].querySelector('div').innerText.trim(),
                cells[9].querySelectorAll('div')[1].innerText.trim(),
                cells[10].innerText.trim(),
                cells[11].innerText.trim()
            ]);
        });

        if (workbookData.length <= 1) {
            alert("No data available to export!");
            return;
        }

        const ws = XLSX.utils.aoa_to_sheet(workbookData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Players_Report");

        const safeDate = new Date().toISOString().slice(0, 10);
        XLSX.writeFile(wb, "Players_Registration_Report_" + safeDate + ".xlsx");

    } catch (error) {
        console.error("Export Error:", error);
        alert("Export failed!");
    }
}
</script>

<?php include 'foot.php'; ?>