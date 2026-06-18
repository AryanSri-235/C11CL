<?php

session_start();
if (!isset($_SESSION['password'])) {
    header('location:login.php');
}
?>

<?php include 'head.php'; ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Submission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Vechile Enquiry</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <h6 class="mb-0 text-uppercase">Vechile Enquiry</h6>
        <hr />

        <div class="search-cont">
            <form method="post">
                <input type="date" name="datef" value="">
                <input type="date" name="datel" value="">
                <input type="submit" name="search" value="search">
            </form>
        </div>

        <div class="card bg">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                
                                <th>E-mail ID</th>
                                
                                <th>Message</th>
                                <th>Date</th>
                                
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            if (!isset($_POST['search'])) {
                            include 'db.php';
                                $sql = "SELECT * FROM Vechile_query ORDER BY id DESC LIMIT 10";
                                $result = $con->query($sql);

                                if ($result->num_rows > 0) {
                                    $count = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        echo '  <tr>
                                                <td>' . ++$count . '</td>
                                               <td>' . $row["name"] . '</td>
                                               <td>' . $row["number"] . '</td>
											   <td>' . $row["email"] . '</td>
											 
											   <td>' . $row["message"] . '</td>
											   <td>' . $row["datetime"] . '</td>
                                            </tr>';
                                    }


                                } else {
                                    echo "0 results";
                                }
                                $con->close();

                            }

                            if (isset($_POST['search'])) {

                                include 'db.php';
                                $datef = $_POST['datef'];
                                $datel = $_POST['datel'];
                                
                                if ($datef == '' && $datel == '') {
        $sql = "SELECT * FROM Vechile_query WHERE (datetime BETWEEN '" . date('Y-m-d') . " 00:00:00' AND '" . date('Y-m-d') . " 23:59:59') ORDER BY datetime DESC";
    } else {
        $sql = "SELECT * FROM Vechile_query WHERE ";
                
                
                // Add the date condition if $datef is entered
                if (!empty($datef)) {
                    $sql .= "(datetime >= '$datef 00:00:00' AND ";
                
                    // If $datel is entered, use it, otherwise, use $datef
                    if (!empty($datel)) {
                        $sql .= "datetime <= '$datel 23:59:59') ";
                    } else {
                        $sql .= "datetime <= '" . date('Y-m-d') . " 23:59:59') ";
                    }
                
                    
                }
                // Remove the trailing "AND" if it exists
                $sql = rtrim($sql, " AND ");
                
                // Complete the query and order by date
                $sql .= "ORDER BY datetime DESC";

        
            }
                                $result = $con->query($sql);

                                if ($result->num_rows > 0) {
                                    $count = 0;


                                    while ($row = $result->fetch_assoc()) {
                                        echo '
                                           <td>' . ++$count . '</td>
                                               <td>' . $row["name"] . '</td>
                                               <td>' . $row["number"] . '</td>
											   <td>' . $row["email"] . '</td>
											 
											   <td>' . $row["message"] . '</td>
											   <td>' . $row["datetime"] . '</td>
                                             </tr>';
                                    }
                                } else {
                                    echo "0 results";
                                }
                                $con->close();

                            }

                            ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
<?php include 'foot.php'; ?>