<?php 
$page_title = "News & Updates"; 
if (!isset($con)) {
    include "../db.php";
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO Meta Tags -->
    <title>Latest News & Updates | Cricket Talent Hunt Announcements | C11CL</title>
    <meta name="description" content="Stay updated with all the important announcements, match updates, and behind-the-scenes highlights from Champions 11 Cricket League (C11CL)." />
    <link rel="canonical" href="https://c11cl.com/news-updates/" />
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Blog Grid System */
        .blog-grid-premium {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .blog-card-modern {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #edf2f7;
            box-shadow: 0 4px 15px rgba(0,0,0,0.01);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex;
            flex-direction: column;
        }
        .blog-card-modern:hover {
            transform: translateY(-5px);
            border-color: #dc2618;
            box-shadow: 0 15px 35px rgba(14, 27, 48, 0.08);
        }

        .blog-img-wrap {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: #f1f5f9;
        }
        .blog-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .blog-card-modern:hover .blog-img-wrap img {
            transform: scale(1.05);
        }

        /* Calendar Date Badge */
        .blog-date-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: #dc2618;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 8px;
            text-align: center;
            font-family: 'Barlow Condensed', sans-serif;
            line-height: 1;
            box-shadow: 0 4px 10px rgba(220, 38, 24, 0.3);
        }
        .blog-date-badge .day {
            display: block;
            font-size: 1.4rem;
            font-weight: 800;
        }
        .blog-date-badge .month {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        .blog-meta-category {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(14, 27, 48, 0.85);
            backdrop-filter: blur(4px);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .blog-info-content {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .blog-meta-author {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }
        .blog-meta-author i {
            color: #dc2618;
        }
        .blog-title-link {
            text-decoration: none;
            color: #0e1b30;
            margin-bottom: 12px;
        }
        .blog-title-link h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.45rem;
            font-weight: 800;
            line-height: 1.2;
            margin: 0;
            transition: color 0.2s ease;
            text-transform: uppercase;
        }
        .blog-card-modern:hover .blog-title-link h3 {
            color: #dc2618;
        }
        .blog-excerpt {
            color: #4b5563;
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0 0 20px 0;
        }

        .blog-card-footer {
            margin-top: auto;
            border-top: 1px solid #edf2f7;
            padding: 15px 0 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .read-more-btn {
            color: #dc2618;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: gap 0.2s ease;
        }
        .blog-card-modern:hover .read-more-btn {
            gap: 10px;
        }

        /* Modal styling standard */
        .custom-news-modal {
            display: none;
            position: fixed;
            z-index: 99999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(14, 27, 48, 0.8);
            backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
        }
        .modal-content-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            width: 90%;
            max-width: 460px;
            text-align: center;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            border-top: 5px solid #dc2618;
            margin: 10% auto;
        }
        .icon-header {
            font-size: 50px;
            margin-bottom: 20px;
        }
        .modal-body h2 {
            font-family: 'Barlow Condensed', sans-serif;
            color: #0e1b30;
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        .modal-body p {
            font-size: 0.95rem;
            color: #4b5563;
            line-height: 1.6;
            margin: 0 0 15px 0;
        }
        .modal-body .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 20px 0;
        }
        .modal-body .sub-text {
            font-size: 0.85rem;
            color: #64748b;
            font-style: italic;
            margin-bottom: 25px;
        }
        .explore-btn {
            background: #dc2618;
            color: #ffffff;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(220, 38, 24, 0.3);
        }
        .explore-btn:hover {
            background: #0e1b30;
            box-shadow: 0 4px 15px rgba(14, 27, 48, 0.3);
        }
        .close-btn {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 30px;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .close-btn:hover {
            color: #dc2618;
        }

        @media (max-width: 990px) {
            .blog-grid-premium {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }
        @media (max-width: 650px) {
            .blog-grid-premium {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<?php include "../head.php"; ?>

<div class="c11p-breadcrumb">
    <div class="c11p-breadcrumb-inner">
        <a href="<?php echo BASE_URL; ?>">Home</a>
        <span class="sep">›</span>
        <span class="cur"><?php echo $page_title; ?></span>
    </div>
</div>

<div class="c11p-title-block">
    <h1>Latest News & <span style="color: #dc2618;">Announcements</span></h1>
    <p class="c11p-intro" style="margin-top: 10px; color: #dc2618; font-weight: 600;">Stay Updated With C11CL</p>
    <p style="color: #4b5563; max-width: 750px; margin: 15px auto 0 auto; line-height: 1.6;">
        Stay updated with all the important announcements, match updates, and behind-the-scenes highlights from Champions 11 Cricket League.
    </p>
</div>

<div class="c11p-content">
    
    <div class="blog-grid-premium">
        <?php
        $result = c11cl_blog_query();
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $date_parts = date_create($row['publish_date']);
                $post_url = BASE_URL . $row['slug'] . '/';
                $img_src = $row['featured_img'];
                if (!empty($img_src) && strpos($img_src, 'http') !== 0) {
                    $img_src = BASE_URL . $img_src;
                }
        ?>
        <div class="blog-card-modern">
            <div class="blog-img-wrap">
                <a href="<?php echo $post_url; ?>">
                    <img src="<?php echo $img_src; ?>" onerror="this.src='../wp-content/uploads/2026/02/Leagues-are-changing-Indian-Cricket.jpg';">
                </a>
                <div class="blog-date-badge">
                    <span class="day"><?php echo date_format($date_parts, "d"); ?></span>
                    <span class="month"><?php echo date_format($date_parts, "M"); ?></span>
                </div>
                <div class="blog-meta-category"><?php echo htmlspecialchars($row['category']); ?></div>
            </div>

            <div class="blog-info-content">
                <div class="blog-meta-author">
                    <i class="fa-solid fa-user"></i> By <?php echo htmlspecialchars($row['author']); ?>
                </div>
                <a href="<?php echo $post_url; ?>" class="blog-title-link">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                </a>
                <p class="blog-excerpt">
                    <?php echo htmlspecialchars($row['excerpt']); ?>
                </p>
                <div class="blog-card-footer">
                    <a href="<?php echo $post_url; ?>" class="read-more-btn">
                        Read More <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
            echo "<div style='grid-column: 1/-1; text-align: center; padding: 40px; color: #64748b;'>No blog posts found.</div>";
        }
        ?>
    </div>

</div>

<!-- Redirect Modal -->
<div id="blogRedirectModal" class="custom-news-modal">
    <div class="modal-content-box">
        <span class="close-btn" onclick="closeNewsModal()">&times;</span>
        <div class="modal-body">
            <div class="icon-header">🏏</div>
            <h2>Looking for that Story?</h2>
            <p>The specific blog post you're trying to reach is currently <strong>unavailable</strong> or has been moved.</p>
            <div class="divider"></div>
            <p class="sub-text">But don't worry! You can stay ahead of the game with our <strong>Latest Cricket Updates</strong> right here!</p>
            <button class="explore-btn" onclick="closeNewsModal()">Catch Latest News</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'not-found') {
            document.getElementById('blogRedirectModal').style.display = 'flex';
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        }
    });

    function closeNewsModal() {
        document.getElementById('blogRedirectModal').style.display = 'none';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") closeNewsModal();
    });
</script>

<?php include "../foot.php"; ?>
</body>
</html>