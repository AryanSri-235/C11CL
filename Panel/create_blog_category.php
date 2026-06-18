<?php
session_start();

// Check if the session exists
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

include 'head.php';
include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addcategory'])) {
    $cat_name = $_POST['cat_name']; // Trim to avoid extra spaces
    
    // Ensure the category name is not empty
    if (empty($cat_name)) {
        echo "<script>alert('Category name cannot be empty');</script>";
    } else {
        date_default_timezone_set('Asia/Kolkata');
        $datetime = date("Y-m-d H:i:s");

        // Check if the category already exists
        $stmt = $con->prepare("SELECT COUNT(*) FROM blog_category WHERE category = ?");
        $stmt->bind_param("s", $cat_name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo "<script>alert('Category already exists!');</script>";
        } else {
            // Insert the new category
            $stmt = $con->prepare("INSERT INTO blog_category (category, datetime) VALUES (?, ?)");
            $stmt->bind_param("ss", $cat_name, $datetime);

            if ($stmt->execute()) {
                echo "<script>alert('New record created successfully');</script>";
                // Redirect to avoid form resubmission
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

// Close the database connection
$con->close();
?>

<!--end header -->

<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Create</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Blogs Category</li>
					</ol>
				</nav>
			</div>
			
		</div>
		<!--end breadcrumb-->

		<!--end row-->
		<div class="row">
			<div class="col-lg-8 mx-auto">

				<div class="card">
					<form method="POST" id="myForm">
					<div class="card-body p-4">
						<h5 class="mb-4">Create Category </h5>
						<div class="row mb-3">
							<label for="input49" class="col-sm-3 col-form-label">Category Name</label>
							<div class="col-sm-9">
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-user'></i></span>
									<input type="text" name="cat_name" class="form-control" id="input49"
										placeholder="Enter Category Name">
								</div>
							</div>
						</div>
						<!-- <div class="row mb-3">
											<label for="input49" class="col-sm-3 col-form-label">ID</label>
											<div class="col-sm-9">
												<div class="input-group">
													<span class="input-group-text"><i class='bx bx-shield'></i></span>
													<input type="text" class="form-control" id="input49" placeholder="">
												  </div>
											</div>
										</div> -->
						<!--<div class="row mb-3">-->
						<!--	<label for="input50" class="col-sm-3 col-form-label">Phone No</label>-->
						<!--	<div class="col-sm-9">-->
						<!--		<div class="input-group">-->
						<!--			<span class="input-group-text"><i class='bx bx-phone-call'></i></span>-->
						<!--			<input type="text" name="mobile" class="form-control" id="input50"-->
						<!--				placeholder="enter player mobile number">-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->
						<!--<div class="row mb-3">-->
						<!--	<label for="input51" class="col-sm-3 col-form-label">Email Address</label>-->
						<!--	<div class="col-sm-9">-->
						<!--		<div class="input-group">-->
						<!--			<span class="input-group-text"><i class='bx bx-envelope'></i></span>-->
						<!--			<input type="text" name="email" class="form-control" id="input51"-->
						<!--				placeholder="enter player email id">-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->

						<!--<div class="row mb-3">-->
						<!--	<label for="input51" class="col-sm-3 col-form-label">Age</label>-->
						<!--	<div class="col-sm-9">-->
						<!--		<div class="input-group">-->
						<!--			<span class="input-group-text"><i class='bx bx-face'></i></span>-->
						<!--			<input type="text" name="age" class="form-control" id="input51"-->
						<!--				placeholder="enter player age">-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->

						<!--<div class="row mb-3">-->
						<!--	<label for="input53" class="col-sm-3 col-form-label">Speciality</label>-->
						<!--	<div class="col-sm-9">-->
						<!--		<div class="input-group">-->
						<!--			<span class="input-group-text"><i class='bx bx-badge-check'></i></span>-->
						<!--			<select name="player" class="form-select" id="input53">-->
						<!--				<option value="batsman">Batsman</option>-->
						<!--				<option value="bowler">Bowler</option>-->
						<!--				<option value="all rounder">All Rounder</option>-->
						<!--				<option value="wicketkepper">Wicketkepper</option>-->
						<!--			</select>-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->
						<!--<div class="row mb-3">-->
						<!--	<label for="input53" class="col-sm-3 col-form-label">Address</label>-->
						<!--	<div class="col-sm-5">-->
						<!--		<div class="input-group">-->
						<!--			<span class="input-group-text"><i class='bx bx-map'></i></span>-->
						<!--			<select name="state" class="form-select" id="state" onchange="selectcity(this.value)">-->
						<!--				<option value="Andaman and Nicobar Islands">Andaman Nicobar Islands</option>-->
						<!--				<option value="Andhra Pradesh">Andhra Pradesh</option>-->
						<!--				<option value="Arunachal Pradesh">Arunachal Pradesh</option>-->
						<!--				<option value="Assam">Assam</option>-->
						<!--				<option value="Bihar">Bihar</option>-->
						<!--				<option value="Chandigarh">Chandigarh</option>-->
						<!--				<option value="Chhattisgarh">Chhattisgarh</option>-->
						<!--				<option value="Dadra and Nagar Haveli">Dadra Nagar Haveli</option>-->
						<!--				<option value="Delhi">Delhi</option>-->
						<!--				<option value="Goa">Goa</option>-->
						<!--				<option value="Gujarat">Gujarat</option>-->
						<!--				<option value="Haryana">Haryana</option>-->
						<!--				<option value="Himachal Pradesh">Himachal Pradesh</option>-->
						<!--				<option value="Jammu and Kashmir">Jammu Kashmir</option>-->
						<!--				<option value="Jharkhand">Jharkhand</option>-->
						<!--				<option value="Karnataka">Karnataka</option>-->
						<!--				<option value="Kerala">Kerala</option>-->
						<!--				<option value="Madhya Pradesh">Madhya Pradesh</option>-->
						<!--				<option value="Maharashtra">Maharashtra</option>-->
						<!--				<option value="Manipur">Manipur</option>-->
						<!--				<option value="Meghalaya">Meghalaya</option>-->
						<!--				<option value="Mizoram">Mizoram</option>-->
						<!--				<option value="Nagaland">Nagaland</option>-->
						<!--				<option value="Odisha">Odisha</option>-->
						<!--				<option value="Puducherry">Puducherry</option>-->
						<!--				<option value="Punjab">Punjab</option>-->
						<!--				<option value="Rajasthan">Rajasthan</option>-->
						<!--				<option value="Tamil Nadu">Tamil Nadu</option>-->
						<!--				<option value="Telangana">Telangana</option>-->
						<!--				<option value="Tripura">Tripura</option>-->
						<!--				<option value="Uttar Pradesh">Uttar Pradesh</option>-->
						<!--				<option value="Uttarakhand">Uttarakhand</option>-->
						<!--				<option value="West Bengal">West Bengal</option>-->
						<!--			</select>-->
						<!--		</div>-->
						<!--	</div>-->
						<!--	<div class="col-sm-4">-->
						<!--		<div class="input-group">-->
						<!--			<span class="input-group-text"><i class='bx bx-target-lock'></i></span>-->
						<!--			<select name="city" class="form-select" id="city">-->

						<!--			</select>-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->
						<!-- <div class="row mb-3">
							<label for="input51" class="col-sm-3 col-form-label">Refferal Code</label>
							<div class="col-sm-9">
								<div class="input-group">
									<span class="input-group-text"><i class='bx bx-shape-circle'></i></span>
									<input type="text" class="form-control" id="input51" placeholder="">
								</div>
							</div>
						</div> -->
						<!--<div class="row mb-3">-->
						<!--	<label for="input51" class="col-sm-3 col-form-label">Date</label>-->
						<!--	<div class="col-sm-9">-->
						<!--		<div class="input-group">-->
						<!--			<span class="input-group-text"><i class='bx bx-time'></i></span>-->
						<!--			<input name="date" type="date" class="form-control">-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->

						<!--<div class="row mb-3">-->
						<!--	<label for="input53" class="col-sm-3 col-form-label">Status</label>-->
						<!--	<div class="col-sm-9">-->
						<!--		<div class="input-group">-->
						<!--			<span class="input-group-text"><i class='bx bx-select-multiple'></i></span>-->
						<!--			<select name="status" class="form-select" id="input53">-->

						<!--				<option value="success">Success</option>-->
						<!--				<option value="pending">Pending</option>-->
						<!--				<option value="cancel">Cancel</option>-->
						<!--			</select>-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->
						<div class="row">
							<label class="col-sm-3 col-form-label"></label>
							<div class="col-sm-9">
								<div class="d-md-flex d-grid align-items-center gap-3">
									<button type="submit" name="addcategory" class="btn btn-primary px-4">Create</button>
									<button type="button" class="btn btn-light px-4"onclick="resetForm()">Reset</button>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
				<?php include 'foot.php'; ?>