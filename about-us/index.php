<?php $page_title = "About Us"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | C11CL</title>
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .about-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 40px;
            align-items: center;
            margin-bottom: 40px;
        }
        .about-grid.reverse {
            grid-template-columns: 1fr 1.2fr;
        }
        .about-text h2 {
            font-family: 'Barlow Condensed', sans-serif !important;
            font-size: 2rem !important;
            font-weight: 800 !important;
            color: #0e1b30 !important;
            text-transform: uppercase !important;
            margin-top: 0 !important;
        }
        .about-img-wrap {
            position: relative;
        }
        .about-img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: 5px solid #fff;
        }
        
        /* Stats Grid */
        .about-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 40px 0;
        }
        .about-stat-card {
            background: #0e1b30;
            color: #fff;
            padding: 24px;
            border-radius: 12px;
            text-align: center;
            border-bottom: 4px solid #dc2618;
            transition: transform 0.3s ease;
        }
        .about-stat-card:hover {
            transform: translateY(-5px);
        }
        .about-stat-card h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.5rem;
            margin: 0;
            color: #dc2618;
            font-weight: 800;
        }
        .about-stat-card p {
            margin: 5px 0 0;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* Philosophy Grid */
        .phil-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin: 40px 0;
        }
        .phil-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border-left: 4px solid #dc2618;
            transition: transform 0.3s ease;
        }
        .phil-card:hover {
            transform: translateY(-5px);
        }
        .phil-card i {
            font-size: 2.2rem;
            color: #dc2618;
            margin-bottom: 20px;
        }
        .phil-card h4 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #0e1b30;
            margin: 0 0 10px;
            text-transform: uppercase;
        }
        .phil-card p {
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }

        /* CEO Section */
        .ceo-card {
            display: flex;
            align-items: center;
            gap: 40px;
            background: #f8fafd;
            padding: 40px;
            border-radius: 20px;
            margin: 40px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }
        .ceo-img-container {
            position: relative;
            flex-shrink: 0;
        }
        .ceo-img {
            width: 260px;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            border: 5px solid #fff;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .ceo-linkedin {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: #0077b5;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(0,119,181,0.3);
            transition: transform 0.3s;
        }
        .ceo-linkedin:hover {
            transform: scale(1.1);
        }
        .ceo-content h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.2rem;
            color: #0e1b30;
            margin: 0;
            font-weight: 800;
            text-transform: uppercase;
        }
        .ceo-title {
            color: #dc2618;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.95rem;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 15px;
        }
        .ceo-text {
            font-size: 0.96rem;
            color: #4b5563;
            line-height: 1.7;
            margin-bottom: 20px;
        }
        .ceo-footer {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .ceo-btn {
            background: #0e1b30;
            color: #fff;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            transition: background 0.3s;
        }
        .ceo-btn:hover {
            background: #dc2618;
        }
        .ceo-sig {
            height: 40px;
        }

        /* Ecosystem Grid */
        .eco-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 40px 0;
        }
        .eco-card {
            background: #0e1b30;
            color: #fff;
            padding: 24px;
            border-radius: 12px;
            border-bottom: 4px solid #dc2618;
        }
        .eco-card h4 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.2rem;
            color: #fff;
            margin: 0 0 10px;
            text-transform: uppercase;
            font-weight: 700;
        }
        .eco-card p {
            color: #a0aec0;
            font-size: 0.88rem;
            line-height: 1.5;
            margin: 0;
        }

        /* Gallery Grid */
        .c11-impact-section {
            padding: 40px 0;
            text-align: center;
            overflow: hidden;
        }
        .impact-scroll-container {
            display: flex;
            width: 100%;
            overflow: hidden;
            margin-top: 30px;
        }
        .impact-track {
            display: flex;
            gap: 20px;
            animation: impactScroll 45s linear infinite;
        }
        .impact-track:hover {
            animation-play-state: paused;
        }
        .impact-card {
            width: 280px;
            height: 220px;
            flex-shrink: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            transition: transform 0.3s, border-color 0.3s;
            border: 3px solid transparent;
        }
        .impact-card:hover {
            transform: translateY(-5px);
            border-color: #dc2618;
        }
        .impact-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        @keyframes impactScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-280px * 18 - 20px * 18)); }
        }

        @media (max-width: 900px) {
            .about-grid, .about-grid.reverse {
                grid-template-columns: 1fr;
            }
            .about-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            .phil-grid {
                grid-template-columns: 1fr;
            }
            .ceo-card {
                flex-direction: column;
                text-align: center;
                padding: 30px 20px;
            }
            .eco-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .about-stats, .eco-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<?php include "../head.php"; ?>

<div class="c11p-breadcrumb">
    <div class="c11p-breadcrumb-inner">
        <a href="<?php echo BASE_URL; ?>">Home</a>
        <span class="sep">›</span>
        <span class="cur"><?php echo $page_title; ?></span>
    </div>
</div>

<div class="c11p-title-block">
    <h1><?php echo $page_title; ?></h1>
    <p class="c11p-intro" style="margin-top: 10px; font-weight: 600; color: #dc2618;">Fueling Dreams, One Over at a Time</p>
</div>

<div class="c11p-content">
    
    <!-- Section 1: About Us -->
    <div class="about-grid" data-aos="fade-right">
        <div class="about-text">
            <h2 style="color: #dc2618 !important;">Every Corner of India Has a Champion. <span style="color:#0e1b30;">We Find Them.</span></h2>
            <p>C11CL is not just a league. It is a mission to discover, nurture, and elevate cricketing talent from every corner of India — through a system where performance is the only currency.</p>
            <p><strong>No references. No politics. No financial barriers.</strong> Just your game, judged fairly, by certified coaches, on a national stage.</p>
        </div>
        <div class="about-img-wrap">
            <img src="../wp-content/uploads/2026/about/1.png" class="about-img" alt="C11CL Champions">
        </div>
    </div>

    <!-- Section 2: Our Story -->
    <div class="about-grid reverse" data-aos="fade-left">
        <div class="about-img-wrap">
            <img src="../wp-content/uploads/2026/about/2.png" class="about-img" alt="C11CL Mission">
        </div>
        <div class="about-text">
            <h2>We Saw the Gap. We Built the Bridge.</h2>
            <p>Founded in 2025, C11CL was born from a problem that nobody was solving. Talented cricketers across India — from Bihar to Himachal, from Jharkhand to Rajasthan — were playing their hearts out with nowhere to go.</p>
            <p>We built a system to close it: Open state-wise trials across 23+ states, performance-based selection assessed by BCCI Certified Coaches, and a complete journey from trial to T20 to national championship.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="about-stats" data-aos="fade-up">
        <div class="about-stat-card">
            <h3>23+</h3>
            <p>States Covered</p>
        </div>
        <div class="about-stat-card">
            <h3>46+</h3>
            <p>Cities Reached</p>
        </div>
        <div class="about-stat-card">
            <h3>20+</h3>
            <p>Trials Done</p>
        </div>
        <div class="about-stat-card">
            <h3>2000+</h3>
            <p>Players Joined</p>
        </div>
    </div>

    <!-- Section 3: Journey Text -->
    <div class="c11p-section" data-aos="fade-up" style="border-left-color: #dc2618;">
        <div class="c11p-section-heading">
            <span class="c11p-icon"><i class="fa-solid fa-route"></i></span>
            <h3>From One Idea to a National Movement</h3>
        </div>
        <p>What started as a belief that every talented cricketer in India deserves a fair shot has grown into something far bigger than we imagined. In a short span of time, C11CL has conducted 20+ trials, reached 46+ cities, covered 23+ states, and registered 2,000+ players — each one of them carrying a dream that this platform is committed to honoring.</p>
        <p>We have seen first-generation cricketers step onto a proper ground for the first time. We have watched players from unknown towns get picked in a live auction. We have handed kits to kids who had never worn one. Every number tells a story. Every player is proof that when you build a system that is truly fair, talent shows up from every corner of India. And we are just getting started.</p>
    </div>

    <!-- Section 4: Core Values -->
    <h2 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.8rem; font-weight: 800; color: #0e1b30; text-transform: uppercase; margin-top: 40px; text-align: center;">More Than a League. What We Stand For</h2>
    <div class="phil-grid" data-aos="fade-up">
        <div class="phil-card">
            <i class="fa-solid fa-rocket"></i>
            <h4>Our Mission</h4>
            <p>To discover and elevate talent from every corner of India through a transparent, merit-based system that ensures a fair shot for every aspiring player.</p>
        </div>
        <div class="phil-card">
            <i class="fa-solid fa-eye"></i>
            <h4>Our Vision</h4>
            <p>To become India's most trusted grassroots league where any player can rise through sheer skill, hard work, and the love of the game.</p>
        </div>
        <div class="phil-card">
            <i class="fa-solid fa-heart"></i>
            <h4>Core Values</h4>
            <p>Discipline, Dedication, and Diversity. We believe character is built on the field, and talent knows no boundaries.</p>
        </div>
    </div>

    <!-- Section 5: CEO Card -->
    <div class="ceo-card" data-aos="zoom-in">
        <div class="ceo-img-container">
            <img src="../wp-content/uploads/2025/09/Screenshot-2025-09-21-182224.png" class="ceo-img" alt="Ruuchi Gautam Pant">
            <a href="https://in.linkedin.com/in/ruuchi-pant-ph-d-0485465" target="_blank" class="ceo-linkedin">
                <i class="fa-brands fa-linkedin-in"></i>
            </a>
        </div>
        <div class="ceo-content">
            <span class="ceo-tagline">The Visionary Force</span>
            <h3>Ruuchi Gautam Pant</h3>
            <span class="ceo-title">Founder and CEO</span>
            <p class="ceo-text">
                Ruuchi Gautam Pant is the visionary force behind C11CL. With a deep passion for sports and youth development, she laid the foundation to create a transparent and empowering platform for aspiring cricketers. Her leadership reflects inclusivity and a relentless commitment to discovering grassroots talent across India.
            </p>
            <div class="ceo-footer">
                <a href="../founder/" class="ceo-btn">Know More <i class="fa-solid fa-arrow-right-long" style="margin-left: 5px;"></i></a>
                <img src="../wp-content/uploads/2025/07/signature-3.png" class="ceo-sig" alt="Signature">
            </div>
        </div>
    </div>

    <!-- Section 6: Ecosystem -->
    <h2 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.8rem; font-weight: 800; color: #0e1b30; text-transform: uppercase; margin-top: 40px; text-align: center;">A Complete System Built Around the Player</h2>
    <div class="eco-grid" data-aos="fade-up">
        <div class="eco-card">
            <h4>Transparent Selection</h4>
            <p>Assessed by BCCI, ICC, and NIS Certified Coaches who evaluate nothing but performance.</p>
        </div>
        <div class="eco-card">
            <h4>Professional Setup</h4>
            <p>Printed jerseys, kits, and professional scoring for a true league-like experience.</p>
        </div>
        <div class="eco-card">
            <h4>National Stage</h4>
            <p>A pathway from trials to live auctions and national championships.</p>
        </div>
        <div class="eco-card">
            <h4>Community & Partners</h4>
            <p>Backed by partners who support our mission to support players on and off the field.</p>
        </div>
    </div>

    <!-- Section 7: Impact Scrolling Gallery -->
    <div class="c11-impact-section" data-fancybox="impact-gallery" data-aos="fade-up">
        <h2 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.8rem; font-weight: 800; color: #0e1b30; text-transform: uppercase; margin: 0 0 10px;">These Smiles Were Earned on the Field</h2>
        <p style="color: #4b5563; font-size: 0.95rem; margin-bottom: 30px;">Behind every photograph is a player who showed up, gave everything, and walked away knowing their talent was seen. This is what C11CL looks like in real life.</p>
        
        <div class="impact-scroll-container">
            <div class="impact-track" id="impactGallery">
                <!-- Images injected via Javascript -->
            </div>
        </div>
    </div>

</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });

    // Inject images for seamless scrolling gallery
    const track = document.getElementById('impactGallery');
    const imagePath = "../wp-content/uploads/2026/about-happy-face/";
    const totalImages = 18;

    let galleryHTML = '';
    for (let j = 0; j < 2; j++) {
        for (let i = 1; i <= totalImages; i++) {
            galleryHTML += `
                <a href="${imagePath}${i}.png" class="impact-card" data-fancybox="impact-gallery">
                    <img src="${imagePath}${i}.png" alt="Happy Face ${i}" loading="lazy">
                </a>
            `;
        }
    }
    track.innerHTML = galleryHTML;

    Fancybox.bind("[data-fancybox='impact-gallery']", {
        Toolbar: {
            display: {
                left: ["infobar"],
                middle: [],
                right: ["iterateZoom", "close"],
            },
        },
    });
</script>

<?php include "../foot.php"; ?>
</body>
</html>