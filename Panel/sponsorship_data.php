<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:login.php');
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
$searchText = trim($_POST['universal'] ?? '');
$filterApplied = false;
$filterNotice = [];

// Base queries & bindings
$rows = [];
$total_count = 0;

if ($con) {
    $sql = "SELECT * FROM founding_owner_inquiries WHERE 1";
    $params = [];
    $types = "";

    if (!empty($datef)) {
        $sql .= " AND DATE(created_at) >= ?";
        $params[] = $datef;
        $filterNotice[] = "From: " . htmlspecialchars($datef);
        $filterApplied = true;
    }
    if (!empty($datel)) {
        $sql .= " AND DATE(created_at) <= ?";
        $params[] = $datel;
        $filterNotice[] = "To: " . htmlspecialchars($datel);
        $filterApplied = true;
    }
    if (!empty($searchText)) {
        $sql .= " AND (brand_company_name LIKE ? OR player_name LIKE ? OR contact_phone LIKE ? OR contact_email LIKE ? OR user_location LIKE ?)";
        $like = "%$searchText%";
        $params[] = $like; $params[] = $like; $params[] = $like; $params[] = $like; $params[] = $like;
        $filterNotice[] = "Search: " . htmlspecialchars($searchText);
        $filterApplied = true;
    }

    $sql .= " ORDER BY created_at DESC LIMIT 1000";

    $stmt = $con->prepare($sql);
    if ($stmt) {
        // Bind parameters dynamically
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
    .f-search { flex: 2; }
    .btn-apply { background: #007bff; color: #fff; border: none; padding: 0 15px; height: 35px; border-radius: 5px; font-weight: bold; cursor: pointer; }
    .btn-clear { background: #dc3545; color: #fff; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-weight: bold; font-size: 12px; }
    .btn-export { background: #16a34a; color: #fff; border: none; padding: 0 15px; height: 35px; border-radius: 5px; font-weight: bold; cursor: pointer; margin-left: 5px; }
    
    .p-name { font-weight: 700; color: #1e293b; display: block; }
    .p-sub { font-size: 11px; color: #000000; font-weight: 500; }
    
    @media (max-width: 1100px) { .f-grid { flex-wrap: wrap; } .f-field { flex: 1 1 30%; } .f-search { flex: 1 1 100%; } }
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
                        <li style="font-weight: 600; color: #64748b;">Sponsorship Data</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h4 class="mb-3 text-dark fw-bold">Sponsorship Submission Logs</h4>

        <!-- Filter Card -->
        <div class="filter-card">
            <form method="post" class="f-grid">
                <input type="text" name="universal" class="f-field f-search" placeholder="🔍 Search Brand/Sponsor..." value="<?= htmlspecialchars($searchText) ?>">
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
                                <th>Brand & Company</th>
                                <th>Contact Details</th>
                                <th>Location</th>
                                <th>Selected Package</th>
                                <th>Brand Brief</th>
                                <th>Received At</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($rows) > 0): ?>
                            <?php $count = 0; foreach ($rows as $row): ?>
                                <tr>
                                    <td class="text-center text-muted"><?= ++$count ?></td>
                                    <td data-export-brand="<?= htmlspecialchars($row['brand_company_name'] ?? '') ?>" data-export-contact-name="<?= htmlspecialchars($row['player_name'] ?? '') ?>" data-export-designation="<?= htmlspecialchars($row['user_designation'] ?? '') ?>">
                                        <span class="p-name"><?= htmlspecialchars($row['brand_company_name'] ?? '') ?></span>
                                        <span class="p-sub"><?= htmlspecialchars($row['player_name'] ?? '') ?> - <?= htmlspecialchars($row['user_designation'] ?? '') ?></span>
                                    </td>
                                    <td data-export-phone="<?= htmlspecialchars($row['contact_phone'] ?? '') ?>" data-export-email="<?= htmlspecialchars($row['contact_email'] ?? '') ?>">
                                        <span class="d-block fw-bold text-dark"><?= htmlspecialchars($row['contact_phone'] ?? '') ?></span>
                                        <span class="p-sub"><?= htmlspecialchars($row['contact_email'] ?? '') ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($row['user_location'] ?? '') ?></td>
                                    <td>
                                        <span class="badge bg-primary text-white" style="padding: 5px 10px; font-weight: 600;"><?= htmlspecialchars($row['chosen_package'] ?? '') ?></span>
                                    </td>
                                    <td style="max-width: 300px; white-space: normal;"><?= htmlspecialchars($row['brand_brief'] ?? '') ?></td>
                                    <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No Inquiries Found</td>
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
        workbookData.push(["#", "Brand & Company", "Contact Name", "Designation", "Phone", "Email", "Location", "Selected Package", "Brand Brief", "Received At"]);

        const rows = document.querySelectorAll("#datatable-buttons tbody tr");
        rows.forEach((row, index) => {
            const cells = row.cells;
            if (cells.length < 7 || cells[0].innerText.includes("No Inquiries Found")) return;

            const brandCol = cells[1];
            const contactCol = cells[2];

            const brand = brandCol.getAttribute('data-export-brand') || '';
            const contactName = brandCol.getAttribute('data-export-contact-name') || '';
            const designation = brandCol.getAttribute('data-export-designation') || '';
            const phone = contactCol.getAttribute('data-export-phone') || '';
            const email = contactCol.getAttribute('data-export-email') || '';
            const location = cells[3].innerText.trim();
            const packageVal = cells[4].innerText.trim();
            const brief = cells[5].innerText.trim();
            const receivedAt = cells[6].innerText.trim();

            workbookData.push([
                index + 1,
                brand,
                contactName,
                designation,
                phone,
                email,
                location,
                packageVal,
                brief,
                receivedAt
            ]);
        });

        if (workbookData.length <= 1) {
            alert("No data available to export!");
            return;
        }

        const ws = XLSX.utils.aoa_to_sheet(workbookData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sponsorship_Log");

        const safeDate = new Date().toISOString().slice(0, 10);
        XLSX.writeFile(wb, "Sponsorship_Inquiries_Report_" + safeDate + ".xlsx");

    } catch (error) {
        console.error("Export Error:", error);
        alert("Export failed!");
    }
}
</script>

<?php include 'foot.php'; ?>
