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

// --- Logic: Filters & Reporting Engine ---
$datef = $_POST['datef'] ?? '';
$datel = $_POST['datel'] ?? '';
$monthf = $_POST['monthf'] ?? ''; // Format: MM (01, 02...)
$yearf = $_POST['yearf'] ?? date('Y'); // Default to current year for month clustering
$searchText = trim($_POST['universal'] ?? '');
$stateFilter = $_POST['state'] ?? '';
$statusFilter = $_POST['status'] ?? '';
$refFilter = $_POST['ref_user'] ?? ''; // User Wise / Ref Code drop-down filter
$quick_filter = $_POST['quick_filter'] ?? '';

$filterApplied = false;
$filterNotice = [];

// Quick Date Range Logic Override
if (!empty($quick_filter)) {
    $filterApplied = true;
    $monthf = ''; 
    if ($quick_filter == 'today') { $datef = $datel = date('Y-m-d'); $filterNotice[] = "Today"; }
    elseif ($quick_filter == 'yesterday') { $datef = $datel = date('Y-m-d', strtotime("-1 days")); $filterNotice[] = "Yesterday"; }
    elseif ($quick_filter == 'this_week') { $datef = date('Y-m-d', strtotime("monday this week")); $datel = date('Y-m-d', strtotime("sunday this week")); $filterNotice[] = "This Week"; }
    elseif ($quick_filter == 'this_month') { $datef = date('Y-m-01'); $datel = date('Y-m-t'); $filterNotice[] = "This Month"; }
}

// Base SQL Condition
$whereClauses = ["1=1"];

// Apply Custom Start & End Date Filters
if (empty($quick_filter)) {
    if (!empty($datef)) { 
        $whereClauses[] = "DATE(`date`) >= '" . $con->real_escape_string($datef) . "'"; 
        $filterNotice[] = "From: $datef"; 
        $filterApplied = true; 
    }
    if (!empty($datel)) { 
        $whereClauses[] = "DATE(`date`) <= '" . $con->real_escape_string($datel) . "'"; 
        $filterNotice[] = "To: $datel"; 
        $filterApplied = true; 
    }
}

// Apply Month-wise Selection Dropdown (Jan - Dec)
if (!empty($monthf) && empty($quick_filter)) {
    $whereClauses[] = "MONTH(`date`) = '" . (int)$monthf . "' AND YEAR(`date`) = '" . (int)$yearf . "'";
    $monthName = date("F", mktime(0, 0, 0, $monthf, 10));
    $filterNotice[] = "Month: $monthName $yearf";
    $filterApplied = true;
}

// Apply User Wise Dropdown Filter (Ref Code Cluster)
if (!empty($refFilter)) {
    $whereClauses[] = "ref = '" . $con->real_escape_string($refFilter) . "'";
    $filterNotice[] = "User/Ref: " . htmlspecialchars($refFilter);
    $filterApplied = true;
}

// Apply Search Text (Universal Filter)
if (!empty($searchText)) {
    $escapedSearch = $con->real_escape_string($searchText);
    $whereClauses[] = "(
        name LIKE '%$escapedSearch%' OR
        reg LIKE '%$escapedSearch%' OR
        email LIKE '%$escapedSearch%' OR
        mobile LIKE '%$escapedSearch%' OR
        state LIKE '%$escapedSearch%' OR
        city LIKE '%$escapedSearch%'
    )";
    $filterNotice[] = "Search: " . htmlspecialchars($searchText);
    $filterApplied = true;
}

if (!empty($stateFilter)) { $whereClauses[] = "state = '".$con->real_escape_string($stateFilter)."'"; $filterNotice[] = "State: $stateFilter"; $filterApplied = true; }
if (!empty($statusFilter)) { $whereClauses[] = "status = '".$con->real_escape_string($statusFilter)."'"; $filterNotice[] = "Status: $statusFilter"; $filterApplied = true; }

$whereSQL = implode(" AND ", $whereClauses);

// --- Analytics KPI Cards Calculation ---
$kpiQuery = "SELECT 
    COUNT(id) as total_reg,
    SUM(CASE WHEN status = 'Success' THEN amount ELSE 0 END) as total_revenue,
    SUM(CASE WHEN status = 'Pending' THEN payable_amount ELSE 0 END) as pending_revenue,
    COUNT(CASE WHEN status = 'Success' THEN 1 END) as success_count,
    COUNT(CASE WHEN status = 'Pending' THEN 1 END) as pending_count,
    COUNT(CASE WHEN status = 'Rejected' THEN 1 END) as rejected_count
FROM register WHERE $whereSQL";

$kpiResult = $con->query($kpiQuery)->fetch_assoc();

// Main reporting records query
$sql = "SELECT * FROM register WHERE $whereSQL ORDER BY `date` DESC, `id` DESC LIMIT 5000";
$result = $con->query($sql);
?>

<style>
/* 🛠️ Style overrides and enhancements */
[style*="color:#94a3b8"], [style*="color: #94a3b8"] { color: #000000 !important; }
.filter-card { background: #fff; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.f-grid { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
.f-field { height: 35px; padding: 5px 8px; border: 1px solid #cbd5e1; border-radius: 5px; font-size: 13px; outline: none; flex: 1; min-width: 130px; }
.f-search { flex: 1.5; min-width: 180px; }
.btn-apply { background: #2563eb; color: #fff; border: none; padding: 0 15px; height: 35px; border-radius: 5px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 5px;}
.btn-clear { background: #dc3545; color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-weight: bold; font-size: 12px; text-align: center; }
.kpi-card { background: #fff; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        
        <!-- Breadcrumb Header -->
        <div class="page-breadcrumb d-flex align-items-center" style="margin-bottom: 15px; background: #fff; padding: 10px 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <div class="breadcrumb-title" style="border-right: 2px solid #e2e8f0; padding-right: 10px; font-weight: 700; font-size: 14px; color: #1e293b; text-transform: uppercase;">
                <i class='bx bx-bar-chart-square' style='font-size:18px; vertical-align: middle;'></i> Dynamic Dashboard
            </div>
            <div class="ps-2" style="flex-grow: 1;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="margin-bottom: 0; padding: 0; background: transparent; display: flex; align-items: center; list-style: none; gap: 8px;">
                        <li class="breadcrumb-item"><a href="dashboard.php" style="color: #2563eb; text-decoration: none;"><i class="bx bx-home-alt"></i></a></li>
                        <li style="color: #94a3b8; font-size: 12px;">/</li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: #64748b; font-size: 13px; font-weight: 600;">Filtered Ledger Matrix</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- 📊 KPI Summary Blocks -->
        <div class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <div class="kpi-card border-start border-dark border-4 py-2">
                    <div class="text-muted small text-uppercase font-weight-bold" style="font-size:11px;">Total Rows</div>
                    <h4 class="mb-0 mt-1 font-weight-bold text-dark"><?= number_format($kpiResult['total_reg']) ?></h4>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="kpi-card border-start border-success border-4 py-2">
                    <div class="text-muted small text-uppercase font-weight-bold" style="font-size:11px;">🟢 Success Total</div>
                    <h4 class="mb-0 mt-1 font-weight-bold text-success"><?= number_format($kpiResult['success_count']) ?></h4>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="kpi-card border-start border-warning border-4 py-2">
                    <div class="text-muted small text-uppercase font-weight-bold" style="font-size:11px;">🟡 Pending Total</div>
                    <h4 class="mb-0 mt-1 font-weight-bold text-warning"><?= number_format($kpiResult['pending_count']) ?></h4>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="kpi-card border-start border-danger border-4 py-2">
                    <div class="text-muted small text-uppercase font-weight-bold" style="font-size:11px;">🔴 Rejected Total</div>
                    <h4 class="mb-0 mt-1 font-weight-bold text-danger"><?= number_format($kpiResult['rejected_count']) ?></h4>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="kpi-card border-start border-primary border-4 py-2">
                    <div class="text-muted small text-uppercase font-weight-bold" style="font-size:11px;">Revenue Recd.</div>
                    <h4 class="mb-0 mt-1 font-weight-bold text-primary">₹<?= number_format($kpiResult['total_revenue'], 0) ?></h4>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="kpi-card border-start border-info border-4 py-2">
                    <div class="text-muted small text-uppercase font-weight-bold" style="font-size:11px;">Expected Due</div>
                    <h4 class="mb-0 mt-1 font-weight-bold text-info">₹<?= number_format($kpiResult['pending_revenue'], 0) ?></h4>
                </div>
            </div>
        </div>

        <!-- 🔍 Advanced Custom Filters Form Control -->
        <div class="filter-card">
            <form method="post" class="f-grid" id="reportingForm">
                
                <!-- Text / Player Info Field -->
                <input type="text" name="universal" class="f-field f-search" placeholder="🔍 Search Name, Phone, Email..." value="<?= htmlspecialchars($searchText) ?>">
                
                <!-- USER WISE dropdown list filter (Ref Code Mapping) -->
                <select name="ref_user" class="f-field" style="background: #fffdf5; font-weight: 600; border: 1px solid #fcd34d;">
                    <option value="">👤 All Users (Ref Codes)</option>
                    <?php
                    $refRes = $con->query("SELECT DISTINCT ref FROM register WHERE ref IS NOT NULL AND ref != '' ORDER BY ref");
                    while ($r = $refRes->fetch_assoc()) {
                        $selected = ($r['ref'] == $refFilter) ? 'selected' : '';
                        echo "<option value='".htmlspecialchars($r['ref'])."' $selected>".htmlspecialchars($r['ref'])."</option>";
                    }
                    ?>
                </select>

                <!-- MONTH WISE selection dropdown -->
                <select name="monthf" class="f-field" style="background: #f0fdf4; font-weight: 600; border: 1px solid #86efac;">
                    <option value="">📅 All Months</option>
                    <option value="01" <?= $monthf == '01' ? 'selected' : '' ?>>January</option>
                    <option value="02" <?= $monthf == '02' ? 'selected' : '' ?>>February</option>
                    <option value="03" <?= $monthf == '03' ? 'selected' : '' ?>>March</option>
                    <option value="04" <?= $monthf == '04' ? 'selected' : '' ?>>April</option>
                    <option value="05" <?= $monthf == '05' ? 'selected' : '' ?>>May</option>
                    <option value="06" <?= $monthf == '06' ? 'selected' : '' ?>>June</option>
                    <option value="07" <?= $monthf == '07' ? 'selected' : '' ?>>July</option>
                    <option value="08" <?= $monthf == '08' ? 'selected' : '' ?>>August</option>
                    <option value="09" <?= $monthf == '09' ? 'selected' : '' ?>>September</option>
                    <option value="10" <?= $monthf == '10' ? 'selected' : '' ?>>October</option>
                    <option value="11" <?= $monthf == '11' ? 'selected' : '' ?>>November</option>
                    <option value="12" <?= $monthf == '12' ? 'selected' : '' ?>>December</option>
                </select>

                <!-- Year helper for month calculation -->
                <select name="yearf" class="f-field" style="max-width: 90px;">
                    <option value="2026" <?= $yearf == '2026' ? 'selected' : '' ?>>2026</option>
                    <option value="2025" <?= $yearf == '2025' ? 'selected' : '' ?>>2025</option>
                </select>

                <!-- STATUS WISE filter drop down -->
                <select name="status" class="f-field" style="font-weight: 600;">
                    <option value="">💳 All Statuses</option>
                    <option value="Success" <?= $statusFilter == 'Success' ? 'selected' : '' ?>>Success Only</option>
                    <option value="Pending" <?= $statusFilter == 'Pending' ? 'selected' : '' ?>>Pending Only</option>
                    <option value="Rejected" <?= $statusFilter == 'Rejected' ? 'selected' : '' ?>>Rejected Only</option>
                </select>

                <!-- Quick Date Filter Shortcuts -->
                <select name="quick_filter" class="f-field" onchange="this.form.submit()" style="background:#f8fafc;">
                    <option value="">⏱️ Quick Shortcuts</option>
                    <option value="today" <?= $quick_filter == 'today' ? 'selected' : '' ?>>Today</option>
                    <option value="yesterday" <?= $quick_filter == 'yesterday' ? 'selected' : '' ?>>Yesterday</option>
                    <option value="this_week" <?= $quick_filter == 'this_week' ? 'selected' : '' ?>>This Week</option>
                    <option value="this_month" <?= $quick_filter == 'this_month' ? 'selected' : '' ?>>This Month</option>
                </select>

                <!-- Custom Raw Dates inputs selection -->
                <input type="date" name="datef" class="f-field" title="Custom From Date" value="<?= htmlspecialchars($datef) ?>" <?= !empty($quick_filter) ? 'disabled' : '' ?>>
                <input type="date" name="datel" class="f-field" title="Custom To Date" value="<?= htmlspecialchars($datel) ?>" <?= !empty($quick_filter) ? 'disabled' : '' ?>>

                <select name="state" class="f-field">
                    <option value="">📍 State</option>
                    <?php
                    $stateRes = $con->query("SELECT DISTINCT state FROM register WHERE state != '' ORDER BY state");
                    while ($s = $stateRes->fetch_assoc()) { 
                        echo "<option value='".htmlspecialchars($s['state'])."' ".($s['state']==$stateFilter?'selected':'').">{$s['state']}</option>"; 
                    }
                    ?>
                </select>

                <button type="submit" class="btn-apply"><i class='bx bx-filter-alt'></i> Apply</button>
                
                <?php if ($filterApplied || !empty($monthf) || !empty($refFilter)): ?> 
                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="btn-clear">Clear</a> 
                <?php endif; ?>

                <button type="button" onclick="exportReportingToExcel()" class="btn-export" style="background:#16a34a; color:#fff; border:none; padding:0 12px; height:35px; border-radius:5px; font-weight:bold; cursor:pointer;">
                    <i class='bx bx-spreadsheet'></i> Excel Export
                </button>
            </form>
        </div>

        <!-- Notification Alerts -->
        <?php if (!empty($filterNotice)): ?>
            <div class="alert alert-info py-2 px-3 mb-3" style="font-size:13px; font-weight:600; border-radius:6px;">
                Filtered Matrix Nodes: <span class="text-dark bg-white px-2 py-0.5 rounded border ml-2"><?= implode(' &nbsp;|&nbsp; ', $filterNotice) ?></span>
            </div>
        <?php endif; ?>

        <!-- Table Responsive Grid System -->
        <div class="card bg">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-reporting" class="table table-striped table-bordered align-middle" style="width:100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width:50px;">#</th>
                                <th>Registration Identity</th>
                                <th>Reg. Code</th>
                                <th>Contact Details</th>
                                <th>Location Context</th>
                                <th>User/Ref Properties</th>
                                <th class="text-center">Dates & Activity</th>
                                <th class="text-center">Ledger Values</th>
                                <th class="text-center">Communication</th>
                                <th class="text-center">Workflow Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            $count = 0;
                            while ($row = $result->fetch_assoc()) {
                                $isSuccess = $row['status'] === 'Success';
                                $isPending = $row['status'] === 'Pending';
                                $rowStyle = $isSuccess ? "style='background-color: #f0fdf4 !important;'" : ($row['status'] === 'Rejected' ? "style='background-color: #fef2f2 !important;'" : "");
                                
                                $regTime = !empty($row['date']) ? date("d M Y", strtotime($row['date'])) : '-';
                                $createdAt = !empty($row['created_at']) ? date("d M, h:i A", strtotime($row['created_at'])) : '-';
                                ?>
                                <tr <?= $rowStyle ?>>
                                    <td class="text-center text-muted"><?= ++$count ?></td>
                                    <td data-val-name="<?= htmlspecialchars($row['name']) ?>">
                                        <div style="font-weight:700; color:#1e293b;"><?= htmlspecialchars($row['name']) ?></div>
                                        <div class="small" style="font-size:10px; color:#64748b;"><?= htmlspecialchars($row['player'] ?? 'Unspecified') ?> (Age: <?= htmlspecialchars($row['age']) ?>)</div>
                                    </td>
                                    <td><span style="font-family:monospace; font-weight:700; color:#2563eb; background:#f1f5f9; padding:3px 6px; border-radius:4px;"><?= htmlspecialchars($row['reg']) ?></span></td>
                                    <td data-val-email="<?= htmlspecialchars($row['email']) ?>">
                                        <div style="font-weight:600; font-size:12px;"><i class='bx bx-phone'></i> <?= htmlspecialchars($row['mobile']) ?></div>
                                        <div style="font-size:10px; color:#64748b;"><i class='bx bx-envelope'></i> <?= htmlspecialchars($row['email']) ?></div>
                                    </td>
                                    <td data-val-state="<?= htmlspecialchars($row['state']) ?>" data-val-city="<?= htmlspecialchars($row['city']) ?>">
                                        <span class="badge bg-secondary text-uppercase mb-1" style="font-size:9px;"><?= htmlspecialchars($row['state']) ?></span>
                                        <div style="font-size:10px; color:#475569;"><i class='bx bx-map-pin'></i> <?= htmlspecialchars($row['city']) ?></div>
                                    </td>
                                    <td>
                                        <div style="font-size:11px; font-weight:700; color:#b45309;">Ref: <?= htmlspecialchars($row['ref'] ?: 'N/A') ?></div>
                                        <div style="font-size:10px; color:#64748b;">Src: <?= htmlspecialchars($row['source'] ?: 'Direct') ?></div>
                                    </td>
                                    <td class="text-center" data-val-time="<?= $regTime ?>">
                                        <div style="font-size:11px; font-weight:700; color:#1e293b;"><?= $regTime ?></div>
                                        <div style="font-size:9px; color:#64748b;">Log: <?= $createdAt ?></div>
                                    </td>
                                    <td class="text-end" data-val-amt="<?= $row['amount'] ?>" data-val-payable="<?= $row['payable_amount'] ?>">
                                        <div style="font-size:12px; font-weight:700; color:#16a34a;">Paid: ₹<?= number_format($row['amount'], 2) ?></div>
                                        <div style="font-size:9px; color:#64748b;">Due: ₹<?= number_format($row['payable_amount'], 2) ?></div>
                                    </td>
                                    <td class="text-center" data-val-mail="<?= $row['mailsent'] ? 'Sent' : 'Pending' ?>" data-val-wa="<?= $row['wasent'] ? 'Sent' : 'Pending' ?>">
                                        <div class="d-flex justify-content-center gap-2">
                                            <i class='bx bxs-envelope <?= $row['mailsent'] ? 'text-success' : 'text-danger' ?>' title="Mail: <?= $row['mailsent'] ? 'Sent' : 'Pending' ?>" style="font-size:16px;"></i>
                                            <i class='bx bxl-whatsapp <?= $row['wasent'] ? 'text-success' : 'text-danger' ?>' title="WhatsApp: <?= $row['wasent'] ? 'Sent' : 'Pending' ?>" style="font-size:16px;"></i>
                                        </div>
                                    </td>
                                    <td class="text-center" data-val-status="<?= $row['status'] ?>">
                                        <?php if($isSuccess): ?>
                                            <span class="badge bg-success" style="padding:5px 8px; font-size:10px;"><i class='bx bx-check-circle'></i> Success</span>
                                        <?php elseif($isPending): ?>
                                            <span class="badge bg-warning text-dark" style="padding:5px 8px; font-size:10px;"><i class='bx bx-time'></i> Pending</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger" style="padding:5px 8px; font-size:10px;"><i class='bx bx-x-circle'></i> Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center p-4 text-muted font-weight-bold'>No Analysable Report Metrics Match the Criteria Selected</td></tr>";
                        }
                        $con->close();
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#datatable-reporting').DataTable({
            "order": [], 
            "pageLength": 50,
            "language": { "search": "🔍 Inline Quick Search:" }
        });
    }
});

function exportReportingToExcel() {
    try {
        if (typeof XLSX === 'undefined') {
            alert('Excel library missing!');
            return;
        }
        let matrixData = [];
        matrixData.push([
            "Index Sequence", "User/Player Name", "Classification", "Assigned Reg Code", 
            "Mobile", "Email", "State", "City", "Source", "Referral User", 
            "Log Date", "Paid Amount", "Payable Due Amount", "Email Status", "WhatsApp Status", "Workflow Status"
        ]);

        let targetRows = document.querySelectorAll("#datatable-reporting tbody tr");
        let counterIndex = 1;

        targetRows.forEach(function(row) {
            if(row.cells.length < 10) return;
            let c = row.cells;
            
            matrixData.push([
                counterIndex++,
                c[1].getAttribute('data-val-name') || '',
                c[1].querySelector('.small') ? c[1].querySelector('.small').innerText : '',
                c[2].innerText.trim(),
                c[3].innerText.split("\n")[0].trim(),
                c[3].getAttribute('data-val-email') || '',
                c[4].getAttribute('data-val-state') || '',
                c[4].getAttribute('data-val-city') || '',
                c[5].innerText.split("\n")[1] ? c[5].innerText.split("\n")[1].replace('Src: ', '').trim() : '',
                c[5].getAttribute('title') || '',
                c[6].getAttribute('data-val-time') || '',
                parseFloat(c[7].getAttribute('data-val-amt') || '0'),
                parseFloat(c[7].getAttribute('data-val-payable') || '0'),
                c[8].getAttribute('data-val-mail') || '',
                c[8].getAttribute('data-val-wa') || '',
                c[9].getAttribute('data-val-status') || ''
            ]);
        });

        const worksheet = XLSX.utils.aoa_to_sheet(matrixData);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Ledger Matrix");
        XLSX.writeFile(workbook, "Filtered_User_Month_Report_" + new Date().toISOString().slice(0, 10) + ".xlsx");
    } catch (err) {
        console.error(err);
        alert("Spreadsheet conversion failed.");
    }
}
</script>

<?php include 'searchbar.php'; ?>