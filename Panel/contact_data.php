<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

include 'head.php';
include 'db.php';

// Enable Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Filters & Sorting ---
$datef = $_POST['datef'] ?? '';
$datel = $_POST['datel'] ?? '';
$filterApplied = false;
$filterNotice = [];

$rows = [];
$total_count = 0;

if ($con) {
    $sql = "SELECT * FROM contact_queries WHERE 1";
    $params = [];
    $types = "";

    if (!empty($datef)) {
        $sql .= " AND created_at >= ?";
        $params[] = "$datef 00:00:00";
        $filterNotice[] = "From: " . htmlspecialchars($datef);
        $filterApplied = true;
    }
    if (!empty($datel)) {
        $sql .= " AND created_at <= ?";
        $params[] = "$datel 23:59:59";
        $filterNotice[] = "To: " . htmlspecialchars($datel);
        $filterApplied = true;
    }

    $sql .= " ORDER BY created_at DESC LIMIT 1000";

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
        $total_count = count($rows);
    }
}
?>

<style>
    .filter-card { background: #fff; padding: 15px; border-radius: 10px; border: 1px solid #e0e0e0; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .f-grid { display: flex; flex-wrap: nowrap; gap: 8px; align-items: center; }
    .f-field { height: 35px; padding: 5px 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 13px; outline: none; flex: 1; min-width: 0; }
    .btn-apply { background: #007bff; color: #fff; border: none; padding: 0 15px; height: 35px; border-radius: 5px; font-weight: bold; cursor: pointer; }
    .btn-clear { background: #dc3545; color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-weight: bold; font-size: 12px; }
    .btn-export { background: #16a34a; color: #fff; border: none; padding: 0 15px; height: 35px; border-radius: 5px; font-weight: bold; cursor: pointer; margin-left: 5px; }
    
    .p-name { font-weight: 700; color: #1e293b; display: block; }
    .p-sub { font-size: 11px; color: #000000; font-weight: 500; }
    
    @media (max-width: 768px) { .f-grid { flex-wrap: wrap; } .f-field { flex: 1 1 100%; } }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumbs -->
        <div class="d-flex align-items-center mb-3" style="background: #fff; padding: 8px 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
            <div style="border-right: 2px solid #e2e8f0; padding-right: 10px; font-weight: 700; font-size: 13px; color: #475569;">SUBMISSION</div>
            <div class="ps-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="list-style: none; display: flex; gap: 8px; align-items: center; font-size: 13px;">
                        <li><a href="dashboard.php" style="color: #2563eb;"><i class="bx bx-home-alt"></i></a></li>
                        <li style="color: #94a3b8;">/</li>
                        <li style="font-weight: 600; color: #64748b;">Contact Queries</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h4 class="mb-3 text-dark fw-bold">Contact Query Submissions</h4>

        <!-- Filter Card -->
        <div class="filter-card">
            <form method="post" class="f-grid">
                <input type="date" name="datef" class="f-field" value="<?= htmlspecialchars($datef) ?>">
                <input type="date" name="datel" class="f-field" value="<?= htmlspecialchars($datel) ?>">
                <button type="submit" class="btn-apply">Apply</button>
                <?php if ($filterApplied): ?> 
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn-clear">Clear</a> 
                <?php endif; ?>
                <button type="button" onclick="exportToExcel()" class="btn-export">
                    <i class='bx bx-spreadsheet'></i> Excel Export
                </button>
            </form>
        </div>

        <?php if($filterApplied && !empty($filterNotice)): ?>
            <div class="alert alert-light border mb-3 py-2" style="font-size: 12px;">Active Filters: <?= implode(' | ', $filterNotice) ?></div>
        <?php endif; ?>

        <!-- Data Grid -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($rows) > 0): ?>
                            <?php $count = 0; foreach ($rows as $row): ?>
                                <tr>
                                    <td class="text-center text-muted"><?= ++$count ?></td>
                                    <td class="fw-bold text-dark"><?= htmlspecialchars($row['name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['email'] ?? '') ?></td>
                                    <td class="fw-bold text-dark"><?= htmlspecialchars($row['phone'] ?? '') ?></td>
                                    <td class="text-primary fw-bold"><?= htmlspecialchars($row['subject'] ?? '') ?></td>
                                    <td style="max-width: 350px; white-space: normal;"><?= htmlspecialchars($row['message'] ?? '') ?></td>
                                    <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No Queries Found</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
function exportToExcel() {
    try {
        if (typeof XLSX === 'undefined') {
            alert('Excel Library missing!');
            return;
        }

        let workbookData = [];
        workbookData.push(["#", "Name", "Email", "Phone", "Subject", "Message", "Date"]);

        const rows = document.querySelectorAll("#datatable-buttons tbody tr");
        rows.forEach((row, index) => {
            const cells = row.cells;
            if (cells.length < 7 || cells[0].innerText.includes("No Queries Found")) return;

            workbookData.push([
                index + 1,
                cells[1].innerText.trim(),
                cells[2].innerText.trim(),
                cells[3].innerText.trim(),
                cells[4].innerText.trim(),
                cells[5].innerText.trim(),
                cells[6].innerText.trim()
            ]);
        });

        if (workbookData.length <= 1) {
            alert("No data available to export!");
            return;
        }

        const ws = XLSX.utils.aoa_to_sheet(workbookData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Contact_Queries");

        const safeDate = new Date().toISOString().slice(0, 10);
        XLSX.writeFile(wb, "Contact_Queries_Report_" + safeDate + ".xlsx");

    } catch (error) {
        console.error("Export Error:", error);
        alert("Export failed!");
    }
}
</script>

<?php include 'foot.php'; ?>
