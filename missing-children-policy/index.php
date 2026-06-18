<?php
$page_title = "Missing Children Policy";
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
                <p data-start="204" data-end="433">At Champions 11 Cricket League, the safety and well-being of all children involved in our cricket league is our top priority. This policy outlines the steps we will take if a child goes missing during any event, match, or league activity.</p><hr data-start="435" data-end="438" /><h5 data-start="440" data-end="467"><strong data-start="444" data-end="467">1. Immediate Action</strong></h5><p data-start="468" data-end="496">If a child is found missing:</p><ul data-start="497" data-end="745"><li data-start="497" data-end="582"><p data-start="499" data-end="582">The area will be searched immediately by staff, volunteers, and responsible adults.</p></li><li data-start="583" data-end="694"><p data-start="585" data-end="694">One person will inform the ground security and local authorities if the child is not found within 10 minutes.</p></li><li data-start="695" data-end="745"><p data-start="697" data-end="745">Other children will be kept safe and supervised.</p></li></ul><hr data-start="747" data-end="750" /><h5 data-start="752" data-end="776"><strong data-start="756" data-end="776">2. Communication</strong></h5><ul data-start="777" data-end="1026"><li data-start="777" data-end="829"><p data-start="779" data-end="829">Parents or guardians will be contacted right away.</p></li><li data-start="830" data-end="945"><p data-start="832" data-end="945">A clear description of the child (clothes, age, last seen location) will be shared with all staff and volunteers.</p></li><li data-start="946" data-end="1026"><p data-start="948" data-end="1026">The incident will be reported to the police if the child is not found quickly.</p></li></ul><hr data-start="1028" data-end="1031" /><h5 data-start="1033" data-end="1060"><strong data-start="1037" data-end="1060">3. Search Procedure</strong></h5><ul data-start="1061" data-end="1271"><li data-start="1061" data-end="1151"><p data-start="1063" data-end="1151">Nearby areas such as restrooms, tents, stands, and parking zones will be searched first.</p></li><li data-start="1152" data-end="1194"><p data-start="1154" data-end="1194">Entry and exit points will be monitored.</p></li><li data-start="1195" data-end="1271"><p data-start="1197" data-end="1271">All staff will stop their regular duties and assist in locating the child.</p></li></ul><hr data-start="1273" data-end="1276" /><h5 data-start="1278" data-end="1312"><strong data-start="1282" data-end="1312">4. When the Child is Found</strong></h5><ul data-start="1313" data-end="1521"><li data-start="1313" data-end="1352"><p data-start="1315" data-end="1352">The child’s safety will be confirmed.</p></li><li data-start="1353" data-end="1405"><p data-start="1355" data-end="1405">Parents or guardians will be immediately informed.</p></li><li data-start="1406" data-end="1463"><p data-start="1408" data-end="1463">The incident will be reviewed to prevent future issues.</p></li><li data-start="1464" data-end="1521"><p data-start="1466" data-end="1521">Emotional support will be given to the child if needed.</p></li></ul><hr data-start="1523" data-end="1526" /><h5 data-start="1528" data-end="1558"><strong data-start="1532" data-end="1558">5. Prevention Measures</strong></h5><ul data-start="1559" data-end="1857"><li data-start="1559" data-end="1640"><p data-start="1561" data-end="1640">Children must always be accompanied by a parent/guardian or assigned volunteer.</p></li><li data-start="1641" data-end="1713"><p data-start="1643" data-end="1713">Entry passes or ID tags will be provided to children during the event.</p></li><li data-start="1714" data-end="1784"><p data-start="1716" data-end="1784">Regular headcounts will be conducted by team managers or volunteers.</p></li><li data-start="1785" data-end="1857"><p data-start="1787" data-end="1857">Staff and volunteers will be trained on how to handle such situations.</p></li></ul><hr data-start="1859" data-end="1862" /><h5 data-start="1864" data-end="1902"><strong data-start="1868" data-end="1902">6. Reporting and Documentation</strong></h5><ul data-start="1903" data-end="2042"><li data-start="1903" data-end="1958"><p data-start="1905" data-end="1958">A written report will be prepared and kept on record.</p></li><li data-start="1959" data-end="2042"><p data-start="1961" data-end="2042">The incident will be discussed in the next committee meeting for better planning.</p></li></ul><hr data-start="2044" data-end="2047" /><h5 data-start="2049" data-end="2071"><strong data-start="2053" data-end="2071">Our Commitment</strong></h5><p data-start="2072" data-end="2255">We are committed to creating a safe and secure environment for all children. We request parents, guardians, and team staff to stay alert and follow our safety guidelines at all times.</p>
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
