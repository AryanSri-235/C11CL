<?php
// C11CL Global Header Component — Scoped, !important-hardened for compatibility with WordPress/Astra themes
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    background: #1a1a1a !important;
    border-bottom: 2px solid #dc2618 !important;
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
    color: #cccccc !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12.5px !important;
    font-weight: 400 !important;
    display: flex !important;
    align-items: center !important;
    gap: 7px !important;
    transition: color 0.2s !important;
    white-space: nowrap !important;
}
#c11-site-header .c11h-contact li a:hover { color: #ffffff !important; }
#c11-site-header .c11h-contact li a i { color: #dc2618 !important; font-size: 11px !important; }

#c11-site-header .c11h-social {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
}
#c11-site-header .c11h-social li a {
    color: #aaaaaa !important;
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
    background: rgba(220, 38, 24, 0.25) !important;
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
#c11-site-header .c11h-nav > li { position: relative !important; }
#c11-site-header .c11h-nav > li > a {
    display: flex !important;
    align-items: center !important;
    gap: 4px !important;
    color: #e0e0e0 !important;
    font-family: 'Barlow Condensed', sans-serif !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    letter-spacing: 0.8px !important;
    text-transform: uppercase !important;
    padding: 8px 10px !important;
    border-radius: 4px !important;
    transition: color 0.2s, background 0.2s !important;
    white-space: nowrap !important;
}
#c11-site-header .c11h-nav > li > a i {
    font-size: 8px !important;
    opacity: 0.65 !important;
    transition: transform 0.2s !important;
}
#c11-site-header .c11h-nav > li:hover > a {
    color: #ffffff !important;
    background: rgba(220, 38, 24, 0.18) !important;
}
#c11-site-header .c11h-nav > li:hover > a i { transform: rotate(180deg) !important; }
#c11-site-header .c11h-nav > li > a.c11h-active { color: #dc2618 !important; }

/* Dropdown */
#c11-site-header .c11h-dropdown {
    display: none !important;
    position: absolute !important;
    top: calc(100% + 6px) !important;
    left: 0 !important;
    min-width: 200px !important;
    background: #1e1e1e !important;
    border: 1px solid rgba(255,255,255,0.09) !important;
    border-top: 3px solid #dc2618 !important;
    border-radius: 0 0 8px 8px !important;
    box-shadow: 0 14px 32px rgba(0,0,0,0.55) !important;
    z-index: 99999 !important;
    overflow: hidden !important;
}
#c11-site-header .c11h-dropdown li a {
    display: block !important;
    padding: 9px 16px !important;
    color: #cccccc !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    border-bottom: 1px solid rgba(255,255,255,0.05) !important;
    transition: color 0.2s, background 0.2s, padding-left 0.2s !important;
}
#c11-site-header .c11h-dropdown li:last-child a { border-bottom: none !important; }
#c11-site-header .c11h-dropdown li a:hover {
    color: #ffffff !important;
    background: rgba(220, 38, 24, 0.2) !important;
    padding-left: 22px !important;
}
#c11-site-header .c11h-nav > li:hover .c11h-dropdown {
    display: block !important;
    animation: c11hDropIn 0.18s ease !important;
}
@keyframes c11hDropIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
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

/* Hamburger */
#c11-site-header .c11h-burger {
    display: none !important;
    background: none !important;
    border: 2px solid rgba(220,38,24,0.5) !important;
    border-radius: 6px !important;
    cursor: pointer !important;
    flex-direction: column !important;
    gap: 4px !important;
    padding: 6px 8px !important;
    flex-shrink: 0 !important;
}
#c11-site-header .c11h-burger span {
    display: block !important;
    width: 22px !important;
    height: 2px !important;
    background: #e0e0e0 !important;
    border-radius: 2px !important;
    transition: all 0.3s !important;
}
#c11-site-header .c11h-burger.c11h-open span:nth-child(1) { transform: translateY(6px) rotate(45deg) !important; }
#c11-site-header .c11h-burger.c11h-open span:nth-child(2) { opacity: 0 !important; }
#c11-site-header .c11h-burger.c11h-open span:nth-child(3) { transform: translateY(-6px) rotate(-45deg) !important; }

/* ---- RESPONSIVE ---- */
@media (max-width: 1100px) {
    #c11-site-header .c11h-nav > li > a { font-size: 11.5px !important; padding: 8px 7px !important; }
}
@media (max-width: 900px) {
    #c11-site-header .c11h-contact { display: none !important; }
    #c11-site-header .c11h-burger { display: flex !important; }
    #c11-site-header .c11h-nav {
        display: none !important;
        position: absolute !important;
        top: 70px !important;
        left: 0 !important;
        width: 100% !important;
        background: #1a1a1a !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        padding: 8px 0 16px !important;
        border-top: 2px solid #dc2618 !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.5) !important;
        z-index: 9998 !important;
        gap: 0 !important;
    }
    #c11-site-header .c11h-nav.c11h-open { display: flex !important; }
    #c11-site-header .c11h-nav > li { width: 100% !important; }
    #c11-site-header .c11h-nav > li > a {
        padding: 12px 20px !important;
        font-size: 14px !important;
        border-radius: 0 !important;
        border-bottom: 1px solid rgba(255,255,255,0.06) !important;
    }
    #c11-site-header .c11h-dropdown {
        position: static !important;
        display: block !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        background: #141414 !important;
        max-height: 0 !important;
        overflow: hidden !important;
        transition: max-height 0.3s ease !important;
    }
    #c11-site-header .c11h-nav > li.c11h-mob-open .c11h-dropdown { max-height: 600px !important; }
    #c11-site-header .c11h-dropdown li a { padding-left: 30px !important; }
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
                <img src="<?php echo BASE_URL; ?>wp-content/uploads/2025/05/favicon-3.png"
                     alt="C11CL — Champions 11 Cricket League"
                     width="58" height="58">
            </a>

            <!-- Hamburger (mobile) -->
            <button class="c11h-burger" id="c11h-burger" aria-label="Toggle navigation" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

            <!-- Nav -->
            <ul class="c11h-nav" id="c11h-nav-menu">

                <li><a href="<?php echo BASE_URL; ?>" class="c11h-active">Home</a></li>

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
                        <li><a href="<?php echo BASE_URL; ?>news-updates/">News</a></li>
                        <li><a href="<?php echo BASE_URL; ?>blog/">Announcements</a></li>
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

<script>
(function() {
    var burger = document.getElementById('c11h-burger');
    var menu   = document.getElementById('c11h-nav-menu');
    if (burger && menu) {
        burger.addEventListener('click', function() {
            var open = menu.classList.toggle('c11h-open');
            burger.classList.toggle('c11h-open', open);
            burger.setAttribute('aria-expanded', String(open));
        });
    }
    // Mobile accordion for dropdowns
    document.querySelectorAll('#c11h-nav-menu > li').forEach(function(item) {
        var link = item.querySelector('a[aria-haspopup]');
        if (!link) return;
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 900) {
                e.preventDefault();
                item.classList.toggle('c11h-mob-open');
            }
        });
    });
})();
</script>
