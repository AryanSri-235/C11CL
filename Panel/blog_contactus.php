<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

include 'head.php';
include 'db.php'; // Database connection
?>

<!-- Start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Contact Messages</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Messages</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End breadcrumb -->

        <h6 class="mb-0 text-uppercase">Contact Messages</h6>
        <hr />

        <!-- Contact Messages Table -->
        <div class="card bg">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="contactTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                 <th>Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch contact form data
                            $sql = "SELECT * FROM blog_contactus ORDER BY id DESC";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>
                                            <td>' . htmlspecialchars($row["id"]) . '</td>
                                            <td>' . htmlspecialchars($row["name"]) . '</td>
                                            <td>' . htmlspecialchars($row["email"]) . '</td>
                                            <td>' . htmlspecialchars($row["message"]) . '</td>
                                             <td>' . htmlspecialchars($row["number"]) . '</td>
                                            <td>
                                                <a href="contact_delete.php?id=' . htmlspecialchars($row["id"]) . '" class="btn btn-sm btn-danger">
                                                    <i class="bx bx-trash"></i> Delete
                                                </a>
                                            </td>
                                          </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5" class="text-center">No messages found</td></tr>';
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
<!-- End page wrapper -->

<?php include 'foot.php'; ?>

<!-- Initialize DataTable -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('#contactTable').DataTable({
            "pageLength": 10,
            "order": [[0, "desc"]]
        });
    });
</script>
