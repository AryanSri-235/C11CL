<?php
$page_title = "Anti-Doping Code";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Champions 11 Cricket League</title>
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
</head>
<body>

<?php
include "../head.php";
?>

<style>
/* Scoped styles for the C11CL Policy Pages to match Poppins/Barlow font stack & brand colors */
.c11-policy-hero {
    background: linear-gradient(135deg, #111111 0%, #222222 100%);
    padding: 50px 0;
    text-align: center;
    border-bottom: 3px solid #dc2618;
}
.c11-policy-hero-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
}
.c11-policy-hero-subtitle {
    color: #dc2618;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 3px;
    font-size: 0.85rem;
    display: block;
    margin-bottom: 8px;
    font-family: 'Poppins', sans-serif;
}
.c11-policy-hero-title {
    font-family: 'Barlow Condensed', 'Oswald', sans-serif;
    font-size: clamp(2.2rem, 5vw, 3rem);
    font-weight: 700;
    margin: 0 0 12px;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: -0.5px;
    line-height: 1.1;
}
.c11-policy-breadcrumb {
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    font-family: 'Poppins', sans-serif;
}
.c11-policy-breadcrumb a {
    color: #bbbbbb;
    text-decoration: none;
    transition: color 0.2s;
}
.c11-policy-breadcrumb a:hover {
    color: #dc2618;
}
.c11-policy-breadcrumb-separator {
    color: #dc2618;
    margin: 0 8px;
    font-weight: 700;
}
.c11-policy-breadcrumb-current {
    color: #888888;
}

.c11-policy-wrapper {
    background-color: #ffffff;
    padding: 60px 0;
    font-family: 'Poppins', 'Inter', sans-serif;
    line-height: 1.7;
}
.c11-policy-container {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
    display: grid;
    grid-template-columns: 3fr 1fr;
    gap: 50px;
}
@media (max-width: 991px) {
    .c11-policy-container {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}
.c11-policy-content {
    color: #333333;
}
.c11-policy-content h2.c11-policy-league-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #dc2618;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0 0 12px 0;
}
.c11-policy-content h1.c11-policy-main-title {
    font-family: 'Barlow Condensed', 'Oswald', sans-serif;
    font-size: 2.8rem;
    font-weight: 700;
    color: #111111;
    text-transform: uppercase;
    margin: 0 0 16px 0;
    letter-spacing: -0.5px;
    line-height: 1.1;
}
.c11-policy-divider {
    width: 60px;
    height: 4px;
    background: #dc2618;
    margin-bottom: 32px;
    border-radius: 2px;
}
.c11-policy-body {
    font-size: 1.05rem;
}
.c11-policy-body p {
    margin-bottom: 20px;
    color: #444444;
}
.c11-policy-body h5 {
    font-family: 'Poppins', sans-serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: #111111;
    margin: 32px 0 16px 0;
    border-left: 4px solid #dc2618;
    padding-left: 14px;
}
.c11-policy-body ul, .c11-policy-body ol {
    margin: 0 0 24px 24px;
    padding: 0;
}
.c11-policy-body li {
    margin-bottom: 10px;
    color: #444444;
}
.c11-policy-body li strong {
    color: #111111;
}

/* Sidebar Styles */
.c11-policy-sidebar {
    background: #fdfdfd;
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    padding: 28px;
    align-self: start;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
}
.c11-policy-sidebar-title {
    font-family: 'Barlow Condensed', 'Oswald', sans-serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: #111111;
    text-transform: uppercase;
    margin: 0 0 20px 0;
    border-bottom: 2px solid #dc2618;
    padding-bottom: 8px;
    letter-spacing: 0.5px;
}
.c11-policy-sidebar-list {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
}
.c11-policy-sidebar-list li {
    margin-bottom: 14px !important;
    padding-bottom: 14px !important;
    border-bottom: 1px solid #f5f5f5;
    list-style-type: none !important;
}
.c11-policy-sidebar-list li:last-child {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
    border-bottom: none;
}
.c11-policy-sidebar-list a {
    color: #555555;
    font-size: 0.95rem;
    text-decoration: none;
    transition: color 0.2s, padding-left 0.2s;
    font-weight: 500;
    display: inline-block;
}
.c11-policy-sidebar-list a:hover {
    color: #dc2618;
    padding-left: 5px;
}
.c11-policy-sidebar-list li.active a {
    color: #dc2618;
    font-weight: 700;
}
</style>

<div class="c11-policy-hero">
    <div class="c11-policy-hero-inner">
        <span class="c11-policy-hero-subtitle">Champions 11 Cricket League</span>
        <h1 class="c11-policy-hero-title"><?php echo $page_title; ?></h1>
        <nav class="c11-policy-breadcrumb">
            <a href="<?php echo BASE_URL; ?>">Home</a>
            <span class="c11-policy-breadcrumb-separator">•</span>
            <span class="c11-policy-breadcrumb-current"><?php echo $page_title; ?></span>
        </nav>
    </div>
</div>

<div class="c11-policy-wrapper">
    <div class="c11-policy-container">
        
        <!-- Left Content Column -->
        <main class="c11-policy-content">
            <h2 class="c11-policy-league-name">Champions 11 Cricket League</h2>
            <h1 class="c11-policy-main-title"><?php echo $page_title; ?></h1>
            <div class="c11-policy-divider"></div>
            
            <div class="c11-policy-body">
                <p>In our commitment to uphold the spirit of cricket, our league strictly follows an Anti-Doping Code aligned with international standards. Doping is a serious violation that affects not only the fairness of the game but also the health and integrity of the players.</p><h5>Why It Matters</h5><p>The Anti-Doping Code is in place to:</p><ul data-start="517" data-end="691"><li data-start="517" data-end="573">Ensure all players compete on a level playing field.</li><li data-start="574" data-end="628">Promote health, fairness, and safety in the sport.</li><li data-start="629" data-end="691">Educate players about prohibited substances and practices.</li></ul><h5>What Players Should Know</h5><ul data-start="723" data-end="1079"><li data-start="723" data-end="851"><strong data-start="725" data-end="750">Prohibited Substances</strong>: All players must avoid using any substance or method listed in the official WADA Prohibited List.</li><li data-start="852" data-end="948"><strong data-start="854" data-end="872">Random Testing</strong>: Players may be subjected to random drug testing during or after matches.</li><li data-start="949" data-end="1079"><strong data-start="951" data-end="986">TUE (Therapeutic Use Exemption)</strong>: If a player needs medication for health reasons, proper clearance must be taken in advance.</li></ul><h5>Responsibilities of Players &amp; Teams</h5><ul data-start="1122" data-end="1289"><li data-start="1122" data-end="1164">Stay informed about banned substances.</li><li data-start="1165" data-end="1242">Avoid taking any supplement or medicine without checking its ingredients.</li><li data-start="1243" data-end="1289">Cooperate during testing and investigations.</li></ul><h5>Consequences of Violations</h5><ul data-start="1323" data-end="1497"><li data-start="1323" data-end="1369">Immediate suspension from ongoing matches.</li><li data-start="1370" data-end="1438">Long-term bans from the league and other affiliated tournaments.</li><li data-start="1439" data-end="1497">Public announcement of the violation after confirmation.</li></ul><p><strong>We are committed to clean cricket. Let’s play fair and respect the game we all love.</strong></p>
            </div>
        </main>
        
        <!-- Right Sidebar Column -->
        <aside class="c11-policy-sidebar">
            <h3 class="c11-policy-sidebar-title">League Policies</h3>
            <ul class="c11-policy-sidebar-list">
                <li class="<?php echo ($page_title == 'Anti-Doping Code') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>anti-doping-code/">Anti-Doping Code</a></li>
                <li class="<?php echo ($page_title == 'Anti-Racism Code') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>anti-racism-code/">Anti-Racism Code</a></li>
                <li class="<?php echo ($page_title == 'Code of Conduct') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>code-of-conduct/">Code of Conduct</a></li>
                <li class="<?php echo ($page_title == 'Prevention of Malpractices Code') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>prevention-of-malpractices-code/">Prevention of Malpractices</a></li>
                <li class="<?php echo ($page_title == 'League Constitution') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>league-constitution/">League Constitution</a></li>
                <li class="<?php echo ($page_title == 'Cancellation Policy') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>cancellation-policy/">Cancellation Policy</a></li>
                <li class="<?php echo ($page_title == 'Privacy Policy') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>privacy-policy/">Privacy Policy</a></li>
                <li class="<?php echo ($page_title == 'Refund Policy') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>refund-policy/">Refund Policy</a></li>
                <li class="<?php echo ($page_title == 'Registration Policies') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>registration-policies/">Registration Policies</a></li>
                <li class="<?php echo ($page_title == 'Missing Children Policy') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>missing-children-policy/">Missing Children Policy</a></li>
                <li class="<?php echo ($page_title == 'Terms & Conditions') ? 'active' : ''; ?>"><a href="<?php echo BASE_URL; ?>terms-conditions/">Terms & Conditions</a></li>
            </ul>
        </aside>
        
    </div>
</div>

<?php include "../foot.php"; ?>

</body>
</html>
