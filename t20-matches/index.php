<?php
$page_title = "T20 Matches";
include '../db.php';
$matches = [];
if ($con) {
    $res = $con->query("SELECT * FROM matches ORDER BY sort_order ASC, id ASC");
    if ($res) { while ($row = $res->fetch_assoc()) { $matches[] = $row; } }
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO Meta Tags -->
    <title>T20 Matches | Professional Cricket League Experience | C11CL</title>
    <meta name="description" content="Experience the thrill of C11CL T20 Matches. From professional kits to stadium lights, play cricket at the highest level. Showcase your skills on a national professional stage." />
    <link rel="canonical" href="https://c11cl.com/t20-matches/" />
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* T20 Custom Layout Styles */
        .t20-alert-panel {
            background: #fff5f5;
            border: 1px dashed rgba(220, 38, 24, 0.4);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .t20-alert-icon {
            font-size: 24px;
            color: #dc2618;
            background: rgba(220, 38, 24, 0.1);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .t20-alert-text h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            color: #0e1b30;
            font-weight: 800;
        }
        .t20-alert-text p {
            margin: 0;
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Matches List */
        .t20-schedule-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 40px;
        }
        .t20-match-row {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px 30px;
            display: grid;
            grid-template-columns: 1.2fr 2fr 1.5fr;
            align-items: center;
            gap: 20px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 4px 10px rgba(0,0,0,0.01);
        }
        .t20-match-row:hover {
            border-color: #dc2618;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(14, 27, 48, 0.06);
        }

        .t20-row-venue {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .t20-venue-icon {
            background: rgba(14, 27, 48, 0.05);
            color: #dc2618;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .t20-row-venue h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            margin: 0;
            text-transform: uppercase;
            color: #0e1b30;
            font-weight: 800;
        }

        .t20-row-ground {
            font-size: 1rem;
            color: #0e1b30;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .t20-row-ground i {
            color: #64748b;
        }
        .t20-row-ground span {
            color: #64748b;
            font-weight: 500;
            font-size: 0.85rem;
            display: block;
            margin-top: 2px;
        }

        .t20-row-date-zone {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }
        .t20-live-tag {
            font-size: 11px;
            font-weight: 700;
            color: #16a34a;
            background: #e8f5e9;
            padding: 4px 12px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .t20-live-tag::before {
            content: "";
            width: 6px;
            height: 6px;
            background: #16a34a;
            border-radius: 50%;
        }
        .t20-date-display {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            color: #dc2618;
            margin: 0;
            font-weight: 800;
            text-transform: uppercase;
        }

        /* Highlight box footer */
        .t20-clean-footer {
            background: #0e1b30;
            padding: 35px;
            border-radius: 12px;
            text-align: center;
            border-left: 5px solid #dc2618;
            box-shadow: 0 10px 25px rgba(14,27,48,0.1);
        }
        .t20-clean-footer p {
            font-size: 1.05rem;
            color: #ffffff;
            max-width: 750px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .t20-clean-footer span {
            display: block;
            margin-top: 15px;
            color: #dc2618;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
        }

        @media (max-width: 900px) {
            .t20-match-row {
                grid-template-columns: 1fr;
                padding: 25px;
                text-align: center;
                justify-items: center;
                gap: 15px;
            }
            .t20-row-venue {
                flex-direction: column;
                gap: 8px;
            }
            .t20-row-ground {
                flex-direction: column;
                gap: 4px;
            }
            .t20-row-date-zone {
                align-items: center;
            }
            .t20-alert-panel {
                flex-direction: column;
                text-align: center;
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
    <h1>T20 <span style="color: #dc2618;">Matches</span></h1>
    <p class="c11p-intro" style="margin-top: 10px; color: #dc2618; font-weight: 600;">Professional Cricket Experience</p>
    <p style="color: #4b5563; max-width: 750px; margin: 15px auto 0 auto; line-height: 1.6;">
        The official State League stage. Raw talent selected from across the nation transition onto a professional stadium ecosystem to lock their valuation parameters.
    </p>
</div>

<div class="c11p-content">
    
    <div class="t20-alert-panel">
        <div class="t20-alert-icon"><i class="fa-solid fa-gavel"></i></div>
        <div class="t20-alert-text">
            <h3>Road to the National Auction</h3>
            <p>Every qualified squad gets exactly <strong>3 high-intensity matches</strong>. Live analytical tracking systems record every performance metric on the pitch. Your scores here directly dictate your pool placement and core valuation inside the upcoming <strong>C11CL National Auction</strong>.</p>
        </div>
    </div>

    <div class="t20-schedule-list">

        <?php foreach ($matches as $m): ?>
        <div class="t20-match-row">
            <div class="t20-row-venue">
                <div class="t20-venue-icon"><i class="fa-solid fa-location-dot"></i></div>
                <h3><?php echo htmlspecialchars($m['city']); ?></h3>
            </div>
            <div class="t20-row-ground">
                <i class="fa-solid fa-hotel" style="margin-top: 4px;"></i>
                <div>
                    <?php echo htmlspecialchars($m['ground_name']); ?>
                    <span><?php echo htmlspecialchars($m['subtitle']); ?></span>
                </div>
            </div>
            <div class="t20-row-date-zone">
                <span class="t20-live-tag"><?php echo htmlspecialchars($m['status_label']); ?></span>
                <h4 class="t20-date-display"><?php echo htmlspecialchars($m['date_display']); ?></h4>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

    <div class="t20-clean-footer">
        <p>No shortcuts. No background recommendations. Only performance metrics matter under the stadium floodlights.</p>
        <span>Your performance will decide your auction nomination.</span>
    </div>

</div>

<?php include "../foot.php"; ?>
</body>
</html>