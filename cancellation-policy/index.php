<?php
$page_title = "Cancellation Policy";
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
                <p data-start="310" data-end="773">At <strong data-start="313" data-end="352">Champions 11 Cricket League (C11CL)</strong>, we aim to provide a highly organized, enjoyable, and competitive cricketing platform for players of all levels. To ensure fairness, consistency, and clarity in the management of all our events and programs, we have created the following <strong data-start="591" data-end="614">Cancellation Policy</strong>. This policy applies to all individuals, teams, and institutions registering for any match, league, tournament, coaching session, or event organized by C11CL.</p><hr data-start="775" data-end="778" /><h5 data-start="780" data-end="807"><strong data-start="784" data-end="807">1. No Refund Policy</strong></h5><p data-start="809" data-end="863">We would like to clearly inform all participants that:</p><ul data-start="865" data-end="1156"><li data-start="865" data-end="996"><p data-start="867" data-end="996"><strong data-start="867" data-end="968">Once a registration is completed, no cancellation will be accepted and no refund will be provided</strong>, under any circumstances.</p></li><li data-start="997" data-end="1156"><p data-start="999" data-end="1156">This includes personal situations such as illness, injury, travel issues, change of plans, or any other reason that may prevent a participant from attending.</p></li></ul><p data-start="1158" data-end="1385">As we operate with pre-booked grounds, umpiring staff, event management, and logistics arrangements, your registration fee goes into immediate planning and execution. Hence, <strong data-start="1332" data-end="1384">no amount will be refunded once a spot is booked</strong>.</p><hr data-start="1387" data-end="1390" /><h5 data-start="1392" data-end="1445"><strong data-start="1396" data-end="1445">2. Cancellation or Rescheduling by Organizers</strong></h5><p data-start="1447" data-end="1648">Although we strive to conduct every match and event as per the announced schedule, unforeseen conditions may arise. In such cases, <strong data-start="1578" data-end="1637">C11CL reserves the right to cancel or postpone an event</strong>, based on:</p><ul data-start="1650" data-end="1859"><li data-start="1650" data-end="1706"><p data-start="1652" data-end="1706">Extreme weather conditions (e.g., heavy rain, storm)</p></li><li data-start="1707" data-end="1743"><p data-start="1709" data-end="1743">Ground or venue technical issues</p></li><li data-start="1744" data-end="1788"><p data-start="1746" data-end="1788">Government guidelines or safety concerns</p></li><li data-start="1789" data-end="1859"><p data-start="1791" data-end="1859">Force majeure situations (unavoidable natural or man-made disasters)</p></li></ul><p data-start="1861" data-end="1876">In such events:</p><ul data-start="1878" data-end="2155"><li data-start="1878" data-end="2057"><p data-start="1880" data-end="2057">The match/tournament will be <strong data-start="1909" data-end="1938">rescheduled to a new date</strong>, and all participants will be informed in advance through official communication (email, WhatsApp, website updates).</p></li><li data-start="2058" data-end="2155"><p data-start="2060" data-end="2155"><strong data-start="2060" data-end="2154">No refunds will be given even if the participant is unable to attend the rescheduled event</strong>.</p></li></ul><p data-start="2157" data-end="2295">We request your cooperation and understanding in such scenarios, as these decisions are taken with everyone’s safety and fairness in mind.</p><hr data-start="2297" data-end="2300" /><h5 data-start="2302" data-end="2355"><strong data-start="2306" data-end="2355">3. Registration is Final and Non-Transferable</strong></h5><p data-start="2357" data-end="2400">Once you complete the registration process:</p><ul data-start="2402" data-end="2533"><li data-start="2402" data-end="2441"><p data-start="2404" data-end="2441">Your entry is <strong data-start="2418" data-end="2438">non-transferable</strong>.</p></li><li data-start="2442" data-end="2533"><p data-start="2444" data-end="2533">You <strong data-start="2448" data-end="2499">cannot pass your spot to another player or team</strong>, even if you&#8217;re unable to attend.</p></li></ul><p data-start="2535" data-end="2629">This ensures that all records, fixtures, and team structures remain consistent and manageable.</p><hr data-start="2631" data-end="2634" /><h5 data-start="2636" data-end="2680"><strong data-start="2640" data-end="2680">4. Responsibility of the Participant</strong></h5><p data-start="2682" data-end="2719">All participants are responsible for:</p><ul data-start="2721" data-end="2962"><li data-start="2721" data-end="2782"><p data-start="2723" data-end="2782"><strong data-start="2723" data-end="2779">Double-checking your availability before registering</strong>.</p></li><li data-start="2783" data-end="2865"><p data-start="2785" data-end="2865">Staying updated on all communications and announcements related to your event.</p></li><li data-start="2866" data-end="2962"><p data-start="2868" data-end="2962">Joining pre-event meetings or briefings, if announced, to stay aligned with rules and updates.</p></li></ul><p data-start="2964" data-end="3095">You can always reach out to us for clarification, but <strong data-start="3018" data-end="3094">C11CL is not liable for missed information due to participant negligence</strong>.</p><hr data-start="3097" data-end="3100" /><h5 data-start="3102" data-end="3130"><strong data-start="3106" data-end="3130">5. How to Contact Us</strong></h5><p data-start="3132" data-end="3223">If you have questions or need support regarding this policy, feel free to contact our team:</p><p data-start="3225" data-end="3327">📧 <strong data-start="3228" data-end="3238">Email:</strong> <a class="cursor-pointer" rel="noopener" data-start="3239" data-end="3253">info@c11cl.com</a></p><p data-start="3329" data-end="3390">We are always here to help and guide you before you register.</p><hr data-start="3392" data-end="3395" /><h5 data-start="3397" data-end="3415"><strong data-start="3401" data-end="3415">Conclusion</strong></h5><p data-start="3417" data-end="3674">We encourage all players and teams to register only when they are fully committed and confident of their availability. Our events require pre-planning and financial investments, and we expect participants to understand the seriousness of their registration.</p><p data-start="3676" data-end="3853">This Cancellation Policy has been created to maintain the integrity of the league and to ensure fairness for everyone involved — organizers, players, sponsors, and ground staff.</p>
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
