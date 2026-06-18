<?php
// C11CL Global Footer Component — Scoped CSS, matches live production site
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ================================================================
   C11CL FOOTER — Scoped to #c11-site-footer, !important hardened
   to beat WordPress/Astra theme CSS
   ================================================================ */

#c11-site-footer * { box-sizing: border-box !important; }
#c11-site-footer ul, #c11-site-footer ol { list-style: none !important; margin: 0 !important; padding: 0 !important; }
#c11-site-footer a { text-decoration: none !important; }
#c11-site-footer img { display: block !important; }
#c11-site-footer p { margin: 0 !important; padding: 0 !important; }

/* ---- MAIN FOOTER BODY ---- */
#c11-site-footer .c11f-main {
    background: #1a1a1a !important;
    padding: 52px 0 36px !important;
    width: 100% !important;
}
#c11-site-footer .c11f-inner {
    max-width: 1240px !important;
    margin: 0 auto !important;
    padding: 0 24px !important;
    display: grid !important;
    grid-template-columns: 220px 1fr 1fr 1fr !important;
    gap: 40px !important;
    align-items: start !important;
}

/* ---- COL 1: Brand ---- */
#c11-site-footer .c11f-brand {}
#c11-site-footer .c11f-brand-logo {
    display: inline-block !important;
    margin-bottom: 14px !important;
}
#c11-site-footer .c11f-brand-logo img {
    width: 90px !important;
    height: 90px !important;
    object-fit: contain !important;
}
#c11-site-footer .c11f-brand-tagline {
    color: #b0b0b0 !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12.5px !important;
    line-height: 1.6 !important;
    margin-bottom: 20px !important;
}
#c11-site-footer .c11f-social {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    flex-wrap: nowrap !important;
}
#c11-site-footer .c11f-social a {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 34px !important;
    height: 34px !important;
    border-radius: 50% !important;
    background: rgba(255,255,255,0.08) !important;
    color: #cccccc !important;
    font-size: 14px !important;
    transition: background 0.25s, color 0.25s, transform 0.2s !important;
}
#c11-site-footer .c11f-social a:hover {
    background: #dc2618 !important;
    color: #ffffff !important;
    transform: translateY(-2px) !important;
}

/* ---- COLS 2 & 3: Link Columns ---- */
#c11-site-footer .c11f-col-title {
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    letter-spacing: 1.5px !important;
    text-transform: uppercase !important;
    margin-bottom: 18px !important;
    padding-bottom: 10px !important;
    border-bottom: 2px solid #dc2618 !important;
    display: inline-block !important;
}
#c11-site-footer .c11f-links li {
    margin-bottom: 10px !important;
}
#c11-site-footer .c11f-links li a {
    color: #b0b0b0 !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 13px !important;
    font-weight: 400 !important;
    transition: color 0.2s, padding-left 0.2s !important;
    display: inline-block !important;
}
#c11-site-footer .c11f-links li a:hover {
    color: #dc2618 !important;
    padding-left: 6px !important;
}

/* ---- COL 4: Subscribe ---- */
#c11-site-footer .c11f-sub-text {
    color: #b0b0b0 !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12.5px !important;
    line-height: 1.6 !important;
    margin-bottom: 16px !important;
}
#c11-site-footer .c11f-sub-form {
    display: flex !important;
    flex-direction: column !important;
    gap: 10px !important;
}
#c11-site-footer .c11f-sub-form input[type="email"] {
    width: 100% !important;
    padding: 11px 14px !important;
    background: rgba(255,255,255,0.07) !important;
    border: 1px solid rgba(255,255,255,0.15) !important;
    border-radius: 4px !important;
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12.5px !important;
    outline: none !important;
    transition: border-color 0.2s !important;
}
#c11-site-footer .c11f-sub-form input[type="email"]::placeholder { color: #888 !important; }
#c11-site-footer .c11f-sub-form input[type="email"]:focus { border-color: #dc2618 !important; }
#c11-site-footer .c11f-sub-form input[type="submit"] {
    width: 100% !important;
    padding: 11px !important;
    background: #dc2618 !important;
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12.5px !important;
    font-weight: 700 !important;
    letter-spacing: 1.2px !important;
    text-transform: uppercase !important;
    border: none !important;
    border-radius: 4px !important;
    cursor: pointer !important;
    transition: background 0.25s !important;
}
#c11-site-footer .c11f-sub-form input[type="submit"]:hover { background: #b81e10 !important; }

/* ---- BOTTOM BAR ---- */
#c11-site-footer .c11f-bottom {
    background: #dc2618 !important;
    padding: 13px 0 !important;
}
#c11-site-footer .c11f-bottom-inner {
    max-width: 1240px !important;
    margin: 0 auto !important;
    padding: 0 24px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
}
#c11-site-footer .c11f-copy {
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12.5px !important;
    font-weight: 400 !important;
}
#c11-site-footer .c11f-copy a {
    color: #ffffff !important;
    font-weight: 600 !important;
}
#c11-site-footer .c11f-policy-links {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
}
#c11-site-footer .c11f-policy-links a {
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12.5px !important;
    font-weight: 500 !important;
    transition: opacity 0.2s !important;
}
#c11-site-footer .c11f-policy-links a:hover { opacity: 0.8 !important; }
#c11-site-footer .c11f-policy-links span {
    color: rgba(255,255,255,0.6) !important;
    font-size: 12px !important;
}

/* ---- CHAT BUTTON (Chaty-style) ---- */
.c11-chat-btn {
    position: fixed !important;
    bottom: 24px !important;
    right: 24px !important;
    z-index: 99999 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 54px !important;
    height: 54px !important;
    background: #dc2618 !important;
    border-radius: 50% !important;
    box-shadow: 0 4px 20px rgba(220, 38, 24, 0.5) !important;
    cursor: pointer !important;
    text-decoration: none !important;
    transition: transform 0.25s, box-shadow 0.25s !important;
    animation: c11ChatPulse 2.5s infinite !important;
}
.c11-chat-btn:hover {
    transform: scale(1.1) !important;
    box-shadow: 0 6px 28px rgba(220, 38, 24, 0.7) !important;
    animation: none !important;
}
.c11-chat-btn svg {
    width: 26px !important;
    height: 26px !important;
    fill: #ffffff !important;
}
@keyframes c11ChatPulse {
    0%, 100% { box-shadow: 0 4px 20px rgba(220,38,24,0.5); }
    50%       { box-shadow: 0 4px 28px rgba(220,38,24,0.85), 0 0 0 8px rgba(220,38,24,0.12); }
}

/* ---- RESPONSIVE ---- */
@media (max-width: 1024px) {
    #c11-site-footer .c11f-inner {
        grid-template-columns: 200px 1fr 1fr 1fr !important;
        gap: 28px !important;
    }
}
@media (max-width: 768px) {
    #c11-site-footer .c11f-inner {
        grid-template-columns: 1fr 1fr !important;
        gap: 32px !important;
    }
}
@media (max-width: 480px) {
    #c11-site-footer .c11f-inner {
        grid-template-columns: 1fr !important;
        gap: 28px !important;
    }
    #c11-site-footer .c11f-bottom-inner {
        flex-direction: column !important;
        text-align: center !important;
    }
}
</style>

<div id="c11-site-footer">

    <!-- MAIN FOOTER -->
    <div class="c11f-main">
        <div class="c11f-inner">

            <!-- Col 1: Brand -->
            <div class="c11f-brand">
                <a href="<?php echo BASE_URL; ?>" class="c11f-brand-logo" aria-label="C11CL Home">
                    <img src="<?php echo BASE_URL; ?>wp-content/uploads/2025/05/favicon-3.png"
                         alt="C11CL — Champions 11 Cricket League"
                         width="90" height="90">
                </a>
                <p class="c11f-brand-tagline">Stay connected with us – Follow for updates, matches &amp; more!</p>
                <div class="c11f-social">
                    <a href="https://www.facebook.com/profile.php?id=61575926537950" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://x.com/champions11cl" target="_blank" rel="noopener" aria-label="X">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/champions11cricketleague/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.youtube.com/@C11CLOfficial" target="_blank" rel="noopener" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.instagram.com/c11cl_official/" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="c11f-col">
                <div class="c11f-col-title">Quick Links</div>
                <ul class="c11f-links">
                    <li><a href="<?php echo BASE_URL; ?>about-us/">About us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact-us/">Contact Us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>gallery/">Gallery</a></li>
                    <li><a href="<?php echo BASE_URL; ?>insta-feed/">Insta Feed</a></li>
                    <li><a href="<?php echo BASE_URL; ?>selection-process/">Selection Process</a></li>
                    <li><a href="<?php echo BASE_URL; ?>who-can-register/">Who Can Register</a></li>
                </ul>
            </div>

            <!-- Col 3: Useful Links -->
            <div class="c11f-col">
                <div class="c11f-col-title">Useful Links</div>
                <ul class="c11f-links">
                    <li><a href="<?php echo BASE_URL; ?>registration/">Register Now</a></li>
                    <li><a href="<?php echo BASE_URL; ?>payments/">Pay Fee</a></li>
                    <li><a href="<?php echo BASE_URL; ?>careers/">Careers</a></li>
                    <li><a href="<?php echo BASE_URL; ?>news-updates/">News &amp; Update</a></li>
                    <li><a href="<?php echo BASE_URL; ?>testimonials/">Testimonials</a></li>
                    <li><a href="<?php echo BASE_URL; ?>mandatory-documents/">IMP Documents</a></li>
                </ul>
            </div>

            <!-- Col 4: Subscribe -->
            <div class="c11f-col">
                <div class="c11f-col-title">Subscribe Now</div>
                <p class="c11f-sub-text">Don't miss our future updates! Get Subscribed Today!</p>
                <form class="c11f-sub-form" method="POST" action="<?php echo BASE_URL; ?>Panel/email_submit.php">
                    <input type="email" name="email" placeholder="Enter your email address" required>
                    <input type="submit" name="submit" value="SUBSCRIBE NOW">
                </form>
            </div>

        </div>
    </div>

    <!-- BOTTOM BAR -->
    <div class="c11f-bottom">
        <div class="c11f-bottom-inner">
            <p class="c11f-copy">
                &copy; 2026. <a href="<?php echo BASE_URL; ?>">C11CL</a>. All Rights Reserved.
            </p>
            <div class="c11f-policy-links">
                <a href="<?php echo BASE_URL; ?>privacy-policy/">Privacy Policy</a>
                <span>|</span>
                <a href="<?php echo BASE_URL; ?>terms-conditions/">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>

</div><!-- /#c11-site-footer -->

<!-- CHAT BUTTON — matches live site (red circular Chaty-style) -->
<a class="c11-chat-btn" href="https://wa.me/919599505213" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp" title="Chat with us">
    <!-- WhatsApp / chat bubble icon -->
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652c1.746.943 3.71 1.444 5.71 1.447h.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.48-8.45zm-8.477 18.3h-.004c-1.774 0-3.513-.476-5.031-1.378l-.361-.214-3.741.976.997-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.884 9.884zm5.43-7.403c-.297-.149-1.758-.867-2.031-.967-.272-.099-.47-.148-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.57-.085 1.758-.719 2.006-1.413.248-.694.248-1.29.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    </svg>
</a>
