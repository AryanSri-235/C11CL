<?php $page_title = "Partners & Sponsors"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | C11CL</title>
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .partners-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        .partner-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .partner-card:hover {
            transform: translateY(-5px);
            border-color: #dc2618;
            box-shadow: 0 20px 40px rgba(220, 38, 24, 0.1);
        }
        .partner-logo-wrap {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            background: #fafafa;
            border-radius: 8px;
            padding: 15px;
        }
        .partner-logo-wrap img {
            max-width: 100%;
            max-height: 85px;
            object-fit: contain;
            transition: transform 0.3s;
        }
        .partner-card:hover .partner-logo-wrap img {
            transform: scale(1.05);
        }
        .partner-info h4 {
            color: #0e1b30;
            font-size: 1.3rem;
            margin: 0 0 12px;
            font-weight: 800;
            text-transform: uppercase;
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: 0.5px;
        }
        .partner-info p {
            color: #4b5563;
            font-size: 0.92rem;
            line-height: 1.6;
            margin: 0;
        }
        .partner-tag {
            display: inline-block;
            background: #fff5f5;
            color: #dc2618;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
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
    <h1><?php echo $page_title; ?></h1>
    <p class="c11p-intro" style="margin-top: 10px; color: #4b5563;">Champions 11 Cricket League is proud to collaborate with brands that support grassroots sports development across India.</p>
</div>

<div class="c11p-content">
    
    <div class="partners-container">
        
        <!-- Partner 1: Arghya Technologies -->
        <div class="partner-card">
            <div class="partner-logo-wrap">
                <img src="../wp-content/uploads/2025/06/Screenshot-2025-06-08-234309.png" alt="Arghya Technologies">
            </div>
            <div class="partner-info">
                <span class="partner-tag">Supply Chain & Distribution</span>
                <h4>Arghya Technologies</h4>
                <p>Arghya Technologies is a pan-India sourcing and distribution company bridging global manufacturing with the Indian market through efficient supply chain and vendor partnerships. Their support towards grassroots sports reflects a shared vision of empowering India’s next generation.</p>
            </div>
        </div>

        <!-- Partner 2: One Turf News -->
        <div class="partner-card">
            <div class="partner-logo-wrap">
                <img src="../wp-content/uploads/2025/05/CNE_Turf_News_logo.jpeg" alt="One Turf News">
            </div>
            <div class="partner-info">
                <span class="partner-tag">Sports Media Partner</span>
                <h4>One Turf News</h4>
                <p>One Turf News is a fast-growing cricket and sports media platform focused on covering grassroots cricket, emerging talent, and the evolving sports ecosystem. Through content, storytelling, and community engagement, they continue to amplify the voice of young cricketers across India.</p>
            </div>
        </div>

    </div>

</div>

<?php include "../foot.php"; ?>
</body>
</html>