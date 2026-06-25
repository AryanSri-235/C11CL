<?php $page_title = "Trials Cities"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO Meta Tags -->
    <title>Trials Cities | Cricket Talent Hunt Locations | C11CL</title>
    <meta name="description" content="Discover C11CL Trials Cities across India. From Bihar to Himachal, find your nearest cricket talent hunt location. Register now for state-wise trials in 46+ cities and 23+ states." />
    <link rel="canonical" href="https://c11cl.com/trials-cities/" />
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Stats banner using brand palette */
        .presence-banner {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            background: #ffffff;
            padding: 35px 20px;
            border-radius: 12px;
            margin-bottom: 40px;
            border: 1px solid #edf2f7;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            text-align: center;
        }
        .stat-item {
            border-right: 1px solid #edf2f7;
        }
        .stat-item:last-child {
            border-right: none;
        }
        .stat-item h2 {
            font-size: 2.8rem;
            color: #dc2618;
            margin: 0;
            font-weight: 800;
            line-height: 1.1;
            font-family: 'Barlow Condensed', sans-serif;
        }
        .stat-item p {
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.8rem;
            color: #4b5563;
            margin: 8px 0 0;
            font-weight: 700;
        }

        /* Grid */
        .trials-grid-premium {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        /* Card design */
        .city-card-modern {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px 25px 30px 25px;
            transition: all 0.3s ease;
            border: 1px solid #edf2f7;
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 15px rgba(0,0,0,0.01);
        }
        .city-card-modern:hover {
            border-color: #dc2618;
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(220,38,24,0.08);
        }

        /* Clickable Status Badge Overlay Button */
        .reg-status-link {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #e6f7ed;
            color: #16a34a;
            font-size: 10px;
            font-weight: 800;
            padding: 5px 12px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            border: 1px solid rgba(22, 163, 74, 0.15);
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .reg-status-link::before {
            content: "";
            width: 6px;
            height: 6px;
            background: #16a34a;
            border-radius: 50%;
            animation: pulse-live 1.5s infinite;
        }
        .reg-status-link:hover {
            background: #16a34a;
            color: #ffffff;
            transform: scale(1.03);
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);
        }
        @keyframes pulse-live {
            0% { opacity: 0.4; }
            50% { opacity: 1; }
            100% { opacity: 0.4; }
        }

        .state-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .icon-holder {
            width: 40px;
            height: 40px;
            background: #f8fafc;
            color: #dc2618;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            border: 1px solid #edf2f7;
            transition: all 0.3s ease;
        }
        .city-card-modern:hover .icon-holder {
            background: #dc2618;
            color: white;
            border-color: #dc2618;
        }
        .state-name-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: #0e1b30;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .city-pill-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .city-pill {
            background: #f8fafc;
            color: #4b5563;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid #edf2f7;
            transition: all 0.3s ease;
        }
        .city-card-modern:hover .city-pill {
            border-color: #ffdada;
            background: #fff8f8;
            color: #dc2618;
        }

        @media (max-width: 990px) {
            .trials-grid-premium {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 650px) {
            .trials-grid-premium {
                grid-template-columns: 1fr;
            }
            .presence-banner {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .stat-item {
                border-right: none;
                border-bottom: 1px solid #edf2f7;
                padding-bottom: 15px;
            }
            .stat-item:last-child {
                border-bottom: none;
                padding-bottom: 0;
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
    <p class="c11p-intro" style="margin-top: 10px; color: #dc2618; font-weight: 600;">Find Your Playing Ground</p>
    <p style="color: #4b5563; max-width: 750px; margin: 15px auto 0 auto; line-height: 1.6;">
        At C11CL, we believe that talent isn't restricted to big stadiums—it thrives in every corner of India. To ensure no champion goes unnoticed, we conduct <strong>open state-wise trials across 46+ cities and 23+ states.</strong>
    </p>
</div>

<div class="c11p-content">
    
    <div class="presence-banner">
        <div class="stat-item">
            <h2>23+</h2>
            <p>States Covered</p>
        </div>
        <div class="stat-item">
            <h2>46+</h2>
            <p>Cities Active</p>
        </div>
        <div class="stat-item">
            <h2>100%</h2>
            <p>Fair Selection</p>
        </div>
    </div>

    <div class="trials-grid-premium" id="grid-container">
        <!-- Generated by JavaScript below -->
    </div>

</div>

<script>
    const data = {
        "Andhra Pradesh": ["Vishakhapatnam"],
        "Assam": ["Guwahati"],
        "Bihar": ["Patna"],
        "Chandigarh": ["Chandigarh"],
        "Chhattisgarh": ["Raipur", "Bilaspur"],
        "Delhi": ["Delhi"],
        "Goa": ["Madgaon"],
        "Gujarat": ["Ahmedabad", "Surat"],
        "Haryana": ["Gurugram", "Ambala"],
        "Himachal Pradesh": ["Shimla"],
        "Jammu and Kashmir": ["Jammu", "Srinagar"],
        "Jharkhand": ["Ranchi", "Jamshedpur"],
        "Karnataka": ["Bangalore"],
        "Kerala": ["Kochi"],
        "Madhya Pradesh": ["Bhopal", "Indore"],
        "Maharashtra": ["Mumbai", "Pune", "Nagpur", "Nanded"],
        "Odisha": ["Bhubaneswar"],
        "Punjab": ["Amritsar", "Ludhiana"],
        "Rajasthan": ["Jaipur", "Jodhpur", "Udaipur"],
        "Tamil Nadu": ["Chennai"],
        "Telangana": ["Hyderabad"],
        "Uttar Pradesh": ["Noida", "Lucknow", "Kanpur", "Varanasi"],
        "Uttarakhand": ["Dehradun"],
        "West Bengal": ["Kolkata"]
    };

    const container = document.getElementById('grid-container');

    Object.entries(data).forEach(([state, cities]) => {
        const card = document.createElement('div');
        card.className = 'city-card-modern';
        
        const pills = cities.map(city => `<span class="city-pill">${city}</span>`).join('');
        
        card.innerHTML = `
            <a href="../registration/" class="reg-status-link">Trials Open</a>
            <div class="state-title-wrap">
                <div class="icon-holder"><i class="fa-solid fa-map-pin"></i></div>
                <h3 class="state-name-text">${state}</h3>
            </div>
            <div class="city-pill-container">${pills}</div>
        `;
        container.appendChild(card);
    });
</script>

<?php include "../foot.php"; ?>
</body>
</html>
