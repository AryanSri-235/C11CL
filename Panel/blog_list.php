<?php
ini_set('display_errors', 0);
error_reporting(0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DELETE must run before head.php (which outputs HTML)
if (isset($_GET['delete_id'])) {
    include 'db.php';
    header('Content-Type: text/plain');
    $del_id = intval($_GET['delete_id']);

    $img_stmt = $con->prepare("SELECT featured_img FROM blog WHERE id = ?");
    if ($img_stmt) {
        $img_stmt->bind_param("s", $del_id);
        $img_stmt->execute();
        $img_res = $img_stmt->get_result();
        $img_data = $img_res ? $img_res->fetch_assoc() : null;
        $img_stmt->close();
        if ($img_data && !empty($img_data['featured_img']) && file_exists($img_data['featured_img'])) {
            unlink($img_data['featured_img']);
        }
    }

    $delete_stmt = $con->prepare("DELETE FROM blog WHERE id = ?");
    if ($delete_stmt) {
        $delete_stmt->bind_param("s", $del_id);
        echo $delete_stmt->execute() ? 'success' : 'error';
        $delete_stmt->close();
    } else {
        echo 'error';
    }
    exit();
}

include 'head.php';
include 'db.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="page-wrapper">
    <div class="page-content">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0 text-uppercase">Blog Management Portal</h5>
            <a href="add_blog.php" class="btn btn-primary px-4">+ Create New Blog</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="color:black;" class="table-light">
                            <tr>
                                <th>#ID</th>
                                <th>Banner Image</th>
                                <th>Blog Details</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // 🟢 2. SELECT LOGIC securely
                            $sql = "SELECT id, title, excerpt, featured_img, status, publish_date FROM blog ORDER BY id DESC";
                            $result = $con->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $status_badge = (strtolower($row['status']) == 'published') ? 'bg-success' : 'bg-warning';
                            ?>
                            <tr id="blog_row_<?php echo $row['id']; ?>">
                                <td><?php echo $row['id']; ?></td>
                                <td>
                                    <img src="/<?php echo ltrim(htmlspecialchars($row['featured_img'] ?? ''), '/'); ?>"
                                         class="rounded shadow-sm" width="100" height="60" 
                                         style="object-fit: cover;"
                                         onerror="this.src='https://via.placeholder.com/100x60?text=No+Img'">
                                </td>
                                <td>
                                    <div style="max-width: 400px;">
                                        <h6 class="mb-1 text-primary"><?php echo htmlspecialchars(substr($row['title'] ?? '', 0, 60)); ?>...</h6>
                                        <p class="mb-0 text-muted small"><?php echo htmlspecialchars(substr($row['excerpt'] ?? '', 0, 100)); ?>...</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?php echo $status_badge; ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo $row['publish_date'] ? date('d M Y', strtotime($row['publish_date'])) : 'N/A'; ?></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bx bxs-edit"></i> Edit
                                        </a>
                                        <button onclick="ajaxDelete(<?php echo $row['id']; ?>)" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bxs-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4'>No blogs found in database.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function ajaxDelete(id) {
    Swal.fire({
        title: 'Delete this blog?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('blog_list.php?delete_id=' + id)
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        Swal.fire('Deleted!', 'Blog has been removed.', 'success');
                        document.getElementById('blog_row_' + id).remove();
                    } else {
                        Swal.fire('Error!', 'Could not delete from database.', 'error');
                    }
                });
        }
    })
}
</script>

<?php
include 'foot.php'; 
?>