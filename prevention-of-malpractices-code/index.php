<?php
$page_title = "Prevention of Malpractices Code";
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
                <p data-start="354" data-end="733">At <strong data-start="357" data-end="396">Champions 11 Cricket League (C11CL)</strong>, we believe in <strong data-start="412" data-end="455">fair play, sportsmanship, and integrity</strong> both on and off the field. To ensure our cricketing events are conducted in a transparent and ethical manner, this <strong data-start="571" data-end="606">Prevention of Malpractices Code</strong> has been created. Every participant, team, coach, mentor, official, and staff member is expected to follow this code strictly.</p><hr data-start="735" data-end="738" /><h5 data-start="740" data-end="771"><strong data-start="744" data-end="771">1. Purpose of This Code</strong></h5><p data-start="772" data-end="803">The purpose of this code is to:</p><ul data-start="805" data-end="986"><li data-start="805" data-end="852"><p data-start="807" data-end="852">Promote honesty and discipline in the game.</p></li><li data-start="853" data-end="900"><p data-start="855" data-end="900">Prevent any form of cheating or wrongdoing.</p></li><li data-start="901" data-end="940"><p data-start="903" data-end="940">Protect the true spirit of cricket.</p></li><li data-start="941" data-end="986"><p data-start="943" data-end="986">Ensure equal opportunity for all players.</p></li></ul><hr data-start="988" data-end="991" /><h5 data-start="993" data-end="1036"><strong data-start="997" data-end="1036">2. Malpractices Strictly Prohibited</strong></h5><p data-start="1037" data-end="1135">The following actions are considered malpractices and are <strong data-start="1095" data-end="1110">not allowed</strong> under any circumstances:</p><ul data-start="1137" data-end="1977"><li data-start="1137" data-end="1224"><p data-start="1139" data-end="1224"><strong data-start="1139" data-end="1155">Match Fixing</strong>: Influencing the result of a match for personal or financial gain.</p></li><li data-start="1225" data-end="1337"><p data-start="1227" data-end="1337"><strong data-start="1227" data-end="1242">Spot Fixing</strong>: Manipulating a specific part of the match (like a wide ball or no-ball) for unfair reasons.</p></li><li data-start="1338" data-end="1453"><p data-start="1340" data-end="1453"><strong data-start="1340" data-end="1365">Bribery or Corruption</strong>: Offering money, gifts, or benefits to players, umpires, or staff to change outcomes.</p></li><li data-start="1454" data-end="1500"><p data-start="1456" data-end="1500"><strong data-start="1456" data-end="1497">Playing Under a Fake Name or Identity</strong>.</p></li><li data-start="1501" data-end="1561"><p data-start="1503" data-end="1561"><strong data-start="1503" data-end="1516">Age Fraud</strong>: Submitting false age proofs or documents.</p></li><li data-start="1562" data-end="1625"><p data-start="1564" data-end="1625"><strong data-start="1564" data-end="1604">Tampering with the Ball or Equipment</strong> in an illegal way.</p></li><li data-start="1626" data-end="1723"><p data-start="1628" data-end="1723"><strong data-start="1628" data-end="1663">Unethical Social Media Behavior</strong>: Spreading rumors, targeting players, or defaming others.</p></li><li data-start="1724" data-end="1810"><p data-start="1726" data-end="1810"><strong data-start="1726" data-end="1764">Disrespecting Umpires or Officials</strong>: Arguing, shouting, or using foul language.</p></li><li data-start="1811" data-end="1882"><p data-start="1813" data-end="1882"><strong data-start="1813" data-end="1851">Doping or Use of Banned Substances</strong> (refer to Anti-Doping Code).</p></li><li data-start="1883" data-end="1977"><p data-start="1885" data-end="1977"><strong data-start="1885" data-end="1918">Bringing Outside Interference</strong> like threatening, political pressure, or unfair influence.</p></li></ul><hr data-start="1979" data-end="1982" /><h5 data-start="1984" data-end="2017"><strong data-start="1988" data-end="2017">3. Reporting Malpractices</strong></h5><p data-start="2018" data-end="2123">If you see or experience any wrongdoing, report it immediately to the league organizers through email at:</p><p data-start="2125" data-end="2146">📧 <strong data-start="2128" data-end="2146"><a class="cursor-pointer" rel="noopener" data-start="2130" data-end="2144">info@c11cl.com</a></strong></p><p data-start="2148" data-end="2255">All reports will be kept confidential and will be seriously investigated. Whistleblowers will be protected.</p><hr data-start="2257" data-end="2260" /><h5 data-start="2262" data-end="2298"><strong data-start="2266" data-end="2298">4. Consequences of Violation</strong></h5><p data-start="2299" data-end="2363">If any individual or team is found guilty of breaking this code:</p><ul data-start="2365" data-end="2677"><li data-start="2365" data-end="2430"><p data-start="2367" data-end="2430"><strong data-start="2367" data-end="2397">Immediate disqualification</strong> from the tournament or league.</p></li><li data-start="2431" data-end="2471"><p data-start="2433" data-end="2471"><strong data-start="2433" data-end="2459">Ban from future events</strong> of C11CL.</p></li><li data-start="2472" data-end="2530"><p data-start="2474" data-end="2530"><strong data-start="2474" data-end="2527">Confiscation of awards, certificates, or trophies</strong>.</p></li><li data-start="2531" data-end="2591"><p data-start="2533" data-end="2591"><strong data-start="2533" data-end="2574">Public announcement of the misconduct</strong> (if required).</p></li><li data-start="2592" data-end="2677"><p data-start="2594" data-end="2677"><strong data-start="2594" data-end="2610">Legal action</strong>, if the malpractice involves fraud, forgery, or criminal behavior.</p></li></ul><hr data-start="2679" data-end="2682" /><h5 data-start="2684" data-end="2732"><strong data-start="2688" data-end="2732">5. Responsibilities of Players and Teams</strong></h5><ul data-start="2734" data-end="2945"><li data-start="2734" data-end="2774"><p data-start="2736" data-end="2774">Always play fairly and by the rules.</p></li><li data-start="2775" data-end="2817"><p data-start="2777" data-end="2817">Maintain discipline and sportsmanship.</p></li><li data-start="2818" data-end="2845"><p data-start="2820" data-end="2845">Avoid shortcuts to win.</p></li><li data-start="2846" data-end="2908"><p data-start="2848" data-end="2908">Respect your opponents, umpires, and all event organizers.</p></li><li data-start="2909" data-end="2945"><p data-start="2911" data-end="2945">Keep the spirit of the game alive.</p></li></ul><hr data-start="2947" data-end="2950" /><h5 data-start="2952" data-end="2977"><strong data-start="2956" data-end="2977">6. Final Decision</strong></h5><p data-start="2978" data-end="3223">The final decision in all cases of suspected malpractice rests with the <strong data-start="3050" data-end="3082">C11CL Disciplinary Committee</strong>. The committee will review all evidence, hear both sides, and make a fair judgment. No appeals will be entertained after the final decision.</p><hr data-start="3225" data-end="3228" /><h5 data-start="3230" data-end="3248"><strong data-start="3234" data-end="3248">Conclusion</strong></h5><p data-start="3249" data-end="3527">The <strong data-start="3253" data-end="3284">Champions 11 Cricket League</strong> is not just about winning trophies—it&#8217;s about building character, playing with honesty, and inspiring others with clean cricket. We thank all players, coaches, and supporters for respecting this code and upholding the true spirit of the game.</p>
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
