<?php
// C11CL — Shared Policy Page Styles (matches live site)
// Include this inside <head> on all policy pages
?>
<!-- Google Fonts: Barlow Condensed + Poppins (matches c11cl.com live site) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,400;0,600;0,700;0,800;1,600&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
<style>
/* ============================================================
   C11CL Policy Pages — Pixel-matched to c11cl.com live design
   ============================================================ */

/* Page background: plain white (matches live site — no texture) */
body {
    background-color: #ffffff !important;
    background-image: none !important;
    font-family: 'Poppins', sans-serif !important;
}

/* ── Breadcrumb strip ── */
.c11p-breadcrumb {
    padding: 14px 0;
    font-size: 0.75rem;
    font-family: 'Poppins', sans-serif;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 1px solid #e5e7eb;
    background: #fff;
}
.c11p-breadcrumb-inner {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 24px;
}
.c11p-breadcrumb a { color: #6b7280; text-decoration: none; }
.c11p-breadcrumb a:hover { color: #dc2618; }
.c11p-breadcrumb .sep { color: #dc2618; margin: 0 6px; font-weight: 700; }
.c11p-breadcrumb .cur { color: #dc2618; font-weight: 600; }

/* ── Page title block ── */
.c11p-title-block {
    max-width: 900px;
    margin: 36px auto 28px;
    padding: 0 24px;
}
.c11p-title-block h1 {
    font-family: 'Barlow Condensed', 'Oswald', sans-serif !important;
    font-size: clamp(2rem, 5vw, 2.8rem) !important;
    font-weight: 800 !important;
    color: #0e1b30 !important;
    text-transform: uppercase !important;
    letter-spacing: -0.5px !important;
    margin: 0 0 6px !important;
    line-height: 1.1 !important;
}

/* ── Main content wrapper ── */
.c11p-content {
    max-width: 900px;
    margin: 0 auto 60px;
    padding: 0 24px;
}

/* ── Intro paragraph ── */
.c11p-intro {
    font-size: 0.97rem;
    color: #4b5563;
    line-height: 1.75;
    margin-bottom: 28px;
    font-family: 'Poppins', sans-serif;
}

/* ── Section cards (each h5 block) ── */
.c11p-section {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-left: 5px solid #0e1b30;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    padding: 24px 28px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.c11p-section:hover {
    border-color: #dc2618 !important;
    border-left-color: #dc2618 !important;
    box-shadow: 0 12px 35px rgba(220,38,24,0.18);
    transform: translateY(-5px);
}

/* Section heading row */
.c11p-section-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}
.c11p-section-heading .c11p-icon {
    color: #dc2618;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.c11p-section-heading h3 {
    font-family: 'Barlow Condensed', 'Oswald', sans-serif !important;
    font-size: 1.05rem !important;
    font-weight: 700 !important;
    color: #0e1b30 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.8px !important;
    margin: 0 !important;
    line-height: 1.2 !important;
}

/* Section body text */
.c11p-section p {
    font-size: 0.96rem;
    color: #4b5563;
    line-height: 1.72;
    margin: 0 0 10px;
    font-family: 'Poppins', sans-serif;
}
.c11p-section p:last-child { margin-bottom: 0; }
.c11p-section p strong { color: #0e1b30; }

/* ── Checklist items ── */
.c11p-section ul,
.c11p-section ol {
    list-style: none !important;
    margin: 8px 0 0 !important;
    padding: 0 !important;
}
.c11p-section li {
    display: flex !important;
    align-items: flex-start !important;
    gap: 10px !important;
    padding: 6px 0 !important;
    font-size: 0.96rem !important;
    color: #4b5563 !important;
    font-family: 'Poppins', sans-serif !important;
    border-bottom: 1px solid #f3f4f6 !important;
    margin: 0 !important;
    background: none !important;
    border-left: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    transform: none !important;
}
.c11p-section li:last-child { border-bottom: none !important; }

/* Crimson check icon before each li */
.c11p-section li::before {
    content: "✓" !important;
    color: #dc2618 !important;
    font-weight: 700 !important;
    font-size: 0.9rem !important;
    margin-top: 2px !important;
    flex-shrink: 0 !important;
}

.c11p-section li strong { color: #0e1b30 !important; }

/* Inner <p> inside <li> — display inline */
.c11p-section li > p {
    margin: 0 !important;
    display: inline !important;
    font-size: 0.96rem !important;
    color: inherit !important;
}

/* ── Closing quote card ── */
.c11p-quote {
    border-left: 4px solid #dc2618;
    background: #fff;
    border-radius: 8px;
    padding: 20px 24px;
    margin-top: 28px;
    font-family: 'Poppins', sans-serif;
    font-style: italic;
    color: #dc2618;
    font-size: 1rem;
    font-weight: 500;
    box-shadow: 0 2px 12px rgba(220,38,24,0.08);
}

/* ── Override old policy card styles that used grid ── */
.c11-policy-body ul,
.c11-policy-body ol {
    display: block !important;
    grid-template-columns: unset !important;
}
.c11-policy-body li {
    display: flex !important;
    background: none !important;
    border: none !important;
    border-left: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    padding: 6px 0 !important;
    transform: none !important;
}
.c11-policy-body li:hover {
    background: none !important;
    color: #4b5563 !important;
    transform: none !important;
    box-shadow: none !important;
}
.c11-policy-body li:hover::before { color: #dc2618 !important; }

@media (max-width: 640px) {
    .c11p-section { padding: 18px 16px; }
    .c11p-title-block, .c11p-content { padding: 0 16px; }
}
</style>
