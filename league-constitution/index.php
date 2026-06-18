<?php
$page_title = "League Constitution";
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
                <p data-start="288" data-end="580">The <strong data-start="292" data-end="331">Champions 11 Cricket League (C11CL)</strong> Constitution outlines the fundamental principles, rules, and structure that govern the league. It ensures transparency, fairness, and consistency in how the league operates, providing a clear framework for players, teams, officials, and organizers.</p><hr data-start="582" data-end="585" /><h5 data-start="587" data-end="616"><strong data-start="591" data-end="614">1. Name and Purpose</strong></h5><ul data-start="617" data-end="870"><li data-start="617" data-end="690"><p data-start="619" data-end="690">The league shall be known as <strong data-start="648" data-end="687">Champions 11 Cricket League (C11CL)</strong>.</p></li><li data-start="691" data-end="870"><p data-start="693" data-end="870">The purpose of the league is to promote competitive cricket, encourage sportsmanship, and provide a platform for players to showcase their talent in a fair and organized manner.</p></li></ul><hr data-start="872" data-end="875" /><h5 data-start="877" data-end="900"><strong data-start="881" data-end="898">2. Membership</strong></h5><ul data-start="901" data-end="1147"><li data-start="901" data-end="998"><p data-start="903" data-end="998">Membership is open to all cricket teams that meet the eligibility criteria set by the league.</p></li><li data-start="999" data-end="1062"><p data-start="1001" data-end="1062">Teams must register officially and follow all league rules.</p></li><li data-start="1063" data-end="1147"><p data-start="1065" data-end="1147">Each team agrees to abide by the league’s Code of Conduct and other regulations.</p></li></ul><hr data-start="1149" data-end="1152" /><h5 data-start="1154" data-end="1177"><strong data-start="1158" data-end="1175">3. Governance</strong></h5><ul data-start="1178" data-end="1509"><li data-start="1178" data-end="1316"><p data-start="1180" data-end="1316">The league is managed by the <strong data-start="1209" data-end="1238">C11CL Governing Committee</strong>, responsible for decision-making, rule enforcement, and dispute resolution.</p></li><li data-start="1317" data-end="1440"><p data-start="1319" data-end="1440">The Committee consists of elected officials including a President, Secretary, Treasurer, and other members as required.</p></li><li data-start="1441" data-end="1509"><p data-start="1443" data-end="1509">Committee members serve for a fixed term as decided by the league.</p></li></ul><hr data-start="1511" data-end="1514" /><h5 data-start="1516" data-end="1542"><strong data-start="1520" data-end="1540">4. League Format</strong></h5><ul data-start="1543" data-end="1903"><li data-start="1543" data-end="1686"><p data-start="1545" data-end="1686">The league format, including number of teams, match schedules, and tournament structure, will be announced before the start of each season.</p></li><li data-start="1687" data-end="1781"><p data-start="1689" data-end="1781">Formats may include round-robin, knockout stages, or a combination based on participation.</p></li><li data-start="1782" data-end="1903"><p data-start="1784" data-end="1903">The rules of cricket as defined by the International Cricket Council (ICC) will be followed unless otherwise specified.</p></li></ul><hr data-start="1905" data-end="1908" /><h5 data-start="1910" data-end="1958"><strong data-start="1914" data-end="1956">5. Player Eligibility and Registration</strong></h5><ul data-start="1959" data-end="2234"><li data-start="1959" data-end="2044"><p data-start="1961" data-end="2044">Players must register with their respective teams before the start of the league.</p></li><li data-start="2045" data-end="2138"><p data-start="2047" data-end="2138">All players must meet age, fitness, and other eligibility criteria defined by the league.</p></li><li data-start="2139" data-end="2234"><p data-start="2141" data-end="2234">Transfers between teams during the league are subject to approval by the Governing Committee.</p></li></ul><hr data-start="2236" data-end="2239" /><h5 data-start="2241" data-end="2284"><strong data-start="2245" data-end="2282">6. Code of Conduct and Discipline</strong></h5><ul data-start="2285" data-end="2583"><li data-start="2285" data-end="2390"><p data-start="2287" data-end="2390">All participants must adhere to the league’s <strong data-start="2332" data-end="2351">Code of Conduct</strong> (refer to the Code of Conduct page).</p></li><li data-start="2391" data-end="2506"><p data-start="2393" data-end="2506">Disciplinary actions for misconduct, cheating, or breaches of rules will be handled by the Governing Committee.</p></li><li data-start="2507" data-end="2583"><p data-start="2509" data-end="2583">Penalties may include warnings, suspensions, or expulsion from the league.</p></li></ul><hr data-start="2585" data-end="2588" /><h5 data-start="2590" data-end="2623"><strong data-start="2594" data-end="2621">7. Matches and Umpiring</strong></h5><ul data-start="2624" data-end="2889"><li data-start="2624" data-end="2692"><p data-start="2626" data-end="2692">Matches will be conducted as per the scheduled dates and venues.</p></li><li data-start="2693" data-end="2779"><p data-start="2695" data-end="2779">Official umpires appointed by the league will oversee matches to ensure fair play.</p></li><li data-start="2780" data-end="2889"><p data-start="2782" data-end="2889">Any disputes or appeals must be submitted in writing to the Governing Committee within the stipulated time.</p></li></ul><hr data-start="2891" data-end="2894" /><h5 data-start="2896" data-end="2931"><strong data-start="2900" data-end="2929">8. Prizes and Recognition</strong></h5><ul data-start="2932" data-end="3102"><li data-start="2932" data-end="3033"><p data-start="2934" data-end="3033">The league will award trophies, medals, or certificates to winning teams and outstanding players.</p></li><li data-start="3034" data-end="3102"><p data-start="3036" data-end="3102">Specific awards and criteria will be announced before each season.</p></li></ul><hr data-start="3104" data-end="3107" /><h5 data-start="3109" data-end="3152"><strong data-start="3113" data-end="3150">9. Amendments to the Constitution</strong></h5><ul data-start="3153" data-end="3317"><li data-start="3153" data-end="3234"><p data-start="3155" data-end="3234">Any changes to this Constitution require approval by the Governing Committee.</p></li><li data-start="3235" data-end="3317"><p data-start="3237" data-end="3317">Members may propose amendments which will be reviewed and communicated promptly.</p></li></ul><hr data-start="3319" data-end="3322" /><h5 data-start="3324" data-end="3357"><strong data-start="3328" data-end="3355">10. Contact Information</strong></h5><p data-start="3358" data-end="3493">For any questions, concerns, or suggestions related to the league constitution or operations, please contact us at:<br data-start="3473" data-end="3476" />📧 <a class="cursor-pointer" rel="noopener" data-start="3479" data-end="3493">info@c11cl.com</a></p>
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
