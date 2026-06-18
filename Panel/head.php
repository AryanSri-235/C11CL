<?php
date_default_timezone_set("Asia/Kolkata");
?>
<?php
if (isset($_SESSION['last-active'])) {
	if ((time() - $_SESSION['last-active']) > 28800) {
		header('Location: login.php?logout');
		exit();
	}
}
$_SESSION['last-active'] = time();
?>

<!doctype html>
<html lang='en' class='semi-dark'>

<head>
	<!-- Required meta tags -->
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<!--favicon-->
	<link rel='icon' href='assets/images/fevikondashoard.png' type='image/png' />
	<!--plugins-->
	<link href='assets/plugins/simplebar/css/simplebar.css' rel='stylesheet' />
	<link href='assets/plugins/fullcalendar/css/main.min.css' rel='stylesheet' />
	<link href='assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css' rel='stylesheet' />
	<link href='assets/plugins/metismenu/css/metisMenu.min.css' rel='stylesheet' />
	<link href='assets/plugins/datatable/css/dataTables.bootstrap5.min.css' rel='stylesheet' />
	<link href='assets/plugins/bs-stepper/css/bs-stepper.css' rel='stylesheet' />
	<!-- loader-->
	<link href='assets/css/pace.min.css' rel='stylesheet' />
	<script src='assets/js/pace.min.js'></script>

	<!-- Bootstrap CSS -->
	<link href='assets/css/bootstrap.min.css' rel='stylesheet'>
	<link href='assets/css/bootstrap-extended.css' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap' rel='stylesheet'>
	<link href='assets/css/app.css' rel='stylesheet'>
	<link href='assets/css/icons.css' rel='stylesheet'>
	<!-- Theme Style CSS -->
	<link rel='stylesheet' href='assets/css/dark-theme.css' />
	<link rel='stylesheet' href='assets/css/semi-dark.css' />
	<link rel='stylesheet' href='assets/css/header-colors.css' />
	<link rel='stylesheet' href='assets/css/style.css'>


	<title>Dashboard-C11CL</title>
	
</head>

<body onload="autoClick()">
    <script>
    window.onload = function() {
        // Check if the user agent indicates a mobile device
        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        
        // If it's not a mobile device, auto-click the toggle icon when the page is loaded
        if (!isMobile) {
            var toggleIcon = document.querySelector(".toggle-icon");
            if (toggleIcon) {
                toggleIcon.click();
            }
        }
    };
</script>

	<!--wrapper-->
	
	<div class='wrapper'>
		<!--sidebar wrapper -->
		<div class='sidebar-wrapper' data-simplebar='true'>
			<div class='sidebar-header'>
				<div>
					<img src='assets/images/logo-icon.png' class='logo-icon' alt='logo icon'>
				</div>
				<div>
					<h4 class='logo-text'></h4>
				</div>
				<div class='toggle-icon ms-auto'><i class='bx bx-arrow-back'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class='metismenu' id='menu'>
			     <li class='menu-label'>Dashboard</li>
<?php
// Check if the session has a status and if it's 'admin' or 'superadmin'
if (isset($_SESSION['status'])) {
    // Forms Data section for admin

// For Phase 1 - only admin can see
if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin') {
    echo "
    <li>
        <a href='phase1data.php'>
            <div class='parent-icon'><i class='bx bx-log-in-circle'></i></div>
            <div class='menu-title'>Phase 1 Data</div>
        </a>
    </li>
    ";
}

// For Phase 2 - only manager can see
if ($_SESSION['status'] == 'sale-leader' || $_SESSION['status'] == 'developer') {
    echo "
    <li>
        <a href='phase1data_user.php'>
            <div class='parent-icon'><i class='bx bx-log-in-circle'></i></div>
            <div class='menu-title'>Phase 1 Data</div>
        </a>
    </li>
    ";
}

// For Phase 3 - both admin and superadmin can see
if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin') {
    echo "
    <li>
        <a href='phase2data.php'>
            <div class='parent-icon'><i class='bx bx-log-in-circle'></i></div>
            <div class='menu-title'>Phase 2 Data</div>
        </a>
    </li>
    ";
}
if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin') {
    echo "
    <li>
        <a href='phase1data_user.php'>
            <div class='parent-icon'><i class='bx bx-log-in-circle'></i></div>
            <div class='menu-title'>Calling Panel</div>
        </a>
    </li>
    ";
}
// For Phase 3 - both admin and superadmin can see
if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin' || $_SESSION['status'] == 'developer') {
    echo "
    <li>
        <a href='register_data.php'>
            <div class='parent-icon'><i class='bx bx-log-in-circle'></i></div>
            <div class='menu-title'>Leads Data</div>
        </a>
    </li>
    ";
}
if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin' || $_SESSION['status'] == 'developer') {
    echo "
    <li>
        <a href='report.php'>
            <div class='parent-icon'><i class='bx bx-log-in-circle'></i></div>
            <div class='menu-title'>Report Graph</div>
        </a>
    </li>
    ";
}




    // Other Options section
    echo "
    <li>
        <a href='javascript:;' class='has-arrow'>
            <div class='parent-icon'><i class='bx bx-user'></i></div>
            <div class='menu-title'>Form Submit Data</div>
        </a>
        <ul>";

    // Check if the user is superadmin, admin, subadmin, or even empty
    if (in_array($_SESSION['status'], ['superadmin', 'admin', 'sale-leader', ''])) {
        echo "<li><a href='contact_data.php'><i class='bx bx-radio-circle'></i>Contact Us</a></li>";
    }
    
     if (in_array($_SESSION['status'], ['superadmin', 'admin', 'sale-leader', ''])) {
        echo "<li><a href='mobile_data.php'><i class='bx bx-radio-circle'></i>Phone No Submit</a></li>";
    }

    // Display the "Create New Blog" option based on roles
    if (in_array($_SESSION['status'], ['superadmin', 'admin', ''])) {
        echo "<li><a href='job_data.php'><i class='bx bx-radio-circle'></i>Apply for Job</a></li>";
    }

    // Display the "Blog List" option based on roles
    if (in_array($_SESSION['status'], ['superadmin', 'admin', ''])) {
        echo "<li><a href='mails_data.php'><i class='bx bx-radio-circle'></i>Submit Mails Data</a></li>";
    }

   
 

    echo "
        </ul>
    </li>
    ";
}
?>

	<?php
// Sirf Superadmin aur Developer ke liye visibility
if (isset($_SESSION['status']) && ($_SESSION['status'] == 'superadmin' || $_SESSION['status'] == 'developer')) {
    echo "<li class='menu-label'>Content Management</li>";

    // 1. All Blogs (List)
    echo "
    <li>
        <a href='blog_list.php'>
            <div class='parent-icon'><i class='bx bx-list-ul'></i></div>
            <div class='menu-title'>Blog List</div>
        </a>
    </li>";

    // 2. Add New Blog
    echo "
    <li>
        <a href='add_blog.php'>
            <div class='parent-icon'><i class='bx bx-plus-circle'></i></div>
            <div class='menu-title'>Add New Blog</div>
        </a>
    </li>";

    // 3. Manage Pages
    echo "
    <li>
        <a href='manage-pages.php'>
            <div class='parent-icon'><i class='bx bx-file'></i></div>
            <div class='menu-title'>Manage Pages</div>
        </a>
    </li>";

    // 4. Website Settings
    echo "
    <li>
        <a href='website-settings.php'>
            <div class='parent-icon'><i class='bx bx-cog'></i></div>
            <div class='menu-title'>Website Settings</div>
        </a>
    </li>";
}
?>	
            

				<?php
				if (isset($_SESSION['status']) && ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin'|| $_SESSION['status'] == 'sale-leader'|| $_SESSION['status'] == 'developer')) {
					echo "
        <li class='menu-label'>Settings</li>
        
        <li>
            <a href='javascript:;' class='has-arrow'>
                <div class='parent-icon'><i class='bx bx-user-pin'></i></div>
                <div class='menu-title'>Users Settings</div>
            </a>
            <ul>";

					if (isset($_SESSION['status']) && ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin' || $_SESSION['status'] == 'sale-leader'|| $_SESSION['status'] == 'developer')) {
						echo "<li><a href='user-profile.php'><i class='bx bx-radio-circle'></i>Profile</a></li>";
					}

					if (isset($_SESSION['status']) && ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin')) {
						echo "<li><a href='users.php'><i class='bx bx-radio-circle'></i>Users</a></li>";
					}

					if (isset($_SESSION['status']) && ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin')) {
						echo "<li><a href='add-user.php'><i class='bx bx-radio-circle'></i>Add User</a></li>";
					}

					if (isset($_SESSION['status']) && ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'superadmin')) {
						echo "<li><a href='users-status.php'><i class='bx bx-radio-circle'></i>Users Status</a></li>";
					}

					

					echo "
            </ul>
        </li>";
				}
				?>
				
				


				<li>
					<a href='login.php?logout'>
						<div class='parent-icon'><i class='bx bx-log-in-circle'></i>
						</div>
						<div class='menu-title'>Sign In / Sign Out</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class='topbar d-flex align-items-center'>
				<nav class='navbar navbar-expand gap-3'>
					<div class='mobile-toggle-menu'><i class='bx bx-menu'></i>
					</div>
					<!--<div> <h3 class='heading'>Young Stars Cricket League  </h3></div>-->

					<!--<div class='position-relative search-bar d-lg-block d-none' data-bs-toggle='modal'-->
					<!--	data-bs-target='#SearchModal'>-->
					<!--	<input class='form-control px-5' type='search' placeholder='Search'>-->
					<!--	<span-->
					<!--		class='position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-5'><i-->
					<!--			class='bx bx-search'></i></span>-->
					<!--</div>-->


					<div class='top-menu ms-auto'>
						<ul class='navbar-nav align-items-center gap-1'>
							<li class='nav-item mobile-search-icon d-flex d-lg-none'>
                                <a class='nav-link' href='javascript:;' onclick='location.reload();'>
                                    <i class='bx bx-refresh'></i>
                                </a>
                            </li>

							<!--<li class='nav-item dropdown dropdown-laungauge d-none d-sm-flex'>-->
							<!--	<a class='nav-link dropdown-toggle dropdown-toggle-nocaret' href='avascript:;'-->
							<!--		data-bs-toggle='dropdown'><img src='assets/images/county/calender.jpeg' width='22'-->
							<!--			alt=''>-->
							<!--	</a>-->
							<!--	<ul class='dropdown-menu dropdown-menu-end'>-->
							<!--		<li><a class='dropdown-item d-flex align-items-center py-2' href='javascript:;'><img-->
							<!--					src='assets/images/county/calender.jpeg' width='20' alt=''><span-->
							<!--					class='ms-2'>2023</span></a>-->
							<!--		</li>-->
							<!--		<li><a class='dropdown-item d-flex align-items-center py-2' href='javascript:;'><img-->
							<!--					src='assets/images/county/calender.jpeg' width='20' alt=''><span-->
							<!--					class='ms-2'>2022</span></a>-->
							<!--		</li>-->
							<!--		<li><a class='dropdown-item d-flex align-items-center py-2' href='javascript:;'><img-->
							<!--					src='assets/images/county/calender.jpeg' width='20' alt=''><span-->
							<!--					class='ms-2'>2021</span></a>-->
							<!--		</li>-->
							<!--		<li><a class='dropdown-item d-flex align-items-center py-2' href='javascript:;'><img-->
							<!--					src='assets/images/county/calender.jpeg' width='20' alt=''><span-->
							<!--					class='ms-2'>2020</span></a>-->
							<!--		</li>-->
							<!--		<li><a class='dropdown-item d-flex align-items-center py-2' href='javascript:;'><img-->
							<!--					src='assets/images/county/calender.jpeg' width='20' alt=''><span-->
							<!--					class='ms-2'>2019</span></a>-->
							<!--		</li>-->
							<!--		<li><a class='dropdown-item d-flex align-items-center py-2' href='javascript:;'><img-->
							<!--					src='assets/images/county/calender.jpeg' width='20' alt=''><span-->
							<!--					class='ms-2'>2018</span></a>-->
							<!--		</li>-->
							<!--	</ul>-->
							<!--</li>-->
							<li class='nav-item dark-mode d-none d-sm-flex'>
								<a class='nav-link dark-mode-icon' href='javascript:;'><i class='bx bx-moon'></i>
								</a>
							</li>

							<li class='nav-item dropdown dropdown-app'>
								<a class='nav-link dropdown-toggle dropdown-toggle-nocaret' data-bs-toggle='dropdown'
									href='javascript:;'><i class='bx bx-grid-alt'></i></a>
								<div class='dropdown-menu dropdown-menu-end p-0'>
									<div class='app-container p-2 my-2'>
										<div class='row gx-0 gy-2 row-cols-3 justify-content-center p-2'>
											<div class='col'>
												<a href='https://www.facebook.com/'target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/facebook.jpeg' width='30'
																alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>Facebook</p>
														</div>
													</div>
												</a>
											</div>
											<div class='col'>
												<a href='https://www.instagram.com/'target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/instagram.jpeg' width='30'
																alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>Instagram</p>
														</div>
													</div>
												</a>
											</div>
											<div class='col'>
												<a href='https://www.youtube.com/channel/UCFKA83F43qh9CiC53vwxh5Q'target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/youtube.png' width='30' alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>Youtube</p>
														</div>
													</div>
												</a>
											</div>
											<div class='col'>
												<a href='drive.google.com'target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/google-drive.png' width='30'
																alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>Drive</p>
														</div>
													</div>
												</a>
											</div>
											<div class='col'>
												<a href='https://www.google.com/' target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/google.jpeg' width='30' alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>Google</p>
														</div>
													</div>
												</a>
											</div>
											<div class='col'>
												<a href='https://in.linkedin.com/' target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/linkedin.png' width='30' alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>Linkedin</p>
														</div>
													</div>
												</a>
											</div>
											<div class='col'>
												<a href='https://calendar.google.com/calendar/u/0/r?pli=1' target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/google-calendar.png' width='30'
																alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>Calendar</p>
														</div>
													</div>
												</a>
											</div>
											<div class='col'>
												<a href='https://mail.google.com/mail/u/0/#inbox'target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/gmail.jpeg' width='30' alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>Gmail</p>
														</div>
													</div>
												</a>
											</div>
											<div class='col'>
												<a href='https://web.whatsapp.com/'target="blank">
													<div class='app-box text-center'>
														<div class='app-icon'>
															<img src='assets/images/app/whatsapp.jpeg' width='30'
																alt=''>
														</div>
														<div class='app-name'>
															<p class='mb-0 mt-1'>WhatsApp</p>
														</div>
													</div>
												</a>
											</div>

										</div><!--end row-->

									</div>
								</div>
							</li>

							<li class='nav-item dropdown dropdown-large'>
								<!-- <a class='nav-link dropdown-toggle dropdown-toggle-nocaret position-relative' href='#'
									data-bs-toggle='dropdown'><span class='alert-count'>7</span>
									<i class='bx bxs-conversation'></i>
								</a> -->
								<div class='dropdown-menu dropdown-menu-end'>
									<a href='javascript:;'>
										<div class='msg-header'>
											<p class='msg-header-title'>Messages</p>
											<p class='msg-header-badge'>8 New</p>
										</div>
									</a>
									<div class='header-notifications-list'>
										<a class='dropdown-item' href='javascript:;'>
											<div class='d-flex align-items-center'>
												<div class='user-online'>
													<img src='assets/images/avatars/avatar-1.png' class='msg-avatar'
														alt='user avatar'>
												</div>
												<div class='flex-grow-1'>
													<h6 class='msg-name'>User 1<span class='msg-time float-end'>5 sec
															ago</span></h6>
													<p class='msg-info'>Admin</p>
												</div>
											</div>
										</a>
										<a class='dropdown-item' href='javascript:;'>
											<div class='d-flex align-items-center'>
												<div class='user-online'>
													<img src='assets/images/avatars/avatar-6.png' class='msg-avatar'
														alt='user avatar'>
												</div>
												<div class='flex-grow-1'>
													<h6 class='msg-name'>User 4 <span class='msg-time float-end'>2 min
															ago</span></h6>
													<p class='msg-info'>Sales Manger</p>
												</div>
											</div>
										</a>
										<a class='dropdown-item' href='javascript:;'>
											<div class='d-flex align-items-center'>
												<div class='user-online'>
													<img src='assets/images/avatars/avatar-2.png' class='msg-avatar'
														alt='user avatar'>
												</div>
												<div class='flex-grow-1'>
													<h6 class='msg-name'>User 7 <span class='msg-time float-end'>14
															sec ago</span></h6>
													<p class='msg-info'>Accounted</p>
												</div>
											</div>
										</a>
										<a class='dropdown-item' href='javascript:;'>
											<div class='d-flex align-items-center'>
												<div class='user-online'>
													<img src='uploads/<?php echo isset($picture) ? $picture : "No name"; ?>'
														class='msg-avatar' alt='user avatar'>
												</div>
												<div class='flex-grow-1'>
													<h6 class='msg-name'>
														<?php echo $name; ?>
													</h6>
													<p class='msg-info'>
														<?php echo $status; ?>
													</p>
												</div>
											</div>
										</a>
										<a class='dropdown-item' href='javascript:;'>
											<div class='d-flex align-items-center'>
												<div class='user-online'>
													<img src='assets/images/avatars/avatar-7.png' class='msg-avatar'
														alt='user avatar'>
												</div>
												<div class='flex-grow-1'>
													<h6 class='msg-name'>User 2 <span class='msg-time float-end'>5 hrs
															ago</span></h6>
													<p class='msg-info'>Event Manager</p>
												</div>
											</div>
										</a>
										<a class='dropdown-item' href='javascript:;'>
											<div class='d-flex align-items-center'>
												<div class='user-online'>
													<img src='assets/images/avatars/avatar-8.png' class='msg-avatar'
														alt='user avatar'>
												</div>
												<div class='flex-grow-1'>
													<h6 class='msg-name'>User 10<span class='msg-time float-end'>1 day
															ago</span></h6>
													<p class='msg-info'>Admin</p>
												</div>
											</div>
										</a>
										<a class='dropdown-item' href='javascript:;'>
											<div class='d-flex align-items-center'>
												<div class='user-online'>
													<img src='assets/images/avatars/avatar-6.png' class='msg-avatar'
														alt='user avatar'>
												</div>
												<div class='flex-grow-1'>
													<h6 class='msg-name'>User 4 <span class='msg-time float-end'>6 hrs
															ago</span></h6>
													<p class='msg-info'>User</p>
												</div>
											</div>
										</a>
									</div>
									<a href='message.php'>
										<div class='text-center msg-footer'>
											<button class='btn btn-primary w-100'>View All Messages</button>
										</div>
									</a>
								</div>
							</li>
							<li class='nav-item dropdown dropdown-large'>
								<?php
								include 'db.php';
								$sql = "SELECT COUNT(DISTINCT username) AS active_users_count FROM history WHERE logout = 'Active'";
								$result = $con->query($sql);
								if ($result->num_rows > 0) {
									$row = $result->fetch_assoc();
									echo '
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
									role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span
										class="alert-count">' . $row["active_users_count"] . '</span>
									<i class="bx bx-user-check"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Active User</p>
										<p class="msg-header-badge">' . $row["active_users_count"] . ' found</p>';

								} else {
									echo '	<p class="msg-header-badge"> 0 found</p>';
								}

								?>


					</div>
					</a>
					<div class='header-message-list'>
						<?php
						$sql = "SELECT history.logout, history.login, history.username, user.picture 
FROM history 
LEFT JOIN user ON history.username = user.username 
WHERE history.logout = 'Active'";

						$result = $con->query($sql);

						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {

								echo '
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="' . $row["picture"] . '" class=" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">' . $row["username"] . '</h6>
													<p>' . $row["login"] . '</p>
													</div>
												<div class=">
													<p class="cart-price mb-0">Active</p>
												</div>
												
											</div>
										</a>';
							}
						} else {
							echo "Currently No Active User(s)";
						}
						$con->close();
						?>

					</div>
					<a href='javascript:;'>
						<div class='text-center msg-footer'>
							<div class='d-flex align-items-center justify-content-between mb-3'>
								<!-- <h5 class='mb-0'>Total</h5>
												<h5 class='mb-0 ms-auto'>$489.00</h5> -->
							</div>
							<!-- <button class='btn btn-primary w-100'>View all user</button> -->
						</div>
					</a>
			</div>
			</li>
			</ul>
	</div>
	<div class='user-box dropdown px-3'>
		<a class='d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret' href='#'
			role='button' data-bs-toggle='dropdown' aria-expanded='false'>
			<img src="<?php if (isset($_SESSION['picture'])) {
				echo $_SESSION['picture'];
			} ?>" class='user-img' alt='user avatar'>
			<div class='user-info'>
				<p class='user-name mb-0'>
					<?php if (isset($_SESSION['uname'])) {
						echo $_SESSION['uname'];
					} ?>
				</p>
				<p class='designattion mb-0'>
					<?php if (isset($_SESSION['status'])) {
						echo $_SESSION['status'];
					} ?>
				</p>
			</div>
		</a>

		<ul class='dropdown-menu dropdown-menu-end'>
			<li><a class='dropdown-item d-flex align-items-center' href="user-profile.php"><i
						class='bx bx-user fs-5'></i><span>Profile</span></a>
			</li>
			<li><a class='dropdown-item d-flex align-items-center' href='users.php'><i
						class='bx bxs-user-detail fs-5'></i><span>Users</span></a>
			</li>
			<li><a class='dropdown-item d-flex align-items-center' href='index.php'><i
						class='bx bx-home-circle fs-5'></i><span>Dashboard</span></a>
			</li>
			<li><a class='dropdown-item d-flex align-items-center' href='password-change.php'><i
						class='bx bx-key fs-5'></i><span>Password Change</span></a>
			</li>
			<li><a class='dropdown-item d-flex align-items-center' href='forgot-password.php'><i
						class='bx bx-revision fs-5'></i><span>Forgot Password</span></a>
			</li>
			<li>
				<div class='dropdown-divider mb-0'></div>
			</li>
			<li class='log-but dropdown-item d-flex align-items-center'><a href='login.php?logout' name='logout'><i
						class='bx bx-log-out-circle' aria-hidden='true'></i><span key='t-maps'>Log Out</span></a></li>
		</ul>
	</div>
	</nav>
	</div>
	</header>
	<!--end header -->