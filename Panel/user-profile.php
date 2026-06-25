<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

// Strict Authentication Check
if (!isset($_SESSION['uname'])) {
    header('location:../index.php');
    exit();
}

// Check database connection - fallback to mock mode if offline
$is_mock_mode = !$con;

if ($is_mock_mode) {
    $id = 1;
    $name = $_SESSION['profile_name'] ?? "Aman Rai";
    $number = $_SESSION['profile_number'] ?? "1234567890";
    $email = $_SESSION['profile_email'] ?? "amanrai7830@gmail.com";
    $role = $_SESSION['role'] ?? "Staff Member";
    $status = $_SESSION['role'] ?? "Staff Member";
    $fb = $_SESSION['profile_fb'] ?? "https://facebook.com";
    $insta = $_SESSION['profile_insta'] ?? "https://instagram.com";
    $ref = $_SESSION['profile_ref'] ?? "C11CL999";
    $picture = $_SESSION['picture'] ?? "";
    $dob = $_SESSION['profile_dob'] ?? "N/A";
    $address = $_SESSION['profile_address'] ?? "N/A";
    $aadhar = $_SESSION['profile_aadhar'] ?? "4532 9876 1100";
    $bank_registry = $_SESSION['profile_bank_registry'] ?? "N/A";
    $account_no = $_SESSION['profile_account_no'] ?? "N/A";
    $ifsc = $_SESSION['profile_ifsc'] ?? "N/A";
    $present_days = $_SESSION['profile_present_days'] ?? 17;
    $blood_group = $_SESSION['profile_blood_group'] ?? "N/A";
    $salary_bracket = $_SESSION['profile_salary_bracket'] ?? "XXXXXX";
} else {
    // 1. Dynamic Table Patching (Alters table if columns do not exist)
    $colsCheck = $con->query("SHOW COLUMNS FROM `user` LIKE 'dob'");
    if ($colsCheck && $colsCheck->num_rows == 0) {
        $con->query("ALTER TABLE `user` ADD `dob` VARCHAR(50) DEFAULT 'N/A'");
        $con->query("ALTER TABLE `user` ADD `address` TEXT DEFAULT NULL");
        $con->query("ALTER TABLE `user` ADD `aadhar` VARCHAR(50) DEFAULT 'N/A'");
        $con->query("ALTER TABLE `user` ADD `bank_registry` VARCHAR(100) DEFAULT 'N/A'");
        $con->query("ALTER TABLE `user` ADD `account_no` VARCHAR(50) DEFAULT 'N/A'");
        $con->query("ALTER TABLE `user` ADD `ifsc` VARCHAR(50) DEFAULT 'N/A'");
        $con->query("ALTER TABLE `user` ADD `present_days` INT DEFAULT 17");
        $con->query("ALTER TABLE `user` ADD `blood_group` VARCHAR(10) DEFAULT 'N/A'");
        $con->query("ALTER TABLE `user` ADD `salary_bracket` VARCHAR(50) DEFAULT 'XXXXXX'");
    }

    // Fetch Logged-in User Data securely
    $userSql = "SELECT * FROM user WHERE username = ?";
    $stmt = $con->prepare($userSql);
    $username = $_SESSION['uname'];
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    $stmt->close();

    if (!$userData) {
        die("User details not found.");
    }

    $id = $userData["id"];
    $name = $userData["name"];
    $number = $userData["number"];
    $email = $userData["email"];
    $role = $userData["role"];
    $status = $userData["status"];
    $fb = $userData["fb"];
    $insta = $userData["insta"];
    $ref = $userData["ref"];
    $picture = $userData["picture"];
    $dob = $userData["dob"] ?? 'N/A';
    $address = $userData["address"] ?? 'N/A';
    $aadhar = $userData["aadhar"] ?? 'N/A';
    $bank_registry = $userData["bank_registry"] ?? 'N/A';
    $account_no = $userData["account_no"] ?? 'N/A';
    $ifsc = $userData["ifsc"] ?? 'N/A';
    $present_days = $userData["present_days"] ?? 17;
    $blood_group = $userData["blood_group"] ?? 'N/A';
    $salary_bracket = $userData["salary_bracket"] ?? 'XXXXXX';
}

$updatedMessage = '';
$errorMessage = '';

// Process update request securely
if (isset($_POST['update_profile_fields'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $number = $_POST['number'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $address = $_POST['address'] ?? '';
    $aadhar = $_POST['aadhar'] ?? '';
    $bank_registry = $_POST['bank_registry'] ?? '';
    $account_no = $_POST['account_no'] ?? '';
    $ifsc = $_POST['ifsc'] ?? '';
    $present_days = intval($_POST['present_days'] ?? 17);
    $blood_group = $_POST['blood_group'] ?? '';
    $salary_bracket = $_POST['salary_bracket'] ?? '';
    $fb = $_POST['fb'] ?? '';
    $insta = $_POST['insta'] ?? '';
    
    // Handle image upload if a file was selected
    $picturePath = $picture;
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = time() . '_' . basename($_FILES['profile_pic']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
            $picturePath = $targetFile;
            $_SESSION['picture'] = $picturePath; // Update session
        }
    }
    
    if ($is_mock_mode) {
        $_SESSION['profile_name'] = $name;
        $_SESSION['profile_email'] = $email;
        $_SESSION['profile_number'] = $number;
        $_SESSION['profile_dob'] = $dob;
        $_SESSION['profile_address'] = $address;
        $_SESSION['profile_aadhar'] = $aadhar;
        $_SESSION['profile_bank_registry'] = $bank_registry;
        $_SESSION['profile_account_no'] = $account_no;
        $_SESSION['profile_ifsc'] = $ifsc;
        $_SESSION['profile_present_days'] = $present_days;
        $_SESSION['profile_blood_group'] = $blood_group;
        $_SESSION['profile_salary_bracket'] = $salary_bracket;
        $_SESSION['profile_fb'] = $fb;
        $_SESSION['profile_insta'] = $insta;
        
        $updatedMessage = "Profile fields updated successfully (Sandbox Mock mode)!";
        $picture = $picturePath;
    } else {
        $updateSql = "UPDATE user SET name = ?, email = ?, number = ?, dob = ?, address = ?, aadhar = ?, bank_registry = ?, account_no = ?, ifsc = ?, present_days = ?, blood_group = ?, salary_bracket = ?, fb = ?, insta = ?, picture = ? WHERE id = ?";
        $updateStmt = $con->prepare($updateSql);
        if ($updateStmt) {
            $updateStmt->bind_param('sssssssssisssssi', $name, $email, $number, $dob, $address, $aadhar, $bank_registry, $account_no, $ifsc, $present_days, $blood_group, $salary_bracket, $fb, $insta, $picturePath, $id);
            if ($updateStmt->execute()) {
                $updatedMessage = "Profile fields updated successfully!";
                $picture = $picturePath;
            } else {
                $errorMessage = "Error updating profile details: " . $updateStmt->error;
            }
            $updateStmt->close();
        }
    }
}
?>

<?php include 'head.php'; ?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">User</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <?php if (!empty($updatedMessage)): ?>
            <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-white"><i class="bx bxs-check-circle"></i></div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Success</h6>
                        <div class="text-white"><?php echo htmlspecialchars($updatedMessage); ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-white"><i class="bx bxs-error-circle"></i></div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Error</h6>
                        <div class="text-white"><?php echo htmlspecialchars($errorMessage); ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="main-body">
                <div class="row">
                    <!-- Profile Card -->
                    <div class="col-12 mb-4">
                        <div class="card overflow-hidden shadow-sm" style="border-radius: 12px; border: 1px solid rgba(0,0,0,0.08);">
                            <!-- Purple Banner -->
                            <div class="profile-banner-header" style="background: linear-gradient(135deg, #7e57c2 0%, #6200ea 100%); height: 180px; position: relative;"></div>
                            
                            <!-- Profile Header Content -->
                            <div class="card-body text-center position-relative pb-4" style="margin-top: -60px;">
                                <div class="d-inline-block position-relative mb-3">
                                    <img src="<?php echo !empty($picture) ? htmlspecialchars($picture) : 'assets/images/avatars/avatar-1.png'; ?>" 
                                         alt="User Profile" 
                                         class="rounded-circle p-1 bg-white" 
                                         width="120" height="120"
                                         style="object-fit: cover; box-shadow: 0 4px 15px rgba(0,0,0,0.15); width: 120px; height: 120px;">
                                    <a href="javascript:;" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" 
                                       style="width: 32px; height: 32px; border: 2px solid #fff;"
                                       data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                        <i class="bx bx-camera" style="font-size: 1.05rem;"></i>
                                    </a>
                                </div>
                                
                                <h4 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($name); ?></h4>
                                <p class="text-muted mb-3" style="font-size: 0.95rem; font-weight: 500;">
                                    <?php echo !empty($status) ? htmlspecialchars($status) : 'Staff Member'; ?>
                                </p>
                                
                                <button class="btn btn-primary px-4 py-2" 
                                        style="border-radius: 20px; font-weight: 600; font-size: 0.9rem;"
                                        data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                    🖊️ EDIT PROFILE FIELDS
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="col-12 mb-4">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="card shadow-sm h-100" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="card-body py-3 px-4 d-flex flex-column justify-content-center align-items-center text-center">
                                        <p class="text-muted mb-1 fw-bold" style="font-size: 0.72rem; letter-spacing: 1px; text-transform: uppercase;">SALARY BRACKET</p>
                                        <h3 class="mb-0 text-dark fw-bold d-flex align-items-center justify-content-center">
                                            <span id="salaryBracketVal" style="font-size: 1.4rem;">XXXXXX</span>
                                            <i class="bx bx-show ms-2 text-primary" id="toggleSalaryBtn" style="cursor: pointer; font-size: 1.25rem;"></i>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="card shadow-sm h-100" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="card-body py-3 px-4 d-flex flex-column justify-content-center align-items-center text-center">
                                        <p class="text-muted mb-1 fw-bold" style="font-size: 0.72rem; letter-spacing: 1px; text-transform: uppercase;">PRESENT DAYS (MONTH)</p>
                                        <h3 class="mb-0 text-success fw-bold" style="font-size: 1.5rem;"><?php echo htmlspecialchars($present_days); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="card shadow-sm h-100" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="card-body py-3 px-4 d-flex flex-column justify-content-center align-items-center text-center">
                                        <p class="text-muted mb-1 fw-bold" style="font-size: 0.72rem; letter-spacing: 1px; text-transform: uppercase;">BLOOD GROUP</p>
                                        <h3 class="mb-0 text-danger fw-bold" style="font-size: 1.5rem;"><?php echo htmlspecialchars($blood_group); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="card shadow-sm h-100" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="card-body py-3 px-4 d-flex flex-column justify-content-center align-items-center text-center">
                                        <p class="text-muted mb-1 fw-bold" style="font-size: 0.72rem; letter-spacing: 1px; text-transform: uppercase;">JOINING DATE</p>
                                        <h3 class="mb-0 text-secondary fw-bold" style="font-size: 1.5rem;">N/A</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal & Official Details -->
                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card shadow-sm h-100" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.06);">
                            <div class="card-header bg-transparent border-0 d-flex align-items-center gap-2 pt-4 px-4">
                                <i class="bx bx-user text-primary" style="font-size: 1.45rem;"></i>
                                <h5 class="mb-0 fw-bold text-dark" style="letter-spacing: 0.5px; font-size: 1rem;">PERSONAL DETAILS</h5>
                            </div>
                            <div class="card-body px-4 pb-4">
                                <div class="mb-3 border-bottom pb-2">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">Full Name</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($name); ?></p>
                                </div>
                                <div class="mb-3 border-bottom pb-2">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">Email Address</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($email); ?></p>
                                </div>
                                <div class="mb-3 border-bottom pb-2">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">Mobile Number</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($number); ?></p>
                                </div>
                                <div class="mb-3 border-bottom pb-2">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">Date of Birth</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($dob); ?></p>
                                </div>
                                <div class="mb-0">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">Current Address</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($address); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card shadow-sm h-100" style="border-radius: 10px; border: 1px solid rgba(0,0,0,0.06);">
                            <div class="card-header bg-transparent border-0 d-flex align-items-center gap-2 pt-4 px-4">
                                <i class="bx bx-folder-open text-primary" style="font-size: 1.45rem;"></i>
                                <h5 class="mb-0 fw-bold text-dark" style="letter-spacing: 0.5px; font-size: 1rem;">OFFICIAL DETAILS</h5>
                            </div>
                            <div class="card-body px-4 pb-4">
                                <div class="mb-3 border-bottom pb-2">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">Identity (Aadhar)</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;" id="aadharDisplayContainer">
                                        <span id="aadharVal">[Aadhar Redacted]</span>
                                        <i class="bx bx-show ms-2 text-primary" id="toggleAadharBtn" style="cursor: pointer;"></i>
                                    </p>
                                </div>
                                <div class="mb-3 border-bottom pb-2">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">Bank Registry</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($bank_registry); ?></p>
                                </div>
                                <div class="mb-3 border-bottom pb-2">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">Account No</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($account_no); ?></p>
                                </div>
                                <div class="mb-0">
                                    <p class="text-muted mb-0" style="font-size: 0.78rem; text-transform: uppercase; font-weight: 600;">IFSC Code</p>
                                    <p class="text-dark mb-0 fw-bold" style="font-size: 0.95rem;"><?php echo htmlspecialchars($ifsc); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; background: #ffffff;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark" id="editProfileModalLabel">🖊️ Edit Profile Fields</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Profile Picture</label>
                            <input type="file" name="profile_pic" class="form-control">
                            <small class="text-muted">Upload a new image to update your avatar</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Mobile Number</label>
                            <input type="text" name="number" class="form-control" value="<?php echo htmlspecialchars($number); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Date of Birth</label>
                            <input type="text" name="dob" class="form-control" value="<?php echo htmlspecialchars($dob); ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">Current Address</label>
                            <textarea name="address" class="form-control" rows="2"><?php echo htmlspecialchars($address); ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Identity (Aadhar)</label>
                            <input type="text" name="aadhar" class="form-control" value="<?php echo htmlspecialchars($aadhar); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Bank Registry</label>
                            <input type="text" name="bank_registry" class="form-control" value="<?php echo htmlspecialchars($bank_registry); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Account No</label>
                            <input type="text" name="account_no" class="form-control" value="<?php echo htmlspecialchars($account_no); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">IFSC Code</label>
                            <input type="text" name="ifsc" class="form-control" value="<?php echo htmlspecialchars($ifsc); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">Present Days (Month)</label>
                            <input type="number" name="present_days" class="form-control" value="<?php echo htmlspecialchars($present_days); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">Blood Group</label>
                            <input type="text" name="blood_group" class="form-control" value="<?php echo htmlspecialchars($blood_group); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">Salary Bracket</label>
                            <input type="text" name="salary_bracket" class="form-control" value="<?php echo htmlspecialchars($salary_bracket); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Facebook Link</label>
                            <input type="text" name="fb" class="form-control" value="<?php echo htmlspecialchars($fb); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark">Instagram Link</label>
                            <input type="text" name="insta" class="form-control" value="<?php echo htmlspecialchars($insta); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_profile_fields" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Salary Bracket
    var toggleSalaryBtn = document.getElementById('toggleSalaryBtn');
    if (toggleSalaryBtn) {
        toggleSalaryBtn.addEventListener('click', function() {
            var salarySpan = document.getElementById('salaryBracketVal');
            var currentVal = salarySpan.innerText;
            var actualSalary = '<?php echo addslashes($salary_bracket); ?>';
            if (currentVal === 'XXXXXX') {
                salarySpan.innerText = actualSalary;
                this.classList.remove('bx-show');
                this.classList.add('bx-hide');
            } else {
                salarySpan.innerText = 'XXXXXX';
                this.classList.remove('bx-hide');
                this.classList.add('bx-show');
            }
        });
    }

    // Toggle Aadhar
    var toggleAadharBtn = document.getElementById('toggleAadharBtn');
    if (toggleAadharBtn) {
        toggleAadharBtn.addEventListener('click', function() {
            var aadharSpan = document.getElementById('aadharVal');
            var currentVal = aadharSpan.innerText;
            var actualAadhar = '<?php echo addslashes($aadhar); ?>';
            if (currentVal === '[Aadhar Redacted]') {
                aadharSpan.innerText = actualAadhar;
                this.classList.remove('bx-show');
                this.classList.add('bx-hide');
            } else {
                aadharSpan.innerText = '[Aadhar Redacted]';
                this.classList.remove('bx-hide');
                this.classList.add('bx-show');
            }
        });
    }
});
</script>

<?php include 'foot.php'; ?>