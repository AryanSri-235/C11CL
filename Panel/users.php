<?php

session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
}
?>
<?php include 'head.php'; ?>
<!--start page wrapper -->
<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Users Settings</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">User list</li>
							</ol>
						</nav>
					</div>
		
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">All users</h6>
				<hr/>
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
				<?php
                                    include 'db.php';
                                    $sql = "SELECT * FROM user  ORDER BY id DESC";
                                    $result = $con->query($sql);

                                    if ($result->num_rows > 0) {
                                        $count = 0;
                                        while ($row = $result->fetch_assoc()) {
									$username	=	$row["username"];
                                            echo '
					<div class="col">
						<div class="card radius-15">
							<div class="card-body text-center">
								<div class="p-4 border radius-15">
									<img src="'. $row["picture"]. ' " width="110" height="110" class="rounded-circle shadow" alt="">
									<h5 class="mb-0 mt-5">'. $row["name"] .'</h5>
									<p class="mb-3">'. $row["role"] .'</p>
                                   
									<div class="list-inline contacts-social mt-3 mb-3">
                                         <a href='. $row["fb"] .' class="list-inline-item bg-facebook text-white border-0"><i class="bx bxl-facebook"></i></a>
										<a href='. $row["insta"] .' class="list-inline-item bg-google text-white border-0"><i class="bx bxl-instagram"></i></a>
										<a href="message.php" class="list-inline-item bg-linkedin text-white border-0"><i class="bx bxs-badge-check"></i></a>
									</div>
									<div class="d-grid"> <a href="profile.php?username='.$row["username"].'" class="btn btn-outline-primary radius-15">Profile</a>
									</div>
								</div>
							</div>
						</div>
					</div>';
				}
			} else {
				echo "0 results";
			}
			$con->close();
			?>
                

				</div>
			</div>
		</div>
		<!--end page wrapper -->
<?php include 'foot.php'; ?>