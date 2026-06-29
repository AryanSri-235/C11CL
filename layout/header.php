<?php
// C11CL Global Header Component — Scoped, !important-hardened for compatibility with WordPress/Astra themes
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
/* ================================================================
   C11CL HEADER — All rules scoped to #c11-site-header or 
   prefixed with !important to beat WordPress/Astra theme CSS
   ================================================================ */

#c11-site-header * { box-sizing: border-box !important; }
#c11-site-header ul, #c11-site-header ol { list-style: none !important; margin: 0 !important; padding: 0 !important; }
#c11-site-header a { text-decoration: none !important; }
#c11-site-header img { display: block !important; }

/* ---- TOP BAR ---- */
#c11-site-header .c11h-topbar {
    background: #dc2618 !important;
    border-bottom: 1px solid #b81e10 !important;
    padding: 6px 0 !important;
    width: 100% !important;
}
#c11-site-header .c11h-topbar-inner {
    max-width: 1240px !important;
    margin: 0 auto !important;
    padding: 0 24px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 16px !important;
}
#c11-site-header .c11h-contact {
    display: flex !important;
    align-items: center !important;
    gap: 20px !important;
}
#c11-site-header .c11h-contact li a {
    color: #ffffff !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12.5px !important;
    font-weight: 400 !important;
    display: flex !important;
    align-items: center !important;
    gap: 7px !important;
    transition: color 0.2s !important;
    white-space: nowrap !important;
}
#c11-site-header .c11h-contact li a:hover { color: rgba(255, 255, 255, 0.85) !important; }
#c11-site-header .c11h-contact li a i { color: #ffffff !important; font-size: 11px !important; }

#c11-site-header .c11h-social {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
}
#c11-site-header .c11h-social li a {
    color: #ffffff !important;
    font-size: 14px !important;
    width: 28px !important;
    height: 28px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50% !important;
    transition: color 0.2s, background 0.2s !important;
}
#c11-site-header .c11h-social li a:hover {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.2) !important;
}

/* ---- MAIN NAV ---- */
#c11-site-header .c11h-navbar {
    background: #1e1e1e !important;
    width: 100% !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 9999 !important;
    box-shadow: 0 2px 12px rgba(0,0,0,0.55) !important;
}
#c11-site-header .c11h-navbar-inner {
    max-width: 1240px !important;
    margin: 0 auto !important;
    padding: 0 20px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    height: 70px !important;
    gap: 12px !important;
}

/* Logo */
#c11-site-header .c11h-logo {
    display: flex !important;
    align-items: center !important;
    flex-shrink: 0 !important;
}
#c11-site-header .c11h-logo img {
    height: 58px !important;
    width: 58px !important;
    object-fit: contain !important;
    display: block !important;
    filter: drop-shadow(0 2px 6px rgba(0,0,0,0.35)) !important;
    transition: transform 0.3s ease !important;
}
#c11-site-header .c11h-logo:hover img { transform: scale(1.06) !important; }

/* Nav List */
#c11-site-header .c11h-nav {
    display: flex !important;
    align-items: center !important;
    gap: 2px !important;
    flex: 1 !important;
    justify-content: center !important;
    flex-wrap: nowrap !important;
}
#c11-site-header .c11h-nav > li { position: relative !important; transition: transform 0.25s cubic-bezier(0.165, 0.84, 0.44, 1) !important; }
#c11-site-header .c11h-nav > li:hover,
#c11-site-header .c11h-nav > li:focus-within {
    z-index: 999999 !important;
}
#c11-site-header .c11h-nav > li > a {
    display: flex !important;
    align-items: center !important;
    gap: 4px !important;
    color: #e0e0e0 !important;
    font-family: 'Barlow Condensed', sans-serif !important;
    font-size: 16px !important;
    font-weight: 800 !important;
    letter-spacing: 1.2px !important;
    text-transform: uppercase !important;
    padding: 8px 12px !important;
    border-radius: 4px 4px 0 0 !important;
    border-bottom: 2px solid transparent !important;
    transition: color 0.25s cubic-bezier(0.165, 0.84, 0.44, 1),
                background-color 0.25s cubic-bezier(0.165, 0.84, 0.44, 1),
                border-color 0.25s cubic-bezier(0.165, 0.84, 0.44, 1),
                transform 0.25s cubic-bezier(0.165, 0.84, 0.44, 1),
                box-shadow 0.25s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
    white-space: nowrap !important;
}
#c11-site-header .c11h-nav > li > a i {
    font-size: 8px !important;
    opacity: 0.65 !important;
    transition: transform 0.2s ease !important;
}
#c11-site-header .c11h-nav > li:hover > a {
    color: #ffffff !important;
    background: rgba(220, 38, 24, 0.15) !important;
    border-color: #dc2618 !important;
    transform: translateY(-3px) !important;
    box-shadow: 0 4px 12px rgba(220, 38, 24, 0.25) !important;
}
#c11-site-header .c11h-nav > li:hover > a i { transform: rotate(180deg) !important; }
#c11-site-header .c11h-nav > li > a.c11h-active {
    color: #ffffff !important;
    border-color: #dc2618 !important;
    background: rgba(220, 38, 24, 0.1) !important;
}

/* Dropdown */
#c11-site-header .c11h-dropdown {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    min-width: 220px !important;
    background: #000000 !important;
    border: 2px solid #222222 !important;
    border-radius: 8px !important;
    box-shadow: 0 12px 30px rgba(0,0,0,0.6) !important;
    z-index: 99999 !important;
    overflow: hidden !important;
    
    /* Premium Hover Animation (Opacity/Transform Transition) */
    opacity: 0 !important;
    visibility: hidden !important;
    transform: translateY(-8px) !important;
    transition: opacity 0.25s cubic-bezier(0.165, 0.84, 0.44, 1),
                transform 0.25s cubic-bezier(0.165, 0.84, 0.44, 1),
                visibility 0.25s !important;
    pointer-events: none !important;
}
/* Bridge to keep dropdown active when moving mouse across the 6px gap */
#c11-site-header .c11h-dropdown::before {
    content: "" !important;
    position: absolute !important;
    top: -20px !important;
    left: 0 !important;
    width: 100% !important;
    height: 20px !important;
    background: transparent !important;
    z-index: -1 !important;
}
#c11-site-header .c11h-dropdown li a {
    display: block !important;
    padding: 10px 18px !important;
    color: #e2e8f0 !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    border-bottom: 1px solid rgba(191,209,255,0.08) !important;
    border-left: 4px solid transparent !important;
    transition: color 0.25s ease, background 0.25s ease, padding-left 0.25s ease, border-left-color 0.25s ease !important;
}
#c11-site-header .c11h-dropdown li:last-child a { border-bottom: none !important; }
#c11-site-header .c11h-dropdown li a:hover,
#c11-site-header .c11h-dropdown li a.c11h-active {
    color: #ffffff !important;
    background: rgba(220, 38, 24, 0.15) !important;
    border-left-color: #dc2618 !important;
    padding-left: 24px !important;
}
#c11-site-header .c11h-nav > li:hover .c11h-dropdown,
#c11-site-header .c11h-dropdown:hover {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) !important;
    pointer-events: auto !important;
}

/* Register Now */
#c11-site-header .c11h-register {
    display: inline-flex !important;
    align-items: center !important;
    background: #dc2618 !important;
    color: #ffffff !important;
    font-family: 'Barlow Condensed', sans-serif !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    letter-spacing: 1.2px !important;
    text-transform: uppercase !important;
    padding: 10px 22px !important;
    border-radius: 50px !important;
    white-space: nowrap !important;
    flex-shrink: 0 !important;
    transition: background 0.25s, transform 0.2s, box-shadow 0.25s !important;
    box-shadow: 0 4px 14px rgba(220, 38, 24, 0.45) !important;
}
#c11-site-header .c11h-register:hover {
    background: #b81e10 !important;
    color: #ffffff !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 20px rgba(220, 38, 24, 0.6) !important;
}

/* Hamburger — shows only on mobile */
#c11-site-header .c11h-burger {
    display: none !important;
    background: none !important;
    border: none !important;
    cursor: pointer !important;
    flex-direction: column !important;
    gap: 5px !important;
    padding: 6px !important;
    flex-shrink: 0 !important;
}
#c11-site-header .c11h-burger span {
    display: block !important;
    width: 24px !important;
    height: 2px !important;
    background: #e0e0e0 !important;
    border-radius: 2px !important;
    transition: all 0.3s !important;
}

/* ── SLIDE-IN DRAWER (matches live site) ── */
#c11-mob-drawer-overlay {
    display: none;
    position: fixed !important;
    inset: 0 !important;
    background: rgba(0,0,0,0.55) !important;
    z-index: 99998 !important;
    transition: opacity 0.3s !important;
}
#c11-mob-drawer-overlay.c11d-open { display: block !important; }

#c11-mob-drawer {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: min(320px, 85vw) !important;
    height: 100vh !important;
    background: #000000 !important;
    z-index: 99999 !important;
    display: flex !important;
    flex-direction: column !important;
    transform: translateX(-100%) !important;
    transition: transform 0.32s cubic-bezier(0.4,0,0.2,1) !important;
    overflow-y: auto !important;
    overflow-x: hidden !important;
}
#c11-mob-drawer.c11d-open { transform: translateX(0) !important; }

/* Drawer header */
#c11-mob-drawer .c11d-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 18px 20px !important;
    border-bottom: 1px solid rgba(191,209,255,0.15) !important;
    flex-shrink: 0 !important;
}
#c11-mob-drawer .c11d-header-title {
    color: #ffffff !important;
    font-family: 'Barlow Condensed', sans-serif !important;
    font-size: 18px !important;
    font-weight: 700 !important;
    letter-spacing: 2px !important;
    text-transform: uppercase !important;
}
#c11-mob-drawer .c11d-close {
    background: none !important;
    border: none !important;
    color: #ffffff !important;
    font-size: 20px !important;
    cursor: pointer !important;
    line-height: 1 !important;
    padding: 4px !important;
    opacity: 0.8 !important;
    transition: opacity 0.2s !important;
}
#c11-mob-drawer .c11d-close:hover { opacity: 1 !important; }

/* Drawer nav list */
#c11-mob-drawer .c11d-nav {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
    flex: 1 !important;
}
#c11-mob-drawer .c11d-nav > li {
    border-bottom: 1px solid rgba(191,209,255,0.08) !important;
}
#c11-mob-drawer .c11d-nav > li > a {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 16px 20px !important;
    color: #ffffff !important;
    font-family: 'Barlow Condensed', sans-serif !important;
    font-size: 16px !important;
    font-weight: 700 !important;
    letter-spacing: 1.2px !important;
    text-transform: uppercase !important;
    text-decoration: none !important;
    border-left: 4px solid transparent !important;
    transition: color 0.25s ease, background-color 0.25s ease, border-left-color 0.25s ease !important;
    cursor: pointer !important;
}
#c11-mob-drawer .c11d-nav > li > a:hover {
    color: #ffffff !important;
    background: rgba(220,38,24,0.12) !important;
    border-left-color: #dc2618 !important;
}
#c11-mob-drawer .c11d-nav > li > a .c11d-chevron {
    font-size: 11px !important;
    opacity: 0.6 !important;
    transition: transform 0.25s !important;
    flex-shrink: 0 !important;
}
#c11-mob-drawer .c11d-nav > li.c11d-open > a .c11d-chevron { transform: rotate(180deg) !important; }

/* Drawer sub-menu */
#c11-mob-drawer .c11d-sub {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
    background: #111111 !important;
    max-height: 0 !important;
    overflow: hidden !important;
    transition: max-height 0.3s ease !important;
}
#c11-mob-drawer .c11d-nav > li.c11d-open .c11d-sub { max-height: 500px !important; }
#c11-mob-drawer .c11d-sub li a {
    display: block !important;
    padding: 11px 20px 11px 32px !important;
    color: #e2e8f0 !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    text-decoration: none !important;
    border-bottom: 1px solid rgba(191,209,255,0.06) !important;
    border-left: 4px solid transparent !important;
    transition: color 0.25s ease, background-color 0.25s ease, padding-left 0.25s ease, border-left-color 0.25s ease !important;
}
#c11-mob-drawer .c11d-sub li:last-child a { border-bottom: none !important; }
#c11-mob-drawer .c11d-sub li a:hover {
    color: #ffffff !important;
    background: rgba(220,38,24,0.12) !important;
    border-left-color: #dc2618 !important;
    padding-left: 36px !important;
}
#c11-mob-drawer .c11d-nav > li > a.c11h-active {
    color: #ffffff !important;
    background: rgba(220,38,24,0.12) !important;
    border-left-color: #dc2618 !important;
}
#c11-mob-drawer .c11d-sub li a.c11h-active {
    color: #ffffff !important;
    background: rgba(220,38,24,0.12) !important;
    border-left-color: #dc2618 !important;
    padding-left: 36px !important;
}

/* Drawer footer CTA */
#c11-mob-drawer .c11d-footer {
    padding: 20px !important;
    flex-shrink: 0 !important;
    border-top: 1px solid rgba(191,209,255,0.15) !important;
}
#c11-mob-drawer .c11d-cta {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 10px !important;
    width: 100% !important;
    padding: 14px 20px !important;
    background: #dc2618 !important;
    color: #ffffff !important;
    font-family: 'Barlow Condensed', sans-serif !important;
    font-size: 15px !important;
    font-weight: 700 !important;
    letter-spacing: 1.5px !important;
    text-transform: uppercase !important;
    text-decoration: none !important;
    border-radius: 50px !important;
    transition: background 0.25s, transform 0.2s, box-shadow 0.25s !important;
    box-shadow: 0 4px 14px rgba(220, 38, 24, 0.45) !important;
}
#c11-mob-drawer .c11d-cta:hover {
    background: #b81e10 !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 20px rgba(220, 38, 24, 0.6) !important;
}

/* ---- RESPONSIVE ---- */
@media (max-width: 1100px) {
    #c11-site-header .c11h-nav > li > a { font-size: 11.5px !important; padding: 8px 7px !important; }
}
@media (max-width: 900px) {
    #c11-site-header .c11h-contact { display: none !important; }
    #c11-site-header .c11h-burger { display: flex !important; }
    #c11-site-header .c11h-nav { display: none !important; }
}
</style>

<div id="c11-site-header">

    <!-- TOP BAR -->
    <div class="c11h-topbar">
        <div class="c11h-topbar-inner">
            <ul class="c11h-contact">
                <li>
                    <a href="tel:+919599505213">
                        <i class="fas fa-phone"></i>
                        +91 9599505213
                    </a>
                </li>
                <li>
                    <a href="mailto:info@c11cl.com">
                        <i class="fas fa-envelope"></i>
                        info@c11cl.com
                    </a>
                </li>
            </ul>
            <ul class="c11h-social">
                <li><a href="https://www.facebook.com/profile.php?id=61575926537950" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://x.com/champions11cl" target="_blank" rel="noopener" aria-label="X"><i class="fab fa-x-twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/company/champions11cricketleague/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                <li><a href="https://www.youtube.com/@C11CLOfficial" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a></li>
                <li><a href="https://www.instagram.com/c11cl_official/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>

    <!-- MAIN NAVBAR -->
    <nav class="c11h-navbar" id="c11h-main-nav" role="navigation" aria-label="Main navigation">
        <div class="c11h-navbar-inner">

            <!-- Logo -->
            <a href="<?php echo BASE_URL; ?>" class="c11h-logo" aria-label="C11CL Home">
                <img src="/wp-content/uploads/2025/05/favicon-3.png"
                     alt="C11CL — Champions 11 Cricket League"
                     width="58" height="58">
            </a>

            <!-- Hamburger (mobile) -->
            <button class="c11h-burger" id="c11h-burger" aria-label="Open navigation" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

            <!-- Nav -->
            <ul class="c11h-nav" id="c11h-nav-menu">

                <li><a href="<?php echo BASE_URL; ?>">Home</a></li>

                <li>
                    <a href="#" aria-haspopup="true">About <i class="fas fa-chevron-down"></i></a>
                    <ul class="c11h-dropdown">
                        <li><a href="<?php echo BASE_URL; ?>about-us/">About Us</a></li>
                        <li><a href="<?php echo BASE_URL; ?>contact-us/">Contact Us</a></li>
                        <li><a href="<?php echo BASE_URL; ?>sponsors/">Sponsors</a></li>
                        <li><a href="<?php echo BASE_URL; ?>testimonials/">Testimonials</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" aria-haspopup="true">Policies <i class="fas fa-chevron-down"></i></a>
                    <ul class="c11h-dropdown">
                        <li><a href="<?php echo BASE_URL; ?>anti-doping-code/">Anti-Doping Code</a></li>
                        <li><a href="<?php echo BASE_URL; ?>anti-racism-code/">Anti-Racism Code</a></li>
                        <li><a href="<?php echo BASE_URL; ?>code-of-conduct/">Code of Conduct</a></li>
                        <li><a href="<?php echo BASE_URL; ?>prevention-of-malpractices-code/">Prevention of Malpractices</a></li>
                        <li><a href="<?php echo BASE_URL; ?>league-constitution/">League Constitution</a></li>
                        <li><a href="<?php echo BASE_URL; ?>cancellation-policy/">Cancellation Policy</a></li>
                        <li><a href="<?php echo BASE_URL; ?>registration-policies/">Registration Policies</a></li>
                        <li><a href="<?php echo BASE_URL; ?>missing-children-policy/">Missing Children Policy</a></li>
                        <li><a href="<?php echo BASE_URL; ?>privacy-policy/">Privacy Policy</a></li>
                        <li><a href="<?php echo BASE_URL; ?>terms-conditions/">Terms & Conditions</a></li>
                        <li><a href="<?php echo BASE_URL; ?>refund-policy/">Refund Policy</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" aria-haspopup="true">Updates <i class="fas fa-chevron-down"></i></a>
                    <ul class="c11h-dropdown">
                        <li><a href="<?php echo BASE_URL; ?>blog/">Blog</a></li>
                        <li><a href="<?php echo BASE_URL; ?>news-updates/">News & Updates</a></li>
                        <li><a href="<?php echo BASE_URL; ?>announcements/">Announcements</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" aria-haspopup="true">Our Presence <i class="fas fa-chevron-down"></i></a>
                    <ul class="c11h-dropdown">
                        <li><a href="<?php echo BASE_URL; ?>trials-cities/">Trial Cities</a></li>
                        <li><a href="<?php echo BASE_URL; ?>t20-matches/">T20 Matches</a></li>
                        <li><a href="<?php echo BASE_URL; ?>national-auction/">National Auction</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" aria-haspopup="true">Information <i class="fas fa-chevron-down"></i></a>
                    <ul class="c11h-dropdown">
                        <li><a href="<?php echo BASE_URL; ?>who-can-register/">Who Can Register</a></li>
                        <li><a href="<?php echo BASE_URL; ?>selection-process/">Selection Process</a></li>
                        <li><a href="<?php echo BASE_URL; ?>trial-info/">Trial Info</a></li>
                        <li><a href="<?php echo BASE_URL; ?>state-match/">State Match</a></li>
                        <li><a href="<?php echo BASE_URL; ?>national-league-info/">National League Info</a></li>
                        <li><a href="<?php echo BASE_URL; ?>mandatory-documents/">Mandatory Documents</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" aria-haspopup="true">Highlights <i class="fas fa-chevron-down"></i></a>
                    <ul class="c11h-dropdown">
                        <li><a href="<?php echo BASE_URL; ?>gallery/">Gallery</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" aria-haspopup="true">More <i class="fas fa-chevron-down"></i></a>
                    <ul class="c11h-dropdown">
                        <li><a href="<?php echo BASE_URL; ?>faqs/">FAQs</a></li>
                        <li><a href="<?php echo BASE_URL; ?>careers/">Careers</a></li>
                        <li><a href="<?php echo BASE_URL; ?>payments/">Payments</a></li>
                    </ul>
                </li>

            </ul>

            <!-- CTA -->
            <a href="<?php echo BASE_URL; ?>registration/" class="c11h-register">
                Register Now
            </a>

        </div>
    </nav>

</div><!-- /#c11-site-header -->

<!-- MOBILE SLIDE-IN DRAWER (matches live c11cl.com menu) -->
<div id="c11-mob-drawer-overlay"></div>
<div id="c11-mob-drawer" role="dialog" aria-modal="true" aria-label="Site navigation">
    <div class="c11d-header">
        <img src="/wp-content/uploads/2025/05/favicon-3.png" alt="C11CL" style="height:36px;width:36px;object-fit:contain;">
        <span class="c11d-header-title">C11CL Menu</span>
        <button class="c11d-close" id="c11d-close" aria-label="Close menu">&times;</button>
    </div>
    <ul class="c11d-nav">
        <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
        <li>
            <a href="#">About <i class="fas fa-chevron-down c11d-chevron"></i></a>
            <ul class="c11d-sub">
                <li><a href="<?php echo BASE_URL; ?>about-us/">About Us</a></li>
                <li><a href="<?php echo BASE_URL; ?>contact-us/">Contact Us</a></li>
                <li><a href="<?php echo BASE_URL; ?>sponsors/">Sponsors</a></li>
                <li><a href="<?php echo BASE_URL; ?>testimonials/">Testimonials</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Policies <i class="fas fa-chevron-down c11d-chevron"></i></a>
            <ul class="c11d-sub">
                <li><a href="<?php echo BASE_URL; ?>anti-doping-code/">Anti-Doping Code</a></li>
                <li><a href="<?php echo BASE_URL; ?>anti-racism-code/">Anti-Racism Code</a></li>
                <li><a href="<?php echo BASE_URL; ?>code-of-conduct/">Code of Conduct</a></li>
                <li><a href="<?php echo BASE_URL; ?>prevention-of-malpractices-code/">Prevention of Malpractices</a></li>
                <li><a href="<?php echo BASE_URL; ?>league-constitution/">League Constitution</a></li>
                <li><a href="<?php echo BASE_URL; ?>cancellation-policy/">Cancellation Policy</a></li>
                <li><a href="<?php echo BASE_URL; ?>registration-policies/">Registration Policies</a></li>
                <li><a href="<?php echo BASE_URL; ?>missing-children-policy/">Missing Children Policy</a></li>
                <li><a href="<?php echo BASE_URL; ?>privacy-policy/">Privacy Policy</a></li>
                <li><a href="<?php echo BASE_URL; ?>refund-policy/">Refund Policy</a></li>
                <li><a href="<?php echo BASE_URL; ?>terms-conditions/">Terms &amp; Conditions</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Updates <i class="fas fa-chevron-down c11d-chevron"></i></a>
            <ul class="c11d-sub">
                <li><a href="<?php echo BASE_URL; ?>blog/">Blog</a></li>
                <li><a href="<?php echo BASE_URL; ?>news-updates/">News &amp; Updates</a></li>
                <li><a href="<?php echo BASE_URL; ?>announcements/">Announcements</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Our Presence <i class="fas fa-chevron-down c11d-chevron"></i></a>
            <ul class="c11d-sub">
                <li><a href="<?php echo BASE_URL; ?>trials-cities/">Trial Cities</a></li>
                <li><a href="<?php echo BASE_URL; ?>t20-matches/">T20 Matches</a></li>
                <li><a href="<?php echo BASE_URL; ?>national-auction/">National Auction</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Information <i class="fas fa-chevron-down c11d-chevron"></i></a>
            <ul class="c11d-sub">
                <li><a href="<?php echo BASE_URL; ?>who-can-register/">Who Can Register</a></li>
                <li><a href="<?php echo BASE_URL; ?>selection-process/">Selection Process</a></li>
                <li><a href="<?php echo BASE_URL; ?>trial-info/">Trial Info</a></li>
                <li><a href="<?php echo BASE_URL; ?>state-match/">State Match</a></li>
                <li><a href="<?php echo BASE_URL; ?>national-league-info/">National League Info</a></li>
                <li><a href="<?php echo BASE_URL; ?>mandatory-documents/">Mandatory Documents</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Highlights <i class="fas fa-chevron-down c11d-chevron"></i></a>
            <ul class="c11d-sub">
                <li><a href="<?php echo BASE_URL; ?>gallery/">Gallery</a></li>
            </ul>
        </li>
        <li>
            <a href="#">More <i class="fas fa-chevron-down c11d-chevron"></i></a>
            <ul class="c11d-sub">
                <li><a href="<?php echo BASE_URL; ?>faqs/">FAQs</a></li>
                <li><a href="<?php echo BASE_URL; ?>careers/">Careers</a></li>
                <li><a href="<?php echo BASE_URL; ?>payments/">Payments</a></li>
            </ul>
        </li>
    </ul>
    <div class="c11d-footer">
        <a href="<?php echo BASE_URL; ?>registration/" class="c11d-cta">
            <i class="fas fa-cricket"></i> Register For Trials
        </a>
    </div>
</div>

<script>
(function() {
    var burger  = document.getElementById('c11h-burger');
    var drawer  = document.getElementById('c11-mob-drawer');
    var overlay = document.getElementById('c11-mob-drawer-overlay');
    var closeBtn= document.getElementById('c11d-close');

    function openDrawer() {
        drawer.classList.add('c11d-open');
        overlay.classList.add('c11d-open');
        document.body.style.overflow = 'hidden';
        if (burger) burger.setAttribute('aria-expanded', 'true');
    }
    function closeDrawer() {
        drawer.classList.remove('c11d-open');
        overlay.classList.remove('c11d-open');
        document.body.style.overflow = '';
        if (burger) burger.setAttribute('aria-expanded', 'false');
    }

    if (burger)  burger.addEventListener('click', openDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    // Accordion sub-menus
    document.querySelectorAll('#c11-mob-drawer .c11d-nav > li').forEach(function(li) {
        var link = li.querySelector('a');
        var sub  = li.querySelector('.c11d-sub');
        if (!sub || !link) return;
        link.addEventListener('click', function(e) {
            e.preventDefault();
            li.classList.toggle('c11d-open');
        });
    });

    // Dynamic Navigation Highlighting
    function normalizePath(path) {
        if (!path) return '';
        var p = path.toLowerCase();
        // Remove index.php or index.html at the end
        p = p.replace(/(index\.php|index\.html)$/, '');
        // Strip trailing slash if it is not just "/"
        if (p.length > 1 && p.endsWith('/')) {
            p = p.slice(0, -1);
        }
        return p;
    }

    var cleanPath = normalizePath(window.location.pathname);

    // Main Nav Highlighting
    var navLinks = document.querySelectorAll('#c11-site-header .c11h-nav a');
    navLinks.forEach(function(link) {
        var href = link.getAttribute('href');
        if (!href || href === '#' || href.startsWith('javascript:')) return;
        
        var linkPath = normalizePath(link.pathname);
        if (cleanPath === linkPath) {
            link.classList.add('c11h-active');
            
            // If it is in a dropdown, highlight the parent dropdown trigger
            var dropdown = link.closest('.c11h-dropdown');
            if (dropdown) {
                var parentTrigger = dropdown.previousElementSibling;
                if (parentTrigger) {
                    parentTrigger.classList.add('c11h-active');
                }
            }
        }
    });

    // Mobile Drawer Highlighting
    var drawerLinks = document.querySelectorAll('#c11-mob-drawer a');
    drawerLinks.forEach(function(link) {
        var href = link.getAttribute('href');
        if (!href || href === '#' || href.startsWith('javascript:')) return;
        
        var linkPath = normalizePath(link.pathname);
        if (cleanPath === linkPath) {
            link.classList.add('c11h-active');
            
            // If it is inside a mobile submenu, auto-expand the parent li
            var subMenu = link.closest('.c11d-sub');
            if (subMenu) {
                var parentLi = subMenu.closest('li');
                if (parentLi) {
                    parentLi.classList.add('c11d-open');
                    
                    // Also highlight the parent menu trigger
                    var parentTrigger = parentLi.querySelector('a');
                    if (parentTrigger) {
                        parentTrigger.classList.add('c11h-active');
                    }
                }
            }
        }
    });
})();
</script>
