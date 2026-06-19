<?php
// C11CL — Shared Policy Card Styles
// Include this inside <head> or at top of page content for all policy pages.
?>
<style>
/* ========================================================
   C11CL Policy Body — Card-style list items with crimson hover
   ======================================================== */

/* Wrap each <ul> / <ol> in a card grid automatically */
.c11-policy-body ul,
.c11-policy-body ol {
    list-style: none !important;
    margin: 0 0 28px 0 !important;
    padding: 0 !important;
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
    gap: 14px !important;
}

/* Each <li> becomes a card */
.c11-policy-body li {
    background: #ffffff !important;
    border: 1px solid #eeeeee !important;
    border-left: 4px solid #dc2618 !important;
    border-radius: 8px !important;
    padding: 16px 18px !important;
    margin: 0 !important;
    color: #444444 !important;
    font-size: 0.97rem !important;
    line-height: 1.65 !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
    transition: border-color 0.22s ease, background 0.22s ease,
                color 0.22s ease, box-shadow 0.22s ease,
                transform 0.22s ease !important;
    cursor: default !important;
    position: relative !important;
}

/* Left-accent icon (chevron) */
.c11-policy-body li::before {
    content: "›" !important;
    font-size: 1.3rem !important;
    font-weight: 700 !important;
    color: #dc2618 !important;
    margin-right: 8px !important;
    line-height: 1 !important;
    transition: color 0.22s ease !important;
    display: inline-block !important;
    vertical-align: middle !important;
}

/* Crimson hover state */
.c11-policy-body li:hover {
    background: #dc2618 !important;
    border-color: #b51e12 !important;
    color: #ffffff !important;
    box-shadow: 0 8px 24px rgba(220, 38, 24, 0.28) !important;
    transform: translateY(-3px) !important;
}

.c11-policy-body li:hover::before {
    color: #ffffff !important;
}

.c11-policy-body li:hover strong,
.c11-policy-body li:hover p,
.c11-policy-body li:hover a {
    color: #ffffff !important;
}

/* Inner <p> tags inside li (some policy pages wrap text in <p>) */
.c11-policy-body li > p {
    margin: 0 !important;
    display: inline !important;
}

/* Strong labels keep their bold but inherit color on hover */
.c11-policy-body li strong {
    color: #111111 !important;
    transition: color 0.22s ease !important;
}

/* ── Responsive: single column on mobile ── */
@media (max-width: 600px) {
    .c11-policy-body ul,
    .c11-policy-body ol {
        grid-template-columns: 1fr !important;
    }
}
</style>
