<?php
$page_title = "Terms & Conditions";
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
                <p data-start="203" data-end="430">Welcome to our website/service. By accessing or using our website, products, or services, you agree to comply with and be bound by the following terms and conditions. Please read these terms carefully before using our services.</p><hr data-start="432" data-end="435" /><h5 data-start="437" data-end="464">1. Acceptance of Terms</h5><p data-start="465" data-end="700">By using this website or participating in any service or event we offer, you confirm that you accept these Terms &amp; Conditions and agree to comply with them. If you do not agree to these terms, please do not use our website or services.</p><hr data-start="702" data-end="705" /><h5 data-start="707" data-end="726">2. Eligibility</h5><p data-start="727" data-end="979">Our services are intended for users who meet the eligibility requirements as defined for each specific service or event. By registering or participating, you confirm that you meet those eligibility criteria, including any age or residency requirements.</p><hr data-start="981" data-end="984" /><h5 data-start="986" data-end="1023">3. User Account and Registration</h5><ul data-start="1024" data-end="1374"><li data-start="1024" data-end="1099"><p data-start="1026" data-end="1099">You may be required to create an account or register for some services.</p></li><li data-start="1100" data-end="1234"><p data-start="1102" data-end="1234">You agree to provide accurate, current, and complete information during registration and to keep your account information updated.</p></li><li data-start="1235" data-end="1374"><p data-start="1237" data-end="1374">You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p></li></ul><hr data-start="1376" data-end="1379" /><h5 data-start="1381" data-end="1404">4. Use of Services</h5><ul data-start="1405" data-end="1775"><li data-start="1405" data-end="1521"><p data-start="1407" data-end="1521">You agree to use our services only for lawful purposes and in a manner consistent with these Terms &amp; Conditions.</p></li><li data-start="1522" data-end="1684"><p data-start="1524" data-end="1684">You shall not use the website or services to upload, post, or transmit any content that is unlawful, harmful, defamatory, abusive, or otherwise objectionable.</p></li><li data-start="1685" data-end="1775"><p data-start="1687" data-end="1775">You agree not to disrupt or interfere with the security or functionality of the website.</p></li></ul><hr data-start="1777" data-end="1780" /><h5 data-start="1782" data-end="1811">5. Intellectual Property</h5><ul data-start="1812" data-end="2126"><li data-start="1812" data-end="1999"><p data-start="1814" data-end="1999">All content on this website, including text, graphics, logos, images, videos, and software, is owned or licensed by us and protected by copyright and other intellectual property laws.</p></li><li data-start="2000" data-end="2126"><p data-start="2002" data-end="2126">You may not reproduce, distribute, modify, or create derivative works from any content without our prior written permission.</p></li></ul><hr data-start="2128" data-end="2131" /><h5 data-start="2133" data-end="2158">6. Payments and Fees</h5><ul data-start="2159" data-end="2486"><li data-start="2159" data-end="2287"><p data-start="2161" data-end="2287">If applicable, you agree to pay all fees associated with the services you use, including registration or participation fees.</p></li><li data-start="2288" data-end="2377"><p data-start="2290" data-end="2377">Payment terms and refund policies will be clearly stated in relation to each service.</p></li><li data-start="2378" data-end="2486"><p data-start="2380" data-end="2486">Failure to make timely payments may result in suspension or cancellation of your account or participation.</p></li></ul><hr data-start="2488" data-end="2491" /><h5 data-start="2493" data-end="2525">7. Cancellation and Refunds</h5><ul data-start="2526" data-end="2812"><li data-start="2526" data-end="2621"><p data-start="2528" data-end="2621">Our cancellation and refund policies will be provided with the specific services or events.</p></li><li data-start="2622" data-end="2742"><p data-start="2624" data-end="2742">Generally, cancellations must be communicated in writing within the specified timeframe to be eligible for a refund.</p></li><li data-start="2743" data-end="2812"><p data-start="2745" data-end="2812">Certain fees may be non-refundable, as stated in the refund policy.</p></li></ul><hr data-start="2814" data-end="2817" /><h5 data-start="2819" data-end="2854">8. Privacy and Data Protection</h5><ul data-start="2855" data-end="3113"><li data-start="2855" data-end="2935"><p data-start="2857" data-end="2935">We collect and use your personal data in accordance with our Privacy Policy.</p></li><li data-start="2936" data-end="3015"><p data-start="2938" data-end="3015">By using our services, you consent to such collection and use of your data.</p></li><li data-start="3016" data-end="3113"><p data-start="3018" data-end="3113">We take reasonable measures to protect your information but cannot guarantee absolute security.</p></li></ul><hr data-start="3115" data-end="3118" /><h5 data-start="3120" data-end="3151">9. Limitation of Liability</h5><ul data-start="3152" data-end="3481"><li data-start="3152" data-end="3340"><p data-start="3154" data-end="3340">To the fullest extent permitted by law, we shall not be liable for any direct, indirect, incidental, special, or consequential damages arising from your use of the website or services.</p></li><li data-start="3341" data-end="3481"><p data-start="3343" data-end="3481">You participate at your own risk, and we are not responsible for any injuries, losses, or damages resulting from your use of our services.</p></li></ul><hr data-start="3483" data-end="3486" /><h5 data-start="3488" data-end="3512">10. Indemnification</h5><p data-start="3513" data-end="3763">You agree to indemnify, defend, and hold harmless our company, its affiliates, officers, and employees from and against any claims, damages, liabilities, losses, or expenses arising out of your violation of these Terms or your misuse of our services.</p><hr data-start="3765" data-end="3768" /><h5 data-start="3770" data-end="3790">11. Termination</h5><p data-start="3791" data-end="3986">We reserve the right to suspend or terminate your access to our services at any time, without notice, for conduct that we believe violates these Terms or is harmful to other users or the company.</p><hr data-start="3988" data-end="3991" /><h5 data-start="3993" data-end="4032">12. Governing Law and Jurisdiction</h5><p data-start="4033" data-end="4283">These Terms &amp; Conditions shall be governed by and construed in accordance with the laws of the jurisdiction in which our company is registered or operates. Any disputes will be subject to the exclusive jurisdiction of the courts in that jurisdiction.</p><hr data-start="4285" data-end="4288" /><h5 data-start="4290" data-end="4315">13. Changes to Terms</h5><p data-start="4316" data-end="4562">We reserve the right to update or modify these Terms &amp; Conditions at any time. Changes will be posted on this page with an updated revision date. Continued use of the website or services after changes constitutes your acceptance of the new Terms.</p><hr data-start="4564" data-end="4567" /><h5 data-start="4569" data-end="4588">14. Contact Us</h5><p data-start="4589" data-end="4708">If you have any questions or concerns about these Terms &amp; Conditions, please contact us at:<br data-start="4680" data-end="4683" /><strong data-start="4683" data-end="4693">Email:</strong> <a class="cursor-pointer" rel="noopener" data-start="4694" data-end="4708">info@c11cl.com</a></p>
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
