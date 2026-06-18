<?php
$page_title = "Refund Policy";
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
                <p data-start="309" data-end="580">At <strong data-start="312" data-end="343">Champions 11 Cricket League</strong>, we are committed to providing a well-organized and professional cricketing experience to all participants. In order to maintain fairness, transparency, and clarity for everyone involved, we have created the following <strong data-start="562" data-end="579">Refund Policy</strong>.</p><p data-start="582" data-end="652">Please read this policy carefully before completing your registration.</p><hr data-start="654" data-end="657" /><h5 data-start="659" data-end="706"><strong data-start="663" data-end="706">1. No Refund Policy – Strictly Enforced</strong></h5><p data-start="708" data-end="925">Once a player, team, or institution completes the registration and makes a payment for any match, tournament, league, training, or cricketing event organized by <strong data-start="869" data-end="878">C11CL</strong>, the payment is considered <strong data-start="906" data-end="924">non-refundable</strong>.</p><p data-start="927" data-end="1019">There will be <strong data-start="941" data-end="962">no refund of fees</strong> under any circumstances, including (but not limited to):</p><ul data-start="1021" data-end="1226"><li data-start="1021" data-end="1061"><p data-start="1023" data-end="1061">Injury or illness after registration</p></li><li data-start="1062" data-end="1086"><p data-start="1064" data-end="1086">Personal emergencies</p></li><li data-start="1087" data-end="1125"><p data-start="1089" data-end="1125">Change in travel or personal plans</p></li><li data-start="1126" data-end="1159"><p data-start="1128" data-end="1159">Player or team unavailability</p></li><li data-start="1160" data-end="1186"><p data-start="1162" data-end="1186">Weather-related issues</p></li><li data-start="1187" data-end="1226"><p data-start="1189" data-end="1226">Failure to attend matches or events</p></li></ul><p data-start="1228" data-end="1433">All registration fees are used immediately for the preparation and planning of the event, including ground booking, event management, technical arrangements, jerseys, logistics, staff, and other resources.</p><hr data-start="1435" data-end="1438" /><h5 data-start="1440" data-end="1474"><strong data-start="1444" data-end="1474">2. Non-Refundable Services</strong></h5><p data-start="1476" data-end="1627">In addition to tournament or match registration, <strong data-start="1525" data-end="1627">any charges paid for kits, jerseys, services, sponsorships, or promotions are also non-refundable.</strong></p><p data-start="1629" data-end="1769">Once these services are confirmed or delivered, the cost will not be returned even if the event is canceled or if the participant withdraws.</p><hr data-start="1771" data-end="1774" /><h5 data-start="1776" data-end="1834"><strong data-start="1780" data-end="1834">3. Rescheduling Instead of Refunds (If Applicable)</strong></h5><p data-start="1836" data-end="2030">If an event is canceled or postponed by <strong data-start="1876" data-end="1885">C11CL</strong> due to <strong data-start="1893" data-end="1921">unforeseen circumstances</strong> (like heavy rain, natural disaster, government restrictions, or venue issues), we will make every effort to:</p><ul data-start="2032" data-end="2177"><li data-start="2032" data-end="2072"><p data-start="2034" data-end="2072">Reschedule the event to a later date</p></li><li data-start="2073" data-end="2111"><p data-start="2075" data-end="2111">Inform all participants in advance</p></li><li data-start="2112" data-end="2177"><p data-start="2114" data-end="2177">Maintain your existing registration for the rescheduled event</p></li></ul><p data-start="2179" data-end="2276">However, <strong data-start="2188" data-end="2219">no refund will be processed</strong>, even if you are unable to attend the rescheduled event.</p><hr data-start="2278" data-end="2281" /><h5 data-start="2283" data-end="2315"><strong data-start="2287" data-end="2315">4. Registration Is Final</strong></h5><p data-start="2317" data-end="2412">Please double-check all information and ensure your availability before completing any payment.</p><ul data-start="2414" data-end="2558"><li data-start="2414" data-end="2471"><p data-start="2416" data-end="2471">All registrations are <strong data-start="2438" data-end="2468">final and non-transferable</strong>.</p></li><li data-start="2472" data-end="2558"><p data-start="2474" data-end="2558">You cannot transfer your spot to another player or team member once payment is made.</p></li></ul><hr data-start="2560" data-end="2563" /><h5 data-start="2565" data-end="2595"><strong data-start="2569" data-end="2595">5. Contact Information</strong></h5><p data-start="2597" data-end="2757">We are here to support you and answer any questions before you register. For any queries related to refunds, registrations, or policies, please reach out to us:</p><p data-start="2759" data-end="2862">📧 <strong data-start="2762" data-end="2772">Email:</strong> <a class="cursor-pointer" rel="noopener" data-start="2773" data-end="2787">info@c11cl.com</a><br data-start="2787" data-end="2790" /><br /></p><hr data-start="2864" data-end="2867" /><h5 data-start="2869" data-end="2887"><strong data-start="2873" data-end="2887">Conclusion</strong></h5><p data-start="2889" data-end="3141">This <strong data-start="2894" data-end="2914">No Refund Policy</strong> helps us ensure the smooth execution of our cricketing events and promotes fairness for all stakeholders involved. We value your trust and participation, and we request your cooperation and understanding regarding this policy.</p>
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
