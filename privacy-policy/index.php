<?php
$page_title = "Privacy Policy";
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
                <p data-start="145" data-end="393">At Champions 11 Cricket League , we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, share, and protect the information you provide when you use our website or interact with us.</p><hr data-start="395" data-end="398" /><h5 data-start="400" data-end="433"><strong data-start="404" data-end="433">1. Information We Collect</strong></h5><p data-start="435" data-end="485">We may collect the following types of information:</p><ul data-start="487" data-end="852"><li data-start="487" data-end="622"><p data-start="489" data-end="622"><strong data-start="489" data-end="514">Personal Information:</strong> Name, email address, phone number, date of birth, and address (if provided during registration or contact).</p></li><li data-start="623" data-end="746"><p data-start="625" data-end="746"><strong data-start="625" data-end="647">Usage Information:</strong> Your interaction with our website such as page visits, time spent, IP address, and device details.</p></li><li data-start="747" data-end="852"><p data-start="749" data-end="852"><strong data-start="749" data-end="769">Media &amp; Content:</strong> Photos or videos uploaded by participants or during matches/events (with consent).</p></li></ul><hr data-start="854" data-end="857" /><h5 data-start="859" data-end="897"><strong data-start="863" data-end="897">2. How We Use Your Information</strong></h5><p data-start="899" data-end="936">We use the information we collect to:</p><ul data-start="938" data-end="1205"><li data-start="938" data-end="981"><p data-start="940" data-end="981">Register and manage player/team profiles.</p></li><li data-start="982" data-end="1033"><p data-start="984" data-end="1033">Send updates about matches, schedules, or events.</p></li><li data-start="1034" data-end="1075"><p data-start="1036" data-end="1075">Improve user experience on the website.</p></li><li data-start="1076" data-end="1114"><p data-start="1078" data-end="1114">Respond to your queries or feedback.</p></li><li data-start="1115" data-end="1205"><p data-start="1117" data-end="1205">Promote events (with your consent for using any media or personal information publicly).</p></li></ul><hr data-start="1207" data-end="1210" /><h5 data-start="1212" data-end="1247"><strong data-start="1216" data-end="1247">3. Sharing Your Information</strong></h5><p data-start="1249" data-end="1347">We do <strong data-start="1255" data-end="1262">not</strong> sell or rent your personal information to anyone. Your data may only be shared with:</p><ul data-start="1349" data-end="1464"><li data-start="1349" data-end="1409"><p data-start="1351" data-end="1409">League organizers or partners, for official communication.</p></li><li data-start="1410" data-end="1464"><p data-start="1412" data-end="1464">Government or legal authorities, if required by law.</p></li></ul><hr data-start="1466" data-end="1469" /><h5 data-start="1471" data-end="1510"><strong data-start="1475" data-end="1510">4. Security of Your Information</strong></h5><p data-start="1512" data-end="1745">We follow standard security practices to protect your personal information. However, no method of online data transmission or storage is 100% secure. We recommend you keep your login credentials safe and don’t share them with others.</p><hr data-start="1747" data-end="1750" /><h5 data-start="1752" data-end="1781"><strong data-start="1756" data-end="1781">5. Cookies &amp; Tracking</strong></h5><p data-start="1783" data-end="1898">Our website may use cookies to enhance your experience. You can choose to disable cookies in your browser settings.</p><hr data-start="1900" data-end="1903" /><h5 data-start="1905" data-end="1933"><strong data-start="1909" data-end="1933">6. Third-Party Links</strong></h5><p data-start="1935" data-end="2109">Our website may contain links to external websites. We are not responsible for their privacy policies. We advise you to read the policies of those websites if you visit them.</p><hr data-start="2111" data-end="2114" /><h5 data-start="2116" data-end="2138"><strong data-start="2120" data-end="2138">7. Your Rights</strong></h5><p data-start="2140" data-end="2148">You can:</p><ul data-start="2150" data-end="2284"><li data-start="2150" data-end="2197"><p data-start="2152" data-end="2197">Request access to the data we have about you.</p></li><li data-start="2198" data-end="2247"><p data-start="2200" data-end="2247">Ask us to correct or delete your personal data.</p></li><li data-start="2248" data-end="2284"><p data-start="2250" data-end="2284">Withdraw your consent at any time.</p></li></ul><hr data-start="2286" data-end="2289" /><h5 data-start="2291" data-end="2324"><strong data-start="2295" data-end="2324">8. Changes to This Policy</strong></h5><p data-start="2326" data-end="2431">We may update this Privacy Policy as needed. Any changes will be posted on this page with a revised date.</p><hr data-start="2433" data-end="2436" /><h5 data-start="2438" data-end="2459"><strong data-start="2442" data-end="2459">9. Contact Us</strong></h5><p data-start="2461" data-end="2573">If you have any questions about this Privacy Policy or want to exercise your rights, feel free to contact us at:</p><p data-start="2575" data-end="2625">📧info@c11cl.com</p>
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
