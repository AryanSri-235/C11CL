<?php
// C11CL Reusable Component: Selection Pathway
?>
<!-- SECTION: COMPACT PREMIUM SNAKE ROADMAP -->
<style>
    .snake-section { 
        padding: 60px 20px; /* Reduced padding for compactness */
        background: #f9f9f9; 
        background-image: url('https://www.transparenttextures.com/patterns/white-diamond-dark.png'); 
        position: relative; 
        overflow: hidden;
    }

    /* Floating Cricket Elements for Background Effect */
    .road-bg-icon {
        position: absolute; opacity: 0.04; pointer-events: none; z-index: 1; color: #000;
    }

    .snake-wrap { 
        max-width: 900px; 
        margin: 0 auto; 
        position: relative; 
        z-index: 2;
    }

    /* The Connecting Path */
    .snake-wrap::before { 
        content: ""; 
        position: absolute; 
        top: 0; left: 50%; 
        width: 6px; height: 100%; 
        background: linear-gradient(to bottom, #ddd, var(--c11-red), #ddd); 
        transform: translateX(-50%); 
        border-radius: 10px;
    }

    .snake-item { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        width: 100%; 
        margin-bottom: 40px; /* Reduced margin to save space */
        position: relative; 
    }

    .snake-item:nth-child(even) { flex-direction: row-reverse; }

    /* Compact Step Cards */
    .snake-card { 
        width: 44%; 
        background: rgba(255, 255, 255, 0.98); 
        padding: 18px 22px; /* Tightened padding */
        border-radius: 15px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        border: 1px solid #eee;
        position: relative;
        transition: 0.3s ease;
    }
    
    .snake-card:hover {
        transform: translateY(-5px);
        border-color: var(--c11-red);
        box-shadow: 0 15px 30px rgba(204, 0, 0, 0.1);
    }

    /* Compact Stage Badge */
    .step-num {
        position: absolute;
        top: -12px;
        left: 15px;
        background: var(--c11-blue);
        color: #fff;
        font-family: 'Oswald';
        padding: 2px 10px;
        border-radius: 5px;
        font-size: 11px;
        letter-spacing: 1px;
    }
    .snake-item:nth-child(even) .step-num { left: auto; right: 15px; }

    .snake-card h4 { 
        font-family: 'Oswald'; 
        font-size: 20px; /* Slightly smaller heading */
        color: var(--c11-blue); 
        margin: 5px 0 8px; 
        text-transform: uppercase;
        border-bottom: 2px solid var(--c11-gold);
        display: inline-block;
    }

    .snake-card p { 
        font-size: 13px; /* Smaller font for compactness */
        color: #555; 
        line-height: 1.5; 
        margin: 0; 
    }

    /* Small Center Points (Cricket Ball Style) */
    .snake-point { 
        width: 32px; height: 32px; 
        background: #fff; 
        border: 5px solid var(--c11-red); 
        border-radius: 50%; 
        position: absolute; 
        left: 50%; 
        transform: translateX(-50%); 
        z-index: 5;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .snake-point i { color: var(--c11-red); font-size: 12px; }

    @media (max-width: 768px) {
        .snake-wrap::before { left: 20px; }
        .snake-point { left: 20px; width: 28px; height: 28px; border-width: 4px; }
        .snake-item, .snake-item:nth-child(even) { flex-direction: row; justify-content: flex-end; }
        .snake-card { width: 85%; padding: 15px; }
        .road-bg-icon { display: none; }
    }
    .fee-badge {
        display: inline-block !important;
        background: #ffd800 !important;
        color: #000000 !important;
        font-weight: bold !important;
        padding: 4px 10px !important;
        border-radius: 4px !important;
        margin-top: 8px !important;
        font-size: 13px !important;
    }
</style>

<section class="snake-section">
    <!-- Cricket Elements Background Effects -->
    <i class="fa-solid fa-cricket-bat-ball road-bg-icon" style="top:5%; left:3%; font-size:100px; transform: rotate(-15deg);" id="el-bat"></i>
    <i class="fa-solid fa-baseball-bat-ball road-bg-icon" style="top:35%; right:2%; font-size:80px; transform: rotate(20deg);" id="el-ball"></i>
    <i class="fa-solid fa-grip-lines-vertical road-bg-icon" style="bottom:15%; left:4%; font-size:120px;" id="el-wicket"></i>

    <h2 class="sec-title">Selection Pathway</h2>
    
   <div class="snake-wrap">
    <div class="snake-item">
        <div class="snake-card">
            <div class="step-num">STAGE 01</div>
            <h4>Open Trials</h4>
           <p>Open trials will be conducted across 23+ states in India. Showcase your talent in a 3-over performance at your nearest city selection camp.<br><span class="fee-badge">Registration Fee: ₹1850</span></p>
        </div>
        <div class="snake-point"><i class="fa-solid fa-check"></i></div>
    </div>

    <div class="snake-item">
        <div class="snake-card">
            <div class="step-num">STAGE 02</div>
            <h4>State Matches</h4>
           <p>Selected players from the trials will form state teams to compete in league matches, designed to test their skills under real match pressure.<br><span class="fee-badge">League Participation Fee: ₹8999</span></p>
        </div>
        <div class="snake-point"><i class="fa-solid fa-medal"></i></div>
    </div>

    <div class="snake-item">
        <div class="snake-card">
            <div class="step-num">STAGE 03</div>
            <h4>Mega Auction</h4>
            <p>Top performers from state matches will enter the Our National Mega Auction. Franchise owners will bid for players on a massive professional platform.</p>
        </div>
        <div class="snake-point"><i class="fa-solid fa-gavel"></i></div>
    </div>

    <div class="snake-item">
        <div class="snake-card">
            <div class="step-num">STAGE 04</div>
            <h4>National League</h4>
            <p>Join elite professional teams in the National League. Elevate your career to new heights based on your on-field performance and statistics.</p>
        </div>
        <div class="snake-point"><i class="fa-solid fa-star"></i></div>
    </div>
</div>
</section>

<script>
    // Scroll effect for Bat, Ball and Wickets with safety checks
    window.addEventListener('scroll', function() {
        let val = window.scrollY;
        let elBat = document.getElementById('el-bat');
        let elBall = document.getElementById('el-ball');
        let elWicket = document.getElementById('el-wicket');
        
        if (elBat) elBat.style.top = (5 + val * 0.02) + '%';
        if (elBall) elBall.style.top = (35 - val * 0.015) + '%';
        if (elWicket) elWicket.style.transform = `rotate(${val * 0.05}deg)`;
    });
</script>
