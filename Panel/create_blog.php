<?php
// Enable error reporting
error_reporting(E_ALL); // Report all PHP errors
ini_set('display_errors', 1); // Display errors on the screen
session_start();

// Check if the session exists
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}


/**
 * Compress the uploaded image to reduce file size
 * @param string $source Path to the source image
 * @param string $destination Path to save the compressed image
 * @param int $quality Compression quality (0-100)
 * @return bool True on success, False on failure
 */
function compressImage($source, $destination, $quality) {
    // Get image info
    $imageInfo = getimagesize($source);
    $mime = $imageInfo['mime'];

    // Create image resource based on MIME type
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }

    // Save the compressed image
    if ($image) {
        // Use imagejpeg for compression
        imagejpeg($image, $destination, $quality);

        // Free up memory
        imagedestroy($image);

        // Check the file size, recompress if > 1MB
        if (filesize($destination) > 1048576) { // 1 MB in bytes
            return compressImage($destination, $destination, $quality - 10);
        }

        return true;
    }

    return false;
} 
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addblog'])) {
    $cat_name = $_POST['cat_name'];
    $title = $_POST['title'];
    // $cat_name = $_POST['cat_name'];
    $blog_content = $_POST['blog_content'];
    
    date_default_timezone_set('Asia/Kolkata');
    $datetime = date("Y-m-d H:i:s");
    
    // Directory where the images will be stored
    $uploadDir = 'blogs_images/';
    // Check and create directory if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    // File details
    $file = $_FILES['blogimage'];
    $fileName = basename($file['name']);
    $targetFilePath = $uploadDir . uniqid() . '-' . $fileName;
    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }
    // Compress and save the image
    if (compressImage($file['tmp_name'], $targetFilePath, 90)) { // Compression quality: 90%
        //echo "Image uploaded and compressed successfully: " . $targetFilePath;
    } else {
        // echo "Image upload failed.";
    }


            include 'db.php';
     // Insert the new category
            $stmt = $con->prepare("INSERT INTO blogs (blog_category, title, image, blog_content, datetime) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $cat_name, $title, $targetFilePath,$blog_content, $datetime);

            if ($stmt->execute()) {
                echo "<script>alert('New record created successfully');</script>";
                // Redirect to avoid form resubmission
                header("Location:create_blog.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();


// Close the database connection
$con->close();
}
include 'head.php';
?>

<!--end header -->
<!--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">-->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<!--start page wrapper -->
<style>
    .ql-editor {
    /*line-height: 20; */
}
</style>
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
						<li class="breadcrumb-item active" aria-current="page">Blog</li>
					</ol>
				</nav>
			</div>
			
		</div>
		<!--end breadcrumb-->

		<!--end row-->
		<div class="row">
			<div class="col-lg-8 mx-auto">

				<div class="card">
					<form method="POST" id="myForm" enctype="multipart/form-data">
					<div class="card-body p-4">
						<h5 class="mb-4">Create New Blog </h5>
						
						<div class="row mb-3">
							<label for="input53" class="col-sm-3 col-form-label">Select Category</label>
							<div class="col-sm-9">
								<div class="input-group">
									<!--<span class="input-group-text"><i class='bx bx-badge-check'></i></span>-->
									<select name="cat_name" class="form-select" id="input53" required> 
									    <option value="">Select..</option>
										<?php
                                        include "db.php";
                                        
                                        // Fetch categories from the database
                                        $query = "SELECT id, category FROM blog_category";
                                        $result = $con->query($query);
                                        
                                        if ($result && $result->num_rows > 0) {
                                            // Loop through the results and create <option> elements
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['category']) . '</option>';
                                            }
                                        } else {
                                            // Handle cases where no data is found or query fails
                                            echo '<option value="">No Category Found</option>';
                                        }
                                        ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label for="input49" class="col-sm-3 col-form-label">Blog Title</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" name="title" class="form-control" id="input49"
										placeholder="Enter Blog Title" required>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label for="input49" class="col-sm-3 col-form-label">Blog Image</label>
							<div class="col-sm-9">
								<div class="input-group">
									<!--<input type="file" name="title" class="form-control" id="input49"-->
									<!--	placeholder="Enter Blog Title">-->
										<input class="form-control" id="blogimage" name="blogimage" type="file" accept="image/*" required>

								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label for="input49" class="col-sm-3 col-form-label">Blog Content</label>
							<div class="col-sm-9">
								<div class="margin-editor">
									<!--<textarea name="title" class="form-control" id="input49"-->
									<!--	placeholder="Enter Blog Content" required rows="5"></textarea>-->
										<div id="editor1" class="editor-container"></div>
                                    <input type="hidden" name="blog_content" id="blog_content">
								</div>
							</div>
						</div>
						<!--<div class=" row mb-3">-->
      <!--      <div class="col">-->
      <!--          <div class="form-row mb-3">-->
      <!--              <div class="col-md-12">-->
      <!--                  <div id="days-container">-->
      <!--                      <div class="form-row day-overview-template">-->
      <!--                          <div class="col-12 margin-editor">-->
      <!--                              <label for="blog_content" class="form-label">Blog Content</label>-->
      <!--                              <div id="editor1" class="editor-container"></div>-->
      <!--                              <input type="hidden" name="blog_content" id="blog_content">-->
      <!--                          </div>-->

      <!--                      </div>-->
      <!--                  </div>-->
      <!--              </div>-->
      <!--          </div>-->

      <!--      </div>-->
      <!--  </div>-->
						
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
									<button type="submit" name="addblog" class="btn btn-primary px-4">Create</button>
									<button type="button" class="btn btn-light px-4"onclick="resetForm()">Reset</button>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
				<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>

    const editors = [
      { selector: '#editor1', hiddenInput: '#blog_content' },
    ];

    editors.forEach(editor => {
      const quill = new Quill(editor.selector, {
        theme: 'snow'
      });
      quill.on('text-change', () => {
        document.querySelector(editor.hiddenInput).value = quill.root.innerHTML;
      });
    });
</script>

				<?php include 'foot.php'; ?>