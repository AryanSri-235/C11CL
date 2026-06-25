<?php $page_title = "Testimonials"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | C11CL</title>
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .testi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin: 40px 0;
        }
        .testi-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,31,63,0.05);
            border: 1px solid #edf2f7;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .testi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(220,38,24,0.1);
            border-color: #dc2618;
        }
        .testi-img-wrap {
            width: 100%;
            height: 240px;
            position: relative;
            overflow: hidden;
            background: #0e1b30;
        }
        .testi-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.95;
            transition: transform 0.3s;
        }
        .testi-card:hover .testi-img-wrap img {
            transform: scale(1.03);
        }
        .play-btn {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: #dc2618;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(220,38,24,0.4);
            z-index: 2;
            transition: transform 0.3s, background-color 0.3s;
            text-decoration: none;
        }
        .play-btn:hover {
            transform: scale(1.1);
            background: #0e1b30;
        }
        .testi-img-wrap::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.3));
        }
        .testi-body {
            padding: 25px;
            background: #fff;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .testi-stars {
            color: #f1c40f;
            font-size: 14px;
            margin-bottom: 12px;
        }
        .testi-quote {
            color: #4b5563;
            font-size: 0.93rem;
            line-height: 1.6;
            margin: 0 0 20px;
        }
        .testi-footer {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 15px;
            border-top: 1px solid #f3f4f6;
        }
        .testi-avatar {
            width: 40px;
            height: 40px;
            background: #0e1b30;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        .testi-avatar.alt-color {
            background: #dc2618;
        }
        .testi-info h4 {
            margin: 0 0 2px;
            font-size: 0.95rem;
            color: #0e1b30;
            font-weight: 700;
        }
        .testi-info span {
            font-size: 11px;
            color: #dc2618;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 900px) {
            .testi-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .testi-grid {
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
    <p class="c11p-intro" style="margin-top: 10px; color: #dc2618; font-weight: 600;">What Players & Parents Say About Us</p>
    <p style="color: #4b5563; max-width: 750px; margin: 15px auto 0 auto; line-height: 1.6;">
        These are not just words — they are proof that when you build something honest, people feel it. Hear from the players who have lived the C11CL journey and the families who trusted us with their child's dream.
    </p>
</div>

<div class="c11p-content">
    
    <div class="testi-grid">
        
        <!-- Card 1 -->
        <div class="testi-card">
            <div class="testi-img-wrap">
                <img src="../wp-content/uploads/2026/review/2.png" alt="Rahul Verma">
                <a href="https://www.instagram.com/reel/DXterX-ieBQ/?utm_source=ig_web_copy_link&igsh=NTc4MTIwNjQ2YQ==" target="_blank" class="play-btn"><i class="fa-solid fa-play"></i></a>
            </div>
            <div class="testi-body">
                <div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"C11CL is an incredible platform for players from small villages to showcase their talent on a grand stage. It provides a rare opportunity to compete with top players from all over India."</p>
                </div>
                <div class="testi-footer">
                    <div class="testi-avatar">RV</div>
                    <div class="testi-info">
                        <h4>Rahul Verma</h4>
                        <span>Batsman | Uttar Pradesh</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="testi-card">
            <div class="testi-img-wrap">
                <img src="../wp-content/uploads/2026/review/1.png" alt="Amit Patel">
                <a href="#" class="play-btn" onclick="return false;" style="opacity: 0.5; pointer-events: none;"><i class="fa-solid fa-play"></i></a>
            </div>
            <div class="testi-body">
                <div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"The environment was excellent and highly professional. The coaches were very supportive, and the entire trial process was managed flawlessly. Truly impressed with the management!"</p>
                </div>
                <div class="testi-footer">
                    <div class="testi-avatar alt-color">AP</div>
                    <div class="testi-info">
                        <h4>Amit Patel</h4>
                        <span>Parent | Gujarat</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="testi-card">
            <div class="testi-img-wrap">
                <img src="../wp-content/uploads/2026/review/3.png" alt="Mohammad Ali">
                <a href="https://www.instagram.com/reel/DXbdIRrFAoh/?utm_source=ig_web_copy_link&igsh=NTc4MTIwNjQ2YQ==" target="_blank" class="play-btn"><i class="fa-solid fa-play"></i></a>
            </div>
            <div class="testi-body">
                <div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"I had an amazing experience during my first trial with C11CL. I learned so much today! I highly recommend others to join these trials as it’s the best platform to showcase your skills."</p>
                </div>
                <div class="testi-footer">
                    <div class="testi-avatar">MA</div>
                    <div class="testi-info">
                        <h4>Mohammad Ali</h4>
                        <span>Player | Afghanistan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="testi-card">
            <div class="testi-img-wrap">
                <img src="../wp-content/uploads/2026/review/4.png" alt="Parent Review">
                <a href="https://www.instagram.com/reel/DXRJ7q4k6RD/?utm_source=ig_web_copy_link&igsh=NTc4MTIwNjQ2YQ==" target="_blank" class="play-btn"><i class="fa-solid fa-play"></i></a>
            </div>
            <div class="testi-body">
                <div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"We came along to ensure our child's safety, but the management here is outstanding. The coaches treat every player like their own children, guiding them with care. This is a truly trustworthy platform for young talent."</p>
                </div>
                <div class="testi-footer">
                    <div class="testi-avatar alt-color">PR</div>
                    <div class="testi-info">
                        <h4>Parent Review</h4>
                        <span>Guardian | India</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="testi-card">
            <div class="testi-img-wrap">
                <img src="../wp-content/uploads/2026/review/5.png" alt="Ashish">
                <a href="https://www.instagram.com/reel/DW3Z8_WkWM4/?utm_source=ig_web_copy_link&igsh=NTc4MTIwNjQ2YQ==" target="_blank" class="play-btn"><i class="fa-solid fa-play"></i></a>
            </div>
            <div class="testi-body">
                <div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"I heard about C11CL from my friends and decided to give the trials. It was an amazing experience! The coaches and staff were very cooperative, and I even made many new friends here while enjoying the game."</p>
                </div>
                <div class="testi-footer">
                    <div class="testi-avatar">AS</div>
                    <div class="testi-info">
                        <h4>Ashish</h4>
                        <span>Junior Player (Age: 14) | India</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="testi-card">
            <div class="testi-img-wrap">
                <img src="../wp-content/uploads/2026/review/6.png" alt="Parent Review">
                <a href="https://www.instagram.com/reel/DWLoi2FDfAy/?utm_source=ig_web_copy_link&igsh=NTc4MTIwNjQ2YQ==" target="_blank" class="play-btn"><i class="fa-solid fa-play"></i></a>
            </div>
            <div class="testi-body">
                <div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"I discovered C11CL through Instagram and brought my child here. It gave him the chance to play with other professional players and provided the perfect bridge to transition from street cricket to a professional level."</p>
                </div>
                <div class="testi-footer">
                    <div class="testi-avatar alt-color">PR</div>
                    <div class="testi-info">
                        <h4>Parent Review</h4>
                        <span>Guardian | India</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "../foot.php"; ?>
</body>
</html>