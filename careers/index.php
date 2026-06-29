<?php $page_title = "Careers"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers | C11CL</title>
    <link rel="icon" href="../wp-content/uploads/2025/05/favicon-3.png" type="image/png">
    <?php include "../layout/policy-style.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Breadcrumb override for dot-style */
        .careers-breadcrumb {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            padding: 28px 0 0;
            margin-bottom: 20px;
        }
        .careers-breadcrumb a { color: #9ca3af; text-decoration: none; }
        .careers-breadcrumb a:hover { color: #dc2618; }
        .careers-breadcrumb .dot { margin: 0 8px; color: #9ca3af; }
        .careers-breadcrumb .cur { color: #dc2618; }

        /* Hero text */
        .careers-hero {
            padding-bottom: 32px;
        }
        .careers-hero-label {
            display: inline-block;
            font-size: 0.78rem;
            font-weight: 800;
            color: #dc2618;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 18px;
            font-family: 'Barlow Condensed', sans-serif;
        }
        .careers-hero h1 {
            font-family: 'Barlow Condensed', 'Heebo', sans-serif;
            font-size: clamp(2.4rem, 6vw, 4.2rem);
            font-weight: 900;
            color: #0e1b30;
            text-transform: uppercase;
            line-height: 1.05;
            margin: 0 0 6px;
        }
        .careers-hero h1 .red { color: #dc2618; }
        .careers-hero-sep {
            border: none;
            border-top: 1px solid #e0e0e0;
            margin: 28px 0 28px;
        }
        .careers-hero-intro {
            font-size: 1.02rem;
            color: #555;
            line-height: 1.8;
            max-width: 760px;
            margin: 0 0 36px;
        }

        /* Team photo */
        .careers-photo {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 50px;
            max-height: 420px;
        }
        .careers-photo img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            object-position: center top;
            display: block;
        }

        /* Feature cards 2x2 */
        .careers-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1px;
            background: #e5e7eb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 60px;
        }
        .career-card {
            background: #fff;
            padding: 36px 32px 36px 36px;
            border-left: 5px solid #dc2618;
            position: relative;
        }
        .career-card.navy { border-left-color: #0e1b30; }
        .career-card h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.15rem;
            font-weight: 900;
            color: #0e1b30;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 14px;
        }
        .career-card p {
            color: #6b7280;
            font-size: 0.93rem;
            line-height: 1.7;
            margin: 0;
        }

        /* Application Portal */
        .careers-portal-wrap {
            background: #f3f6fc;
            border-radius: 16px;
            padding: 52px 52px;
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 60px;
            align-items: start;
            margin-bottom: 40px;
        }
        .portal-left h2 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.4rem;
            font-weight: 900;
            color: #0e1b30;
            text-transform: uppercase;
            margin: 0 0 16px;
            line-height: 1;
        }
        .portal-left h2 span { color: #dc2618; }
        .portal-left > p {
            color: #555;
            font-size: 0.97rem;
            line-height: 1.75;
            margin: 0 0 32px;
        }
        .careers-contact-box {
            background: #0e1b30;
            padding: 28px 32px;
            border-radius: 12px;
        }
        .careers-contact-box p {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.55);
            margin: 0 0 6px;
        }
        .careers-contact-box h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.85rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
            letter-spacing: 0.5px;
        }

        /* Form */
        .careers-form input[type="text"],
        .careers-form input[type="email"],
        .careers-form input[type="tel"],
        .careers-form input[type="file"] {
            width: 100%;
            box-sizing: border-box;
            padding: 15px 16px;
            border: 1.5px solid #dde1e8;
            border-radius: 10px;
            background: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            color: #374151;
            outline: none;
            margin-bottom: 16px;
            transition: border-color 0.25s;
        }
        .careers-form input:focus { border-color: #dc2618; }
        .careers-form input::placeholder { color: #9ca3af; }

        .cv-upload-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #0e1b30;
            margin-bottom: 6px;
        }
        .cv-upload-wrap {
            border: 1.5px dashed #c8d0de;
            border-radius: 10px;
            padding: 14px 16px;
            background: #fff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: border-color 0.25s;
        }
        .cv-upload-wrap:hover { border-color: #dc2618; }
        .cv-upload-wrap input[type="file"] {
            padding: 0; border: none; background: none;
            margin-bottom: 0; flex: 1;
        }

        .careers-submit-btn {
            width: 100%;
            padding: 17px;
            background: #dc2618;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 900;
            cursor: pointer;
            text-transform: uppercase;
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: 2px;
            transition: background 0.25s, transform 0.2s;
        }
        .careers-submit-btn:hover { background: #0e1b30; transform: translateY(-2px); }
        .careers-submit-btn:disabled { background: #9ca3af; cursor: not-allowed; transform: none; }

        @media (max-width: 900px) {
            .careers-grid { grid-template-columns: 1fr; }
            .careers-portal-wrap { grid-template-columns: 1fr; gap: 36px; padding: 32px 20px; }
        }
    </style>
</head>
<body>
<?php include "../head.php"; ?>

<div class="c11p-content">

    <!-- Breadcrumb -->
    <div class="careers-breadcrumb">
        <a href="<?php echo BASE_URL; ?>">Home</a>
        <span class="dot">·</span>
        <span class="cur">Careers</span>
    </div>

    <!-- Hero -->
    <div class="careers-hero">
        <span class="careers-hero-label">Executive Recruitment 2026</span>
        <h1>Architecting the Future of<br><span class="red">Professional Cricket.</span></h1>
        <hr class="careers-hero-sep">
        <p class="careers-hero-intro">Join the leadership team at Champions 11 Cricket League. We are seeking high-caliber professionals to manage operations, media, and talent development across India.</p>
    </div>

    <!-- Team photo -->
    <div class="careers-photo">
        <img src="../wp-content/uploads/2025/06/Lucid_Realism_A_group_of_young_Indian_male_cricketers_training_1-1024x1536.jpg"
             alt="C11CL Team" loading="lazy">
    </div>

    <!-- Feature cards -->
    <div class="careers-grid">
        <div class="career-card">
            <h3>Operational Excellence</h3>
            <p>We maintain the highest standards of sports governance, ensuring transparency and professional ethics in every match we organize.</p>
        </div>
        <div class="career-card navy">
            <h3>Strategic Growth</h3>
            <p>Our team members are key stakeholders in our expansion. We provide a clear roadmap for professional advancement within the organization.</p>
        </div>
        <div class="career-card">
            <h3>Innovation in Sports</h3>
            <p>From digital scouting to advanced analytics, we leverage technology to redefine how grassroots cricket is played and managed.</p>
        </div>
        <div class="career-card navy">
            <h3>Nationwide Legacy</h3>
            <p>With a presence in over 24 states, your work will directly contribute to creating the next generation of Indian cricket superstars.</p>
        </div>
    </div>

    <!-- Application Portal -->
    <div class="careers-portal-wrap">

        <div class="portal-left">
            <h2>Application <span>Portal</span></h2>
            <p>Submit your credentials for review. Our HR department analyzes every profile based on industry experience and passion for the sport.</p>
            <div class="careers-contact-box">
                <p>Career Inquiries</p>
                <h3>+91 9599505213</h3>
            </div>
        </div>

        <form class="careers-form" id="careersForm">
            <input type="text"  name="fullname"  placeholder="Full Name"              required>
            <input type="email" name="email"     placeholder="Email Address"          required>
            <input type="tel"   name="phone"     placeholder="Phone Number"           required minlength="10" maxlength="10" pattern="[0-9]{10}">
            <input type="text"  name="position"  placeholder="Position (e.g. Media Head)" required>

            <label class="cv-upload-label">Upload CV (PDF Only)</label>
            <div class="cv-upload-wrap">
                <i class="fa-solid fa-paperclip" style="color:#9ca3af;"></i>
                <input type="file" name="cv" accept=".pdf" id="cvInput">
            </div>

            <button type="submit" class="careers-submit-btn" id="careersSubmitBtn">
                Submit Application
            </button>
        </form>

    </div>

</div>

<script>
document.getElementById('careersForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('careersSubmitBtn');
    var phone = this.phone.value.trim();

    if (!/^\d{10}$/.test(phone)) {
        Swal.fire({ icon: 'error', title: 'Invalid Phone', text: 'Please enter a valid 10-digit mobile number.', confirmButtonColor: '#dc2618' });
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Submitting...';

    var formData = new FormData(this);

    fetch('/submit_career.php', { method: 'POST', body: formData })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            btn.disabled = false;
            btn.textContent = 'Submit Application';
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Application Submitted!',
                    text: 'Thank you for applying. Our HR team will review your profile and get in touch shortly.',
                    confirmButtonColor: '#dc2618',
                    confirmButtonText: 'OK'
                }).then(function() {
                    document.getElementById('careersForm').reset();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Submission Failed', text: data.message || 'Please try again.', confirmButtonColor: '#dc2618' });
            }
        })
        .catch(function() {
            btn.disabled = false;
            btn.textContent = 'Submit Application';
            Swal.fire({ icon: 'error', title: 'Error', text: 'Connection failed. Please try again.', confirmButtonColor: '#dc2618' });
        });
});
</script>

<?php include "../foot.php"; ?>
</body>
</html>
