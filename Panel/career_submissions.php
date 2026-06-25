<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

include 'head.php';
include 'db.php';

// Enable error reporting (only for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

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
                        <li class="breadcrumb-item active" aria-current="page">Career Submissions</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <h6 class="mb-0 text-uppercase">Career Submissions</h6>
        <hr />

        <!-- Search Form -->
        <form method="post" class="mb-3 d-flex gap-2 align-items-center">
            <input type="date" name="datef" class="form-control w-auto" value="<?= $_POST['datef'] ?? '' ?>">
            <input type="date" name="datel" class="form-control w-auto" value="<?= $_POST['datel'] ?? '' ?>">
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>

        <!-- Table Card -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="careerTable">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Position</th>
                                 <th>Cover Letter</th>
                                <th>Date</th>
                                <th>Resume</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Default SQL
                            $sql = "SELECT * FROM job_applications ORDER BY submitted_at DESC";

                            // Filtering if search is used
                            if (isset($_POST['search'])) {
                                $datef = $_POST['datef'] ?? '';
                                $datel = $_POST['datel'] ?? '';

                                if (!empty($datef) && !empty($datel)) {
                                    $sql = "SELECT * FROM job_applications WHERE submitted_at BETWEEN '$datef 00:00:00' AND '$datel 23:59:59' ORDER BY submitted_at DESC";
                                } elseif (!empty($datef)) {
                                    $sql = "SELECT * FROM job_applications WHERE submitted_at >= '$datef 00:00:00' ORDER BY submitted_at DESC";
                                } elseif (!empty($datel)) {
                                    $sql = "SELECT * FROM job_applications WHERE submitted_at <= '$datel 23:59:59' ORDER BY submitted_at DESC";
                                }
                            }

                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>" . ++$count . "</td>
                                        <td>" . htmlspecialchars($row['name'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['phone'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['email'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['position'] ?? '') . "</td>
                                         <td>" . htmlspecialchars($row['cover_letter'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($row['submitted_at'] ?? '') . "</td>
                                        <td>";
                                    
                                    if (!empty($row['cv_file'])) {
                                        echo "<a href='uploads/" . htmlspecialchars($row['cv_file']) . "' target='_blank' class='btn btn-sm btn-primary'>View Resume</a>";
                                    } else {
                                        echo "<span class='text-danger'>No Resume</span>";
                                    }

                                    echo "</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No Results Found</td></tr>";
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

<?php include 'foot.php'; ?>
