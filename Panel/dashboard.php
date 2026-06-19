<?php
session_start();

/* 🔒 Login check */
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

/* 🔐 Role check - Restrict to admin, superadmin, developer */
$allowedRoles = ['superadmin', 'admin', 'developer'];
$currentStatus = $_SESSION['status'] ?? 'Unknown';

if (!in_array($currentStatus, $allowedRoles)) {
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
            Aapko is dashboard ka access nahi hai.
        </p>
        <a href='login.php?logout' style='
            display:inline-block;
            margin-top:15px;
            padding:8px 15px;
            background:#0f172a;
            color:#fff;
            text-decoration:none;
            border-radius:5px;
        '>Log Out</a>
    </div>";
    exit();
}

include_once 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ==========================================
// 📊 STATS EXTRACTION ENGINE
// ==========================================

// Initialize default fallback arrays
$p1_stats = ['total'=>0, 'success'=>0, 'pending'=>0, 'revenue'=>0.0, 'mail_sent'=>0];
$p2_stats = ['total'=>0, 'success'=>0, 'pending'=>0, 'revenue'=>0.0, 'mail_sent'=>0];
$leads_stats = ['total'=>0];
$p1_recent = [];
$p2_recent = [];
$leads_recent = [];
$role_data = ['Batsman' => 0, 'Bowler' => 0, 'All Rounder' => 0, 'Wicketkeeper' => 0];
$state_data = [];

if ($con) {
    // 1. Phase 1 Stats
    $p1_stats_res = $con->query("SELECT 
        COUNT(id) as total,
        SUM(CASE WHEN status = 'Success' THEN 1 ELSE 0 END) as success,
        SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'Success' THEN amount ELSE 0 END) as revenue,
        SUM(CASE WHEN mailsent = 1 THEN 1 ELSE 0 END) as mail_sent
    FROM `register`");
    if ($p1_stats_res) {
        $p1_stats_assoc = $p1_stats_res->fetch_assoc();
        if ($p1_stats_assoc) $p1_stats = $p1_stats_assoc;
    }

    // 2. Phase 2 Stats
    $p2_stats_res = $con->query("SELECT 
        COUNT(id) as total,
        SUM(CASE WHEN status = 'Success' THEN 1 ELSE 0 END) as success,
        SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN status = 'Success' THEN amount ELSE 0 END) as revenue,
        SUM(CASE WHEN mailsent = 1 THEN 1 ELSE 0 END) as mail_sent
    FROM `register-second`");
    if ($p2_stats_res) {
        $p2_stats_assoc = $p2_stats_res->fetch_assoc();
        if ($p2_stats_assoc) $p2_stats = $p2_stats_assoc;
    }

    // 3. Leads Stats
    $leads_stats_res = $con->query("SELECT COUNT(id) as total FROM `regdata`");
    if ($leads_stats_res) {
        $leads_stats_assoc = $leads_stats_res->fetch_assoc();
        if ($leads_stats_assoc) $leads_stats = $leads_stats_assoc;
    }

    // 5. Recent Candidates Phase 1 (Last 10)
    $p1_res = $con->query("SELECT id, name, reg, player, mobile, state, created_at, status FROM `register` ORDER BY created_at DESC LIMIT 10");
    if ($p1_res) {
        while ($row = $p1_res->fetch_assoc()) {
            $p1_recent[] = $row;
        }
    }

    // 6. Recent Candidates Phase 2 (Last 10)
    $p2_res = $con->query("SELECT id, name, reg, reg2, player, mobile, state, created_at, status, amount FROM `register-second` ORDER BY created_at DESC LIMIT 10");
    if ($p2_res) {
        while ($row = $p2_res->fetch_assoc()) {
            $p2_recent[] = $row;
        }
    }

    // 7. Recent Leads (Last 10)
    $leads_res = $con->query("SELECT id, name, email, phone, state, city, created_at FROM `regdata` ORDER BY created_at DESC LIMIT 10");
    if ($leads_res) {
        while ($row = $leads_res->fetch_assoc()) {
            $leads_recent[] = $row;
        }
    }

    // 8. Role Distribution Chart Data (Combined Phase 1 & Phase 2)
    $role_res1 = $con->query("SELECT player, COUNT(*) as count FROM `register` GROUP BY player");
    if ($role_res1) {
        while ($r = $role_res1->fetch_assoc()) {
            $p = strtolower($r['player']);
            if (strpos($p, 'batsman') !== false && strpos($p, 'wicket') === false) $role_data['Batsman'] += $r['count'];
            elseif (strpos($p, 'bowler') !== false) $role_data['Bowler'] += $r['count'];
            elseif (strpos($p, 'all rounder') !== false || strpos($p, 'all-rounder') !== false) $role_data['All Rounder'] += $r['count'];
            elseif (strpos($p, 'wicket') !== false) $role_data['Wicketkeeper'] += $r['count'];
        }
    }
    $role_res2 = $con->query("SELECT player, COUNT(*) as count FROM `register-second` GROUP BY player");
    if ($role_res2) {
        while ($r = $role_res2->fetch_assoc()) {
            $p = strtolower($r['player']);
            if (strpos($p, 'batsman') !== false && strpos($p, 'wicket') === false) $role_data['Batsman'] += $r['count'];
            elseif (strpos($p, 'bowler') !== false) $role_data['Bowler'] += $r['count'];
            elseif (strpos($p, 'all rounder') !== false || strpos($p, 'all-rounder') !== false) $role_data['All Rounder'] += $r['count'];
            elseif (strpos($p, 'wicket') !== false) $role_data['Wicketkeeper'] += $r['count'];
        }
    }

    // 9. State Wise Leaderboard (Combined Top 5)
    $state_res1 = $con->query("SELECT state, COUNT(*) as count FROM `register` WHERE state != '' GROUP BY state");
    if ($state_res1) {
        while ($s = $state_res1->fetch_assoc()) {
            $state_data[$s['state']] = ($state_data[$s['state']] ?? 0) + $s['count'];
        }
    }
    $state_res2 = $con->query("SELECT state, COUNT(*) as count FROM `register-second` WHERE state != '' GROUP BY state");
    if ($state_res2) {
        while ($s = $state_res2->fetch_assoc()) {
            $state_data[$s['state']] = ($state_data[$s['state']] ?? 0) + $s['count'];
        }
    }
}

// 4. Combined Stats
$total_candidates = ($p1_stats['total'] ?? 0) + ($p2_stats['total'] ?? 0);
$total_success = ($p1_stats['success'] ?? 0) + ($p2_stats['success'] ?? 0);
$total_pending = ($p1_stats['pending'] ?? 0) + ($p2_stats['pending'] ?? 0);
$total_revenue = ($p1_stats['revenue'] ?? 0.0) + ($p2_stats['revenue'] ?? 0.0);
$total_mail_sent = ($p1_stats['mail_sent'] ?? 0) + ($p2_stats['mail_sent'] ?? 0);

arsort($state_data);
$top_states = array_slice($state_data, 0, 5, true);

include 'head.php';
?>

<!-- Add custom fonts and modern icon stylesheets if not already present -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --primary-font: 'Plus Jakarta Sans', sans-serif;
    }
    
    body {
        font-family: var(--primary-font) !important;
    }

    /* Premium Custom Cards */
    .dashboard-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
        border-color: rgba(37, 99, 235, 0.2);
    }
    .card-icon-wrapper {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }
    
    .bg-light-blue { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
    .bg-light-green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .bg-light-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    .bg-light-orange { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }

    .card-title {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .card-value {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1;
    }
    .card-trend {
        font-size: 12px;
        margin-top: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Tabs Styling */
    .custom-tabs .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .custom-tabs .nav-link.active {
        background-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    .custom-tabs .nav-link:hover:not(.active) {
        background-color: #f1f5f9;
        color: #0f172a;
    }

    /* Modern Table design */
    .table-container {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .modern-table {
        margin-bottom: 0;
    }
    .modern-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
        border-bottom: 2px solid #e2e8f0;
    }
    .modern-table td {
        padding: 16px;
        font-size: 14px;
        color: #0f172a;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-status.success { background: #dcfce7; color: #16a34a; }
    .badge-status.pending { background: #fef3c7; color: #d97706; }
    
    .badge-phase {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
</style>

<div class="page-wrapper">
    <div class="page-content">

        <!-- Welcome Banner / Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <h3 class="mb-1 font-weight-bold text-dark" style="font-weight: 700; font-size: 26px;">Young Stars Cricket League</h3>
                <p class="text-secondary mb-0" style="font-size: 14px;">Master Administrative Panel & Candidates Distribution Dashboard</p>
            </div>
            <div>
                <button onclick="location.reload();" class="btn btn-outline-primary d-flex align-items-center gap-2" style="font-weight: 600; border-radius: 8px;">
                    <i class="bx bx-refresh fs-5"></i> Refresh Data
                </button>
            </div>
        </div>

        <!-- 📊 KPI Cards Section -->
        <div class="row g-3 mb-4">
            
            <!-- Card 1: Total Candidates Combined -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon-wrapper bg-light-blue">
                        <i class="bx bx-group"></i>
                    </div>
                    <div class="card-title">Total Registered</div>
                    <div class="card-value"><?= number_format($total_candidates) ?></div>
                    <div class="card-trend d-flex flex-column align-items-start gap-1" style="margin-top: 8px;">
                        <span class="text-success font-weight-bold" style="font-size: 13px;"><i class="bx bx-check-circle"></i> <?= number_format($total_success) ?> Paid</span>
                        <span class="text-info font-weight-bold" style="font-size: 13px;"><i class="bx bx-envelope"></i> <?= number_format($total_mail_sent) ?> Mail Sent</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Phase 1 Stats Card -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon-wrapper bg-light-green">
                        <i class="bx bx-directions"></i>
                    </div>
                    <div class="card-title">Phase 1 Registrations</div>
                    <div class="card-value"><?= number_format($p1_stats['total'] ?? 0) ?></div>
                    <div class="card-trend d-flex flex-column align-items-start gap-1" style="margin-top: 8px;">
                        <span class="text-success font-weight-bold" style="font-size: 13px;"><i class="bx bx-check-circle"></i> <?= number_format($p1_stats['success'] ?? 0) ?> Paid</span>
                        <span class="text-info font-weight-bold" style="font-size: 13px;"><i class="bx bx-envelope"></i> <?= number_format($p1_stats['mail_sent'] ?? 0) ?> Mail Sent</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Phase 2 Stats Card -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon-wrapper bg-light-purple">
                        <i class="bx bx-package"></i>
                    </div>
                    <div class="card-title">Phase 2 Registrations</div>
                    <div class="card-value"><?= number_format($p2_stats['total'] ?? 0) ?></div>
                    <div class="card-trend d-flex flex-column align-items-start gap-1" style="margin-top: 8px;">
                        <span class="text-success font-weight-bold" style="font-size: 13px;"><i class="bx bx-check-circle"></i> <?= number_format($p2_stats['success'] ?? 0) ?> Paid</span>
                        <span class="text-info font-weight-bold" style="font-size: 13px;"><i class="bx bx-envelope"></i> <?= number_format($p2_stats['mail_sent'] ?? 0) ?> Mail Sent</span>
                    </div>
                </div>
            </div>

            <!-- Card 4: Total Revenue Realised -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon-wrapper bg-light-orange">
                        <i class="bx bx-rupee"></i>
                    </div>
                    <div class="card-title">Total Revenue</div>
                    <div class="card-value">₹<?= number_format($total_revenue, 2) ?></div>
                    <div class="card-trend d-flex flex-column align-items-start gap-1" style="margin-top: 8px;">
                        <span class="text-warning font-weight-bold" style="font-size: 13px;"><i class="bx bx-time-five"></i> <?= number_format($total_pending) ?> Unpaid</span>
                        <span class="text-secondary" style="font-size: 12px;"><i class="bx bx-link-external"></i> Leads: <?= number_format($leads_stats['total'] ?? 0) ?> in regdata</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- 📈 Visual Analytics Charts Row -->
        <div class="row g-4 mb-4">
            
            <!-- Chart 1: Role Distribution (Doughnut) -->
            <div class="col-12 col-lg-5">
                <div class="card border shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class="bx bx-cricket-ball text-primary me-2"></i>Candidates Speciality Distribution</h6>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="min-height: 320px;">
                        <div style="position: relative; height: 260px; width: 100%;">
                            <canvas id="roleDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart 2: Top States (Bar) -->
            <div class="col-12 col-lg-7">
                <div class="card border shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 font-weight-bold text-dark"><i class="bx bx-map-alt text-success me-2"></i>Top 5 Registrations by State</h6>
                    </div>
                    <div class="card-body" style="min-height: 320px;">
                        <div style="position: relative; height: 260px; width: 100%;">
                            <canvas id="stateDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 📑 Tabbed Candidates Showcase Section -->
        <div class="card border shadow-sm" style="border-radius: 12px; border: 1px solid #e2e8f0;">
            <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <h6 class="mb-0 font-weight-bold text-dark"><i class="bx bx-list-ul text-warning me-2"></i>Showcase: Recent Registered Candidates</h6>
                
                <!-- Quick Navigation Tabs -->
                <ul class="nav nav-pills custom-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-phase1-tab" data-bs-toggle="pill" data-bs-target="#pills-phase1" type="button" role="tab">Phase 1</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-phase2-tab" data-bs-toggle="pill" data-bs-target="#pills-phase2" type="button" role="tab">Phase 2</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-leads-tab" data-bs-toggle="pill" data-bs-target="#pills-leads" type="button" role="tab">Registered Leads</button>
                    </li>
                </ul>
            </div>
            
            <div class="card-body p-0">
                <div class="tab-content" id="pills-tabContent">
                    
                    <!-- TAB 1: PHASE 1 -->
                    <div class="tab-pane fade show active" id="pills-phase1" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table modern-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Reg. Code</th>
                                        <th>Name</th>
                                        <th>Speciality</th>
                                        <th>Mobile</th>
                                        <th>State</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($p1_recent)): ?>
                                        <?php foreach ($p1_recent as $c): ?>
                                            <tr>
                                                <td>
                                                    <a href="phase1data.php" class="font-weight-bold text-primary" style="font-family: monospace; font-size: 14px; text-decoration: none;">
                                                        <?= htmlspecialchars($c['reg'] ?? 'N/A') ?>
                                                    </a>
                                                </td>
                                                <td class="font-weight-bold"><?= htmlspecialchars($c['name']) ?></td>
                                                <td><?= htmlspecialchars($c['player'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($c['mobile'] ?? 'N/A') ?></td>
                                                <td>
                                                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($c['state'] ?? 'N/A') ?></span>
                                                </td>
                                                <td style="font-size: 13px; color: #64748b;">
                                                    <?= date('d M Y, h:i A', strtotime($c['created_at'])) ?>
                                                </td>
                                                <td>
                                                    <?php if ($c['status'] === 'Success'): ?>
                                                        <span class="badge-status success"><i class="bx bx-check-double"></i> Success</span>
                                                    <?php else: ?>
                                                        <span class="badge-status pending"><i class="bx bx-time"></i> Pending</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">No recent candidates found in Phase 1</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 text-center border-top">
                            <a href="phase1data.php" class="btn btn-sm btn-link font-weight-bold text-primary text-decoration-none">
                                View All Phase 1 Candidates <i class="bx bx-right-arrow-alt"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- TAB 2: PHASE 2 -->
                    <div class="tab-pane fade" id="pills-phase2" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table modern-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Reg IDs</th>
                                        <th>Name</th>
                                        <th>Speciality</th>
                                        <th>Mobile</th>
                                        <th>State</th>
                                        <th>Amount</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($p2_recent)): ?>
                                        <?php foreach ($p2_recent as $c): ?>
                                            <tr>
                                                <td>
                                                    <a href="phase2data.php" class="font-weight-bold text-primary" style="font-family: monospace; font-size: 13px; text-decoration: none;">
                                                        <?= htmlspecialchars($c['reg'] ?? '') ?><br><small class="text-muted"><?= htmlspecialchars($c['reg2'] ?? '') ?></small>
                                                    </a>
                                                </td>
                                                <td class="font-weight-bold"><?= htmlspecialchars($c['name']) ?></td>
                                                <td><?= htmlspecialchars($c['player'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($c['mobile'] ?? 'N/A') ?></td>
                                                <td>
                                                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($c['state'] ?? 'N/A') ?></span>
                                                </td>
                                                <td class="font-weight-bold">₹<?= number_format($c['amount'] ?? 0, 2) ?></td>
                                                <td style="font-size: 13px; color: #64748b;">
                                                    <?= date('d M Y, h:i A', strtotime($c['created_at'])) ?>
                                                </td>
                                                <td>
                                                    <?php if ($c['status'] === 'Success'): ?>
                                                        <span class="badge-status success"><i class="bx bx-check-double"></i> Success</span>
                                                    <?php else: ?>
                                                        <span class="badge-status pending"><i class="bx bx-time"></i> Pending</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">No recent candidates found in Phase 2</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 text-center border-top">
                            <a href="phase2data.php" class="btn btn-sm btn-link font-weight-bold text-primary text-decoration-none">
                                View All Phase 2 Candidates <i class="bx bx-right-arrow-alt"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- TAB 3: LEADS -->
                    <div class="tab-pane fade" id="pills-leads" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table modern-table align-middle">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($leads_recent)): ?>
                                        <?php $sn = 0; foreach ($leads_recent as $c): ?>
                                            <tr>
                                                <td><?= ++$sn ?></td>
                                                <td class="font-weight-bold"><?= htmlspecialchars($c['name']) ?></td>
                                                <td><?= htmlspecialchars($c['email'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($c['phone'] ?? 'N/A') ?></td>
                                                <td>
                                                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($c['state'] ?? 'N/A') ?></span>
                                                </td>
                                                <td><?= htmlspecialchars($c['city'] ?? 'N/A') ?></td>
                                                <td style="font-size: 13px; color: #64748b;">
                                                    <?= date('d M Y, h:i A', strtotime($c['created_at'])) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">No recent leads found in regdata</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 text-center border-top">
                            <a href="register_data.php" class="btn btn-sm btn-link font-weight-bold text-primary text-decoration-none">
                                View All Registered Leads <i class="bx bx-right-arrow-alt"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- ==========================================
      📊 CHARTS SCRIPT RENDERING ENGINE
     ========================================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Speciality Distribution Chart
    const ctxRole = document.getElementById('roleDistributionChart').getContext('2d');
    new Chart(ctxRole, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_keys($role_data)) ?>,
            datasets: [{
                data: <?= json_encode(array_values($role_data)) ?>,
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6'],
                borderColor: '#ffffff',
                borderWidth: 2,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: {
                            family: 'Plus Jakarta Sans',
                            size: 12,
                            weight: '600'
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // 2. State Distribution Chart
    const ctxState = document.getElementById('stateDistributionChart').getContext('2d');
    new Chart(ctxState, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($top_states)) ?>,
            datasets: [{
                label: 'Candidate Count',
                data: <?= json_encode(array_values($top_states)) ?>,
                backgroundColor: 'rgba(37, 99, 235, 0.85)',
                borderColor: '#2563eb',
                borderWidth: 1.5,
                borderRadius: 8,
                barThickness: 32
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    },
                    ticks: {
                        font: {
                            family: 'Plus Jakarta Sans',
                            weight: '500'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Plus Jakarta Sans',
                            weight: '600'
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>

<?php include 'foot.php'; ?>
