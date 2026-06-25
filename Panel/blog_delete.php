<?php
$is_backend_script = true;
include 'head.php'; // Performs authentication/RBAC check

include 'db.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM blog WHERE id = ?";
    $stmt = $con->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    ?>
    <script>
        alert('Delete Successfully');
        window.open('blog_list.php', '_self');
    </script>
    <?php
    exit();
}
?>