<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

include 'head.php';
include 'db.php'; // Database connection

if (!$con) {
    die("Database connection failed: " . db_error());
}

// Function (for word limiting - kept for consistency)
function limit_words($text, $limit) {
    $words = preg_split('/\s+/', trim($text));
    return implode(' ', array_slice($words, 0, $limit)) . (count($words) > $limit ? '...' : '');
}

// --- Filter Logic ---
$filter_name = "All Time";
$where_clause = ""; // Initially empty
$start_date = '';
$end_date = '';
$selected_period = $_GET['filter_period'] ?? 'ALL_TIME';

if (isset($_GET['clear_filter'])) {
    header('Location: ' . basename($_SERVER['PHP_SELF'])); 
    exit();
}

// 1. Quick Filter Logic
if ($selected_period != 'ALL_TIME') {
    $period = $selected_period;
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
        // Start date filter with WHERE
        $where_clause = " WHERE date BETWEEN '$start_date' AND '$end_date'";
    }
} 
// 2. Date Range Filter Logic (overrides Quick Filter if set)
elseif (isset($_GET['start_date']) && isset($_GET['end_date']) && $_GET['start_date'] != '' && $_GET['end_date'] != '') {
    $start_date = $con->real_escape_string($_GET['start_date']);
    $end_date = $con->real_escape_string($_GET['end_date']);
    $selected_period = ''; 

    if (strtotime($start_date) <= strtotime($end_date)) {
        // Start date filter with WHERE
        $where_clause = " WHERE date BETWEEN '$start_date' AND '$end_date'";
        $filter_name = "Custom Range: " . date('d M Y', strtotime($start_date)) . " to " . date('d M Y', strtotime($end_date));
    } else {
         $filter_name = "Invalid Date Range Applied";
    }
}

// --- Data Fetching Function (FIXED SQL Syntax Error, ASC Order, and NULL Check) ---
function fetchData($con, $select_expression, $group_by_expression, $where_clause, $order_by_col = 'total_registration', $limit = 10) {
    
    // Determine the sorting order (Ascending)
    $orderBy = ($order_by_col == 'total_registration') ? 'total_registration ASC' : $group_by_expression . ' ASC';

    // 1. Determine the $null_check part (starts with AND if non-empty)
    $base_col_parts = explode(' AS ', $select_expression);
    $base_col = $base_col_parts[0];
    
    $null_check = "";
    // Apply NULL/Empty check for grouping columns like state, city, ref, etc.
    if (!in_array($base_col, ['date', 'id', "DATE_FORMAT(date, '%Y-%m')"])) { 
        $null_check = " AND $base_col IS NOT NULL AND $base_col != '' ";
    }
    
    // 2. Build the final WHERE clause safely (Ensuring no lone AND is present)
    $full_where_clause = "";
    
    if (!empty($where_clause)) {
        // Case 1: Filter is applied (" WHERE date BETWEEN..."). Append the null check.
        $full_where_clause = $where_clause . $null_check;
    } elseif (!empty($null_check)) {
        // Case 2: No date filter ("All Time"), but we have a null check (state/city/ref). 
        // We must start with the WHERE keyword.
        $null_check_safe = ltrim($null_check, ' AND');
        $full_where_clause = " WHERE " . $null_check_safe;
    }
    
    // 3. Construct the SQL query
    $sql = "
        SELECT 
            $select_expression AS label,
            COUNT(id) AS total_registration,
            SUM(CASE WHEN status = 'Success' THEN 1 ELSE 0 END) AS success_count
        FROM register
        $full_where_clause
        GROUP BY label
        ORDER BY $orderBy
        LIMIT $limit
    ";
    
    $result = $con->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if (empty($row['label'])) {
                 $row['label'] = 'Unknown';
            }
            $data[] = $row;
        }
    } else {
        // Output critical SQL error 
        echo "<p style='color: red;'><b>SQL Error:</b> " . htmlspecialchars($con->error) . "</p>";
        echo "<p><b>FAILED QUERY:</b> " . htmlspecialchars($sql) . "</p>";
    }
    return $data;
}

// 1. Month-wise Data (Group by Date, Order by Date ASC)
$month_data = fetchData(
    $con, 
    "DATE_FORMAT(date, '%Y-%m')", 
    "DATE_FORMAT(date, '%Y-%m')", 
    $where_clause, 
    "DATE_FORMAT(date, '%Y-%m')", // Order by Month ASC
    120 
); 

$month_labels = json_encode(array_column($month_data, 'label'));
$month_total_data = json_encode(array_column($month_data, 'total_registration'));
$month_success_data = json_encode(array_column($month_data, 'success_count'));

// 2. State-wise Data (Order by Total Count ASC)
$state_data = fetchData($con, 'state', 'state', $where_clause, 'total_registration');
$state_labels = json_encode(array_column($state_data, 'label'));
$state_total_data = json_encode(array_column($state_data, 'total_registration'));
$state_success_data = json_encode(array_column($state_data, 'success_count'));

// 3. City-wise Data (Order by Total Count ASC)
$city_data = fetchData($con, 'city', 'city', $where_clause, 'total_registration');
$city_labels = json_encode(array_column($city_data, 'label'));
$city_total_data = json_encode(array_column($city_data, 'total_registration'));
$city_success_data = json_encode(array_column($city_data, 'success_count'));

// 4. Referral Code-wise Data (Order by Total Count ASC)
$ref_data = fetchData($con, 'ref', 'ref', $where_clause, 'total_registration');
$ref_labels = json_encode(array_column($ref_data, 'label'));
$ref_total_data = json_encode(array_column($ref_data, 'total_registration'));
$ref_success_data = json_encode(array_column($ref_data, 'success_count'));


$con->close();
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
                            <option value="ALL_TIME" <?= ($selected_period == 'ALL_TIME') ? 'selected' : '' ?>>All Time</option>
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
                    <?php if (isset($_GET['filter_period']) && $_GET['filter_period'] != 'ALL_TIME' || (isset($_GET['start_date']) && $_GET['start_date'] != '')): ?>
                        <a href="?clear_filter=1" class="btn btn-sm btn-danger"><i class="bx bx-x"></i> Clear Filter</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <hr/>
        <div class="card bg mt-4 border border-warning">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">🔍 Data Debugging Check (REMOVE THIS LATER)</h5>
            </div>
            <div class="card-body">
                <?php
                // Check overall counts
                $status_check = $con->query("SELECT COUNT(id) AS total, SUM(CASE WHEN status = 'Success' THEN 1 ELSE 0 END) AS successful FROM register");
                $status_row = $status_check ? $status_check->fetch_assoc() : ['total' => 'Error', 'successful' => 'Error'];

                echo "Total Records in Table: <b>" . htmlspecialchars($status_row['total']) . "</b><br>";
                echo "Total Successful Records: <b>" . htmlspecialchars($status_row['successful']) . "</b><br>";

                // Check State data array content
                echo "<h6>State Data Array (PHP Output - Check Count > 0):</h6>";
                echo "<p>Total state groups found: <b>" . count($state_data) . "</b></p>";
                echo "<pre style='background:#eee; padding:10px; font-size: 12px;'>" . htmlspecialchars(print_r($state_data, true)) . "</pre>";
                
                // Check JSON output
                echo "<h6>JSON Sent to Chart.js:</h6>";
                echo "State Labels: <span class='badge bg-secondary'>" . htmlspecialchars($state_labels) . "</span><br>";
                echo "State Data: <span class='badge bg-secondary'>" . htmlspecialchars($state_total_data) . "</span>";
                ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card bg">
                    <div class="card-header">
                        <h5 class="mb-0">📅 Month-wise Trend (Total & Success)</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="monthStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card bg h-100">
                    <div class="card-header">
                        <h5 class="mb-0">🗺️ State-wise Report (Top 10 - Ascending Count)</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="stateWiseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card bg h-100">
                    <div class="card-header">
                        <h5 class="mb-0">🏙️ City-wise Report (Top 10 - Ascending Count)</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="cityWiseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card bg h-100">
                    <div class="card-header">
                        <h5 class="mb-0">🔗 Referral Code Report (Top 10 - Ascending Count)</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="refWiseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card bg h-100">
                    <div class="card-header">
                        <h5 class="mb-0">📊 Total Success Rate</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                         <div style="max-width: 400px; max-height: 400px;">
                             <canvas id="successRatePie"></canvas>
                         </div>
                    </div>
                </div>
            </div>

        </div> </div>
</div>
<?php include 'foot.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        function parseJson(data) {
            try {
                const trimmedData = data.trim();
                if (trimmedData === '[]' || trimmedData === '') return [];
                return JSON.parse(trimmedData);
            } catch (e) {
                console.error("JSON Parsing Error. Check PHP output for errors:", data, e);
                return [];
            }
        }
        
        // --- Data from PHP to JavaScript ---
        const monthLabels = parseJson(<?= $month_labels; ?>);
        const monthTotalData = parseJson(<?= $month_total_data; ?>);
        const monthSuccessData = parseJson(<?= $month_success_data; ?>);

        const stateLabels = parseJson(<?= $state_labels; ?>);
        const stateTotalData = parseJson(<?= $state_total_data; ?>);
        const stateSuccessData = parseJson(<?= $state_success_data; ?>);

        const cityLabels = parseJson(<?= $city_labels; ?>);
        const cityTotalData = parseJson(<?= $city_total_data; ?>);
        const citySuccessData = parseJson(<?= $city_success_data; ?>);

        const refLabels = parseJson(<?= $ref_labels; ?>);
        const refTotalData = parseJson(<?= $ref_total_data; ?>);
        const refSuccessData = parseJson(<?= $ref_success_data; ?>);
        
        // Calculate Global Success Rate for Pie Chart
        const totalOverall = monthTotalData.reduce((sum, current) => sum + current, 0);
        const successOverall = monthSuccessData.reduce((sum, current) => sum + current, 0);
        const pendingOverall = totalOverall - successOverall;

        // --- Helper Function for colors ---
        function generateColors(count) {
            const colors = [];
            for (let i = 0; i < count; i++) {
                const r = Math.floor(Math.random() * 200 + 55);
                const g = Math.floor(Math.random() * 200 + 55);
                const b = Math.floor(Math.random() * 200 + 55);
                colors.push(`rgba(${r}, ${g}, ${b}, 0.7)`);
            }
            return colors;
        }

        // --- 1. Month-wise Chart (Total vs Success Trend) ---
        if (document.getElementById('monthStatusChart') && monthLabels.length > 0) {
            new Chart(document.getElementById('monthStatusChart'), {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [
                        {
                            label: 'Total Registration',
                            data: monthTotalData,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)', // Blue
                            borderColor: 'rgba(54, 162, 235, 1)',
                            type: 'line', // Line for Total Trend
                            fill: false,
                            tension: 0.4
                        },
                        {
                            label: 'Successful Registration',
                            data: monthSuccessData,
                            backgroundColor: 'rgba(75, 192, 192, 0.9)', // Greenish-Cyan (Bar)
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    },
                    plugins: {
                        title: { display: true, text: 'Monthly Registration Trend (ASC by Month)' }
                    }
                }
            });
        }

        // --- 2. State-wise Chart (Horizontal Bars - ASC Count) ---
        if (document.getElementById('stateWiseChart') && stateLabels.length > 0) {
            new Chart(document.getElementById('stateWiseChart'), {
                type: 'bar',
                data: {
                    labels: stateLabels,
                    datasets: [
                        {
                            label: 'Total Registrations',
                            data: stateTotalData,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)', // Red
                            borderWidth: 1
                        },
                        {
                            label: 'Successful Registrations',
                            data: stateSuccessData,
                            backgroundColor: 'rgba(153, 102, 255, 0.7)', // Purple
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    indexAxis: 'y', // Landscape/Horizontal View
                    responsive: true,
                    scales: { x: { beginAtZero: true } },
                    plugins: { title: { display: false } }
                }
            });
        }

        // --- 3. City-wise Chart (Horizontal Bars - ASC Count) ---
        if (document.getElementById('cityWiseChart') && cityLabels.length > 0) {
            new Chart(document.getElementById('cityWiseChart'), {
                type: 'bar',
                data: {
                    labels: cityLabels,
                    datasets: [
                         {
                            label: 'Total Registrations',
                            data: cityTotalData,
                            backgroundColor: 'rgba(255, 159, 64, 0.7)', // Orange
                            borderWidth: 1
                        },
                        {
                            label: 'Successful Registrations',
                            data: citySuccessData,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)', // Greenish-Cyan
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    indexAxis: 'y', // Landscape/Horizontal View
                    responsive: true,
                    scales: { x: { beginAtZero: true } },
                    plugins: { title: { display: false } }
                }
            });
        }
        
        // --- 4. Referral Code-wise Chart (Horizontal Bars - ASC Count) ---
        if (document.getElementById('refWiseChart') && refLabels.length > 0) {
            new Chart(document.getElementById('refWiseChart'), {
                type: 'bar',
                data: {
                    labels: refLabels,
                    datasets: [
                        {
                            label: 'Total Registrations',
                            data: refTotalData,
                            backgroundColor: 'rgba(255, 206, 86, 0.7)', // Yellow
                            borderWidth: 1
                        },
                        {
                            label: 'Successful Registrations',
                            data: refSuccessData,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)', // Blue
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    indexAxis: 'y', // Landscape/Horizontal View
                    responsive: true,
                    scales: { x: { beginAtZero: true } },
                    plugins: { title: { display: false } }
                }
            });
        }
        
        // --- 5. Success Rate Pie Chart (Extra Graph) ---
        if (document.getElementById('successRatePie') && totalOverall > 0) {
            new Chart(document.getElementById('successRatePie'), {
                type: 'doughnut',
                data: {
                    labels: ['Success', 'Pending/Other'],
                    datasets: [{
                        data: [successOverall, pendingOverall],
                        backgroundColor: [
                            'rgba(75, 192, 192, 1)', // Green for Success
                            'rgba(255, 159, 64, 1)'  // Orange for Pending
                        ],
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: { display: true, text: 'Overall Success vs Pending/Other' }
                    }
                }
            });
        }

    });
</script>