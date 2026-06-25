<?php
session_start();

// ─── AUTH GUARD ───────────────────────────────────────────────────────────────
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

include_once 'db.php';
date_default_timezone_set('Asia/Kolkata');


// ─── FILTERS ──────────────────────────────────────────────────────────────────
$include_stage4   = isset($_GET['stage4']) && $_GET['stage4'] === '1';
$search_query     = trim($_GET['q'] ?? '');
$filter_stage     = trim($_GET['stage'] ?? '');
$filter_zone      = trim($_GET['zone'] ?? '');

// ─── FETCH DATA ───────────────────────────────────────────────────────────────
$rows = [];
$total_count = 0;

if ($con) {
    // Build WHERE clause with parameterized prepared statements
    $where_parts = [];
    $params      = [];
    $types       = '';

    if (!$include_stage4) {
        $where_parts[] = "current_stage NOT LIKE '%Stage 4%'";
    }
    if ($search_query !== '') {
        $where_parts[] = "(name LIKE ? OR email LIKE ? OR mobile LIKE ?)";
        $like = "%{$search_query}%";
        $params[] = $like; $params[] = $like; $params[] = $like;
        $types   .= 'sss';
    }
    if ($filter_stage !== '') {
        $where_parts[] = "current_stage LIKE ?";
        $params[] = "%{$filter_stage}%";
        $types   .= 's';
    }
    if ($filter_zone !== '') {
        $where_parts[] = "(state LIKE ? OR city LIKE ?)";
        $params[] = "%{$filter_zone}%";
        $params[] = "%{$filter_zone}%";
        $types   .= 'ss';
    }

    $where_sql = count($where_parts) ? 'WHERE ' . implode(' AND ', $where_parts) : '';
    $sql = "SELECT id, name, email, mobile, player, state, city, dob, dress_size,
                   current_stage, attempts,
                   created_at, updated_at
            FROM abandoned_leads
            {$where_sql}
            ORDER BY id DESC";

    $stmt = $con->prepare($sql);
    if ($stmt) {
        if (count($params) > 0) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while ($r = $result->fetch_assoc()) {
            $rows[] = $r;
        }
        $total_count = count($rows);
    }
}

// ─── STAGE BADGE HELPER ───────────────────────────────────────────────────────
function stageBadge($stage) {
    if (empty($stage)) return '<span class="badge-stage unknown">Unknown</span>';
    $lower = strtolower($stage);
    if (strpos($lower, 'stage 4') !== false || strpos($lower, 'payment') !== false) {
        return '<span class="badge-stage s4">Stage 4: Reached Payment Page</span>';
    } elseif (strpos($lower, 'stage 3') !== false || strpos($lower, 'completed') !== false) {
        return '<span class="badge-stage s3">Stage 3: Completed Form</span>';
    } elseif (strpos($lower, 'stage 2') !== false || strpos($lower, 'entering') !== false) {
        return '<span class="badge-stage s2">Stage 2: Entering Information</span>';
    } elseif (strpos($lower, 'stage 1') !== false) {
        return '<span class="badge-stage s1">Stage 1: Opened Page</span>';
    }
    return '<span class="badge-stage unknown">' . htmlspecialchars(substr($stage, 0, 35)) . '</span>';
}

include 'head.php';
?>

<!-- DataTables + Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">

<style>
:root {
    --navy: #002244;
    --crimson: #e31e24;
    --s1: #6c757d; --s1-bg: #f0f0f0;
    --s2: #d97706; --s2-bg: #fef3c7;
    --s3: #16a34a; --s3-bg: #dcfce7;
    --s4: #e31e24; --s4-bg: #fde8e8;
}
body { font-family: 'Plus Jakarta Sans', sans-serif !important; }

/* ── Page Header ── */
.page-title-bar {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
    padding: 20px 0 16px;
}
.page-title-bar h4 {
    font-size: 20px; font-weight: 800; color: var(--navy);
    margin: 0; letter-spacing: -0.3px;
}
.page-title-bar .breadcrumb-trail { font-size: 12px; color: #94a3b8; margin: 2px 0 0; }
.page-title-bar .breadcrumb-trail a { color: var(--crimson); text-decoration: none; }

/* ── Stats Bar ── */
.stats-bar { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
.stat-pill {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 10px; padding: 10px 18px;
    display: flex; align-items: center; gap: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.stat-pill .sp-num { font-size: 22px; font-weight: 800; color: var(--navy); }
.stat-pill .sp-label { font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-pill .sp-icon { font-size: 22px; }

/* ── Filter Bar ── */
.filter-bar {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 10px;
    padding: 16px 20px; margin-bottom: 20px;
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}
.filter-bar label { font-size: 12px; font-weight: 700; color: #334155; margin: 0; white-space: nowrap; }
.filter-bar input, .filter-bar select {
    border: 1px solid #e2e8f0; border-radius: 7px;
    padding: 7px 12px; font-size: 13px; color: #0f172a;
    font-family: inherit; outline: none;
    transition: border-color 0.2s;
}
.filter-bar input:focus, .filter-bar select:focus { border-color: var(--navy); }
.filter-bar .stage4-toggle {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; color: #475569; font-weight: 600;
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 7px; padding: 7px 14px; cursor: pointer;
    user-select: none; white-space: nowrap;
}
.filter-bar .stage4-toggle input[type=checkbox] { accent-color: var(--crimson); width: 14px; height: 14px; }
.btn-apply-filter {
    background: var(--navy); color: #fff; border: none;
    border-radius: 7px; padding: 8px 18px; font-size: 13px;
    font-weight: 700; cursor: pointer; font-family: inherit;
    transition: background 0.2s;
}
.btn-apply-filter:hover { background: #003a6b; }
.btn-reset-filter {
    background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
    border-radius: 7px; padding: 8px 14px; font-size: 12px;
    font-weight: 600; cursor: pointer; font-family: inherit;
    text-decoration: none; display: inline-block; line-height: 1.5;
}

/* ── Data Card ── */
.data-card {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    overflow: hidden;
}
.data-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
    flex-wrap: wrap; gap: 10px;
}
.data-card-header h5 {
    font-size: 15px; font-weight: 800; color: var(--navy); margin: 0;
    display: flex; align-items: center; gap: 8px;
}
.data-card-header h5 .dot { width: 8px; height: 8px; background: var(--crimson); border-radius: 50%; }

/* ── Export Buttons ── */
.dt-buttons .btn-export {
    background: #f8fafc; color: #475569; border: 1px solid #e2e8f0;
    border-radius: 6px; padding: 6px 14px; font-size: 12px;
    font-weight: 700; cursor: pointer; font-family: inherit;
    transition: all 0.15s; text-transform: uppercase; letter-spacing: 0.5px;
}
.dt-buttons .btn-export:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
.dt-buttons .btn-export.excel { background: #16a34a; color: #fff; border-color: #16a34a; }
.dt-buttons .btn-export.pdf   { background: var(--crimson); color: #fff; border-color: var(--crimson); }
.dt-buttons .btn-export.excel:hover { background: #15803d; }
.dt-buttons .btn-export.pdf:hover   { background: #c41920; }

/* ── Table ── */
.table-scroll { overflow-x: auto; }
table.grid-table { width: 100% !important; border-collapse: collapse; }
table.grid-table thead tr { background: #f8fafc; }
table.grid-table thead th {
    font-size: 11px; font-weight: 800; color: #475569;
    text-transform: uppercase; letter-spacing: 0.6px;
    padding: 12px 14px; border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
}
table.grid-table tbody td {
    padding: 12px 14px; font-size: 12.5px; color: #1e293b;
    border-bottom: 1px solid #f1f5f9; vertical-align: middle;
}
table.grid-table tbody tr:hover { background: #f8fafc; }
table.grid-table tbody tr:last-child td { border-bottom: none; }

/* ── Candidate Info ── */
.cand-name { font-weight: 700; color: #0f172a; font-size: 13px; line-height: 1.3; }
.cand-email { font-size: 11px; color: #64748b; margin-top: 2px; }

/* ── Stage Badges ── */
.badge-stage {
    display: inline-block; padding: 4px 10px;
    border-radius: 20px; font-size: 11px; font-weight: 700;
    white-space: nowrap;
}
.badge-stage.s1 { background: var(--s1-bg); color: var(--s1); }
.badge-stage.s2 { background: var(--s2-bg); color: var(--s2); }
.badge-stage.s3 { background: var(--s3-bg); color: var(--s3); }
.badge-stage.s4 { background: var(--s4-bg); color: var(--s4); }
.badge-stage.unknown { background: #f1f5f9; color: #94a3b8; }

/* ── Zone ── */
.zone-info .state { font-weight: 700; font-size: 12px; color: #334155; }
.zone-info .city  { font-size: 11px; color: #64748b; margin-top: 2px; }

/* ── Jersey Size ── */
.jersey-badge {
    display: inline-block; background: var(--navy); color: #fff;
    border-radius: 6px; padding: 3px 9px; font-size: 11px; font-weight: 700;
    letter-spacing: 0.5px;
}
.jersey-badge.na { background: #e2e8f0; color: #94a3b8; }

/* ── Attempt ── */
.attempt-circle {
    display: inline-flex; align-items: center; justify-content: center;
    width: 26px; height: 26px; border-radius: 50%;
    background: #eff6ff; color: #2563eb;
    font-size: 12px; font-weight: 800;
}

/* ── Timestamp ── */
.ts-filled { font-size: 11.5px; color: #334155; font-weight: 600; }
.ts-updated { font-size: 11px; color: var(--crimson); font-weight: 600; margin-top: 2px; }

/* DataTables overrides */
div.dataTables_wrapper div.dataTables_length select,
div.dataTables_wrapper div.dataTables_filter input {
    border: 1px solid #e2e8f0; border-radius: 7px;
    padding: 6px 10px; font-size: 13px; font-family: inherit;
}
div.dataTables_info { font-size: 12px; color: #64748b; }
div.dataTables_paginate .paginate_button {
    border-radius: 6px !important; font-size: 12px !important;
}
div.dataTables_paginate .paginate_button.current,
div.dataTables_paginate .paginate_button.current:hover {
    background: var(--navy) !important; color: #fff !important;
    border-color: var(--navy) !important;
}
</style>

<div class="page-wrapper">
<div class="page-content" style="padding: 20px 24px;">

    <!-- Page Title -->
    <div class="page-title-bar">
        <div>
            <h4>&#128195; Digital Footprints Log Grid</h4>
            <div class="breadcrumb-trail">
                <a href="dashboard.php">Dashboard</a> &rsaquo; Abandoned Leads
            </div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <span style="font-size:12px;color:#64748b;background:#f1f5f9;padding:5px 12px;border-radius:6px;">
                &#128337; <?= date('d M Y, h:i A') ?>
            </span>
            <button onclick="location.reload();" style="background:var(--navy);color:#fff;border:none;border-radius:7px;padding:7px 16px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;">
                &#8635; Refresh
            </button>
        </div>
    </div>

    <!-- Stats Pills -->
    <div class="stats-bar">
        <div class="stat-pill">
            <span class="sp-icon">&#128100;</span>
            <div>
                <div class="sp-num"><?= number_format($total_count) ?></div>
                <div class="sp-label">Total Showing</div>
            </div>
        </div>
        <?php
        $s2c = 0; $s3c = 0; $s4c = 0;
        foreach ($rows as $r) {
            $sl = strtolower($r['current_stage'] ?? '');
            if (strpos($sl,'stage 2')!==false||strpos($sl,'entering')!==false) $s2c++;
            elseif (strpos($sl,'stage 3')!==false||strpos($sl,'completed')!==false) $s3c++;
            elseif (strpos($sl,'stage 4')!==false||strpos($sl,'payment')!==false) $s4c++;
        }
        ?>
        <div class="stat-pill">
            <span class="sp-icon">&#128209;</span>
            <div>
                <div class="sp-num" style="color:#d97706;"><?= $s2c ?></div>
                <div class="sp-label">Stage 2 — Entering Info</div>
            </div>
        </div>
        <div class="stat-pill">
            <span class="sp-icon">&#9989;</span>
            <div>
                <div class="sp-num" style="color:#16a34a;"><?= $s3c ?></div>
                <div class="sp-label">Stage 3 — Completed Form</div>
            </div>
        </div>
        <div class="stat-pill">
            <span class="sp-icon">&#128176;</span>
            <div>
                <div class="sp-num" style="color:#e31e24;"><?= $s4c ?></div>
                <div class="sp-label">Stage 4 — Payment Page</div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="abandoned_leads_view.php">
        <div class="filter-bar">
            <label>&#128269; Search:</label>
            <input type="text" name="q" value="<?= htmlspecialchars($search_query) ?>"
                   placeholder="Name, email or mobile..." style="min-width:200px;">

            <label>Stage:</label>
            <select name="stage">
                <option value="">All Stages</option>
                <option value="Stage 2" <?= $filter_stage==='Stage 2'?'selected':'' ?>>Stage 2 — Entering Info</option>
                <option value="Stage 3" <?= $filter_stage==='Stage 3'?'selected':'' ?>>Stage 3 — Completed Form</option>
                <option value="Stage 4" <?= $filter_stage==='Stage 4'?'selected':'' ?>>Stage 4 — Payment Page</option>
            </select>

            <label>Zone:</label>
            <input type="text" name="zone" value="<?= htmlspecialchars($filter_zone) ?>"
                   placeholder="State or City..." style="min-width:130px;">

            <label class="stage4-toggle">
                <input type="checkbox" name="stage4" value="1" <?= $include_stage4?'checked':'' ?>>
                Include Payment Page (Stage 4) Entries
            </label>

            <button type="submit" class="btn-apply-filter">Filter &rsaquo;</button>
            <a href="abandoned_leads_view.php" class="btn-reset-filter">Clear</a>
        </div>
    </form>

    <!-- Data Grid -->
    <div class="data-card">
        <div class="data-card-header">
            <h5><span class="dot"></span> Abandoned Leads — Digital Footprints</h5>
            <div class="dt-buttons" id="export-btns"></div>
        </div>
        <div class="table-scroll">
            <table id="leadsTable" class="grid-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Candidate Details</th>
                        <th>Specialist Role</th>
                        <th>Mobile Coordinate</th>
                        <th>Form Filled Time</th>
                        <th>Last Update Clock</th>
                        <th>Current Dropped Stage</th>
                        <th>Zone Location</th>
                        <th>Jersey Size</th>
                        <th>Attempts Count</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($rows)): ?>
                    <tr>
                        <td colspan="10" style="text-align:center;padding:40px;color:#94a3b8;">
                            <div style="font-size:32px;margin-bottom:8px;">&#128203;</div>
                            No records found matching your criteria.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $sn = 0; foreach ($rows as $r): $sn++; ?>
                    <tr>
                        <td style="font-size:12px;color:#94a3b8;font-weight:700;"><?= $sn ?></td>
                        <td>
                            <div class="cand-name"><?= htmlspecialchars($r['name'] ?? 'N/A') ?></div>
                            <div class="cand-email"><?= htmlspecialchars($r['email'] ?? '') ?></div>
                        </td>
                        <td>
                            <?php $role = $r['player'] ?? ''; ?>
                            <?php if (empty($role) || strtolower($role) === 'n/a'): ?>
                                <span style="color:#94a3b8;font-size:11px;">N/A</span>
                            <?php else: ?>
                                <span style="font-size:12px;font-weight:600;color:#334155;"><?= htmlspecialchars($role) ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="font-family:monospace;font-weight:700;font-size:13px;color:#0f172a;">
                            <?= htmlspecialchars($r['mobile'] ?? 'N/A') ?>
                        </td>
                        <td>
                            <?php if (!empty($r['created_at']) && $r['created_at'] !== '0000-00-00 00:00:00'): ?>
                                <div class="ts-filled"><?= date('d-M-y h:i A', strtotime($r['created_at'])) ?></div>
                            <?php else: ?>
                                <span style="color:#94a3b8;font-size:11px;">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($r['updated_at']) && $r['updated_at'] !== '0000-00-00 00:00:00'): ?>
                                <div class="ts-updated"><?= date('d-M-y h:i A', strtotime($r['updated_at'])) ?></div>
                            <?php else: ?>
                                <span style="color:#94a3b8;font-size:11px;">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?= stageBadge($r['current_stage'] ?? '') ?></td>
                        <td>
                            <div class="zone-info">
                                <div class="state"><?= htmlspecialchars($r['state'] ?? 'N/A') ?></div>
                                <?php if (!empty($r['city'])): ?>
                                    <div class="city">&#128205; <?= htmlspecialchars($r['city']) ?></div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <?php $sz = strtoupper(trim($r['dress_size'] ?? '')); ?>
                            <?php if (empty($sz) || $sz === 'N/A' || $sz === 'NA'): ?>
                                <span class="jersey-badge na">N/A</span>
                            <?php else: ?>
                                <span class="jersey-badge"><?= htmlspecialchars($sz) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="attempt-circle"><?= intval($r['attempts'] ?? 1) ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    var table = $('#leadsTable').DataTable({
        pageLength: 50,
        lengthMenu: [[25, 50, 100, 200, -1], ['25 records', '50 records', '100 records', '200 records', 'Show All']],
        ordering: true,
        order: [[0, 'asc']],
        dom: '<"d-flex align-items-center justify-content-between mb-3"<"d-flex align-items-center gap-2"l>f>rtip',
        buttons: [
            { extend: 'copy',  text: '&#128203; Copy',  className: 'btn-export' },
            { extend: 'excel', text: '&#128200; Excel', className: 'btn-export excel',
              title: 'C11CL - Abandoned Leads - <?= date("d-M-Y") ?>' },
            { extend: 'pdf',   text: '&#128196; PDF',  className: 'btn-export pdf',
              title: 'C11CL - Abandoned Leads - <?= date("d-M-Y") ?>',
              orientation: 'landscape', pageSize: 'A3' },
            { extend: 'print', text: '&#128438; Print', className: 'btn-export' }
        ],
        language: {
            search: '&#128269;',
            searchPlaceholder: 'Search within results...',
            lengthMenu: 'Show _MENU_',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: { previous: '&lsaquo;', next: '&rsaquo;' }
        },
        initComplete: function() {
            // Move export buttons to our custom container
            this.api().buttons().container().appendTo('#export-btns');
        }
    });
});
</script>

<?php include 'foot.php'; ?>
