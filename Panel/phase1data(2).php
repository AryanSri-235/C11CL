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
?>

<style>
.badge-success {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
.badge-danger {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
.modal-background {
    backdrop-filter: blur(5px);
}
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Submission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Player Registrations</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Registered Players</h6>
        <hr />

        <!-- Search Form -->
        <div class="search-cont mb-3">
            <form method="post">
                <input type="date" name="datef" value="">
                <input type="date" name="datel" value="">
                <input type="submit" name="search" value="Search">
            </form>
        </div>

        <!-- Table Card -->
        <div class="card bg">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                 <th>Reg. Code</th>
                                <th>Age</th>
                                <th>Role</th>
                                <th>Reg Date</th>
                                <th>Email</th>
                                <th>Mobile</th>
                               
                                <th>Mail Sent</th>
                                <th>State</th>
                                <th>Reference</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
$sql = "SELECT * FROM register ORDER BY reg DESC LIMIT 100";

if (isset($_POST['search'])) {
    $datef = $_POST['datef'];
    $datel = $_POST['datel'];

    if (!empty($datef) && !empty($datel)) {
        $sql = "SELECT * FROM register WHERE reg BETWEEN '$datef' AND '$datel' ORDER BY reg DESC";
    } elseif (!empty($datef)) {
        $sql = "SELECT * FROM register WHERE reg >= '$datef' ORDER BY reg DESC";
    } elseif (!empty($datel)) {
        $sql = "SELECT * FROM register WHERE reg <= '$datel' ORDER BY reg DESC";
    }
}

$result = $con->query($sql);

$roleShorts = [
    'Batsman' => 'BAT',
    'Bowler' => 'BWL',
    'All Rounder' => 'AR',
    'Wicketkeeper/Batsman' => 'WK',
];

if ($result && $result->num_rows > 0) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $shortRole = $roleShorts[$row['player']] ?? $row['player'];

        // Button logic for status
        if ($row['status'] === 'Success') {
            $statusBadge = '<button class="btn btn-success btn-sm" disabled>Success</button>';
        } else {
            $statusBadge = '<a href="../send.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm" onclick="return confirm(\'Are you sure you want to mark this as Success?\')">Mark Success</a>';
        }

        echo "<tr>
            <td>" . ++$count . "</td>
            <td>" . htmlspecialchars($row['name'] ?? '', ENT_QUOTES) . "</td>
            <td>
                <a href=\"#\" class=\"openModal\" data-details='" . htmlspecialchars(json_encode($row), ENT_QUOTES) . "'>
                    " . htmlspecialchars($row['reg'] ?? '', ENT_QUOTES) . "
                </a>
            </td>
            <td>" . htmlspecialchars($row['age'] ?? '', ENT_QUOTES) . "</td>  
            <td>" . htmlspecialchars($shortRole ?? '', ENT_QUOTES) . "</td>
            <td>" . htmlspecialchars($row['date'] ?? '', ENT_QUOTES) . "</td>       
            <td>" . htmlspecialchars($row['email'] ?? '', ENT_QUOTES) . "</td>
            <td>" . htmlspecialchars($row['mobile'] ?? '', ENT_QUOTES) . "</td>
            <td>" . ($row['mailsent'] ? 'Yes' : 'No') . "</td>
            <td>" . htmlspecialchars($row['state'] ?? '', ENT_QUOTES) . "</td>
            <td>" . htmlspecialchars($row['ref'] ?? '', ENT_QUOTES) . "</td>
            <td>" . $statusBadge . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='14' style='text-align:center;'>No Results Found</td></tr>";
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

<!-- Modal -->
<div class="modal fade" id="playerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-background" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Player Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Filled by JS -->
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.openModal').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const data = JSON.parse(this.dataset.details);
        let html = '<table class="table table-bordered">';
        for (const [key, value] of Object.entries(data)) {
            html += `<tr><th>${key}</th><td>${value ?? ''}</td></tr>`;
        }
        html += '</table>';
        document.getElementById('modalContent').innerHTML = html;
        new bootstrap.Modal(document.getElementById('playerModal')).show();
    });
});
</script>

<?php include 'foot.php'; ?>
