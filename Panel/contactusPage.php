<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

include 'head.php';
include 'db.php'; // Database connection

// Error Reporting Enable
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
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us Enquiry</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <h6 class="mb-0 text-uppercase">Contact Us</h6>
        <hr />

        <!-- Search Form -->
        <div class="search-cont">
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
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>E-mail</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Default Query: Last 10 Entries
                            $sql = "SELECT * FROM contactus ORDER BY datetime DESC LIMIT 10";

                            // Search Query if Dates are Provided
                            if (isset($_POST['search'])) {
                                $datef = $_POST['datef'];
                                $datel = $_POST['datel'];

                                if (!empty($datef) && !empty($datel)) {
                                    $sql = "SELECT * FROM contactus WHERE datetime BETWEEN '$datef 00:00:00' AND '$datel 23:59:59' ORDER BY datetime DESC";
                                } elseif (!empty($datef)) {
                                    $sql = "SELECT * FROM contactus WHERE datetime >= '$datef 00:00:00' ORDER BY datetime DESC";
                                } elseif (!empty($datel)) {
                                    $sql = "SELECT * FROM contactus WHERE datetime <= '$datel 23:59:59' ORDER BY datetime DESC";
                                }
                            }

                            // Fetch Data
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . ++$count . "</td>
                                            <td>" . htmlspecialchars($row["name"]) . "</td>
                                            <td>" . htmlspecialchars($row["phone"]) . "</td>
                                            <td>" . htmlspecialchars($row["email"]) . "</td>
                                            <td>" . htmlspecialchars($row["message"]) . "</td>
                                            <td>" . $row["datetime"] . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center;'>No Results Found</td></tr>";
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
<!-- End Page Wrapper -->

<?php include 'foot.php'; ?>
