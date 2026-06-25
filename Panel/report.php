<?php
session_start();

/* 🔒 Login check */
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

/* 🔐 Role check */
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'superadmin') {
    $currentStatus = $_SESSION['status'] ?? 'Unknown';
    echo "
    <div style='margin: 80px auto; max-width: 500px; padding: 25px; border-radius: 10px; background: #fff3cd; border: 1px solid #ffeeba; color: #856404; font-family: Arial; text-align: center;'>
        <h3>Access Denied 🚫</h3>
        <p>Aapka status <strong>{$currentStatus}</strong> hai.<br>Aapko is page ka access nahi hai.</p>
        <a href='dashboard.php' style='display:inline-block; margin-top:15px; padding:8px 15px; background:#0f172a; color:#fff; text-decoration:none; border-radius:5px;'>Go Back</a>
    </div>";
    exit();
}

include 'head.php';
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- 🔍 Date Filters Logic ---
$datef = $_POST['datef'] ?? '';
$datel = $_POST['datel'] ?? '';
$filterApplied = false;

$whereClauses = ["1=1"];
if (!empty($datef)) { 
    $whereClauses[] = "DATE(`date`) >= '" . $con->real_escape_string($datef) . "'"; 
    $filterApplied = true; 
}
if (!empty($datel)) { 
    $whereClauses[] = "DATE(`date`) <= '" . $con->real_escape_string($datel) . "'"; 
    $filterApplied = true; 
}
$whereSQL = implode(" AND ", $whereClauses);

// ==========================================
// 📊 METRIC EXTRACTION ENGINE (SQL BLOCKS)
// ==========================================

// 1. Grand Total KPI Indicators
$grandTotalRes = $con->query("SELECT 
    COUNT(id) as total,
    COUNT(CASE WHEN status = 'Success' THEN 1 END) as success,
    COUNT(CASE WHEN status = 'Pending' THEN 1 END) as pending,
    COUNT(CASE WHEN status = 'Rejected' THEN 1 END) as rejected,
    SUM(CASE WHEN status = 'Success' THEN amount ELSE 0 END) as revenue
FROM register WHERE $whereSQL")->fetch_assoc();

// 2. All-Time Chronological Month-Wise Summary Performance Matrix (Jan 2025 to Present)
$monthMatrixSql = "SELECT 
    YEAR(`date`) as yr,
    MONTH(`date`) as month_num,
    DATE_FORMAT(`date`, '%b-%Y') as month_label,
    COUNT(id) as total_reg,
    COUNT(CASE WHEN status = 'Success' THEN 1 END) as success_reg,
    COUNT(CASE WHEN status = 'Pending' THEN 1 END) as pending_reg
FROM register 
WHERE $whereSQL
GROUP BY YEAR(`date`), MONTH(`date`), DATE_FORMAT(`date`, '%b-%Y')
ORDER BY YEAR(`date`) ASC, MONTH(`date`) ASC";
$monthMatrixRes = $con->query($monthMatrixSql);

$chartTimelineMonths = [];
$chartTimelineSuccess = [];
$chartTimelinePending = [];

// 3. User Referral Conversion matrix with non-conversion consolidation block (Others)
$refMatrixSql = "SELECT 
    COALESCE(NULLIF(ref, ''), 'Direct / No Ref') as referral_user,
    COUNT(CASE WHEN YEAR(`date`) = 2025 THEN 1 END) as total_2025,
    COUNT(CASE WHEN YEAR(`date`) = 2025 AND status = 'Success' THEN 1 END) as success_2025,
    COUNT(CASE WHEN YEAR(`date`) = 2026 THEN 1 END) as total_2026,
    COUNT(CASE WHEN YEAR(`date`) = 2026 AND status = 'Success' THEN 1 END) as success_2026,
    COUNT(CASE WHEN status = 'Pending' THEN 1 END) as total_pending_overall
FROM register
WHERE $whereSQL
GROUP BY referral_user";
$refRawResult = $con->query($refMatrixSql);

// Processing logic to merge 0 success entries into "Others" row cleanly
$processedRefRows = [];
$othersRow = [
    'referral_user' => 'Others (No Conversion Users)',
    'total_2025' => 0, 'success_2025' => 0,
    'total_2026' => 0, 'success_2026' => 0,
    'total_pending_overall' => 0
];
$hasOthersData = false;

if ($refRawResult && $refRawResult->num_rows > 0) {
    while ($rRow = $refRawResult->fetch_assoc()) {
        $totalSuccessAcrossYears = (int)$rRow['success_2025'] + (int)$rRow['success_2026'];
        
        if ($totalSuccessAcrossYears === 0 && $rRow['referral_user'] !== 'Direct / No Ref') {
            $othersRow['total_2025'] += (int)$rRow['total_2025'];
            $othersRow['total_2026'] += (int)$rRow['total_2026'];
            $othersRow['total_pending_overall'] += (int)$rRow['total_pending_overall'];
            $hasOthersData = true;
        } else {
            $processedRefRows[] = $rRow;
        }
    }
}
// Append aggregated row at the bottom if records were consolidated
if ($hasOthersData) {
    $processedRefRows[] = $othersRow;
}

// Custom manual tracking array sorting logic to sort highest 2026 conversions on top
usort($processedRefRows, function($a, $b) {
    if ($a['referral_user'] === 'Others (No Conversion Users)') return 1;
    if ($b['referral_user'] === 'Others (No Conversion Users)') return -1;
    return $b['success_2026'] <=> $a['success_2026'];
});

// 4. Complete Demographic / State-Wise Performance Table (No Limit)
$stateMatrixSql = "SELECT 
    COALESCE(NULLIF(state, ''), 'Unknown') as geo_state,
    COUNT(id) as total,
    COUNT(CASE WHEN status = 'Success' THEN 1 END) as success,
    SUM(CASE WHEN status = 'Success' THEN amount ELSE 0 END) as revenue
FROM register WHERE $whereSQL
GROUP BY geo_state ORDER BY success DESC";
$stateMatrixRes = $con->query($stateMatrixSql);

// 5. Age Category Distribution Metrics
$ageMatrixSql = "SELECT 
    COALESCE(NULLIF(age, ''), 'Unspecified') as age_group,
    COUNT(id) as total,
    COUNT(CASE WHEN status = 'Success' THEN 1 END) as success,
    COUNT(CASE WHEN status = 'Pending' THEN 1 END) as pending
FROM register WHERE $whereSQL
GROUP BY age_group ORDER BY total DESC";
$ageMatrixRes = $con->query($ageMatrixSql);

// 6. Marketing Source Acquisition Performance Channels
$sourceMatrixSql = "SELECT 
    COALESCE(NULLIF(source, ''), 'Organic / Direct') as channel,
    COUNT(id) as total,
    COUNT(CASE WHEN status = 'Success' THEN 1 END) as success,
    SUM(CASE WHEN status = 'Success' THEN amount ELSE 0 END) as revenue
FROM register WHERE $whereSQL
GROUP BY channel ORDER BY revenue DESC";
$sourceMatrixRes = $con->query($sourceMatrixSql);
?>

<!-- Framework Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.metric-card { background: #fff; padding: 18px; border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
.filter-card { background: #fff; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
.f-grid { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
.f-input { height: 38px; padding: 6px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; outline: none; background:#fff; }
.btn-primary-custom { background: #2563eb; color: #fff; border: none; padding: 0 20px; height: 38px; border-radius: 6px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px; }
.btn-clear-custom { background: #64748b; color: #fff; text-decoration: none; padding: 8px 15px; height: 38px; border-radius: 6px; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; }
.summary-table th { background-color: #f8fafc; font-weight: 700; color: #334155; font-size: 13px; position: sticky; top: 0; }
.summary-table td { font-size: 13px; color: #000 !important; font-weight: 500; }
.badge-ratio { background: #f1f5f9; color: #0f172a; font-weight: 700; padding: 3px 6px; border-radius: 4px; font-family: monospace; }
.table-scroll-container { max-height: 380px; overflow-y: auto; }
</style>

<div class="page-wrapper">
    <div class="page-content">
        
        <!-- Breadcrumb Header -->
        <div class="page-breadcrumb d-flex align-items-center" style="margin-bottom: 15px; background: #fff; padding: 10px 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <div class="breadcrumb-title" style="border-right: 2px solid #e2e8f0; padding-right: 10px; font-weight: 700; font-size: 14px; color: #0f172a; text-transform: uppercase;">
                <i class='bx bx-pie-chart-alt-2' style='font-size:18px; vertical-align: middle;'></i> Corporate Intelligence Reporting Suite
            </div>
            <div class="ms-auto">
                <span class="badge bg-dark px-3 py-2" style="font-size:12px;">Unified Analytics Center</span>
            </div>
        </div>

        <!-- 🔍 Date Filtering Rules Management -->
        <div class="filter-card shadow-sm">
            <form method="post" class="f-grid">
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 small font-weight-bold text-secondary">Custom Range Isolation:</label>
                    <input type="date" name="datef" class="f-input" value="<?= htmlspecialchars($datef) ?>">
                    <span class="text-muted">to</span>
                    <input type="date" name="datel" class="f-input" value="<?= htmlspecialchars($datel) ?>">
                </div>
                
                <button type="submit" class="btn-primary-custom"><i class='bx bx-refresh'></i> Regenerate Master Records Matrix</button>
                
                <?php if ($filterApplied): ?>
                    <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="btn-clear-custom">Reset Dynamic Rules</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- 📊 Live Metric Total Counters -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="metric-card border-start border-primary border-4">
                    <div class="text-muted small text-uppercase font-weight-bold">Combined Dataset Volume</div>
                    <h3 class="mb-0 mt-1 font-weight-bold text-dark"><?= number_format($grandTotalRes['total']) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="metric-card border-start border-success border-4">
                    <div class="text-muted small text-uppercase font-weight-bold">Conversions (Success)</div>
                    <h3 class="mb-0 mt-1 font-weight-bold text-success"><?= number_format($grandTotalRes['success']) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="metric-card border-start border-warning border-4">
                    <div class="text-muted small text-uppercase font-weight-bold">Pipeline Workload (Pending)</div>
                    <h3 class="mb-0 mt-1 font-weight-bold text-warning"><?= number_format($grandTotalRes['pending']) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="metric-card border-start border-info border-4">
                    <div class="text-muted small text-uppercase font-weight-bold">All-Time Revenue Secured</div>
                    <h3 class="mb-0 mt-1 font-weight-bold text-info">₹<?= number_format($grandTotalRes['revenue'], 2) ?></h3>
                </div>
            </div>
        </div>

        <!-- 📈 Chart Visualizations Area -->
        <div class="row g-3 mb-4">
            <!-- Company Growth Trend Chart (NEW UPGRADED LINE STRATEGY) -->
            <div class="col-12 col-md-8">
                <div class="card border shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class='bx bx-trending-up text-primary'></i> Master Corporate Growth Graph (Success vs Pending Streams)</h6>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height:280px; width:100%;">
                            <canvas id="companyGrowthTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ledger Status Doughnut Chart -->
            <div class="col-12 col-md-4">
                <div class="card border shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class='bx bx-pie-chart text-success'></i> Global Transaction Ledger Ratio</h6>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div style="position: relative; height:280px; width:100%;">
                            <canvas id="ledgerDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 📊 Tabular Matrices Content Block -->
        <div class="row g-3 mb-4">
            
            <!-- Matrix 1: All-Time Chronological Month-Wise Flows (Jan 2025 to Present) -->
            <div class="col-12 col-md-5">
                <div class="card border shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class='bx bx-calendar-event text-primary'></i> Chronological Month-Wise Flow Analysis</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-scroll-container">
                            <table class="table table-striped align-middle mb-0 summary-table">
                                <thead>
                                    <tr>
                                        <th>Month-Year Timeline</th>
                                        <th class="text-center">Total Volume</th>
                                        <th class="text-center text-success">🟢 Success</th>
                                        <th class="text-center text-warning">🟡 Pending</th>
                                        <th class="text-center">Ratio %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($monthMatrixRes && $monthMatrixRes->num_rows > 0) {
                                    while ($mRow = $monthMatrixRes->fetch_assoc()) {
                                        $chartTimelineMonths[] = $mRow['month_label'];
                                        $chartTimelineSuccess[] = (int)$mRow['success_reg'];
                                        $chartTimelinePending[] = (int)$mRow['pending_reg'];
                                        
                                        $monthConvRate = $mRow['total_reg'] > 0 ? round(($mRow['success_reg'] / $mRow['total_reg']) * 100, 1) : 0;
                                        echo "
                                        <tr>
                                            <td><strong>{$mRow['month_label']}</strong></td>
                                            <td class='text-center'>".number_format($mRow['total_reg'])."</td>
                                            <td class='text-center text-success font-weight-bold'>".number_format($mRow['success_reg'])."</td>
                                            <td class='text-center text-warning font-weight-bold'>".number_format($mRow['pending_reg'])."</td>
                                            <td class='text-center'><span class='badge-ratio'>{$monthConvRate}%</span></td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center text-muted p-4'>Timeline trace metrics empty.</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Matrix 2: User wise Referral Analysis Comparison (Cleaned No Conversion Filtering) -->
            <div class="col-12 col-md-7">
                <div class="card border shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class='bx bx-user-voice text-warning'></i> Referral User Cross-Year Success Matrix</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-scroll-container">
                            <table class="table table-striped align-middle mb-0 summary-table">
                                <thead>
                                    <tr>
                                        <th>Referral Account Channel</th>
                                        <th class="text-center bg-light">2025 Succ / Total</th>
                                        <th class="text-center bg-light">2025 %</th>
                                        <th class="text-center" style="color:#2563eb; background:#f0fdf4;">2026 Succ / Total</th>
                                        <th class="text-center" style="color:#2563eb; background:#f0fdf4;">2026 %</th>
                                        <th class="text-center text-warning">Total Pending</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($processedRefRows)) {
                                    foreach ($processedRefRows as $rRow) {
                                        $ratio2025 = $rRow['total_2025'] > 0 ? round(($rRow['success_2025'] / $rRow['total_2025']) * 100, 1) : 0;
                                        $ratio2026 = $rRow['total_2026'] > 0 ? round(($rRow['success_2026'] / $rRow['total_2026']) * 100, 1) : 0;
                                        
                                        $isOthersAggregated = ($rRow['referral_user'] === 'Others (No Conversion Users)');
                                        $rowInlineHighlight = $isOthersAggregated ? "style='background-color: #f8fafc; font-style: italic;'" : "";
                                        $iconClass = $isOthersAggregated ? "bx-folder" : "bx-hash";
                                        
                                        echo "
                                        <tr {$rowInlineHighlight}>
                                            <td><span style='font-weight:700; color:#1e293b;'><i class='bx {$iconClass} text-muted'></i> ".htmlspecialchars($rRow['referral_user'])."</span></td>
                                            <td class='text-center'>
                                                <span class='text-success font-weight-bold'>{$rRow['success_2025']}</span> / <span class='text-secondary small'>{$rRow['total_2025']}</span>
                                            </td>
                                            <td class='text-center'><span class='badge-ratio'>{$ratio2025}%</span></td>
                                            
                                            <td class='text-center' style='background-color:#f0fdf4;'>
                                                <span class='text-success font-weight-bold' style='font-size:14px;'>{$rRow['success_2026']}</span> / <span class='text-secondary small'>{$rRow['total_2026']}</span>
                                            </td>
                                            <td class='text-center' style='background-color:#f0fdf4;'><span class='badge-ratio' style='background:#dbeafe; color:#2563eb;'>{$ratio2026}%</span></td>
                                            
                                            <td class='text-center text-danger font-weight-bold'>".number_format($rRow['total_pending_overall'])."</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center text-muted p-4'>No structural referral metadata processed.</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Secondary Analytics Row Framework -->
        <div class="row g-3">
            
            <!-- 1. State-Wise Market Share Leaderboard (All States - Full Grid Matrix) -->
            <div class="col-12 col-md-5">
                <div class="card border shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class='bx bx-map text-success'></i> Regional State Demographics Performance (All Processed States)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-scroll-container" style="max-height: 350px;">
                            <table class="table table-striped mb-0 summary-table">
                                <thead>
                                    <tr>
                                        <th>State Jurisdiction</th>
                                        <th class="text-center">Total Volume</th>
                                        <th class="text-center text-success">Success Logs</th>
                                        <th class="text-end">Revenue Realised</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($stateMatrixRes && $stateMatrixRes->num_rows > 0) {
                                    while($stRow = $stateMatrixRes->fetch_assoc()) {
                                        echo "<tr>
                                            <td><strong>{$stRow['geo_state']}</strong></td>
                                            <td class='text-center'>".number_format($stRow['total'])."</td>
                                            <td class='text-center text-success font-weight-bold'>".number_format($stRow['success'])."</td>
                                            <td class='text-end font-weight-bold text-dark'>₹".number_format($stRow['revenue'],2)."</td>
                                        </tr>";
                                    }
                                } else { echo "<tr><td colspan='4' class='text-center text-muted p-3'>No localized operational metrics mapped.</td></tr>"; }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Age Group Insights -->
            <div class="col-12 col-md-3">
                <div class="card border shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class='bx bx-group text-info'></i> Age Demographics</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-scroll-container" style="max-height: 350px;">
                            <table class="table table-striped mb-0 summary-table">
                                <thead>
                                    <tr>
                                        <th>Age Bracket</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center text-success">Succ</th>
                                        <th class="text-center text-warning">Pend</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($ageMatrixRes && $ageMatrixRes->num_rows > 0) {
                                    while($agRow = $ageMatrixRes->fetch_assoc()) {
                                        echo "<tr>
                                            <td><span class='badge bg-light text-dark border'>{$agRow['age_group']}</span></td>
                                            <td class='text-center'>{$agRow['total']}</td>
                                            <td class='text-center text-success font-weight-bold'>{$agRow['success']}</td>
                                            <td class='text-center text-warning font-weight-bold'>{$agRow['pending']}</td>
                                        </tr>";
                                    }
                                } else { echo "<tr><td colspan='4' class='text-center text-muted p-3'>No category blocks found</td></tr>"; }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Acquisition Channels & Lead Source ROI -->
            <div class="col-12 col-md-4">
                <div class="card border shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class='bx bx-bullseye text-danger'></i> Acquisition Funnel Channels ROI</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-scroll-container" style="max-height: 350px;">
                            <table class="table table-striped mb-0 summary-table">
                                <thead>
                                    <tr>
                                        <th>Acquisition Node</th>
                                        <th class="text-center">Conversions</th>
                                        <th class="text-center">Conv. %</th>
                                        <th class="text-end">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($sourceMatrixRes && $sourceMatrixRes->num_rows > 0) {
                                    while($srcRow = $sourceMatrixRes->fetch_assoc()) {
                                        $srcRatio = $srcRow['total'] > 0 ? round(($srcRow['success'] / $srcRow['total']) * 100, 1) : 0;
                                        echo "<tr>
                                            <td><strong>{$srcRow['channel']}</strong></td>
                                            <td class='text-center'>{$srcRow['success']} <span class='text-muted small'>/ {$srcRow['total']}</span></td>
                                            <td class='text-center'><span class='badge-ratio'>{$srcRatio}%</span></td>
                                            <td class='text-end text-success font-weight-bold'>₹".number_format($srcRow['revenue'],0)."</td>
                                        </tr>";
                                    }
                                } else { echo "<tr><td colspan='4' class='text-center text-muted p-3'>No marketing channel trace data found.</td></tr>"; }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- ==========================================
      📊 GRAPHICAL RENDERING ENGINE SCRIPT 
     ========================================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // 1. Double Line Graph Engine for Company Growth Metrics Tracking
    const ctxGrowth = document.getElementById('companyGrowthTrendChart').getContext('2d');
    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: <?= json_encode($chartTimelineMonths) ?>,
            datasets: [
                {
                    label: '📈 Success Processing Flow',
                    data: <?= json_encode($chartTimelineSuccess) ?>,
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.05)',
                    borderWidth: 3,
                    tension: 0.25,
                    fill: true,
                    pointBackgroundColor: '#16a34a',
                    pointRadius: 4
                },
                {
                    label: '📉 Pending Workload Load',
                    data: <?= json_encode($chartTimelinePending) ?>,
                    borderColor: '#ea580c',
                    backgroundColor: 'rgba(234, 88, 12, 0.02)',
                    borderWidth: 2.5,
                    borderDash: [4, 4],
                    tension: 0.25,
                    fill: false,
                    pointBackgroundColor: '#c2410c',
                    pointRadius: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { weight: 'bold' } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: 'bold' } }
                }
            },
            plugins: {
                legend: { 
                    position: 'top', 
                    labels: { boxWidth: 15, font: { weight: 'bold', size: 12 } } 
                }
            }
        }
    });

    // 2. Global Doughnut Chart Ledger Balancing
    const ctxDistribution = document.getElementById('ledgerDistributionChart').getContext('2d');
    new Chart(ctxDistribution, {
        type: 'doughnut',
        data: {
            labels: ['Success Status', 'Pending Pipelines', 'Rejected Matrix'],
            datasets: [{
                data: [
                    <?= (int)$grandTotalRes['success'] ?>, 
                    <?= (int)$grandTotalRes['pending'] ?>, 
                    <?= (int)$grandTotalRes['rejected'] ?>
                ],
                backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                borderWidth: 1.5,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11, weight: 'bold' } } }
            },
            cutout: '72%'
        }
    });
});
</script>

<?php include 'searchbar.php'; ?>