<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

include 'head.php';
// 'db.php' is assumed to establish the $con mysqli connection
include 'db.php'; 

if (!isset($con) || $con->connect_error) {
    // Better error handling for DB connection
    die("<div class='alert alert-danger'>Database connection failed: " . htmlspecialchars($con->connect_error) . "</div>");
}

function limit_words($text, $limit) {
    $words = preg_split('/\s+/', trim($text));
    return implode(' ', array_slice($words, 0, $limit)) . (count($words) > $limit ? '...' : '');
}

// --- Filter Logic (Using Prepared Statements for Safety) ---
$filter_name = "All Time";
$where_clause_parts = [];
$params = [];
$types = '';
$start_date = '';
$end_date = '';
$selected_period = $_GET['filter_period'] ?? 'ALL_TIME';

if (isset($_GET['clear_filter'])) {
    header('Location: ' . basename($_SERVER['PHP_SELF'])); 
    exit();
}

// Quick Filter Logic
if (isset($_GET['filter_period']) && $_GET['filter_period'] !== 'ALL_TIME') {
    $period = $_GET['filter_period'];
    $today = date('Y-m-d');
    $start_date_temp = '';
    $end_date_temp = '';

    switch ($period) {
        case 'TODAY': $start_date_temp = $today; $end_date_temp = $today; $filter_name = "Today"; break;
        case 'THIS_WEEK': $start_date_temp = date('Y-m-d', strtotime('monday this week')); $end_date_temp = date('Y-m-d', strtotime('sunday this week')); $filter_name = "This Week"; break;
        case 'LAST_WEEK': $start_date_temp = date('Y-m-d', strtotime('monday last week')); $end_date_temp = date('Y-m-d', strtotime('sunday last week')); $filter_name = "Last Week"; break;
        case 'THIS_MONTH': $start_date_temp = date('Y-m-01'); $end_date_temp = date('Y-m-t'); $filter_name = "This Month"; break;
        case 'LAST_MONTH': $start_date_temp = date('Y-m-01', strtotime('last month')); $end_date_temp = date('Y-m-t', strtotime('last month')); $filter_name = "Last Month"; break;
        case 'TOMORROW': $start_date_temp = date('Y-m-d', strtotime('+1 day')); $end_date_temp = date('Y-m-d', strtotime('+1 day')); $filter_name = "Tomorrow (Future)"; break;
    }

    if (!empty($start_date_temp) && !empty($end_date_temp)) {
        $start_date = $start_date_temp;
        $end_date = $end_date_temp;
        $where_clause_parts[] = "created_at BETWEEN ? AND ?";
        $params[] = $start_date . ' 00:00:00';
        $params[] = $end_date . ' 23:59:59';
        $types .= 'ss';
    }
} 

// Custom Date Range Filter Logic (Overrides Quick Filter if both are set)
if (isset($_GET['start_date']) && isset($_GET['end_date']) && $_GET['start_date'] !== '' && $_GET['end_date'] !== '') {
    $custom_start_date = $_GET['start_date'];
    $custom_end_date = $_GET['end_date'];
    $selected_period = ''; // Clear quick period selection
    
    // Clear previous filter parts if custom is set
    $where_clause_parts = [];
    $params = [];
    $types = '';
    $start_date = $custom_start_date;
    $end_date = $custom_end_date;

    if (strtotime($start_date) <= strtotime($end_date)) {
        $where_clause_parts[] = "created_at BETWEEN ? AND ?";
        $params[] = $start_date . ' 00:00:00';
        $params[] = $end_date . ' 23:59:59';
        $types .= 'ss';
        $filter_name = "Custom Range: " . date('d M Y', strtotime($start_date)) . " to " . date('d M Y', strtotime($end_date));
    } else {
        $filter_name = "Invalid Date Range Applied";
        $start_date = '';
        $end_date = '';
    }
}

$where_clause_str = count($where_clause_parts) > 0 ? " WHERE " . implode(" AND ", $where_clause_parts) : "";

// --- Data Fetching Function (Optimized and Secure with Prepared Statements) ---
function fetchData($con, $select_expression, $group_by_expression, $where_clause_str, $params, $types, $order_by_col = 'total_registration', $limit = 10, $order_by_count_desc = true) {
    $data = [];
    
    // Determine ORDER BY clause
    if ($order_by_col == 'total_registration' && $order_by_count_desc) {
        $orderBy = 'total_registration DESC'; 
    } else {
        $orderBy = $group_by_expression . ' ASC';
    }

    $sql = "
        SELECT 
            $select_expression AS label,
            COUNT(id) AS total_registration,
            SUM(CASE WHEN status = 'Success' THEN 1 ELSE 0 END) AS success_count
        FROM register
        $where_clause_str
        GROUP BY label
        ORDER BY $orderBy
        LIMIT $limit
    ";
    
    if ($stmt = $con->prepare($sql)) {
        if (!empty($params)) {
            // Bind parameters dynamically
            $stmt->bind_param($types, ...$params);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                // Correctly labels NULL/Empty group values
                if (empty($row['label'])) { 
                    $row['label'] = 'Unknown/Blank';
                }
                $data[] = $row;
            }
            $result->free();
        } else {
            error_log("SQL Execution Error: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("SQL Preparation Error: " . $con->error);
    }
    
    return $data;
}

// 1. Month-wise Data (Uses the secure fetchData for consistency)
$month_data_raw = fetchData($con, 
    "DATE_FORMAT(created_at, '%Y-%m')", 
    "DATE_FORMAT(created_at, '%Y-%m')", 
    $where_clause_str, 
    $params, 
    $types, 
    "DATE_FORMAT(created_at, '%Y-%m')", 
    120, 
    false // ASC order by month
); 

$month_labels = json_encode(array_column($month_data_raw, 'label'));
$month_total_data = json_encode(array_column($month_data_raw, 'total_registration'));
$month_success_data = json_encode(array_column($month_data_raw, 'success_count'));
// Calculate pending data for Month-wise chart (Total - Success)
$month_pending_data = json_encode(array_map(function($total, $success) {
    return $total - $success;
}, array_column($month_data_raw, 'total_registration'), array_column($month_data_raw, 'success_count')));


// 2. State-wise Data
$state_data = fetchData($con, 'state', 'state', $where_clause_str, $params, $types, 'total_registration', 10, true);
$state_labels = json_encode(array_column($state_data, 'label'));
$state_total_data = json_encode(array_column($state_data, 'total_registration'));
$state_success_data = json_encode(array_column($state_data, 'success_count'));

// 3. City-wise Data
$city_data = fetchData($con, 'city', 'city', $where_clause_str, $params, $types, 'total_registration', 10, true);
$city_labels = json_encode(array_column($city_data, 'label'));
$city_total_data = json_encode(array_column($city_data, 'total_registration'));
$city_success_data = json_encode(array_column($city_data, 'success_count'));

// 4. Referral Code-wise Data
$ref_data = fetchData($con, 'ref', 'ref', $where_clause_str, $params, $types, 'total_registration', 10, true);
$ref_labels = json_encode(array_column($ref_data, 'label'));
$ref_total_data = json_encode(array_column($ref_data, 'total_registration'));
$ref_success_data = json_encode(array_column($ref_data, 'success_count'));

// Fetch status check data for Pie chart calculations
$status_check_sql = "SELECT COUNT(id) AS total, SUM(CASE WHEN status = 'Success' THEN 1 ELSE 0 END) AS successful FROM register $where_clause_str";
$status_row = ['total' => 0, 'successful' => 0];

if ($stmt = $con->prepare($status_check_sql)) {
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $status_row = $result->fetch_assoc();
        $result->free();
    } else {
        error_log("Status check execution error: " . $stmt->error);
    }
    $stmt->close();
} else {
    error_log("Status check preparation error: " . $con->error);
}

$con->close();
$total_overall = (int)$status_row['total'];
$success_overall = (int)$status_row['successful'];
$pending_overall = max(0, $total_overall - $success_overall);
?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">📊 Registration Reports</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Full Registration Analysis</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Registration Analysis Graphs</h6>
        <hr />

        <div class="card bg">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="filter_period" class="form-label">Quick Filter</label>
                        <select name="filter_period" id="filter_period" class="form-select">
                            <option value="ALL_TIME" <?= ($selected_period == 'ALL_TIME' || $selected_period == '') ? 'selected' : '' ?>>All Time</option>
                            <option value="TODAY" <?= ($selected_period == 'TODAY') ? 'selected' : '' ?>>Today</option>
                            <option value="THIS_WEEK" <?= ($selected_period == 'THIS_WEEK') ? 'selected' : '' ?>>This Week</option>
                            <option value="LAST_WEEK" <?= ($selected_period == 'LAST_WEEK') ? 'selected' : '' ?>>Last Week</option>
                            <option value="THIS_MONTH" <?= ($selected_period == 'THIS_MONTH') ? 'selected' : '' ?>>This Month</option>
                            <option value="LAST_MONTH" <?= ($selected_period == 'LAST_MONTH') ? 'selected' : '' ?>>Last Month</option>
                            <option value="TOMORROW" <?= ($selected_period == 'TOMORROW') ? 'selected' : '' ?>>Tomorrow (Future)</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= htmlspecialchars($start_date) ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?= htmlspecialchars($end_date) ?>">
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                    </div>
                </form>

                <div class="mt-3">
                    <h5 class="d-inline-block me-3">Current Filter: <span class="badge bg-primary"><?= htmlspecialchars($filter_name) ?></span></h5>
                    <?php if ((isset($_GET['filter_period']) && $_GET['filter_period'] != 'ALL_TIME') || (isset($_GET['start_date']) && $_GET['start_date'] != '')): ?>
                        <a href="?clear_filter=1" class="btn btn-sm btn-danger"><i class="bx bx-x"></i> Clear Filter</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card bg">
                    <div class="card-header"><h5 class="mb-0">📅 Month-wise Trend (Total & Success)</h5></div>
                    <div class="card-body" style="height: 420px;">
                        <div class="chart-container" style="height:100%;">
                            <canvas id="monthStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card bg h-100">
                    <div class="card-header"><h5 class="mb-0">🗺️ State-wise Report (Top 10)</h5></div>
                    <div class="card-body" style="height: 320px;">
                        <div class="chart-container" style="height:100%;">
                            <canvas id="stateWiseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card bg h-100">
                    <div class="card-header"><h5 class="mb-0">🏙️ City-wise Report (Top 10)</h5></div>
                    <div class="card-body" style="height: 320px;">
                        <div class="chart-container" style="height:100%;">
                            <canvas id="cityWiseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card bg h-100">
                    <div class="card-header"><h5 class="mb-0">🔗 Referral Code Report (Top 10)</h5></div>
                    <div class="card-body" style="height: 320px;">
                        <div class="chart-container" style="height:100%;">
                            <canvas id="refWiseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card bg h-100">
                    <div class="card-header"><h5 class="mb-0">📊 Overall Success Rate</h5></div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height:320px;">
                        <div style="max-width: 400px; width:100%;">
                            <canvas id="successRatePie"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'foot.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function safeParse(str) {
        try {
            // Added check for "null" string which sometimes happens with empty PHP JSON output
            if (!str || str.trim() === '[]' || str.trim() === '' || str.trim() === 'null') return [];
            return JSON.parse(str);
        } catch (e) {
            console.error("JSON parse error:", e, str);
            return [];
        }
    }

    // Data from PHP
    const monthLabels = safeParse(<?= $month_labels ?: '[]' ?>);
    const monthTotalData = safeParse(<?= $month_total_data ?: '[]' ?>);
    const monthSuccessData = safeParse(<?= $month_success_data ?: '[]' ?>);
    const monthPendingData = safeParse(<?= $month_pending_data ?: '[]' ?>); // New data for Pending

    // Data fetched DESC. Reverse for horizontal charts (Highest Count at Top).
    const stateData = safeParse(<?= $state_data ? json_encode($state_data) : '[]' ?>);
    const stateLabels = stateData.map(d => d.label).reverse();
    const stateTotalData = stateData.map(d => d.total_registration).reverse();
    const stateSuccessData = stateData.map(d => d.success_count).reverse();

    const cityData = safeParse(<?= $city_data ? json_encode($city_data) : '[]' ?>);
    const cityLabels = cityData.map(d => d.label).reverse();
    const cityTotalData = cityData.map(d => d.total_registration).reverse();
    const citySuccessData = cityData.map(d => d.success_count).reverse();

    const refData = safeParse(<?= $ref_data ? json_encode($ref_data) : '[]' ?>);
    const refLabels = refData.map(d => d.label).reverse();
    const refTotalData = refData.map(d => d.total_registration).reverse();
    const refSuccessData = refData.map(d => d.success_count).reverse();

    const totalOverall = <?= json_encode($total_overall) ?>;
    const successOverall = <?= json_encode($success_overall) ?>;
    const pendingOverall = <?= json_encode($pending_overall) ?>;

    // --- 1) Month-wise chart (Bar/Line Mix - Total & Success) ---
    if (document.getElementById('monthStatusChart')) {
        const ctx = document.getElementById('monthStatusChart').getContext('2d');
        if (monthLabels.length > 0) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [
                        {
                            type: 'bar', // Pending as a bar (bottom layer)
                            label: 'Pending Registration',
                            data: monthPendingData,
                            backgroundColor: 'rgba(255, 159, 64, 0.7)', // Orange
                            borderWidth: 1
                        },
                        {
                            type: 'bar', // Success stacked on Pending
                            label: 'Successful Registration',
                            data: monthSuccessData,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)', // Greenish-Cyan
                            borderWidth: 1
                        },
                        {
                            type: 'line',
                            label: 'Total Registration (Trend)',
                            data: monthTotalData,
                            yAxisID: 'y', // Use primary Y-axis
                            borderColor: 'rgba(54,162,235,1)',
                            backgroundColor: 'rgba(54,162,235,0.2)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            order: 0 // Draw line on top
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { stacked: true, ticks: { autoSkip: false, maxRotation: 45, minRotation: 45 } },
                        y: { stacked: true, beginAtZero: true }
                    },
                    plugins: { title: { display: true, text: 'Monthly Registration Status (Stacked Bars)' } }
                }
            });
        } else {
            const ctx = document.getElementById('monthStatusChart').getContext('2d');
            ctx.font = "16px Arial";
            ctx.fillStyle = "#6c757d";
            ctx.textAlign = "center";
            ctx.fillText("No monthly data available for selected filter.", ctx.canvas.width / 2, ctx.canvas.height / 2);
        }
    }

    // --- 2) State-wise horizontal (Total & Success) ---
    if (document.getElementById('stateWiseChart')) {
        const ctx = document.getElementById('stateWiseChart').getContext('2d');
        if (stateLabels.length > 0) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: stateLabels,
                    datasets: [
                        { label: 'Total Registrations', data: stateTotalData, backgroundColor: 'rgba(255, 99, 132, 0.7)' },
                        { label: 'Successful Registrations', data: stateSuccessData, backgroundColor: 'rgba(153, 102, 255, 0.7)' }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { x: { beginAtZero: true } },
                    plugins: { legend: { position: 'top' } }
                }
            });
        } else {
            const ctx = document.getElementById('stateWiseChart').getContext('2d');
            ctx.font = "16px Arial";
            ctx.fillStyle = "#6c757d";
            ctx.textAlign = "center";
            ctx.fillText("No state data available for selected filter.", ctx.canvas.width / 2, ctx.canvas.height / 2);
        }
    }

    // --- 3) City-wise horizontal (Total & Success) ---
    if (document.getElementById('cityWiseChart')) {
        const ctx = document.getElementById('cityWiseChart').getContext('2d');
        if (cityLabels.length > 0) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: cityLabels,
                    datasets: [
                        { label: 'Total Registrations', data: cityTotalData, backgroundColor: 'rgba(255, 159, 64, 0.7)' },
                        { label: 'Successful Registrations', data: citySuccessData, backgroundColor: 'rgba(75, 192, 192, 0.7)' }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { x: { beginAtZero: true } },
                    plugins: { legend: { position: 'top' } }
                }
            });
        } else {
            const ctx = document.getElementById('cityWiseChart').getContext('2d');
            ctx.font = "16px Arial";
            ctx.fillStyle = "#6c757d";
            ctx.textAlign = "center";
            ctx.fillText("No city data available for selected filter.", ctx.canvas.width / 2, ctx.canvas.height / 2);
        }
    }

    // --- 4) Referral-wise horizontal (Total & Success) ---
    if (document.getElementById('refWiseChart')) {
        const ctx = document.getElementById('refWiseChart').getContext('2d');
        if (refLabels.length > 0) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: refLabels,
                    datasets: [
                        { label: 'Total Registrations', data: refTotalData, backgroundColor: 'rgba(255, 206, 86, 0.7)' },
                        { label: 'Successful Registrations', data: refSuccessData, backgroundColor: 'rgba(54, 162, 235, 0.7)' }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { x: { beginAtZero: true } },
                    plugins: { legend: { position: 'top' } }
                }
            });
        } else {
            const ctx = document.getElementById('refWiseChart').getContext('2d');
            ctx.font = "16px Arial";
            ctx.fillStyle = "#6c757d";
            ctx.textAlign = "center";
            ctx.fillText("No referral data available for selected filter.", ctx.canvas.width / 2, ctx.canvas.height / 2);
        }
    }

    // --- 5) Success rate doughnut ---
    if (document.getElementById('successRatePie')) {
        const ctx = document.getElementById('successRatePie').getContext('2d');
        if (totalOverall > 0) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Success', 'Pending/Other'],
                    datasets: [{
                        data: [successOverall, pendingOverall],
                        backgroundColor: ['rgba(75,192,192,0.9)', 'rgba(255,159,64,0.9)'],
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        title: { display: true, text: 'Overall Success vs Pending/Other' },
                        legend: { position: 'bottom' }
                    }
                }
            });
        } else {
            const ctx = document.getElementById('successRatePie').getContext('2d');
            ctx.font = "16px Arial";
            ctx.fillStyle = "#6c757d";
            ctx.textAlign = "center";
            ctx.fillText("No registrations found for selected filter.", ctx.canvas.width / 2, ctx.canvas.height / 2);
        }
    }
});
</script>