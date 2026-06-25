<?php
$is_backend_script = true;
include 'head.php'; // Enforce authentication/RBAC check

include 'db.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM blog_contactus WHERE id = ?";
    $stmt = $con->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    ?>
    <script>
        alert('Delete Successfully');
        window.open('blog_contactus.php', '_self');
    </script>
    <?php
    exit();
}
?>