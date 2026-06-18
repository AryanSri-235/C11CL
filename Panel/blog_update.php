<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:login.php');
    exit();
}

include 'head.php';
include 'db.php'; // Database connection

// Fetch the blog ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch blog data with category name
    $sql = "SELECT b.id, b.blog_category, c.category AS category_name, b.title, b.image, b.blog_content, b.datetime 
            FROM blogs b 
            JOIN blog_category c ON b.blog_category = c.id 
            WHERE b.id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Blog not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Fetch all blog categories for dropdown
$category_sql = "SELECT id, category FROM blog_category ORDER BY category ASC";
$category_result = $con->query($category_sql);

// Handle form submission for updating blog
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated values from the form
    $blog_category = $_POST['blog_category'];
    $title = $_POST['title'];
    $blog_content = $_POST['blog_content'];

    // Handle image upload
    $image = $row['image']; // Keep existing image if no new upload

    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Update blog in the database
    $sql_update = "UPDATE blogs SET blog_category = ?, title = ?, image = ?, blog_content = ? WHERE id = ?";
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bind_param("isssi", $blog_category, $title, $image, $blog_content, $id);

    if ($stmt_update->execute()) {
        ?>
        <script>
            alert('Blog updated successfully');
            window.open('blog_list.php', '_self');
        </script>
        <?php
    } else {
        echo "Error updating blog: " . $stmt_update->error;
    }
}
?>

<!-- Start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">Update Blog</h6>
        <hr />
        <form method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <label for="blog_category" class="col-sm-2 col-form-label">Blog Category</label>
                <div class="col-sm-10">
                    <select name="blog_category" id="blog_category" class="form-control">
                        <?php while ($cat = $category_result->fetch_assoc()) { ?>
                            <option value="<?php echo $cat['id']; ?>" 
                                <?php echo ($cat['id'] == $row['blog_category']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['category']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" name="title" id="title" class="form-control" 
                           value="<?php echo htmlspecialchars($row['title']); ?>" required />
                </div>
            </div>

            <div class="row mb-3">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" name="image" id="image" class="form-control" />
                    <?php if ($row['image']) { echo "<img src='" . htmlspecialchars($row['image']) . "' width='100' height='100' />"; } ?>
                </div>
            </div>
            

            <div class="row mb-3">
                <label for="blog_content" class="col-sm-2 col-form-label">Content</label>
                <div class="col-sm-10">
           <textarea name="blog_content" id="blog_content" class="form-control" cols="30" rows="10">
    <?php echo html_entity_decode($row['blog_content'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>

</textarea>


                </div>
            </div>

            <div class="row mb-3">
                <label for="datetime" class="col-sm-2 col-form-label">Date & Time</label>
                <div class="col-sm-10">
                    <input type="text" name="datetime" id="datetime" class="form-control" 
                           value="<?php echo htmlspecialchars($row['datetime']); ?>" disabled />
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Blog</button>
            </div>
        </form>
    </div>
</div>

<script src="./tinymce/tinymce.min.js"></script>
<script src="script.js"></script>
<!-- End page wrapper -->

<?php include 'foot.php'; ?>
