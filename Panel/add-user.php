<?php

session_start();
if (!isset($_SESSION['password']) || !isset($_SESSION['uname'])) {
    header('location:../index.php');
    exit();
}
?>
<?php
// session_start();

include 'db.php';

if (isset($_POST['addaccount'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $fb = $_POST['fb'];
    $insta = $_POST['insta'];
    $ref = $_POST['ref'];

    // File Upload Logic
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $max_file_size = 1000000; // 1 MB

    // Check file size (max size allowed: 1 MB)
    if ($_FILES["picture"]["size"] > $max_file_size) {
        // echo "Sorry, your file is too large.";
        echo "<script>alert('Sorry, your file is too large.')</script>";
        $uploadOk = 0;
    }

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check === false) {
        //echo "File is not an image.";
        echo "<script>alert('File is not an image.')</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // echo "Sorry, your file was not uploaded.";
        echo "<script>alert('Sorry, your file was not uploaded.')</script>";
    } else {
        // Compress image
        $compressed_image = compressImage($_FILES["picture"]["tmp_name"], $target_file, 75); // Quality set to 75

        if ($compressed_image) {
            echo "The file " . htmlspecialchars(basename($target_file)) . " has been uploaded.";

            // Update image path in the user table
            $image = $target_file;
            $sql = "INSERT INTO user (name, username, password, number, email, role, status, fb, insta, ref, picture)
                    VALUES ('$name','$username','$password','$number', '$email','$role', '$status', '$fb','$insta','$ref','$image')";

            if ($con->query($sql) === TRUE) {
                $_SESSION['addaccount'] = "New user created successfully";
                // Redirect to profile.php
                // header('location:profile.php');
            } else {
                // echo "Error: " . $sql . "<br>" . $con->error;
                echo "<script>alert('Sql Error...')</script>";
            }
        } else {
            // echo "Sorry, there was an error uploading your file.";
            echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
        }
    }
    $con->close();
}

// Function to compress image
function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}
include 'head.php';
?>

<!-- Add JavaScript alert -->
<script>
    <?php if(isset($_SESSION['addaccount'])) : ?>
        alert("<?php echo $_SESSION['addaccount']; ?>");
        <?php unset($_SESSION['addaccount']); ?>
    <?php endif; ?>
</script>



<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <!-- ... -->
        </div>
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Enter User Details</h5>
                        <form id="myForm" method="POST" class="row g-3" enctype="multipart/form-data" onsubmit="return validateForm()">
						<div class="col-md-6">
										<label for="input1" class="form-label">Full Name</label>
										<input type="text" name="name" class="form-control" id="input1" placeholder="Enter your name"required>
									</div>

                                    <div class="col-md-6">
										<label for="input1" class="form-label">User Id</label>
										<input type="text" name="username" class="form-control" id="username" placeholder="enter user id"required>
										<div id="usernameError" class="text-danger"></div> <!-- Placeholder for error message -->
									</div>
                                    <div class="col-md-6">
        <label for="input5" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Enter password"required>
    </div>
    
    <div class="col-md-6">
        <label for="input6" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm password">
        <span id="password_error" style="color:red"></span>
    </div>
    <div class="col-md-6">
    <label for="input3" class="form-label">Phone Number</label>
    <input type="tel" name="number" class="form-control" id="input3" placeholder="Enter phone number" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" required>
</div>
									<div class="col-md-6">
										<label for="input4" class="form-label">Email</label>
										<input type="email" name="email" class="form-control" id="input4" placeholder="enter mail id"required>
									</div>

									<div class="col-md-6">
										<label for="input7" class="form-label">Select Role</label>
										<select id="input7" name="role" class="form-select"required>
											<option selected>Choose...</option>
											<option value="owner" >Owner</option>
											<option value="developer" >Developer</option>
											<option value="manager">Manager</option>
                                            <option value="team-leader">Team Leader</option>
                                            <option value="sales-manger">Sales Manger</option>
                                            <option value="sale-person">Sale Person</option>
                                            <option value="event-manger">Event Manager</option>
                                            <option value="accounted">Accountant</option>
                                            
										</select>
									</div>
                                    <div class="col-md-6">
										<label for="input7" class="form-label">Select Authority</label>
										<select id="input7" name="status" class="form-select"required>
											<option selected>Choose...</option>
											<option value="superadmin" >Super Admin</option>
											<option value="admin" >Admin</option>
											<option value="subadmin" >Sub Admin</option>
											<option value="sale-leader" >Sales Person</option>
                                            
										</select>
									</div>
                                    <div class="col-md-12">
										<label for="input3" class="form-label">Address</label>
										<input type="text" name="fb" class="form-control" id="input3" placeholder="enter facebook id">
									</div>

                                    <div class="col-md-6">
                                    <label for="basic-url" class="form-label">User Ref Code</label>
								<div class="input-group mb-3"> 
								<!--<span class="input-group-text" id="basic-addon3">YSCL</span>-->
									<input type="text" name="ref" class="form-control" id="basic-url" aria-describedby="basic-addon3"required>
								</div>
</div>
<div class="col-md-6">
        <label for="image-uploadify" class="form-label">Profile Image (Max Size - 1MB)</label>
        <input id="image-uploadify" name="picture" type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>
    </div>

    <div class="col-md-12">
        <div class="d-md-flex d-grid align-items-center gap-3">
            <button type="submit" name="addaccount" class="btn btn-primary px-4">Submit</button>
            <button type="button" class="btn btn-light px-4" onclick="resetForm()">Reset</button>
        </div>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#username').blur(function() { // Triggered when input field loses focus
        var username = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'check_username.php', // PHP script to check username
            data: { username: username },
            success: function(response) {
                if (response === 'exists') {
                    $('#usernameError').text('Username already exists.');
                    //$('#username').val(''); // Clear the input field
                } else {
                    $('#usernameError').text('');
                }
            }
        });
    });
});
</script>



<!--end page wrapper -->
<?php include 'foot.php'; ?>
   