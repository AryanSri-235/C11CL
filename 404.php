<!DOCTYPE html>
<html lang="en-US">
<head>
    <?php include "head.php"; ?>
    
    <style>
        /* Sirf Error Section ke liye extra styling - theme se match karti hui */
        .error-section-c11 {
            padding: 100px 0;
            text-align: center;
            background: #ffffff;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        .error-content-box {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .error-404-title {
            font-family: 'Oswald', sans-serif !important;
            font-size: 120px;
            color: #d71a21;
            line-height: 1;
            margin: 0;
        }
        .error-sub-text {
            font-family: 'Oswald', sans-serif !important;
            font-size: 32px;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: #000;
        }
        .error-desc {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
        }
        .error-btns-wrapper {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .c11-btn {
            padding: 15px 35px;
            text-transform: uppercase;
            font-weight: 600;
            border-radius: 4px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            font-family: 'Poppins', sans-serif;
        }
        .btn-main {
            background: #d71a21;
            color: #fff !important;
        }
        .btn-sec {
            background: #1a1a1a;
            color: #fff !important;
        }
        .c11-btn:hover {
            opacity: 0.8;
            transform: translateY(-3px);
        }
        @media (max-width: 768px) {
            .error-404-title { font-size: 80px; }
            .error-sub-text { font-size: 24px; }
            .c11-btn { width: 100%; }
        }
    </style>
</head>

<body class="error404 elementor-default elementor-kit-247">
    
    <div id="page" class="hfeed site">
        
        <div id="content" class="site-content">
            <div class="ast-container">
                <main id="main" class="site-main">
                    
                    <section class="elementor-section elementor-top-section error-section-c11">
                        <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-column elementor-col-100">
                                <div class="elementor-widget-wrap">
                                    
                                    <div class="error-content-box">
                                        <div class="elementor-element">
                                            <img src="https://c11cl.com/wp-content/uploads/2025/05/favicon-3.png" style="width: 100px; margin-bottom: 20px;">
                                        </div>

                                        <h1 class="error-404-title">404</h1>
                                        <h2 class="error-sub-text">You're Clean Bowled!</h2>
                                        
                                        <p class="error-desc">
                                            Maafi chahte hain! Jo page aap dhund rahe hain wo boundary ke bahar chala gaya hai. 
                                            Niche diye gaye buttons se wapas maidan mein lautein.
                                        </p>

                                        <div class="error-btns-wrapper">
                                            <a href="https://c11cl.com/" class="c11-btn btn-main">Home Page</a>
                                            <a href="https://c11cl.com/registration/" class="c11-btn btn-sec">Register Now</a>
                                            <a href="https://c11cl.com/news-updates/" class="c11-btn btn-sec">News & Updates</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    </main>
            </div>
        </div>

        <?php include "foot.php"; ?>
    </div>

</body>
</html>