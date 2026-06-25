<?php
session_start();
if (!isset($_SESSION['password']) || !isset($_SESSION['uname'])) {
    header('location:../index.php');
    exit();
}

include 'db.php';

$error   = '';
$success = '';

if (isset($_POST['addaccount'])) {
    $name     = trim($_POST['name']     ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password']         ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';
    $number   = trim($_POST['number']   ?? '');
    $email    = trim($_POST['email']    ?? '');
    $role     = $_POST['role']             ?? '';
    $status   = $_POST['status']           ?? '';
    $address  = trim($_POST['fb']       ?? '');
    $insta    = trim($_POST['insta']    ?? '');
    $ref      = trim($_POST['ref']      ?? '');

    // ── Backend validation ───────────────────────────────────────────
    if (empty($name) || empty($username) || empty($password) || empty($email) || empty($role) || empty($status)) {
        $error = 'All required fields must be filled in.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif (!preg_match('/^[0-9]{10}$/', $number)) {
        $error = 'Phone number must be exactly 10 digits.';
    } else {
        // ── Username uniqueness check ────────────────────────────────
        $chk = $con->prepare("SELECT id FROM user WHERE username = ?");
        $chk->bind_param('s', $username);
        $chk->execute();
        $chk_result = $chk->get_result();
        if ($chk_result->num_rows > 0) {
            $error = 'Username already exists. Please choose a different one.';
            $chk->close();
        } else {
            $chk->close();

            // ── Hash the password ────────────────────────────────────
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // ── File upload ──────────────────────────────────────────
            $image = '';
            if (!empty($_FILES['picture']['name'])) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $max_size      = 2 * 1024 * 1024; // 2 MB
                $file_tmp      = $_FILES['picture']['tmp_name'];
                $file_size     = $_FILES['picture']['size'];
                $file_mime     = mime_content_type($file_tmp);
                $file_ext      = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));
                $allowed_exts  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (!in_array($file_mime, $allowed_types) || !in_array($file_ext, $allowed_exts)) {
                    $error = 'Only JPG, PNG, GIF, or WEBP images are allowed.';
                } elseif ($file_size > $max_size) {
                    $error = 'Image must be under 2 MB.';
                } elseif (getimagesize($file_tmp) === false) {
                    $error = 'Uploaded file is not a valid image.';
                } else {
                    $upload_dir = 'uploads/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    // Sanitized unique filename — never use original filename directly
                    $safe_filename = uniqid('usr_', true) . '.' . $file_ext;
                    $target_path   = $upload_dir . $safe_filename;

                    $compressed = compressImage($file_tmp, $target_path, 80);
                    if ($compressed) {
                        $image = $target_path;
                    } else {
                        $error = 'Failed to upload profile image.';
                    }
                }
            }

            // ── Insert user if no upload error ───────────────────────
            if (empty($error)) {
                $stmt = $con->prepare(
                    "INSERT INTO user (name, username, password, number, email, role, status, fb, insta, ref, picture)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->bind_param(
                    'sssssssssss',
                    $name, $username, $hashed_password,
                    $number, $email, $role, $status,
                    $address, $insta, $ref, $image
                );

                if ($stmt->execute()) {
                    $success = 'User <strong>' . htmlspecialchars($name) . '</strong> created successfully.';
                } else {
                    $error = 'Database error. Please try again.';
                }
                $stmt->close();
            }
        }
    }
}

// ── Image compression helper ─────────────────────────────────────────
function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);
    if (!$info) return false;

    switch ($info['mime']) {
        case 'image/jpeg': $img = imagecreatefromjpeg($source); break;
        case 'image/png':  $img = imagecreatefrompng($source);  break;
        case 'image/gif':  $img = imagecreatefromgif($source);  break;
        case 'image/webp': $img = imagecreatefromwebp($source); break;
        default: return false;
    }

    if (!$img) return false;
    $result = imagejpeg($img, $destination, $quality);
    imagedestroy($img);
    return $result ? $destination : false;
}

include 'head.php';
?>

<?php if ($error): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'error', title: 'Error', html: '<?= addslashes($error) ?>' });
    });
</script>
<?php endif; ?>

<?php if ($success): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'success', title: 'User Created', html: '<?= addslashes($success) ?>' });
    });
</script>
<?php endif; ?>

<div class="page-wrapper">
    <div class="page-content">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Users</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add User</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Add New User</h5>

                        <form id="addUserForm" method="POST" class="row g-3" enctype="multipart/form-data">

                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter full name"
                                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">User ID (Username) <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" id="username"
                                       placeholder="Enter username"
                                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                                <div id="usernameError" class="text-danger small mt-1"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="Min. 8 characters" required minlength="8">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                                       placeholder="Re-enter password" required>
                                <div id="passwordError" class="text-danger small mt-1"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="number" class="form-control" placeholder="10-digit number"
                                       pattern="[0-9]{10}" title="10-digit phone number"
                                       value="<?= htmlspecialchars($_POST['number'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email"
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select" required>
                                    <option value="">Choose role...</option>
                                    <?php
                                    $roles = ['owner' => 'Owner', 'developer' => 'Developer', 'manager' => 'Manager',
                                              'team-leader' => 'Team Leader', 'sales-manager' => 'Sales Manager',
                                              'sale-person' => 'Sale Person', 'event-manager' => 'Event Manager',
                                              'accountant' => 'Accountant'];
                                    foreach ($roles as $val => $label):
                                        $sel = (($_POST['role'] ?? '') === $val) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $val ?>" <?= $sel ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Authority Level <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="">Choose authority...</option>
                                    <?php
                                    $authorities = ['superadmin' => 'Super Admin', 'admin' => 'Admin',
                                                    'subadmin' => 'Sub Admin', 'sale-leader' => 'Sales Person'];
                                    foreach ($authorities as $val => $label):
                                        $sel = (($_POST['status'] ?? '') === $val) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $val ?>" <?= $sel ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Instagram Handle</label>
                                <input type="text" name="insta" class="form-control" placeholder="@handle"
                                       value="<?= htmlspecialchars($_POST['insta'] ?? '') ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Referral Code <span class="text-danger">*</span></label>
                                <input type="text" name="ref" class="form-control" placeholder="Enter ref code"
                                       value="<?= htmlspecialchars($_POST['ref'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="fb" class="form-control" placeholder="Enter address"
                                       value="<?= htmlspecialchars($_POST['fb'] ?? '') ?>">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Profile Image <span class="text-muted">(JPG/PNG/GIF/WEBP, max 2 MB)</span></label>
                                <input type="file" name="picture" class="form-control" id="pictureInput"
                                       accept="image/jpeg,image/png,image/gif,image/webp">
                                <div id="imagePreviewWrapper" class="mt-2 d-none">
                                    <img id="imagePreview" src="#" alt="Preview"
                                         style="max-height:120px;border-radius:8px;border:1px solid #ddd;">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" name="addaccount" class="btn btn-primary px-4">
                                        <i class="bx bx-user-plus me-1"></i> Create User
                                    </button>
                                    <button type="reset" class="btn btn-light px-4"
                                            onclick="document.getElementById('imagePreviewWrapper').classList.add('d-none')">
                                        Reset
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Live password match check
document.getElementById('confirm_password').addEventListener('input', function () {
    const pw  = document.getElementById('password').value;
    const err = document.getElementById('passwordError');
    err.textContent = (this.value && this.value !== pw) ? 'Passwords do not match.' : '';
});

// Image preview
document.getElementById('pictureInput').addEventListener('change', function () {
    const wrapper = document.getElementById('imagePreviewWrapper');
    const preview = document.getElementById('imagePreview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; wrapper.classList.remove('d-none'); };
        reader.readAsDataURL(this.files[0]);
    } else {
        wrapper.classList.add('d-none');
    }
});

// Client-side form validation before submit
document.getElementById('addUserForm').addEventListener('submit', function (e) {
    const pw  = document.getElementById('password').value;
    const cpw = document.getElementById('confirm_password').value;
    if (pw !== cpw) {
        e.preventDefault();
        document.getElementById('passwordError').textContent = 'Passwords do not match.';
        return;
    }
    if (document.getElementById('usernameError').textContent) {
        e.preventDefault();
        Swal.fire({ icon: 'warning', title: 'Fix errors', text: 'Username is already taken.' });
    }
});

// AJAX username uniqueness check
$('#username').on('blur', function () {
    const username = $(this).val().trim();
    if (!username) return;
    $.post('check_username.php', { username }, function (response) {
        document.getElementById('usernameError').textContent =
            (response.trim() === 'exists') ? 'Username already taken.' : '';
    });
});
</script>

<?php include 'foot.php'; ?>
