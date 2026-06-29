<?php
include "../db.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog | C11CL — Champions 11 Cricket League</title>
    <meta name="description" content="Read the latest cricket blogs, match previews, player spotlights, and insights from Champions 11 Cricket League.">
    <link rel="canonical" href="https://c11cl.com/blog/">
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <style>
        /* ── Blog listing page ── */
        .blog-section {
            padding: 52px 0 72px;
        }

        /* Label above heading */
        .blog-label {
            display: block;
            text-align: center;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 14px;
            font-family: 'Barlow Condensed', sans-serif;
        }

        /* Breadcrumb */
        .blog-breadcrumb {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            text-align: center;
            margin-bottom: 32px;
        }
        .blog-breadcrumb a { color: #9ca3af; text-decoration: none; }
        .blog-breadcrumb a:hover { color: #dc2618; }
        .blog-breadcrumb .dot { margin: 0 8px; }
        .blog-breadcrumb .cur { color: #dc2618; }

        /* Main heading */
        .blog-heading {
            text-align: center;
            font-family: 'Barlow Condensed', 'Heebo', sans-serif;
            font-size: clamp(2.4rem, 6vw, 4rem);
            font-weight: 900;
            color: #0e1b30;
            text-transform: uppercase;
            line-height: 1.05;
            margin: 0 0 18px;
            letter-spacing: 1px;
        }
        .blog-heading .red { color: #dc2618; }

        /* Red underline bar */
        .blog-divider {
            width: 56px;
            height: 4px;
            background: #dc2618;
            border-radius: 3px;
            margin: 0 auto 24px;
        }

        /* Description */
        .blog-desc {
            text-align: center;
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.75;
            max-width: 680px;
            margin: 0 auto 48px;
        }

        /* 3-col grid */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        /* Card */
        .blog-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            overflow: hidden;
            border: 1.5px solid #f0f0f0;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }
        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 32px rgba(0,0,0,0.12);
            text-decoration: none;
            color: inherit;
        }
        .blog-card.featured {
            border: 2px solid #dc2618;
        }

        /* Card image */
        .blog-card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center;
            display: block;
        }
        .blog-card-img-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #0e1b30 0%, #1e3a5f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .blog-card-img-placeholder span {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
            color: rgba(255,255,255,0.3);
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        /* Card body */
        .blog-card-body {
            padding: 22px 22px 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Category tag */
        .blog-card-cat {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9ca3af;
            margin-bottom: 10px;
            font-family: 'Barlow Condensed', sans-serif;
        }

        /* Card title */
        .blog-card-title {
            font-family: 'Barlow Condensed', 'Heebo', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            color: #0e1b30;
            line-height: 1.3;
            margin: 0 0 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .blog-card.featured .blog-card-title {
            color: #dc2618;
        }

        /* Meta: author · date */
        .blog-card-meta {
            font-size: 0.78rem;
            color: #9ca3af;
            margin-bottom: 12px;
        }
        .blog-card-meta .sep { margin: 0 5px; }

        /* Excerpt */
        .blog-card-excerpt {
            font-size: 0.9rem;
            color: #6b7280;
            line-height: 1.7;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        /* Empty state */
        .blog-empty {
            text-align: center;
            padding: 72px 24px;
            color: #9ca3af;
        }
        .blog-empty h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #0e1b30;
            margin: 0 0 10px;
        }
        .blog-empty p { font-size: 0.95rem; }

        @media (max-width: 900px) {
            .blog-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 580px) {
            .blog-grid { grid-template-columns: 1fr; }
            .blog-section { padding: 36px 0 52px; }
        }
    </style>
</head>
<body>
<?php include "../head.php"; ?>

<div class="c11p-content blog-section">

    <!-- Label -->
    <span class="blog-label">Champions 11 Cricket League</span>

    <!-- Breadcrumb -->
    <div class="blog-breadcrumb">
        <a href="<?php echo BASE_URL; ?>">Home</a>
        <span class="dot">·</span>
        <span class="cur">Blog</span>
    </div>

    <!-- Heading -->
    <h1 class="blog-heading">Our Cricket <span class="red">Blogs</span></h1>
    <div class="blog-divider"></div>

    <!-- Description -->
    <p class="blog-desc">Stay updated with the latest articles, match previews, player spotlights, and insights from Champions 11 Cricket League.</p>

    <?php
    /* ── Fetch published posts ── */
    $posts = [];
    try {
        $stmt = $con->prepare(
            "SELECT id, title, slug, excerpt, featured_img, category, author, publish_date
             FROM blog
             WHERE status = 'published'
             ORDER BY id DESC"
        );
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        /* silently degrade — show empty state */
    }
    ?>

    <?php if (empty($posts)): ?>
        <div class="blog-empty">
            <h3>No Articles Yet</h3>
            <p>Check back soon for the latest cricket news and updates.</p>
        </div>
    <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($posts as $post):
                /* ── Image path ── */
                $imgRaw  = trim($post['featured_img'] ?? '');
                $imgExt  = strtolower(pathinfo($imgRaw, PATHINFO_EXTENSION));
                $validExts = ['jpg','jpeg','png','gif','webp','avif'];
                if ($imgRaw !== '' && in_array($imgExt, $validExts)) {
                    if (filter_var($imgRaw, FILTER_VALIDATE_URL)) {
                        // Full URL stored — use directly
                        $imgPath = htmlspecialchars($imgRaw);
                    } else {
                        // Relative path — serve from live site so images always load
                        $imgPath = 'https://c11cl.com/' . htmlspecialchars(ltrim($imgRaw, '/'));
                    }
                } else {
                    $imgPath = ''; // invalid or no image → show placeholder
                }

                /* ── Title cleanup ── */
                $rawTitle = $post['title'] ?? '';
                $rawTitle = preg_replace('/\s*[\|\-]\s*C11CL\s*$/i', '', $rawTitle);
                $title    = htmlspecialchars(trim($rawTitle));

                $slug     = htmlspecialchars($post['slug'] ?? '#');
                $excerpt  = htmlspecialchars($post['excerpt'] ?? '');
                $category = htmlspecialchars($post['category'] ?? 'Cricket News');
                $author   = htmlspecialchars($post['author'] ?? 'Admin');
                $date     = !empty($post['publish_date']) ? date('d M Y', strtotime($post['publish_date'])) : '';
                $postUrl  = BASE_URL . $slug . '/';
            ?>
            <a class="blog-card" href="<?php echo $postUrl; ?>">

                <?php if ($imgPath): ?>
                    <img class="blog-card-img" src="<?php echo $imgPath; ?>" alt="<?php echo $title; ?>" loading="lazy">
                <?php else: ?>
                    <div class="blog-card-img-placeholder"><span>C11CL</span></div>
                <?php endif; ?>

                <div class="blog-card-body">
                    <div class="blog-card-cat"><?php echo $category; ?></div>
                    <div class="blog-card-title"><?php echo $title; ?></div>
                    <div class="blog-card-meta">
                        <?php echo $author; ?>
                        <?php if ($date): ?>
                            <span class="sep">·</span><?php echo $date; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($excerpt): ?>
                        <p class="blog-card-excerpt"><?php echo $excerpt; ?></p>
                    <?php endif; ?>
                </div>

            </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include "../foot.php"; ?>
</body>
</html>
