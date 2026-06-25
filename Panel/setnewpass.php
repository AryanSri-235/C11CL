<?php

session_start();

if (!isset($_SESSION['password']) && isset($_SESSION['uname'])) {
    header('location:../index.php');
}
    // Access the username from the session
    $username = $_SESSION['uname'];
?>
<?php
// session_start();
include 'db.php';

if (isset($_POST['changepassword'])) {
    
    $newpass = $_POST['password'];
    $sql = "SELECT * FROM user WHERE username = '$username' ORDER by id DESC LIMIT 1 ";
    $result = $con->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$sql = "UPDATE user SET password = '$newpass' WHERE username = '$username' ";
		$con->query($sql);
		    $success = '<span class="text-success">Your Password has been Updated Successfully<br></span> <a href="login.php" class="btn btn-light">Click Here to Login</a>';
            
	 }else {
		$_SESSION['wrong'] = "WRONG USERNAME AND PASSWORD";
	}
    
}

?>


<!doctype html>
<html lang="en" class="semi-dark">


<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel='icon' href='assets/images/yscl fevikon.png' type='image/png' />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
    <title>YSCL - Yonug Stars Cricket League</title>
</head>

<body class="">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-cover">
			<div class="">
				<div class="row g-0">
					<div class="col-12 col-xl-7 col-xxl-8 auth-cover-left bg-gradient-moonlit align-items-center justify-content-center d-none d-xl-flex">
                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
							<div class="card-body">
                                 <img src="assets/images/login-images/reset-password-cover.svg" class="img-fluid" width="600" alt=""/>
							</div>
						</div>
					</div>
					<div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
						<div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
							<div class="card-body p-sm-5">
								<div class="">
									<div class="mb-4 text-center">
										<img src="assets/myimg/yscllogoblack.png" width="150" alt="" />
									</div>
									<div class="text-start mb-4">
										<h5 class="">Genrate New Password</h5>
										<p class="mb-0">We received your password change request. Please enter your new password!</p>
										<h5>
											<?php if (isset($success)) {
												echo $success;
												} ?>
										</h5>
									</div>
								<form id="myForm" method="POST" class="row g-3" enctype="multipart/form-data" onsubmit="return validateForm()">
                                    <div class="mb-3 mt-4">
										<label for="input5" class="form-label">New Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter password"required>
									</div>
									<div class="mb-4">
										<label for="input6" class="form-label">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm password">
                                        <span id="password_error" style="color:red"></span>

									</div>
									<div class="d-grid gap-2">
										<button type="submit" class="btn btn-primary" name='changepassword'>Change Password</button> <a href="login.php" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a>
									</div>
								</form>	
								</div>
							</div>
						</div>
					</div>

				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
<!-- confirm_password javascript code -->
<script>
    function validateForm() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;

        if (password != confirm_password) {
            document.getElementById("password_error").innerHTML = "Passwords do not match";
            return false;
        } else {
            document.getElementById("password_error").innerHTML = "";
            return true;
        }
    }
</script>

	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>


</html>