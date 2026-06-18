<?php
// C11CL Reusable Component: Player Benefits
?>
<!-- SECTION: PLAYER BENEFITS -->
<!-- Google Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --c11-red: #CC0000;
        --c11-blue: #001f3f;
        --c11-gold: #b8860b;
        --c11-soft-gray: #f2f4f7;
    }

    /* 1. Main Section with Texture & Soft Lighting */
    .c11-benefits-wrapper {
        padding: 60px 15px 40px;
        background-color: #ffffff;
        background-image: 
            radial-gradient(circle at 50% -20%, rgba(0, 31, 63, 0.05) 0%, transparent 70%),
            url('https://www.transparenttextures.com/patterns/white-diamond.png'); 
        font-family: 'Poppins', sans-serif;
        overflow: hidden;
        position: relative;
    }

    /* 2. Compact Typographic Heading */
    .c11-header-compact {
        text-align: center;
        max-width: 800px;
        margin: 0 auto 40px;
    }
    .c11-header-compact h2 {
        font-family: 'Oswald', sans-serif;
        font-size: clamp(30px, 5vw, 46px);
        line-height: 1.1;
        margin: 0 0 10px 0;
        color: var(--c11-blue);
        text-transform: uppercase;
        font-weight: 700;
    }
    .c11-header-compact .highlight-tag {
        display: inline-block;
        font-weight: 800;
        font-size: 13px;
        color: var(--c11-red);
        border: 2px solid var(--c11-red);
        padding: 3px 18px;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
        border-radius: 50px;
    }
    .c11-header-compact .intro-text {
        font-size: 14.5px;
        color: #4a5568;
        line-height: 1.7;
        margin: 0 auto;
        max-width: 720px;
    }

    /* 3. Grid Layout Setup */
    .c11-grid-compact {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* 4. Mini Card Design */
    .c11-card-mini {
        background: #fff;
        padding: 25px 15px;
        border-radius: 14px;
        border: 1px solid #e1e8ef;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }

    /* Hover Animation */
    .c11-card-mini:hover {
        transform: translateY(-6px);
        border-color: var(--c11-red);
        box-shadow: 0 12px 25px rgba(204, 0, 0, 0.08);
    }

    /* Icon Box */
    .icon-box-mini {
        width: 50px;
        height: 50px;
        background: var(--c11-soft-gray);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--c11-red);
        font-size: 20px;
        margin-bottom: 15px;
        transition: 0.4s ease;
    }
    .c11-card-mini:hover .icon-box-mini {
        background: var(--c11-red);
        color: #fff;
        transform: rotateY(360deg);
    }

    /* Content Styling */
    .card-text-mini h4 {
        font-family: 'Oswald', sans-serif;
        font-size: 19px;
        margin: 0 0 8px 0;
        color: var(--c11-blue);
        text-transform: uppercase;
        line-height: 1.2;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    
    /* NEW PREMIUM HIGHLIGHT TAG FOR SUB-HEADINGS */
    .card-text-mini .sub-heading-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        color: var(--c11-red);
        background: rgba(204, 0, 0, 0.06);
        border: 1px solid rgba(204, 0, 0, 0.15);
        padding: 2px 12px;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 4px;
        line-height: 1.3;
    }
    
    .card-text-mini p {
        font-size: 12px;
        margin: 0;
        color: #555555;
        font-weight: 400;
        line-height: 1.55;
    }

    /* Universal Header Inside Span Inheritance Configuration */
    h1 span, h2 span, h3 span, h4 span, h5 span, h6 span, .card-text-mini h4 span {
        font-family: inherit !important;
        font-weight: inherit !important;
        letter-spacing: inherit !important;
    }

    /* 5. Mobile Optimization: 2 items per row */
    @media (max-width: 991px) {
        .c11-grid-compact {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
    }
    @media (max-width: 768px) {
        .c11-benefits-wrapper { padding: 40px 10px; }
        .c11-card-mini { padding: 22px 12px; }
        .card-text-mini h4 { font-size: 17px; margin-bottom: 6px; }
        .card-text-mini .sub-heading-tag { font-size: 10px; padding: 2px 10px; margin-bottom: 10px; }
        .card-text-mini p { font-size: 11px; line-height: 1.45; }
    }

    /* Footer Slogan Sizing */
    .c11-footer-tag {
        margin-top: 45px;
        text-align: center;
        font-size: 14px;
        font-weight: 800;
        color: var(--c11-blue);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        opacity: 0.85;
    }
</style>

<section class="c11-benefits-wrapper">
    <!-- Header -->
    <div class="c11-header-compact">
        <div class="highlight-tag">C11CL Season 2026</div>
        <h2>PLAYER BENEFITS</h2>
        <p class="intro-text">Every player who steps on the C11CL field competes for real rewards — from life-changing prize money to global coaching. Here's exactly what you're playing for.</p>
    </div>

    <!-- Grid Layout Interface Components -->
    <div class="c11-grid-compact">
        
        <!-- Auction -->
        <div class="c11-card-mini">
            <div class="icon-box-mini"><i class="fa-solid fa-gavel"></i></div>
            <div class="card-text-mini">
                <h4>₹2.5L Auction</h4>
                <div class="sub-heading-tag">Bidding System</div>
                <p>Team owners bid on you at a live auction. Your game sets your price.</p>
            </div>
        </div>

        <!-- Winner -->
        <div class="c11-card-mini">
            <div class="icon-box-mini"><i class="fa-solid fa-trophy"></i></div>
            <div class="card-text-mini">
                <h4>₹25L Winner</h4>
                <div class="sub-heading-tag">Grand Prize</div>
                <p>The champions take home ₹25 Lakhs. Win the league, change your story.</p>
            </div>
        </div>

        <!-- Runner Up -->
        <div class="c11-card-mini">
            <div class="icon-box-mini"><i class="fa-solid fa-medal"></i></div>
            <div class="card-text-mini">
                <h4>₹11L Runner</h4>
                <div class="sub-heading-tag">Finalist Prize</div>
                <p>Reach the final and your team earns ₹11 Lakhs. Getting close still counts here.</p>
            </div>
        </div>

        <!-- Bike -->
        <div class="c11-card-mini">
            <div class="icon-box-mini"><i class="fa-solid fa-motorcycle"></i></div>
            <div class="card-text-mini">
                <h4>Sports Bike</h4>
                <div class="sub-heading-tag">Man of the Series</div>
                <p>One full season of standout cricket. One bike waiting at the end of it.</p>
            </div>
        </div>

        <!-- Silver Bat -->
        <div class="c11-card-mini">
            <div class="icon-box-mini"><i class="fas fa-baseball-bat-ball"></i></div>
            <div class="card-text-mini">
                <h4>Silver Bat</h4>
                <div class="sub-heading-tag">Best Batsman</div>
                <p>Awarded to the batsman who proves himself across the season. One player takes this home.</p>
            </div>
        </div>

        <!-- Silver Shoes -->
        <div class="c11-card-mini">
            <div class="icon-box-mini"><i class="fa-solid fa-shoe-prints"></i></div>
            <div class="card-text-mini">
                <h4>Silver Shoes</h4>
                <div class="sub-heading-tag">Best Bowler</div>
                <p>Awarded to the bowler who shows up every single game. One player takes this home.</p>
            </div>
        </div>

        <!-- Intl Grounds -->
        <div class="c11-card-mini">
            <div class="icon-box-mini"><i class="fa-solid fa-earth-asia"></i></div>
            <div class="card-text-mini">
                <h4>Intl. Grounds</h4>
                <div class="sub-heading-tag">World-Class Venues</div>
                <p>Every match on an international-standard turf. You deserve the right surface to play on.</p>
            </div>
        </div>

        <!-- Learn Pro -->
        <div class="c11-card-mini">
            <div class="icon-box-mini"><i class="fa-solid fa-users-gear"></i></div>
            <div class="card-text-mini">
                <h4>Learn Pro</h4>
                <div class="sub-heading-tag">International Coaching</div>
                <p>Certified international coaches on the ground. They watch you play and tell you exactly what to fix.</p>
            </div>
        </div>

    </div>

    <!-- Footer Slogan -->
    <div class="c11-footer-tag">
        Every ground in India has a champion. We're here to find them.
    </div>
</section>
