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
    background: #000000  !important;
    padding: 52px 0 36px !important;
    width: 100% !important;
}
#c11-site-footer .c11f-inner {
    max-width: 1400px  !important;
    margin: 0 auto !important;
    padding: 0 24px !important;
    display: grid !important;
   grid-template-columns: 250px 1fr 1fr 1fr !important;
gap: 70px !important;
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
    font-size: 15px !important;
font-weight: 800 !important;
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
    padding: 18px 0 !important;
}
#c11-site-footer .c11f-bottom-inner {
    max-width: 1400px  !important;
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

/* ---- CUSTOM CHATY WIDGET (Multi-channel) ---- */
#c11-connect-widget {
    position: fixed !important;
    bottom: 24px !important;
    right: 24px !important;
    top: auto !important;
    left: auto !important;
    transform: none !important;
    height: auto !important;
    z-index: 999999 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    gap: 12px !important;
    font-family: 'Poppins', sans-serif !important;
}

/* Trigger Button */
.c11-widget-trigger {
    width: 54px !important;
    height: 54px !important;
    background: #dc2618 !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #ffffff !important;
    cursor: pointer !important;
    box-shadow: 0 4px 20px rgba(220, 38, 24, 0.5) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    border: none !important;
    outline: none !important;
    animation: c11WidgetPulse 2.5s infinite !important;
}
.c11-widget-trigger:hover {
    transform: scale(1.08) !important;
    box-shadow: 0 6px 28px rgba(220, 38, 24, 0.7) !important;
    animation: none !important;
}
.c11-widget-trigger i {
    font-size: 22px !important;
    transition: transform 0.3s ease !important;
}

/* Channels Container (Pill) */
.c11-widget-channels {
    background: #1e1e1e !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    border-radius: 30px !important;
    padding: 12px 8px !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 10px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transform: translateY(20px) scale(0.9) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    pointer-events: none !important;
}

#c11-connect-widget.c11-widget-open .c11-widget-channels {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) scale(1) !important;
    pointer-events: auto !important;
}

#c11-connect-widget.c11-widget-open .c11-widget-trigger {
    display: none !important;
}

/* Individual Channel Icons */
.c11-channel-btn {
    width: 42px !important;
    height: 42px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #ffffff !important;
    font-size: 18px !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    position: relative !important;
    border: none !important;
    cursor: pointer !important;
    text-decoration: none !important;
}
.c11-channel-btn:hover {
    transform: scale(1.1) !important;
}

/* Channel Backgrounds */
.c11-channel-btn.youtube { background: #ff0000 !important; box-shadow: 0 3px 10px rgba(255, 0, 0, 0.3) !important; }
.c11-channel-btn.instagram { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%) !important; box-shadow: 0 3px 10px rgba(220, 39, 67, 0.3) !important; }
.c11-channel-btn.email { background: #ff4757 !important; box-shadow: 0 3px 10px rgba(255, 71, 87, 0.3) !important; }
.c11-channel-btn.whatsapp { background: #25d366 !important; box-shadow: 0 3px 10px rgba(37, 211, 102, 0.3) !important; }
.c11-channel-btn.call { background: #007aff !important; box-shadow: 0 3px 10px rgba(0, 122, 255, 0.3) !important; }
.c11-channel-btn.close-btn { background: #dc2618 !important; box-shadow: 0 3px 10px rgba(220, 38, 24, 0.3) !important; }

/* Tooltip on hover */
.c11-channel-btn::after {
    content: attr(data-tooltip) !important;
    position: absolute !important;
    right: 56px !important;
    top: 50% !important;
    transform: translateY(-50%) scale(0.8) !important;
    background: #1e1e1e !important;
    color: #ffffff !important;
    font-size: 11px !important;
    font-weight: 500 !important;
    padding: 4px 8px !important;
    border-radius: 4px !important;
    white-space: nowrap !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: all 0.2s ease !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2) !important;
    pointer-events: none !important;
}
.c11-channel-btn:hover::after {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(-50%) scale(1) !important;
}

@keyframes c11WidgetPulse {
    0%, 100% { box-shadow: 0 4px 20px rgba(220,38,24,0.5); }
    50%       { box-shadow: 0 4px 28px rgba(220,38,24,0.85), 0 0 0 8px rgba(220,38,24,0.12); }
}

/* ---- RESPONSIVE ---- */
@media (max-width: 1024px) {
    #c11-site-footer .c11f-inner {
        grid-template-columns: 200px 1fr 1fr !important;
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

            <!-- Col 2: Useful Links -->
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

            <!-- Col 3: Quick Links + Subscribe stacked (matches live site right column) -->
            <div class="c11f-col">
                <div class="c11f-col-title">Quick Links</div>
                <ul class="c11f-links" style="margin-bottom:32px!important;">
                    <li><a href="<?php echo BASE_URL; ?>about-us/">About us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact-us/">Contact Us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>gallery/">Gallery</a></li>
                    <li><a href="<?php echo BASE_URL; ?>insta-feed/">Insta Feed</a></li>
                    <li><a href="<?php echo BASE_URL; ?>selection-process/">Selection Process</a></li>
                    <li><a href="<?php echo BASE_URL; ?>who-can-register/">Who Can Register</a></li>
                </ul>

                <div class="c11f-col-title">Subscribe Now</div>
                <p class="c11f-sub-text">Don't miss our future updates! Get Subscribed Today!</p>
                <form class="c11f-sub-form" method="POST" action="/email_subscribe.php">
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

<!-- MULTI-CHANNEL CONNECT WIDGET -->
<div class="c11-chat-widget-wrapper">
    
    <div class="chat-channels-vertical-flyout">
        <a href="https://www.youtube.com/@C11CLOfficial" target="_blank" rel="noopener" class="chat-channel-item youtube" aria-label="Subscribe on YouTube" title="YouTube">
            <i class="bi bi-youtube"></i>
        </a>
        <a href="https://www.instagram.com/c11cl_official/" target="_blank" rel="noopener" class="chat-channel-item instagram" aria-label="Follow on Instagram" title="Instagram">
            <i class="bi bi-instagram"></i>
        </a>
        <a href="mailto:info@c11cl.com?subject=Cricket%20Trials%20Enquiry" class="chat-channel-item email" aria-label="Send Email" title="Email">
            <i class="bi bi-envelope-fill"></i>
        </a>
        <a href="https://wa.me/919599505213?text=Hi%20C11CL,%20I%20have%20an%20enquiry%20regarding%20the%20cricket%20trials." target="_blank" rel="noopener" class="chat-channel-item whatsapp" aria-label="WhatsApp Chat" title="WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
        <a href="tel:+919599505213" class="chat-channel-item call" aria-label="Call Support" title="Call Us">
            <i class="bi bi-telephone-fill"></i>
        </a>
    </div>

    <button class="chat-trigger-badge" onclick="toggleChatWidget()" aria-label="Toggle Custom Support Options">
        <i class="bi bi-chat-dots-fill main-icon"></i>
        <i class="bi bi-x-lg close-icon"></i>
        <span class="chat-pulse-ring"></span>
    </button>
</div>

<style>
    /* ================= CORE POSITIONING ROOT ================= */
    .c11-chat-widget-wrapper {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        font-family: 'Poppins', sans-serif;
    }

    /* ================= PRIMARY CHAT BUTTON STYLES ================= */
    .chat-trigger-badge {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #F2281F, #BA0F07);
        border: none;
        border-radius: 50%;
        color: #ffffff;
        font-size: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(242, 40, 31, 0.4);
        position: relative;
        z-index: 10;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        outline: none;
    }
    
    .chat-trigger-badge .close-icon {
        display: none;
        font-size: 22px;
    }

    /* Dynamic Pulse Ring Effect */
    .chat-trigger-badge .chat-pulse-ring {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        border: 2px solid #F2281F;
        border-radius: 50%;
        box-sizing: border-box;
        animation: chatWidgetPulse 2s infinite ease-out;
        pointer-events: none;
        z-index: -1;
    }

    /* ================= VERTICAL PORTRAIT CHANNELS PANEL ================= */
    .chat-channels-vertical-flyout {
        display: flex;
        flex-direction: column;
        gap: 12px;
        position: absolute;
        bottom: 75px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px) scale(0.8);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: rgba(10, 13, 18, 0.88);
        padding: 12px 10px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
    }

    /* ================= HOVER INTERACTION TRIGGER ENGINE (DESKTOP) ================= */
    @media (min-width: 992px) {
        .c11-chat-widget-wrapper:hover .chat-channels-vertical-flyout {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        .c11-chat-widget-wrapper:hover .chat-trigger-badge {
            transform: scale(1.05);
            background: linear-gradient(135deg, #FF3B30, #D6110A);
            box-shadow: 0 10px 30px rgba(242, 40, 31, 0.6);
        }
        .c11-chat-widget-wrapper:hover .chat-trigger-badge .main-icon { display: none; }
        .c11-chat-widget-wrapper:hover .chat-trigger-badge .close-icon { display: block; }
        .c11-chat-widget-wrapper:hover .chat-trigger-badge .chat-pulse-ring { display: none; }
    }

    /* ================= ACTIVE STATE TRIGGER ENGINE (MOBILE / CLICK) ================= */
    .c11-chat-widget-wrapper.active-widget .chat-channels-vertical-flyout {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }
    .c11-chat-widget-wrapper.active-widget .chat-trigger-badge {
        background: linear-gradient(135deg, #FF3B30, #D6110A);
    }
    .c11-chat-widget-wrapper.active-widget .chat-trigger-badge .main-icon { display: none; }
    .c11-chat-widget-wrapper.active-widget .chat-trigger-badge .close-icon { display: block; }
    .c11-chat-widget-wrapper.active-widget .chat-trigger-badge .chat-pulse-ring { display: none; }

    /* ================= INDEPENDENT ICON ITEM STYLES ================= */
    .chat-channel-item {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #ffffff !important;
        font-size: 19px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        position: relative;
    }

    .chat-channel-item:hover {
        transform: scale(1.15);
    }

    /* Tooltip styling */
    .chat-channel-item::after {
        content: attr(title);
        position: absolute;
        right: 55px;
        top: 50%;
        transform: translateY(-50%);
        background: #111;
        color: #fff;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s;
        font-family: Poppins, sans-serif;
    }
    .chat-channel-item:hover::after {
        opacity: 1;
    }

    /* Brand Colors Definition Mapping */
    .chat-channel-item.call { background: #34b7f1; }
    .chat-channel-item.whatsapp { background: #25D366; }
    .chat-channel-item.email { background: #ea4335; }
    .chat-channel-item.instagram { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
    .chat-channel-item.youtube { background: #ff0000; }

    /* ================= SYSTEM KEYFRAME ANIMATIONS ================= */
    @keyframes chatWidgetPulse {
        0% { transform: scale(1); opacity: 1; }
        50% { opacity: 0.5; }
        100% { transform: scale(1.4); opacity: 0; }
    }

    /* ================= MOBILE VIEWBREAK ADJUSTMENTS ================= */
    @media (max-width: 768px) {
        .c11-chat-widget-wrapper {
            bottom: 25px;
            right: 25px;
            gap: 10px;
        }
        .chat-trigger-badge {
            width: 54px;
            height: 54px;
            font-size: 22px;
        }
        .chat-trigger-badge .close-icon { font-size: 18px; }
        .chat-channels-vertical-flyout {
            bottom: 65px;
            padding: 10px 8px;
            gap: 10px;
        }
        .chat-channel-item {
            width: 40px;
            height: 40px;
            font-size: 17px;
        }
        .chat-channel-item::after {
            display: none !important;
        }
    }
</style>

<script>
    function toggleChatWidget() {
        const widgetContainer = document.querySelector('.c11-chat-widget-wrapper');
        if (widgetContainer) {
            widgetContainer.classList.toggle('active-widget');
        }
    }

    // Auto close menu context drawer when user touches overlay areas outside container target limits
    window.addEventListener('click', function(event) {
        const widgetWrapper = document.querySelector('.c11-chat-widget-wrapper');
        if (widgetWrapper && !widgetWrapper.contains(event.target)) {
            widgetWrapper.classList.remove('active-widget');
        }
    });

    // Asynchronous Footer Newsletter Subscription Handler
    document.addEventListener('DOMContentLoaded', function() {
        const subForm = document.querySelector('.c11f-sub-form');
        if (subForm) {
            subForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const emailInput = subForm.querySelector('input[type="email"]');
                const submitBtn = subForm.querySelector('input[type="submit"]');
                const originalVal = submitBtn.value;
                
                submitBtn.value = 'SUBSCRIBING...';
                submitBtn.disabled = true;
                
                const formData = new FormData();
                formData.append('email', emailInput.value);
                formData.append('submit', '1');
                formData.append('ajax', '1');
                
                fetch('/email_subscribe.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    submitBtn.value = originalVal;
                    submitBtn.disabled = false;
                    if (data.status === 'success') {
                        emailInput.value = '';
                        Swal.fire({
                            icon: 'success',
                            title: 'Subscribed! 📩',
                            text: data.message || 'You have successfully subscribed to C11CL updates.',
                            confirmButtonColor: '#dc2618'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Subscription Failed',
                            text: data.message || 'Something went wrong. Please try again.',
                            confirmButtonColor: '#dc2618'
                        });
                    }
                })
                .catch(err => {
                    submitBtn.value = originalVal;
                    submitBtn.disabled = false;
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Connection Error',
                        text: 'Unable to connect to the server. Please try again.',
                        confirmButtonColor: '#dc2618'
                    });
                });
            });
        }
    });
</script>
