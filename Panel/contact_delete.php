<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM blog_contactus WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    ?>
    <script>
        alert('Delete Successfully');
        window.open('blog_contactus.php', '_self');
    </script>
    <?php
    exit();
}
?>