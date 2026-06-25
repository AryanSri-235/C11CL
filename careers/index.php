<?php $page_title = "Careers"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | C11CL</title>
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .careers-hero-banner {
            background: #0e1b30;
            border-bottom: 4px solid #dc2618;
            padding: 80px 40px;
            color: #ffffff;
            border-radius: 12px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }
        .careers-hero-banner::after {
            content: "";
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: linear-gradient(135deg, rgba(14,27,48,0.9) 0%, rgba(220,38,24,0.15) 100%);
            z-index: 1;
        }
        .careers-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }
        .careers-hero-content span {
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #dc2618;
            font-weight: 800;
            font-size: 0.85rem;
            display: block;
            margin-bottom: 15px;
            font-family: 'Barlow Condensed', sans-serif;
        }
        .careers-hero-content h1 {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 900;
            line-height: 1.15;
            margin: 0 0 20px;
            color: #ffffff;
            font-family: 'Barlow Condensed', sans-serif;
            text-transform: uppercase;
        }
        .careers-hero-content p {
            font-size: 1.1rem;
            color: #bfd1ff;
            line-height: 1.6;
            margin: 0;
        }

        .careers-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-bottom: 50px;
        }
        .career-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #edf2f7;
            border-left: 5px solid #dc2618;
        }
        .career-card.navy-border {
            border-left-color: #0e1b30;
        }
        .career-card h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #0e1b30;
            margin: 0 0 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .career-card p {
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.65;
            margin: 0;
        }

        /* Application Portal layout */
        .portal-section {
            background-color: #f8fafd;
            border-radius: 20px;
            padding: 50px;
            display: grid;
            grid-template-columns: 1.1fr 1.3fr;
            gap: 50px;
            align-items: start;
            margin-bottom: 40px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.03);
        }
        .portal-info h2 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.2rem;
            font-weight: 900;
            color: #0e1b30;
            text-transform: uppercase;
            margin: 0 0 15px;
        }
        .portal-info h2 span {
            color: #dc2618;
        }
        .portal-info p {
            color: #4b5563;
            font-size: 1.05rem;
            line-height: 1.7;
            margin: 0 0 35px;
        }
        .inquiry-box {
            background: #0e1b30;
            color: #fff;
            padding: 30px;
            border-radius: 12px;
            border-left: 5px solid #dc2618;
            box-shadow: 0 10px 30px rgba(14,27,48,0.15);
        }
        .inquiry-box p {
            margin: 0;
            font-size: 0.85rem;
            text-transform: uppercase;
            opacity: 0.8;
            letter-spacing: 2px;
        }
        .inquiry-box h3 {
            margin: 8px 0 0;
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Barlow Condensed', sans-serif;
            color: #fff;
        }

        .portal-form-wrap {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #edf2f7;
        }
        .portal-form-wrap form input[type="text"],
        .portal-form-wrap form input[type="email"],
        .portal-form-wrap form input[type="tel"],
        .portal-form-wrap form input[type="file"] {
            width: 100%;
            box-sizing: border-box;
            padding: 14px 15px;
            border: 2px solid #f3f4f6;
            border-radius: 8px;
            outline: none;
            background: #f9fafb;
            font-family: inherit;
            font-size: 0.95rem;
            margin-bottom: 18px;
            transition: border-color 0.3s;
        }
        .portal-form-wrap form input:focus {
            border-color: #dc2618;
        }
        .portal-form-wrap label {
            display: block;
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 6px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .portal-submit-btn {
            width: 100%;
            padding: 16px;
            background: #dc2618;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: 1px;
            transition: background 0.3s;
        }
        .portal-submit-btn:hover {
            background: #0e1b30;
        }

        @media (max-width: 900px) {
            .portal-section {
                grid-template-columns: 1fr;
                gap: 40px;
                padding: 30px 20px;
            }
            .careers-grid {
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

<div class="c11p-content">
    
    <!-- Hero Section -->
    <div class="careers-hero-banner">
        <div class="careers-hero-content">
            <span>Executive Recruitment 2026</span>
            <h1>Architecting the Future of <br><span style="color: #dc2618;">Professional Cricket.</span></h1>
            <p>Join the leadership team at Champions 11 Cricket League. We are seeking high-caliber professionals to manage operations, media, and talent development across India.</p>
        </div>
    </div>

    <!-- Perks / Info Cards -->
    <div class="careers-grid">
        <div class="career-card">
            <h3>Operational Excellence</h3>
            <p>We maintain the highest standards of sports governance, ensuring transparency and professional ethics in every match we organize.</p>
        </div>
        <div class="career-card navy-border">
            <h3>Strategic Growth</h3>
            <p>Our team members are key stakeholders in our expansion. We provide a clear roadmap for professional advancement within the organization.</p>
        </div>
        <div class="career-card navy-border">
            <h3>Innovation in Sports</h3>
            <p>From digital scouting to advanced analytics, we leverage technology to redefine how grassroots cricket is played and managed.</p>
        </div>
        <div class="career-card">
            <h3>Nationwide Legacy</h3>
            <p>With a presence in over 24 states, your work will directly contribute to creating the next generation of Indian cricket superstars.</p>
        </div>
    </div>

    <!-- Application Portal section -->
    <div class="portal-section">
        
        <div class="portal-info">
            <h2>Application <span>Portal</span></h2>
            <p>Submit your credentials for review. Our HR department analyzes every profile based on industry experience and passion for the sport.</p>
            
            <div class="inquiry-box">
                <p>Career Inquiries</p>
                <h3>+91 9599505213</h3>
            </div>
        </div>

        <div class="portal-form-wrap">
            <form id="jobApplyForm" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="tel" name="phone" placeholder="Phone Number" required minlength="10" maxlength="10" pattern="[0-9]{10}">
                <input type="text" name="position" placeholder="Position (e.g. Media Head)" required>

                <div style="margin-bottom: 20px;">
                    <label>Upload CV (PDF format)</label>
                    <input type="file" name="cv" accept=".pdf" required style="margin-bottom: 0;">
                </div>

                <button type="submit" id="submitBtn" class="portal-submit-btn">
                    <span id="btnText">Submit Application</span>
                </button>
            </form>
        </div>

    </div>

</div>

<script>
document.getElementById('jobApplyForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const formData = new FormData(this);

    const phoneVal = formData.get('phone').trim();
    if (!/^\d{10}$/.test(phoneVal)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Phone Number',
            text: 'Please enter a valid 10-digit phone number.',
            confirmButtonColor: '#dc2618'
        });
        return;
    }

    btn.disabled = true;
    btn.style.background = '#9ca3af';
    btnText.innerText = 'Processing...';

    // Pointing to relative path
    fetch('../Panel/apply_job.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;
        btn.style.background = '#dc2618';
        btnText.innerText = 'Submit Application';

        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Sent!',
                text: data.message,
                confirmButtonColor: '#dc2618'
            });
            document.getElementById('jobApplyForm').reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
    .catch(error => {
        btn.disabled = false;
        btn.style.background = '#dc2618';
        btnText.innerText = 'Submit Application';
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Server connection failed.'
        });
    });
});
</script>

<?php include "../foot.php"; ?>
</body>
</html>