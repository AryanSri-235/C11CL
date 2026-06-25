<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set("Asia/Kolkata");

// 1. Strict Login Check
if (!isset($_SESSION['password']) || !isset($_SESSION['uname'])) {
    if (isset($is_backend_script) && $is_backend_script) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unauthorized access. Session expired or not logged in.']);
        exit();
    } else {
        header('location:../index.php');
        exit();
    }
}

// 2. Session Timeout (8 Hours)
if (isset($_SESSION['last-active'])) {
    if ((time() - $_SESSION['last-active']) > 28800) {
        if (isset($is_backend_script) && $is_backend_script) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Session timeout. Please log in again.']);
            exit();
        } else {
            header('Location: login.php?logout');
            exit();
        }
    }
}
$_SESSION['last-active'] = time();

// 3. Role Switcher Logic
if (isset($_GET['switch_role'])) {
    $newRole = $_GET['switch_role'];
    $validRoles = ['developer', 'superadmin', 'admin', 'subadmin', 'marketing', 'sales-manager', 'sale-person', 'operation-team', 'coach'];
    if (in_array($newRole, $validRoles)) {
        $_SESSION['status'] = $newRole;
        
        $roleDesignations = [
            'developer' => 'Developer (All Access)',
            'superadmin' => 'Super Admin',
            'admin' => 'Admin',
            'subadmin' => 'Sub Admin',
            'marketing' => 'Marketing',
            'sales-manager' => 'Sales Manager',
            'sale-person' => 'Sale Person',
            'operation-team' => 'Operation Team',
            'coach' => 'Coach'
        ];
        if (isset($roleDesignations[$newRole])) {
            $_SESSION['role'] = $roleDesignations[$newRole];
        }
    }
    // Redirect to the current page without the query parameter to clean the URL
    $cleanUrl = strtok($_SERVER['REQUEST_URI'], '?');
    header("Location: $cleanUrl");
    exit();
}

// 4. Centralized Route-based Access Authorization Check
$currentPage = basename($_SERVER['PHP_SELF']);
$currentRole = $_SESSION['status'] ?? '';

// Map of restricted pages to allowed roles
$rolePermissions = [
    'dashboard.php'             => ['superadmin', 'admin', 'developer'],
    'phase1data.php'            => ['superadmin', 'admin', 'developer'],
    'phase1data_user.php'       => ['sale-leader', 'developer', 'admin', 'superadmin'],
    'phase2data.php'            => ['superadmin', 'admin', 'developer'],
    'register_data.php'         => ['superadmin', 'admin', 'developer'],
    'report.php'                => ['superadmin', 'admin', 'developer'],
    'abandoned_leads_view.php'  => ['superadmin', 'admin', 'developer', 'sale-leader'],
    'blog_list.php'             => ['superadmin', 'developer'],
    'add_blog.php'              => ['superadmin', 'developer'],
    'edit_blog.php'             => ['superadmin', 'developer'],
    'users.php'                 => ['superadmin', 'admin'],
    'add-user.php'              => ['superadmin', 'admin'],
    'users-status.php'          => ['superadmin', 'admin'],
    'user-profile.php'          => ['superadmin', 'admin', 'developer', 'sale-leader', 'coach', 'subadmin', 'marketing', 'sales-manager', 'sale-person', 'operation-team'],
    'coming-soon.php'           => ['superadmin', 'admin', 'developer', 'sale-leader', 'coach', 'subadmin', 'marketing', 'sales-manager', 'sale-person', 'operation-team'],
    'contact_data.php'          => ['superadmin', 'admin', 'developer'],
    'mobile_data.php'           => ['superadmin', 'admin', 'developer'],
    'job_data.php'              => ['superadmin', 'admin', 'developer'],
    'mails_data.php'            => ['superadmin', 'admin', 'developer'],
    'sponsorship_data.php'      => ['superadmin', 'admin', 'developer'],
    'partners_data.php'         => ['superadmin', 'admin', 'developer'],
    
    // Backend API scripts
    'delete_player.php'         => ['superadmin', 'admin', 'developer'],
    'update_player.php'         => ['superadmin', 'admin', 'developer'],
    'blog_delete.php'           => ['superadmin', 'developer'],
    'contact_delete.php'        => ['superadmin', 'admin', 'developer'],
];

if (array_key_exists($currentPage, $rolePermissions)) {
    if (!in_array($currentRole, $rolePermissions[$currentPage])) {
        if (isset($is_backend_script) && $is_backend_script) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Forbidden. You do not have permission to execute this operation.']);
            exit();
        } else {
            // Output Denied UI directly
            echo "
            <!DOCTYPE html>
            <html>
            <head>
                <title>Access Denied - C11CL Panel</title>
                <link href='assets/css/bootstrap.min.css' rel='stylesheet'>
                <link href='https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap' rel='stylesheet'>
                <style>
                    body { background: #0f172a; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
                    .card-denied { background: #1e293b; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 40px; text-align: center; max-width: 450px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); }
                    h3 { color: #f87171; font-weight: 700; margin-bottom: 15px; }
                    p { color: #94a3b8; font-size: 14px; line-height: 1.6; }
                    .btn-back { background: #ef4444; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; margin-top: 20px; transition: background 0.2s; }
                    .btn-back:hover { background: #dc2626; color: #fff; }
                </style>
            </head>
            <body>
                <div class='card-denied'>
                    <h3>Access Denied 🚫</h3>
                    <p>Your current account role (<strong>" . htmlspecialchars($currentRole) . "</strong>) does not have permission to access this page.</p>
                    <a href='index.php' class='btn-back'>Return to Dashboard</a>
                </div>
            </body>
            </html>";
            exit();
        }
    }
}

// If this is a backend API script and checks passed, return immediately without outputting any HTML wrapper markup
if (isset($is_backend_script) && $is_backend_script) {
    return;
}
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
			     <li class='menu-label'>CORE ENGINE</li>
<?php if ($currentRole !== 'coach'): ?>
				<li>
					<a href='phase1data.php'>
						<div class='parent-icon'><i class='bx bx-log-in-circle'></i></div>
						<div class='menu-title'>Phase 1 Data</div>
					</a>
				</li>
				<li>
					<a href='phase1data_user.php'>
						<div class='parent-icon'><i class='bx bx-phone-call'></i></div>
						<div class='menu-title'>Phase 1 Data</div>
					</a>
				</li>
				<li>
					<a href='phase2data.php'>
						<div class='parent-icon'><i class='bx bx-check-double'></i></div>
						<div class='menu-title'>Phase 2 Data</div>
					</a>
				</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-rocket'></i></div>
						<div class='menu-title'>Phase 3 Data (New)</div>
					</a>
				</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-credit-card'></i></div>
						<div class='menu-title'>Razorpay Payments</div>
					</a>
				</li>

				<li class='menu-label'>CRM Operations</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-calendar-check'></i></div>
						<div class='menu-title'>Staff Attendance</div>
					</a>
				</li>
				<li>
					<a href='javascript:;' class='has-arrow'>
						<div class='parent-icon'><i class='bx bx-receipt'></i></div>
						<div class='menu-title'>Form Submit Data</div>
					</a>
					<ul>
						<li><a href='contact_data.php'><i class='bx bx-radio-circle'></i>Contact Us</a></li>
						<li><a href='mobile_data.php'><i class='bx bx-radio-circle'></i>Phone No Submit</a></li>
						<li><a href='job_data.php'><i class='bx bx-radio-circle'></i>Apply for Job</a></li>
						<li><a href='mails_data.php'><i class='bx bx-radio-circle'></i>Submit Mails Data</a></li>
						<li><a href='sponsorship_data.php'><i class='bx bx-radio-circle'></i>Sponsorship Data</a></li>
					</ul>
				</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-money'></i></div>
						<div class='menu-title'>Expense Management</div>
					</a>
				</li>

				<li>
					<a href='javascript:;' class='has-arrow'>
						<div class='parent-icon'><i class='bx bx-run'></i></div>
						<div class='menu-title'>Coach & Academy</div>
					</a>
					<ul>
						<li><a href='partners_data.php'><i class='bx bx-radio-circle'></i>Academy Partners</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Coach Panel</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Coach Profiles</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Coach Attendance</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Player Attendance</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Player Card Updates</a></li>
					</ul>
				</li>

				<li>
					<a href='javascript:;' class='has-arrow'>
						<div class='parent-icon'><i class='bx bx-bar-chart-alt-2'></i></div>
						<div class='menu-title'>Analytics & Reports</div>
					</a>
					<ul>
						<li><a href='report.php'><i class='bx bx-radio-circle'></i>Dashboard Graph</a></li>
						<li><a href='users-status.php'><i class='bx bx-radio-circle'></i>Active Users Logs</a></li>
					</ul>
				</li>

				<li class='menu-label'>CMS AREA</li>
				<li>
					<a href='blog_list.php'>
						<div class='parent-icon'><i class='bx bx-list-ul'></i></div>
						<div class='menu-title'>Blog List</div>
					</a>
				</li>
				<li>
					<a href='add_blog.php'>
						<div class='parent-icon'><i class='bx bx-plus-circle'></i></div>
						<div class='menu-title'>Add Blog</div>
					</a>
				</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-file'></i></div>
						<div class='menu-title'>Manage Pages</div>
					</a>
				</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-cog'></i></div>
						<div class='menu-title'>Site Settings</div>
					</a>
				</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-images'></i></div>
						<div class='menu-title'>Manage Gallery</div>
					</a>
				</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-trophy'></i></div>
						<div class='menu-title'>Match Management</div>
					</a>
				</li>
				<li>
					<a href='coming-soon.php'>
						<div class='parent-icon'><i class='bx bx-broadcast'></i></div>
						<div class='menu-title'>Manage Announcement.php</div>
					</a>
				</li>

				<li class='menu-label'>CONTROLS</li>
				<li>
					<a href='javascript:;' class='has-arrow'>
						<div class='parent-icon'><i class='bx bx-user-pin'></i></div>
						<div class='menu-title'>Users Settings</div>
					</a>
					<ul>
						<li><a href='user-profile.php'><i class='bx bx-radio-circle'></i>Profile</a></li>
						<?php if (in_array($currentRole, ['superadmin', 'admin', 'developer'])): ?>
							<li><a href='users.php'><i class='bx bx-radio-circle'></i>Users</a></li>
							<li><a href='add-user.php'><i class='bx bx-radio-circle'></i>Add User</a></li>
							<li><a href='users-status.php'><i class='bx bx-radio-circle'></i>Users Status</a></li>
						<?php endif; ?>
					</ul>
				</li>
				<li>
					<a href='login.php?logout'>
						<div class='parent-icon'><i class='bx bx-log-out-circle'></i></div>
						<div class='menu-title'>Sign Out Portal</div>
					</a>
				</li>
<?php else: ?>
				<!-- Coach Section -->
				<li>
					<a href='javascript:;' class='has-arrow' aria-expanded='true'>
						<div class='parent-icon'><i class='bx bx-run'></i></div>
						<div class='menu-title'>Coach & Academy</div>
					</a>
					<ul class='mm-collapse mm-show'>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Coach Panel</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Coach Profiles</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Coach Attendance</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Player Attendance</a></li>
						<li><a href='coming-soon.php'><i class='bx bx-radio-circle'></i>Player Card Updates</a></li>
					</ul>
				</li>

				<li class='menu-label'>CONTROLS</li>
				<li>
					<a href='user-profile.php'>
						<div class='parent-icon'><i class='bx bx-user'></i></div>
						<div class='menu-title'>My Profile</div>
					</a>
				</li>
				<li>
					<a href='login.php?logout'>
						<div class='parent-icon'><i class='bx bx-log-out-circle'></i></div>
						<div class='menu-title'>Sign Out Portal</div>
					</a>
				</li>
<?php endif; ?>
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
					
					<div class="dropdown ms-2">
						<button class="btn dropdown-toggle text-white border border-secondary" type="button" id="roleSwitcherDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 6px; font-weight: 500; background: rgba(255,255,255,0.05); font-size: 0.85rem; padding: 6px 12px;">
							<i class="bx bx-cog me-1 text-warning"></i> Testing As: <strong class="text-warning"><?php 
								$statusLabel = $_SESSION['status'] ?? 'Unknown';
								$rolesMap = [
									'developer' => 'Developer',
									'superadmin' => 'Super Admin',
									'admin' => 'Admin',
									'subadmin' => 'Sub Admin',
									'marketing' => 'Marketing',
									'sales-manager' => 'Sales Manager',
									'sale-person' => 'Sale Person',
									'operation-team' => 'Operation Team',
									'coach' => 'Coach'
								];
								echo htmlspecialchars($rolesMap[$statusLabel] ?? ucfirst($statusLabel));
							?></strong>
						</button>
						<ul class="dropdown-menu shadow-lg" aria-labelledby="roleSwitcherDropdown" style="background: #151c2c; border: 1px solid rgba(255,255,255,0.1);">
							<li><a class="dropdown-item text-white-50" href="?switch_role=developer">Developer (All Access)</a></li>
							<li><a class="dropdown-item text-white-50" href="?switch_role=superadmin">Super Admin</a></li>
							<li><a class="dropdown-item text-white-50" href="?switch_role=admin">Admin</a></li>
							<li><a class="dropdown-item text-white-50" href="?switch_role=subadmin">Sub Admin</a></li>
							<li><a class="dropdown-item text-white-50" href="?switch_role=marketing">Marketing</a></li>
							<li><a class="dropdown-item text-white-50" href="?switch_role=sales-manager">Sales Manager</a></li>
							<li><a class="dropdown-item text-white-50" href="?switch_role=sale-person">Sale Person</a></li>
							<li><a class="dropdown-item text-white-50" href="?switch_role=operation-team">Operation Team</a></li>
							<li><a class="dropdown-item text-white-50" href="?switch_role=coach">Coach</a></li>
						</ul>
					</div>
					<div class="ms-3 d-none d-md-block">
						<h5 class="mb-0 text-white fw-bold" style="font-size: 1.05rem; letter-spacing: 0.5px;">Champions 11 Cricket League</h5>
					</div>

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
								$active_users_count = 0;
								if ($con) {
									$sql = "SELECT COUNT(DISTINCT username) AS active_users_count FROM history WHERE logout = 'Active'";
									$result = $con->query($sql);
									if ($result && $result->num_rows > 0) {
										$row = $result->fetch_assoc();
										$active_users_count = $row["active_users_count"];
									}
								} else {
									$active_users_count = 1;
								}
								
								echo '
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
									role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span
										class="alert-count">' . $active_users_count . '</span>
									<i class="bx bx-user-check"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Active User</p>
										<p class="msg-header-badge">' . $active_users_count . ' found</p>';
								?>
									</div>
									</a>
									<div class='header-message-list'>
										<?php
										if ($con) {
											$sql = "SELECT history.logout, history.login, history.username, user.picture 
													FROM history 
													LEFT JOIN user ON history.username = user.username 
													WHERE history.logout = 'Active'";
											$result = $con->query($sql);
											if ($result && $result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													echo '
															<a class="dropdown-item" href="javascript:;">
																<div class="d-flex align-items-center gap-3">
																	<div class="position-relative">
																		<div class="cart-product rounded-circle bg-light">
																			<img src="' . htmlspecialchars($row["picture"] ?? '') . '" alt="product image" onerror="this.src=\'assets/images/avatars/avatar-1.png\'">
																		</div>
																	</div>
																	<div class="flex-grow-1">
																		<h6 class="cart-product-title mb-0">' . htmlspecialchars($row["username"] ?? '') . '</h6>
																		<p>' . htmlspecialchars($row["login"] ?? '') . '</p>
																	</div>
																	<div>
																		<p class="cart-price mb-0">Active</p>
																	</div>
																</div>
															</a>';
												}
											} else {
												echo "Currently No Active User(s)";
											}
										} else {
											echo '
											<a class="dropdown-item" href="javascript:;">
												<div class="d-flex align-items-center gap-3">
													<div class="position-relative">
														<div class="cart-product rounded-circle bg-light">
															<img src="assets/images/avatars/avatar-1.png" alt="product image">
														</div>
													</div>
													<div class="flex-grow-1">
														<h6 class="cart-product-title mb-0">' . htmlspecialchars($_SESSION['uname'] ?? 'admin') . '</h6>
														<p>Active now</p>
													</div>
													<div>
														<p class="cart-price mb-0">Active</p>
													</div>
												</div>
											</a>';
										}
										?>
									</div>
									<a href='javascript:;'>
										<div class='text-center msg-footer'>
											<div class='d-flex align-items-center justify-content-between mb-3'>
											</div>
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