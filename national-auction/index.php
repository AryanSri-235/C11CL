<?php 
$page_title = "National Auction"; 
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO Meta Tags -->
    <title>National Auction | Professional Stage | C11CL</title>
    <meta name="description" content="This is where talent gets its true valuation. Our National Auction is a high impact live event that serves as a life-changing platform for aspiring cricketers." />
    <link rel="canonical" href="https://c11cl.com/national-auction/" />
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Auction Custom Layout Styles */
        .auc-alert-panel {
            background: #fff5f5;
            border: 1px dashed rgba(220, 38, 24, 0.4);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .auc-alert-icon {
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
        .auc-alert-text h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            color: #0e1b30;
            font-weight: 800;
        }
        .auc-alert-text p {
            margin: 0;
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Steps List */
        .auc-process-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 40px;
        }
        .auc-step-row {
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
        .auc-step-row:hover {
            border-color: #dc2618;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(14, 27, 48, 0.06);
        }

        .auc-row-step {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .auc-step-icon {
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
        .auc-row-step h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            margin: 0;
            text-transform: uppercase;
            color: #0e1b30;
            font-weight: 800;
        }

        .auc-row-details {
            font-size: 1rem;
            color: #0e1b30;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .auc-row-details i {
            color: #64748b;
        }
        .auc-row-details span {
            color: #64748b;
            font-weight: 500;
            font-size: 0.85rem;
            display: block;
            margin-top: 2px;
        }

        .auc-row-badge-zone {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }
        .auc-status-tag {
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
        .auc-status-tag::before {
            content: "";
            width: 6px;
            height: 6px;
            background: #16a34a;
            border-radius: 50%;
        }
        .auc-badge-display {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            color: #dc2618;
            margin: 0;
            font-weight: 800;
            text-transform: uppercase;
        }

        /* Highlight box footer */
        .auc-clean-footer {
            background: #0e1b30;
            padding: 35px;
            border-radius: 12px;
            text-align: center;
            border-left: 5px solid #dc2618;
            box-shadow: 0 10px 25px rgba(14,27,48,0.1);
        }
        .auc-clean-footer p {
            font-size: 1.05rem;
            color: #ffffff;
            max-width: 750px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .auc-clean-footer span {
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
            .auc-step-row {
                grid-template-columns: 1fr;
                padding: 25px;
                text-align: center;
                justify-items: center;
                gap: 15px;
            }
            .auc-row-step {
                flex-direction: column;
                gap: 8px;
            }
            .auc-row-details {
                flex-direction: column;
                gap: 4px;
            }
            .auc-row-badge-zone {
                align-items: center;
            }
            .auc-alert-panel {
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
    <h1>National <span style="color: #dc2618;">Auction</span></h1>
    <p class="c11p-intro" style="margin-top: 10px; color: #dc2618; font-weight: 600;">Player Value Recognition Stage</p>
    <p style="color: #4b5563; max-width: 750px; margin: 15px auto 0 auto; line-height: 1.6;">
        This is where talent gets its true valuation. Our National Auction is a high impact live event that serves as a life-changing platform for aspiring cricketers.
    </p>
</div>

<div class="c11p-content">
    
    <div class="auc-alert-panel">
        <div class="auc-alert-icon"><i class="fa-solid fa-gavel"></i></div>
        <div class="auc-alert-text">
            <h3>Live Auction - Online Broadcasting</h3>
            <p>After proving their mettle in the high-octane T20 matches, selected standout players enter the official auction pool. Franchise owners, scouts, and corporate sponsors use our customized bidding software to bid for players live on YouTube.</p>
        </div>
    </div>

    <div class="auc-process-list">

        <!-- Step 1 -->
        <div class="auc-step-row">
            <div class="auc-row-step">
                <div class="auc-step-icon"><i class="fa-solid fa-id-card-clip"></i></div>
                <h3>01. Pool Activation</h3>
            </div>
            <div class="auc-row-details">
                <i class="fa-solid fa-chart-line" style="margin-top: 4px;"></i>
                <div>
                    State Performance Evaluation
                    <span>Top scorecard performers entry gateway</span>
                </div>
            </div>
            <div class="auc-row-badge-zone">
                <span class="auc-status-tag">Data Ready</span>
                <h4 class="auc-badge-display">Trials & T20 Pass</h4>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="auc-step-row">
            <div class="auc-row-step">
                <div class="auc-step-icon"><i class="fa-solid fa-users"></i></div>
                <h3>02. Franchise War</h3>
            </div>
            <div class="auc-row-details">
                <i class="fa-solid fa-laptop-code" style="margin-top: 4px;"></i>
                <div>
                    Automated Software Bidding
                    <span>Real-time point allocation & player picks</span>
                </div>
            </div>
            <div class="auc-row-badge-zone">
                <span class="auc-status-tag">Live System</span>
                <h4 class="auc-badge-display">YouTube Broadcast</h4>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="auc-step-row">
            <div class="auc-row-step">
                <div class="auc-step-icon"><i class="fa-solid fa-tower-broadcast"></i></div>
                <h3>03. Career Growth</h3>
            </div>
            <div class="auc-row-details">
                <i class="fa-solid fa-bullseye" style="margin-top: 4px;"></i>
                <div>
                    Scout & Sponsor Portals
                    <span>Direct transition from local town to national fame</span>
                </div>
            </div>
            <div class="auc-row-badge-zone">
                <span class="auc-status-tag">Final Arena</span>
                <h4 class="auc-badge-display">National Squad</h4>
            </div>
        </div>

    </div>

    <div class="auc-clean-footer">
        <p>We provide the visibility you need to transition from a local standout to a national prospect. In our league, transparency is guaranteed.</p>
        <span>Talent is the only currency that matters!</span>
    </div>

</div>

<?php include "../foot.php"; ?>
</body>
</html>
