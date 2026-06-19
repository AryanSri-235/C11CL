<?php
$page_title = "Important Update for T20 Participants";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Champions 11 Cricket League</title>
    <link rel="icon" href="../../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../../layout/policy-style.php"; ?>
    <style>
        .detail-media-frame {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            margin: 25px 0 35px 0;
            background: #0b0f19;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .detail-media-frame video {
            width: 100%;
            height: auto;
            max-height: 480px;
            display: block;
            object-fit: contain;
            z-index: 2;
        }
        .rich-html-render-pipeline {
            font-size: 1.05rem;
            line-height: 1.85;
            color: #334155;
            font-weight: 500;
        }
        .rich-html-render-pipeline p {
            margin-bottom: 22px;
        }
    </style>
</head>
<body>

<?php include "../../head.php"; ?>

<!-- Breadcrumb -->
<div class="c11p-breadcrumb">
    <div class="c11p-breadcrumb-inner">
        <a href="<?php echo BASE_URL; ?>">Home</a>
        <span class="sep">›</span>
        <a href="<?php echo BASE_URL; ?>announcements/">Announcements</a>
        <span class="sep">›</span>
        <span class="cur">Important Update</span>
    </div>
</div>

<!-- Content Wrapper -->
<div class="c11p-content" style="margin-top: 36px;">
    
    <!-- Premium Article Card -->
    <div class="c11p-section" style="border-left: 5px solid #dc2618; padding: 35px;">
        <div class="c11p-title-block" style="margin: 0 0 25px 0; padding: 0;">
            <span style="background: rgba(220, 38, 24, 0.08); color: #dc2618; font-size: 0.75rem; font-weight: 700; padding: 5px 12px; border-radius: 20px; text-transform: uppercase; display: inline-block; margin-bottom: 10px;">Official Notice</span>
            <h1 style="font-size: 2.2rem; font-weight: 800; line-height: 1.25; color: #0e1b30; text-transform: uppercase; margin: 0; font-family: 'Barlow Condensed', sans-serif;"><?php echo $page_title; ?></h1>
            <p style="color: #666; font-size: 0.9rem; margin-top: 8px;"><i class="bi bi-calendar-event"></i> Published on June 19, 2026</p>
        </div>

        <div class="detail-media-frame">
            <video src="<?php echo BASE_URL; ?>Panel/uploads/announcements/banner_1781267069.mp4" controls autoplay muted playsinline></video>
        </div>

        <div class="rich-html-render-pipeline">
            <div style="margin-bottom: 20px;">
                <span style="color: #0e1b30; font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 700; text-transform: uppercase; border-bottom: 3px solid #dc2618; padding-bottom: 4px; display: inline-block;">
                    📭 Message To All Participants
                </span>
            </div>
            
            <p>Thank you for participating in the Champions 11 Cricket League State-wise T20s. We truly appreciate the passion and effort shown by every player.</p>
            
            <p>As T20 leagues are still being conducted across multiple states of India, we request your patience while we complete the nationwide process.</p>
            
            <p>Our priority is to ensure a fair opportunity for every player. Once all state-wise T20 leagues are concluded, we will communicate the next steps through official Champions 11 Cricket League channels.</p>
        </div>

        <!-- Call to action or footer note within card -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <a href="<?php echo BASE_URL; ?>announcements/" style="text-decoration: none; color: #dc2618; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                <i class="bi bi-arrow-left"></i> Back to Notice Board
            </a>
            <span style="color: #6b7280; font-size: 0.85rem;">Champions 11 Cricket League Management</span>
        </div>
    </div>
</div>

<?php include "../../foot.php"; ?>

</body>
</html>
