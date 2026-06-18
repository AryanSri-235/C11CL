<?php
$page_title = "Code of Conduct";
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
                <p data-start="247" data-end="619">At <strong data-start="250" data-end="281">Champions 11 Cricket League</strong>, we aim to create a positive, respectful, and fair environment for all players, teams, officials, and fans. This <strong data-start="395" data-end="414">Code of Conduct</strong> is designed to help everyone understand the behavior expected while participating in or supporting the league. Following this code ensures the spirit of cricket is maintained and everyone enjoys the game.</p><hr data-start="621" data-end="624" /><h5 data-start="626" data-end="664"><strong data-start="630" data-end="662">1. Respect and Sportsmanship</strong></h5><ul data-start="665" data-end="923"><li data-start="665" data-end="743"><p data-start="667" data-end="743">Treat teammates, opponents, officials, and fans with respect at all times.</p></li><li data-start="744" data-end="805"><p data-start="746" data-end="805">Accept the decisions of umpires and officials gracefully.</p></li><li data-start="806" data-end="867"><p data-start="808" data-end="867">Avoid any form of abusive language, gestures, or actions.</p></li><li data-start="868" data-end="923"><p data-start="870" data-end="923">Encourage fair play and support your team positively.</p></li></ul><hr data-start="925" data-end="928" /><h5 data-start="930" data-end="952"><strong data-start="934" data-end="950">2. Fair Play</strong></h5><ul data-start="953" data-end="1223"><li data-start="953" data-end="1016"><p data-start="955" data-end="1016">Play the game honestly and follow all the rules of cricket.</p></li><li data-start="1017" data-end="1070"><p data-start="1019" data-end="1070">Do not cheat, fix matches, or manipulate results.</p></li><li data-start="1071" data-end="1162"><p data-start="1073" data-end="1162">Avoid any unfair advantage such as tampering with equipment or using banned substances.</p></li><li data-start="1163" data-end="1223"><p data-start="1165" data-end="1223">Report any suspicious behavior or malpractice you witness.</p></li></ul><hr data-start="1225" data-end="1228" /><h5 data-start="1230" data-end="1272"><strong data-start="1234" data-end="1270">3. Responsibility and Discipline</strong></h5><ul data-start="1273" data-end="1510"><li data-start="1273" data-end="1337"><p data-start="1275" data-end="1337">Arrive on time for matches, practice sessions, and meetings.</p></li><li data-start="1338" data-end="1400"><p data-start="1340" data-end="1400">Wear proper cricket gear and follow the dress code if any.</p></li><li data-start="1401" data-end="1451"><p data-start="1403" data-end="1451">Take care of your physical fitness and health.</p></li><li data-start="1452" data-end="1510"><p data-start="1454" data-end="1510">Keep a positive attitude even in challenging situations.</p></li></ul><hr data-start="1512" data-end="1515" /><h5 data-start="1517" data-end="1556"><strong data-start="1521" data-end="1554">4. Communication and Behavior</strong></h5><ul data-start="1557" data-end="1824"><li data-start="1557" data-end="1631"><p data-start="1559" data-end="1631">Communicate respectfully with coaches, teammates, officials, and fans.</p></li><li data-start="1632" data-end="1747"><p data-start="1634" data-end="1747">Use social media responsibly; avoid posting harmful or offensive content related to the league or participants.</p></li><li data-start="1748" data-end="1824"><p data-start="1750" data-end="1824">Avoid any behavior that damages the reputation of the league or the sport.</p></li></ul><hr data-start="1826" data-end="1829" /><h5 data-start="1831" data-end="1865"><strong data-start="1835" data-end="1863">5. Safety and Well-being</strong></h5><ul data-start="1866" data-end="2050"><li data-start="1866" data-end="1923"><p data-start="1868" data-end="1923">Follow safety guidelines during matches and practice.</p></li><li data-start="1924" data-end="1989"><p data-start="1926" data-end="1989">Do not engage in any form of violence or aggressive behavior.</p></li><li data-start="1990" data-end="2050"><p data-start="1992" data-end="2050">Support teammates and opponents to play safely and fairly.</p></li></ul><hr data-start="2052" data-end="2055" /><h5 data-start="2057" data-end="2096"><strong data-start="2061" data-end="2094">6. Consequences of Violations</strong></h5><p data-start="2097" data-end="2142">Violating this Code of Conduct can lead to:</p><ul data-start="2143" data-end="2345"><li data-start="2143" data-end="2184"><p data-start="2145" data-end="2184">Warnings or penalties during matches.</p></li><li data-start="2185" data-end="2236"><p data-start="2187" data-end="2236">Suspension or disqualification from the league.</p></li><li data-start="2237" data-end="2289"><p data-start="2239" data-end="2289">Bans from future tournaments organized by C11CL.</p></li><li data-start="2290" data-end="2345"><p data-start="2292" data-end="2345">Possible legal action in cases of serious misconduct.</p></li></ul><hr data-start="2347" data-end="2350" /><h5 data-start="2352" data-end="2375"><strong data-start="2356" data-end="2373">7. Commitment</strong></h5><p data-start="2376" data-end="2587">By participating in the Champions 11 Cricket League, all players, teams, and officials agree to follow this Code of Conduct fully. Together, we will create a respectful, fun, and competitive cricket environment.</p>
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
