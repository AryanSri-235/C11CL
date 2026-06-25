<?php $page_title = "Contact Us"; ?>
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
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        .contact-info-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-top: 6px solid #dc2618;
        }
        .contact-info-card h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: #0e1b30;
            margin: 0 0 10px;
            text-transform: uppercase;
        }
        .contact-info-card h3 span {
            color: #dc2618;
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        .info-icon {
            background: #fff5f5;
            color: #dc2618;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 18px;
            flex-shrink: 0;
            border: 1px solid #ffeded;
        }
        .info-icon.whatsapp {
            background: #f0fff4;
            color: #25d366;
            border-color: #e1ffed;
        }
        .info-text h6 {
            margin: 0 0 4px;
            font-size: 1rem;
            color: #0e1b30;
            font-weight: 700;
        }
        .info-text p, .info-text a {
            margin: 0;
            color: #4b5563;
            font-size: 0.92rem;
            text-decoration: none;
            line-height: 1.5;
        }
        .info-text a:hover {
            color: #dc2618;
        }
        .social-row {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }
        .social-btn {
            color: #fff;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: transform 0.3s ease;
            text-decoration: none;
        }
        .social-btn:hover {
            transform: translateY(-3px);
        }

        /* Form Card */
        .contact-form-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
        }
        .contact-form-card h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: #0e1b30;
            margin: 0 0 10px;
            text-transform: uppercase;
        }
        .contact-form-card h3 span {
            color: #dc2618;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-field {
            position: relative;
        }
        .form-field i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        .form-field.textarea-field i {
            top: 20px;
            transform: none;
        }
        .form-field input, .form-field textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 14px 15px 14px 45px;
            border: 2px solid #f3f4f6;
            border-radius: 8px;
            outline: none;
            background: #f9fafb;
            font-family: inherit;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }
        .form-field input:focus, .form-field textarea:focus {
            border-color: #dc2618;
        }
        .form-field textarea {
            height: 140px;
            resize: none;
        }
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #0e1b30;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            font-family: 'Barlow Condensed', sans-serif;
            letter-spacing: 1px;
            transition: background 0.3s;
        }
        .submit-btn:hover {
            background: #dc2618;
        }
        
        .map-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
            margin-top: 40px;
        }

        @media (max-width: 900px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
            .form-row {
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
    <p class="c11p-intro" style="margin-top: 10px; color: #4b5563;">Feel free to contact us for any questions and doubts. Our team is always here to assist you.</p>
</div>

<div class="c11p-content">
    
    <div class="contact-grid">
        
        <!-- Left Column: Get In Touch -->
        <div class="contact-info-card">
            <h3>Get In <span>Touch</span></h3>
            <p style="color: #6b7280; font-size: 0.92rem; margin-bottom: 30px;">Reach out to us via any of these channels. Our team is ready to assist you.</p>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="info-text">
                    <h6>Head Office</h6>
                    <p>3rd Floor, G-13, G Block, Sector 6, Noida, Uttar Pradesh 201301</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div class="info-text">
                    <h6>Email Support</h6>
                    <p><a href="mailto:info@c11cl.com">info@c11cl.com</a></p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <div class="info-text">
                    <h6>Call Us</h6>
                    <p><a href="tel:+919599505213">+91 9599505213</a></p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon whatsapp">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div class="info-text">
                    <h6>WhatsApp Support</h6>
                    <p><a href="https://wa.me/919211760909" target="_blank">+91 9211760909</a></p>
                </div>
            </div>

            <h6 style="color: #0e1b30; font-weight: 700; font-size: 0.95rem; margin: 30px 0 10px;">Connect Socially</h6>
            <div class="social-row">
                <a href="https://facebook.com/people/Champions11CricketLeague/61575926537950/" target="_blank" class="social-btn" style="background: #1877F2;">
                   <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="https://x.com/champions11cl" target="_blank" class="social-btn" style="background: #000;">
                   <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="https://www.instagram.com/c11cl_official/" target="_blank" class="social-btn" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">
                   <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.youtube.com/@C11CLOfficial" target="_blank" class="social-btn" style="background: #FF0000;">
                   <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>

        <!-- Right Column: Send Message -->
        <div class="contact-form-card">
            <h3>Send A <span>Message</span></h3>
            <p style="color: #6b7280; font-size: 0.92rem; margin-bottom: 30px;">Have questions? Drop us a line and we'll get back to you shortly.</p>

            <form id="contactForm">
                <div class="form-row">
                    <div class="form-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" id="c_name" placeholder="Full Name" required>
                    </div>
                    <div class="form-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="c_email" placeholder="Email Address" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name="phone" id="c_phone" placeholder="Mobile Number" minlength="10" maxlength="10" pattern="[0-9]{10}" required>
                    </div>
                    <div class="form-field">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <input type="text" name="subject" id="c_subject" placeholder="Subject" required>
                    </div>
                </div>

                <div class="form-field textarea-field" style="margin-bottom: 25px;">
                    <i class="fa-solid fa-message"></i>
                    <textarea name="message" id="c_message" placeholder="How can we help you?" required></textarea>
                </div>

                <button type="submit" id="submitBtn" class="submit-btn">
                    <span id="btnText">SEND MESSAGE</span>
                    <span id="loaderText" style="display: none;"><i class="fa-solid fa-circle-notch fa-spin"></i> Processing...</span>
                    <i class="fa-solid fa-paper-plane" id="planeIcon"></i>
                </button>
            </form>
        </div>

    </div>

    <!-- Map View -->
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3503.127464800389!2d77.31838537528762!3d28.5959526756848!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce57b6c2848a5%3A0x758d7cbf927e5c39!2sChampions%2011%20Cricket%20League%20(C11CL)!5e0!3m2!1sen!2sin!4v1778573246262!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    
    if(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 

            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loaderText = document.getElementById('loaderText');
            const planeIcon = document.getElementById('planeIcon');
            
            const formData = new FormData(this);

            const phoneVal = document.getElementById('c_phone').value.trim();
            if (!/^\d{10}$/.test(phoneVal)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Mobile Number',
                    text: 'Please enter a valid 10-digit mobile number.',
                    confirmButtonColor: '#0e1b30'
                });
                return;
            }

            btn.disabled = true;
            btnText.style.display = 'none';
            planeIcon.style.display = 'none';
            loaderText.style.display = 'inline-block';

            // Pointing to relative path
            fetch('../Panel/submit_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                resetBtn();
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sent!',
                        text: data.message || 'Message sent successfully',
                        confirmButtonColor: '#0e1b30'
                    }).then(function() {
                        window.location.href = '<?php echo BASE_URL; ?>';
                    });
                    form.reset();
                } else {
                    Swal.fire({ icon: 'error', title: 'Oops!', text: data.message });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resetBtn();
                Swal.fire({ icon: 'error', title: 'Error', text: 'Server connection failed.' });
            });

            function resetBtn() {
                btn.disabled = false;
                btnText.style.display = 'inline-block';
                planeIcon.style.display = 'inline-block';
                loaderText.style.display = 'none';
            }
        });
    }
});
</script>

<?php include "../foot.php"; ?>
</body>
</html>