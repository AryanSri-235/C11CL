<?php 
$page_title = "Selection Process"; 
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO Meta Tags -->
    <title>C11CL Selection Process: Trials to National Stage</title>
    <meta name="description" content="From first trial to national level, C11CL offers equal opportunity and structured growth, ensuring every cricketer's talent is fairly assessed and elevated." />
    <link rel="canonical" href="https://c11cl.com/selection-process/" />
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Selection Process Custom styles */
        .sel-grid {
            display: flex;
            flex-direction: column;
            gap: 40px;
            margin-bottom: 50px;
        }
        .sel-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }
        .sel-card:hover {
            border-color: #dc2618;
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(14,27,48,0.08);
        }
        .sel-card:nth-child(even) {
            flex-direction: row-reverse;
        }

        .sel-image-wrap {
            flex: 1;
            min-width: 280px;
            height: 220px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }
        .sel-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sel-info {
            flex: 1.3;
        }
        .sel-num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: rgba(220, 38, 24, 0.2);
            line-height: 1;
            margin-bottom: 5px;
        }
        .sel-info h2 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.8rem;
            color: #0e1b30;
            text-transform: uppercase;
            font-weight: 800;
            margin: 0 0 15px 0;
        }
        .sel-info p {
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .sel-tags {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .sel-tags li {
            font-size: 0.85rem;
            background: #f3f4f6;
            color: #0e1b30;
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 600;
        }
        .sel-tags li strong {
            color: #dc2618;
        }

        .sel-cta-block {
            text-align: center;
            padding: 40px;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }
        .sel-cta-btn {
            display: inline-block;
            background: #dc2618;
            color: #ffffff;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 14px 40px;
            border-radius: 8px;
            letter-spacing: 0.5px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(220,38,24,0.3);
        }
        .sel-cta-btn:hover {
            background: #0e1b30;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14,27,48,0.4);
        }

        @media (max-width: 800px) {
            .sel-card, .sel-card:nth-child(even) {
                flex-direction: column;
                align-items: stretch;
                padding: 20px;
                gap: 20px;
            }
            .sel-image-wrap {
                height: 180px;
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
    <h1>Selection <span style="color: #dc2618;">Process</span></h1>
    <p class="c11p-intro" style="margin-top: 10px; color: #dc2618; font-weight: 600;">How C11CL Empowers Future Stars</p>
    <p style="color: #4b5563; max-width: 850px; margin: 15px auto 0 auto; line-height: 1.6;">
        At Champions 11 Cricket League (C11CL), our selection process is built to offer <strong>equal opportunity, unbiased assessment, and structured growth</strong> to every aspiring cricketer. We believe every over counts.
    </p>
</div>

<div class="c11p-content">

    <div class="sel-grid">

        <!-- Step 1 -->
        <div class="sel-card">
            <div class="sel-image-wrap">
                <img src="../wp-content/uploads/2025/06/1-3.png" alt="State-Wise Trials">
            </div>
            <div class="sel-info">
                <div class="sel-num">01</div>
                <h2>State-Wise Trials</h2>
                <p>This is the entry gate for all aspiring cricketers. Open trials are conducted across multiple states with certified guidance.</p>
                <ul class="sel-tags">
                    <li>Format: <strong>2-3 Over Rounds</strong></li>
                    <li>Age: <strong>U14, U16, U19, A19, 23+</strong></li>
                    <li>Fees: <strong>₹1850</strong></li>
                    <li>Guidance: <strong>BCCI Coaches</strong></li>
                </ul>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="sel-card">
            <div class="sel-image-wrap">
                <img src="../wp-content/uploads/2025/06/Lucid_Realism_A_dramatic_midmatch_scene_of_a_nationallevel_cri_2.jpg" alt="T20 Matches">
            </div>
            <div class="sel-info">
                <div class="sel-num">02</div>
                <h2>T20 Matches</h2>
                <p>Top performers move forward to play competitive matches under professional conditions, complete with kit and dress support.</p>
                <ul class="sel-tags">
                    <li>3 T20 Matches</li>
                    <li>Professional Kit & Dress</li>
                    <li>Individual Awards</li>
                    <li>Fees: <strong>₹8,999</strong></li>
                </ul>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="sel-card">
            <div class="sel-image-wrap">
                <img src="../wp-content/uploads/2025/06/Lucid_Realism_A_highenergy_cricket_auction_event_for_Champions_0.jpg" alt="Auction Day">
            </div>
            <div class="sel-info">
                <div class="sel-num">03</div>
                <h2>Auction Day</h2>
                <p>A grand, high-energy event where players are picked by franchise owners live on YouTube, mimicking professional cricket auctions.</p>
                <ul class="sel-tags">
                    <li>8 Franchise Teams</li>
                    <li>Live YouTube Broadcast</li>
                    <li>Scout Portals</li>
                </ul>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="sel-card">
            <div class="sel-image-wrap">
                <img src="../wp-content/uploads/2025/06/Lucid_Realism_A_thrilling_nationallevel_cricket_championship_m_3.jpg" alt="National League">
            </div>
            <div class="sel-info">
                <div class="sel-num">04</div>
                <h2>National League</h2>
                <p>Prove yourself on the big stage. 8 teams compete for the ultimate trophy, cash prizes, and nationwide media spotlight.</p>
                <ul class="sel-tags">
                    <li>Cash Prizes</li>
                    <li>Stay & Food Included</li>
                    <li>Live Broadcast Coverage</li>
                </ul>
            </div>
        </div>

    </div>

    <div class="sel-cta-block">
        <p style="font-size: 1.1rem; color: #4b5563; margin-bottom: 20px;">Ready to showcase your talent on the national stage?</p>
        <a href="../registration/" class="sel-cta-btn">Register For Trials Now</a>
    </div>

</div>

<?php include "../foot.php"; ?>
</body>
</html>