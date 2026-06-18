<?php
$page_title = "Registration Policies";
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
                <p data-start="159" data-end="453">Welcome to <strong data-start="170" data-end="209">Champions 11 Cricket League (C11CL)</strong>! This Registration Policy outlines the rules, eligibility, and important guidelines that participants must follow when registering for any of our tournaments, events, or activities. Please read it carefully before submitting your registration.</p><hr data-start="455" data-end="458" /><h5 data-start="460" data-end="490">1. <strong data-start="466" data-end="490">Eligibility Criteria</strong></h5><ul data-start="491" data-end="856"><li data-start="491" data-end="575"><p data-start="493" data-end="575">All players must be of the required age as specified in the tournament guidelines.</p></li><li data-start="576" data-end="686"><p data-start="578" data-end="686">Participants must be physically fit and free from any condition that may affect their performance or safety.</p></li><li data-start="687" data-end="770"><p data-start="689" data-end="770">Team members must register under one team only. Dual registration is not allowed.</p></li><li data-start="771" data-end="856"><p data-start="773" data-end="856">All participants must agree to abide by the league&#8217;s rules and the Code of Conduct.</p></li></ul><hr data-start="858" data-end="861" /><h5 data-start="863" data-end="893">2. <strong data-start="869" data-end="893">Registration Process</strong></h5><ul data-start="894" data-end="1266"><li data-start="894" data-end="999"><p data-start="896" data-end="999">Registrations must be completed online via our official website: <a class="" href="../index.html" target="_new" rel="noopener" data-start="961" data-end="998">www.c11cl.com</a>.</p></li><li data-start="1000" data-end="1083"><p data-start="1002" data-end="1083">All fields in the registration form must be accurately filled with valid details.</p></li><li data-start="1084" data-end="1193"><p data-start="1086" data-end="1193">Required documents like ID proof, age certificate (if applicable), and player photographs must be uploaded.</p></li><li data-start="1194" data-end="1266"><p data-start="1196" data-end="1266">Incomplete or incorrect forms may lead to cancellation without refund.</p></li></ul><hr data-start="1268" data-end="1271" /><h5 data-start="1273" data-end="1300">3. <strong data-start="1279" data-end="1300">Registration Fees</strong></h5><ul data-start="1301" data-end="1587"><li data-start="1301" data-end="1418"><p data-start="1303" data-end="1418">A non-refundable registration fee (as specified on the registration page) must be paid to confirm the registration.</p></li><li data-start="1419" data-end="1492"><p data-start="1421" data-end="1492">The fee must be paid through the available online payment methods only.</p></li><li data-start="1493" data-end="1587"><p data-start="1495" data-end="1587">No cash payments will be accepted unless specifically announced by the organizing committee.</p></li></ul><hr data-start="1589" data-end="1592" /><h5 data-start="1594" data-end="1621">4. <strong data-start="1600" data-end="1621">Team Registration</strong></h5><ul data-start="1622" data-end="1915"><li data-start="1622" data-end="1703"><p data-start="1624" data-end="1703">A team must have the minimum required number of players to be considered valid.</p></li><li data-start="1704" data-end="1819"><p data-start="1706" data-end="1819">Team leaders/captains are responsible for submitting team details and coordinating with the organizing committee.</p></li><li data-start="1820" data-end="1915"><p data-start="1822" data-end="1915">Once a team is registered, player transfers or replacements are not allowed without approval.</p></li></ul><hr data-start="1917" data-end="1920" /><h5 data-start="1922" data-end="1941">5. <strong data-start="1928" data-end="1941">Deadlines</strong></h5><ul data-start="1942" data-end="2118"><li data-start="1942" data-end="2010"><p data-start="1944" data-end="2010">All registrations must be completed before the announced deadline.</p></li><li data-start="2011" data-end="2118"><p data-start="2013" data-end="2118">Late registrations will not be accepted under any circumstances unless extended by the league organizers.</p></li></ul><hr data-start="2120" data-end="2123" /><h5 data-start="2125" data-end="2163">6. <strong data-start="2131" data-end="2163">Confirmation of Registration</strong></h5><ul data-start="2164" data-end="2400"><li data-start="2164" data-end="2309"><p data-start="2166" data-end="2309">Once the registration form and payment are successfully submitted, participants will receive a confirmation email at their registered email ID.</p></li><li data-start="2310" data-end="2400"><p data-start="2312" data-end="2400">This confirmation serves as proof of registration and must be retained for verification.</p></li></ul><hr data-start="2402" data-end="2405" /><h5 data-start="2407" data-end="2442">7. <strong data-start="2413" data-end="2442">Changes and Cancellations</strong></h5><ul data-start="2443" data-end="2675"><li data-start="2443" data-end="2574"><p data-start="2445" data-end="2574">After confirmation, changes to the registration (e.g., name, team info) must be requested in writing and are subject to approval.</p></li><li data-start="2575" data-end="2675"><p data-start="2577" data-end="2675"><strong data-start="2577" data-end="2608">No refunds will be provided</strong> in case of cancellation by the participant or team for any reason.</p></li></ul><hr data-start="2677" data-end="2680" /><h5 data-start="2682" data-end="2708">8. <strong data-start="2688" data-end="2708">Disqualification</strong></h5><ul data-start="2709" data-end="2930"><li data-start="2709" data-end="2822"><p data-start="2711" data-end="2822">Providing false information or using fake documents will result in immediate disqualification without a refund.</p></li><li data-start="2823" data-end="2930"><p data-start="2825" data-end="2930">Any misconduct or violation of league rules may also lead to suspension or expulsion from the tournament.</p></li></ul><hr data-start="2932" data-end="2935" /><h5 data-start="2937" data-end="2964">9. <strong data-start="2943" data-end="2964">Health and Safety</strong></h5><ul data-start="2965" data-end="3134"><li data-start="2965" data-end="3041"><p data-start="2967" data-end="3041">All participants must ensure they are in good health before participating.</p></li><li data-start="3042" data-end="3134"><p data-start="3044" data-end="3134">The league is not responsible for any injury or health issue arising during participation.</p></li></ul><hr data-start="3136" data-end="3139" /><h5 data-start="3141" data-end="3171">10. <strong data-start="3148" data-end="3171">Contact Information</strong></h5><p data-start="3172" data-end="3314">For queries or registration support, please contact us:<br data-start="3227" data-end="3230" />📧 <strong data-start="3233" data-end="3243">Email:</strong> <a class="cursor-pointer" rel="noopener" data-start="3244" data-end="3258">info@c11cl.com</a><br data-start="3258" data-end="3261" /><br /></p>
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
