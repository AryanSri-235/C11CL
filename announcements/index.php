<?php
$page_title = "Announcements";
include '../db.php';

$announcements = [];
if ($con) {
    $res = $con->query("SELECT * FROM announcements ORDER BY sort_order ASC, id DESC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $row['publish_date'] = date('F j, Y', strtotime($row['publish_date']));
            $announcements[] = $row;
        }
    }
}
// Fallback if table doesn't exist yet
if (empty($announcements)) {
    $announcements = [
        [
            'publish_date' => 'June 19, 2026',
            'title'        => 'Important Update for T20 Participants',
            'description'  => 'Crucial guidelines, schedule timeline shifts, mandatory document checklists, and registration verification updates for all players participating in the upcoming T20 tournament.',
            'link'         => 'important-update-for-t20-participants/',
            'is_new'       => 1,
        ],
    ];
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Important Announcements | C11CL – Champions 11 Cricket League</title>
    <meta name="description" content="Stay informed with official updates, important announcements, and essential participant guidance from the C11CL management.">
    <link rel="canonical" href="https://c11clchampionscricketleague.infinityfree.net/announcements/">
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ── Diamond / Argyle background ─────────────────────────────── */
        .anc-page {
            background-color: #e9e9e9;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Crect width='100' height='100' fill='%23eeeeee'/%3E%3Cpath d='M50 2 L98 50 L50 98 L2 50 Z' fill='%23e4e4e4' stroke='%23d8d8d8' stroke-width='1'/%3E%3C/svg%3E");
            background-size: 100px 100px;
            min-height: 100vh;
            padding-bottom: 80px;
        }

        /* ── Hero header ─────────────────────────────────────────────── */
        .anc-hero {
            text-align: center;
            padding: 60px 20px 50px;
        }
        .anc-league-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #6b7280;
            margin: 0 0 12px;
        }
        .anc-breadcrumb {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 28px;
        }
        .anc-breadcrumb a { color: #9ca3af; text-decoration: none; }
        .anc-breadcrumb a:hover { color: #dc2618; }
        .anc-main-title {
            font-size: clamp(2.4rem, 6vw, 4rem);
            font-weight: 900;
            text-transform: uppercase;
            color: #0e1b30;
            letter-spacing: 1px;
            line-height: 1.1;
            margin: 0 0 14px;
        }
        .anc-main-title span { color: #dc2618; }
        .anc-red-sub {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #dc2618;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 0 0 14px;
        }

        .anc-red-divider {
            width: 60px;
            height: 4px;
            background: #dc2618;
            margin: 0 auto 22px;
            border-radius: 2px;
        }
        .anc-subtitle {
            font-size: 1.05rem;
            color: #4b5563;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.65;
        }

        /* ── Timeline wrapper ────────────────────────────────────────── */
        .anc-timeline-wrap {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ── Single timeline item ────────────────────────────────────── */
        .anc-item {
            display: grid;
            grid-template-columns: 120px 60px 1fr;
            align-items: flex-start;
            gap: 0;
            margin-bottom: 60px;
            position: relative;
        }

        /* Date box */
        .anc-date-box {
            text-align: center;
            background: #fff;
            border-radius: 10px;
            padding: 14px 10px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            align-self: flex-start;
            margin-top: 10px;
        }
        .anc-day {
            display: block;
            font-size: 2.4rem;
            font-weight: 900;
            color: #0e1b30;
            line-height: 1;
        }
        .anc-mon-year {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #6b7280;
            margin-top: 4px;
            text-transform: uppercase;
        }

        /* Vertical line + icon */
        .anc-connector {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .anc-v-line {
            width: 2px;
            flex: 1;
            background: #d1d5db;
            min-height: 100%;
            position: absolute;
            top: 0;
            bottom: -60px;
            left: 50%;
            transform: translateX(-50%);
        }
        .anc-icon-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #dc2618;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            position: relative;
            z-index: 1;
            margin-top: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(220,38,24,0.35);
        }

        /* Content card */
        .anc-card {
            background: #fff;
            border-radius: 12px;
            padding: 28px 32px;
            box-shadow: 0 4px 20px rgba(14,27,48,0.07);
            position: relative;
            margin-left: 10px;
        }
        .anc-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .anc-card-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0e1b30;
            margin: 0;
            line-height: 1.3;
        }
        .anc-badge-new {
            background: #dc2618;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .anc-card-desc {
            font-size: 0.97rem;
            color: #4b5563;
            line-height: 1.7;
            margin: 0 0 22px;
        }
        .anc-read-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #0e1b30;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            border: 2px solid #0e1b30;
            padding: 10px 22px;
            border-radius: 6px;
            transition: all 0.25s;
        }
        .anc-read-link:hover {
            background: #0e1b30;
            color: #fff;
        }

        /* Last item — hide the bottom connector line */
        .anc-item:last-child .anc-v-line { display: none; }

        /* ── Responsive ──────────────────────────────────────────────── */
        @media (max-width: 700px) {
            .anc-item {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .anc-date-box { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
            .anc-day { font-size: 1.8rem; }
            .anc-connector { display: none; }
            .anc-card { margin-left: 0; }
        }
    </style>
</head>
<body>
<?php include "../head.php"; ?>

<div class="anc-page">

    <!-- Hero -->
    <div class="anc-hero">
        <p class="anc-league-label">Champions 11 Cricket League</p>
        <div class="anc-breadcrumb">
            <a href="<?php echo BASE_URL; ?>">Home</a> &nbsp;•&nbsp; Important Announcements
        </div>
        <h1 class="anc-main-title">Important <span>Announcements</span></h1>
        <p class="anc-red-sub">Stay Updated With C11CL</p>
        <div class="anc-red-divider"></div>
        <p class="anc-subtitle">Stay informed with official updates, important announcements, and essential participant guidance.</p>
    </div>

    <!-- Timeline -->
    <div class="anc-timeline-wrap">
        <?php foreach ($announcements as $anc):
            $ts       = strtotime($anc['publish_date']);
            $day      = date('j', $ts);
            $mon_year = strtoupper(date('M Y', $ts));
        ?>
        <div class="anc-item">

            <!-- Date box -->
            <div class="anc-date-box">
                <span class="anc-day"><?php echo $day; ?></span>
                <span class="anc-mon-year"><?php echo $mon_year; ?></span>
            </div>

            <!-- Vertical line + icon -->
            <div class="anc-connector">
                <div class="anc-v-line"></div>
                <div class="anc-icon-circle">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
            </div>

            <!-- Content card -->
            <div class="anc-card">
                <div class="anc-card-header">
                    <h2 class="anc-card-title"><?php echo htmlspecialchars($anc['title']); ?></h2>
                    <?php if (!empty($anc['is_new'])): ?>
                    <span class="anc-badge-new">New</span>
                    <?php endif; ?>
                </div>
                <p class="anc-card-desc"><?php echo htmlspecialchars($anc['description']); ?></p>
                <a href="<?php echo htmlspecialchars($anc['link']); ?>" class="anc-read-link">
                    Read Full Details &nbsp;→
                </a>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

</div>

<?php include "../foot.php"; ?>
</body>
</html>
