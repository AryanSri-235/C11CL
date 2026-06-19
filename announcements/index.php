<?php
$page_title = "Announcements";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Champions 11 Cricket League</title>
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
</head>
<body>

<?php include "../head.php"; ?>

<!-- Breadcrumb -->
<div class="c11p-breadcrumb">
    <div class="c11p-breadcrumb-inner">
        <a href="<?php echo BASE_URL; ?>">Home</a>
        <span class="sep">›</span>
        <span class="cur"><?php echo $page_title; ?></span>
    </div>
</div>

<!-- Page Title -->
<div class="c11p-title-block">
    <h1>Notice Board</h1>
    <p style="color: #666; font-size: 1rem; margin-top: 5px;">Stay updated with official notices, guidelines, and timelines from the C11CL management.</p>
</div>

<!-- Content -->
<div class="c11p-content">

    <!-- Active Notice 1 -->
    <div class="c11p-section" style="cursor: pointer;" onclick="location.href='important-update-for-t20-participants/';">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px;">
            <div class="c11p-section-heading">
                <span class="c11p-icon"><i class="bi bi-megaphone-fill"></i></span>
                <h3 style="font-size: 1.25rem !important;">Important Update for T20 Participants</h3>
            </div>
            <span style="background: #dc2618; color: #fff; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">New</span>
        </div>
        <p style="margin-top: 10px; font-weight: 500; color: #0e1b30;">Publish Date: June 19, 2026</p>
        <p>Crucial guidelines, schedule timeline shifts, mandatory document checklists, and registration verification updates for all players participating in the upcoming T20 tournament.</p>
        <div style="margin-top: 15px; display: inline-flex; align-items: center; gap: 5px; color: #dc2618; font-weight: 600; text-transform: uppercase; font-size: 0.85rem;">
            Read Full Announcement <i class="bi bi-arrow-right"></i>
        </div>
    </div>

</div>

<?php include "../foot.php"; ?>

</body>
</html>
