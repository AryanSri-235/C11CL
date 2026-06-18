<?php
$page_title = "Anti-Racism Code";
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
                <p data-start="206" data-end="512">At C11CL, we believe that cricket is more than just a sport — it’s a platform to unite people from different backgrounds, communities, and cultures. Our Anti-Racism Code outlines our unwavering commitment to fostering a safe, inclusive, and respectful environment where everyone feels welcome.</p><hr data-start="514" data-end="517" /><h5 data-start="519" data-end="541"><strong data-start="523" data-end="541">Our Commitment</strong></h5><p data-start="543" data-end="848">Racism, in any form, is strictly condemned in our league. We are dedicated to creating a space where every participant, whether player, coach, official, staff, or spectator, is respected and celebrated for who they are — regardless of race, color, ethnicity, nationality, religion, or cultural background.</p><p data-start="850" data-end="993">We stand united against discrimination, and we expect all members of our cricketing community to uphold these values both on and off the field.</p><hr data-start="995" data-end="998" /><h5 data-start="1000" data-end="1025"><strong data-start="1004" data-end="1025">What We Stand For</strong></h5><ul data-start="1027" data-end="1291"><li data-start="1027" data-end="1081"><p data-start="1029" data-end="1081">Equal opportunities for all players and participants</p></li><li data-start="1082" data-end="1140"><p data-start="1084" data-end="1140">Respectful and inclusive behavior from everyone involved</p></li><li data-start="1141" data-end="1213"><p data-start="1143" data-end="1213">Immediate and firm action against any form of racism or discrimination</p></li><li data-start="1214" data-end="1291"><p data-start="1216" data-end="1291">Education and awareness to eliminate unconscious bias and promote diversity</p></li></ul><hr data-start="1293" data-end="1296" /><h5 data-start="1298" data-end="1327"><strong data-start="1302" data-end="1327">Zero-Tolerance Policy</strong></h5><p data-start="1329" data-end="1431">We operate on a strict <strong data-start="1352" data-end="1377">zero-tolerance policy</strong> towards racism. This includes, but is not limited to:</p><ul data-start="1433" data-end="1697"><li data-start="1433" data-end="1487"><p data-start="1435" data-end="1487">Racial abuse or slurs (spoken, written, or gestured)</p></li><li data-start="1488" data-end="1560"><p data-start="1490" data-end="1560">Mocking or insulting cultural practices, accents, or religious beliefs</p></li><li data-start="1561" data-end="1629"><p data-start="1563" data-end="1629">Offensive chants or crowd behavior targeting individuals or groups</p></li><li data-start="1630" data-end="1697"><p data-start="1632" data-end="1697">Discriminatory selection or treatment of players and team members</p></li></ul><p data-start="1699" data-end="1882">Any individual found engaging in racist behavior will be subject to disciplinary actions, which may include suspension, fines, bans from matches, or permanent removal from the league.</p><hr data-start="1884" data-end="1887" /><h5 data-start="1889" data-end="1923"><strong data-start="1893" data-end="1923">Speak Up — We’re Listening</strong></h5><p data-start="1925" data-end="2054">If you witness or are a victim of racist behavior, please don’t stay silent. We encourage reporting through any of the following:</p><ul data-start="2056" data-end="2270"><li data-start="2056" data-end="2105"><p data-start="2058" data-end="2105">Contacting the league management team in person</p></li><li data-start="2106" data-end="2166"><p data-start="2108" data-end="2166">Filling out the <strong data-start="2124" data-end="2146">Report an Incident</strong> form on our website</p></li><li data-start="2167" data-end="2204"><p data-start="2169" data-end="2204">Emailing us at [your email address]</p></li><li data-start="2205" data-end="2270"><p data-start="2207" data-end="2270">Speaking with the designated Anti-Racism Officer during matches</p></li></ul><p data-start="2272" data-end="2347">All reports will be treated with sensitivity, confidentiality, and urgency.</p><hr data-start="2349" data-end="2352" /><h5 data-start="2354" data-end="2385"><strong data-start="2358" data-end="2385">Education and Inclusion</strong></h5><p data-start="2387" data-end="2544">We believe education is key to building a respectful sporting environment. Through training sessions, awareness drives, and community discussions, we aim to:</p><ul data-start="2546" data-end="2690"><li data-start="2546" data-end="2602"><p data-start="2548" data-end="2602">Help players and teams understand the impact of racism</p></li><li data-start="2603" data-end="2633"><p data-start="2605" data-end="2633">Encourage inclusive behavior</p></li><li data-start="2634" data-end="2690"><p data-start="2636" data-end="2690">Build empathy and mutual respect across cultural lines</p></li></ul><p data-start="2692" data-end="2781">We are continuously evolving our approach to ensure that every voice is heard and valued.</p>
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
