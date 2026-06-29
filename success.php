
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<?php
session_start();

$mailSent = $_SESSION['mail_sent'] ?? false;
$mailTo   = $_SESSION['mail_to']   ?? '';

// Check if 'payreg' session variable is set
if (isset($_SESSION['payreg'])) {
    include 'db.php';

    // No status filter — Razorpay signature already verified the payment
    $regVal = $con->real_escape_string($_SESSION['payreg']);
    $sql = "SELECT * FROM register WHERE reg = '$regVal'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row     = $result->fetch_assoc();
        $reg     = $row["reg"];
        $paydate = $row["paydate"];
        $paytime = $row["paytime"];
        $name    = $row["name"];
        $age     = $row["age"];
        $player  = $row["player"];
        $city    = $row["city"];
        $state   = $row["state"];
        $mobile  = $row["mobile"];
    } else {
        header('Location: /failure.php');
        exit();
    }
} else {
    header('Location: /failure.php');
    exit();
}

$qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($reg) . '&size=150x150&margin=5';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C11CL - Registration Success</title>
  <link rel="icon" href="../Panel/assets/images/fevikon.png" type="image/png">
  <link href="/Panel/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #f2f6fc, #e6efff);
      font-family: 'Roboto', sans-serif;
      padding: 20px;
    }

    .card {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.6s ease-in-out;
    }

    .success-header {
      background: #28a745;
      color: #fff;
      padding: 5px;
    }

    .success-header img {
      width: 70px;
    }

    .player-section {
      padding: 20px;
    }

    .qr-section {
      background-color: #f8f9fa;
      padding: 20px;
      border-top: 1px solid #ddd;
    }

    .reg-section {
      background: #fff3cd;
      padding: 20px;
      border-top: 1px solid #ffeeba;
    }

    .social-links a {
      display: inline-flex;
      align-items: center;
      padding: 8px 14px;
      border-radius: 20px;
      font-size: 14px;
      margin: 4px;
      text-decoration: none;
      color: white;
    }

    .btn-youtube { background-color: #ff0000; }
    .btn-insta { background-color: #e4405f; }
    .btn-fb { background-color: #3b5998; }
    .btn-twitter { background-color: #1da1f2; }

    @keyframes confetti {
      0% { transform: translateY(-100%); opacity: 0; }
      100% { transform: translateY(0); opacity: 1; }
    }

    @media (max-width: 576px) {
      .success-header h2 {
        font-size: 20px;
      }
    }
  </style>
  <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PHSBK2RF');</script>
<!-- End Google Tag Manager -->
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '727837786776844');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=727837786776844&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PHSBK2RF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

  <div class="container">
    <div class="card">
<div class="success-header text-center position-relative" style="background-color: #28a745; padding: 20px; border-radius: 12px;">
  <!-- Cross Icon -->
  <a href="https://c11cl.com/" class="position-absolute top-0 end-0 m-3" style="color: white; font-size: 36px; text-decoration: none;">
    &times;
  </a>

  <img src="/Panel/assets/images/ok.png.webp" alt="Success" class="success-img mb-2">
  <h2 class="fw-bold text-white">Registration Successful</h2>
  <p class="text-white mb-0">Welcome to <strong>C11CL</strong> – Your Cricketing Journey Begins</p>
</div>
    


      <div class="player-section">
        <h5 class="mb-3">Player Details</h5>
        <p><strong>Date & Time:</strong> <?php echo $paydate; ?> | <?php echo $paytime; ?></p>
        <p><strong>Name:</strong> <?php echo $name ?></p>
        <p><strong>Age & Role:</strong> <?php echo "$age years | $player"; ?></p>
        <p><strong>City & State:</strong> <?php echo "$city | $state"; ?></p>
        <p><strong>Mobile:</strong> <?php echo $mobile; ?></p>
      </div>
 <div class="reg-section text-center">
        <h5 class="fw-bold">C11CL Registration No.</h5>
        <h3 class="text-primary fw-bold"><?php echo $reg; ?></h3>
        <p>Use this ID for all trial entries and communication.</p>
      </div>

      <div class="qr-section text-center">
          <img src="https://c11cl.com/wp-content/uploads/2025/05/favicon-3.png" width="140" alt="Logo">
        <?php echo '<img src="' . $qrUrl . '" class="img-fluid rounded mb-2" width="120" alt="QR Code">'; ?>
        <br><br>
        <h5 class="fw-bold">C11CL Registration Slip.</h5>
        <a href="pdf.php?pdf=<?php echo $reg; ?>" class="btn btn-outline-primary rounded-pill mt-2">📄 Download Registration PDF</a>
      </div>

      <!-- Mail Status & Home Button -->
      <div class="text-center px-4 py-3" style="border-top:1px solid #eee;">
        <?php if ($mailSent): ?>
          <div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px; border-radius:8px; font-size:0.9rem; margin-bottom:14px;">
            ✅ Confirmation email with your registration PDF has been sent to <strong><?php echo htmlspecialchars($mailTo, ENT_QUOTES, 'UTF-8'); ?></strong>
          </div>
        <?php else: ?>
          <div style="background:#fef3c7; border:1px solid #fcd34d; color:#92400e; padding:12px 16px; border-radius:8px; font-size:0.9rem; margin-bottom:14px;">
            📧 Confirmation email will be sent to your registered email address shortly.
          </div>
        <?php endif; ?>
        <a href="https://c11cl.com/" class="btn fw-bold px-5 py-2" style="background:#dc2618; color:#fff; border-radius:8px; font-size:1rem; text-decoration:none;">
          Go to Home
        </a>
      </div>

     
<!-- Add in <head> if not present -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Stay Connected Section -->
<div class="text-center py-3">
  <p class="mb-2 fw-bold">Stay Connected</p>
  <div class="d-flex justify-content-center gap-3 flex-wrap">
    <!-- YouTube (red) -->
    <a href="https://www.youtube.com/@champions11cricketleague" target="_blank"
      class="rounded-circle" style="width: 45px; height: 45px; background-color: #FF0000; color: white; display: flex; align-items: center; justify-content: center;">
      <i class="bi bi-youtube" style="font-size: 20px;"></i>
    </a>

    <!-- Instagram (gradient-style color) -->
    <a href="https://www.instagram.com/champions11cricketleague" target="_blank"
      class="rounded-circle" style="width: 45px; height: 45px; background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%); color: white; display: flex; align-items: center; justify-content: center;">
      <i class="bi bi-instagram" style="font-size: 20px;"></i>
    </a>

    <!-- Facebook (blue) -->
    <a href="https://www.facebook.com/profile.php?id=61575926537950" target="_blank"
      class="rounded-circle" style="width: 45px; height: 45px; background-color: #3b5998; color: white; display: flex; align-items: center; justify-content: center;">
      <i class="bi bi-facebook" style="font-size: 20px; color:white;"></i>
    </a>

    <!-- Twitter/X (black) -->
<a href="https://x.com/champions11cl" target="_blank"
  class="rounded-circle social-icon"
  style="width: 45px; height: 45px; background-color:black; display: flex; align-items: center; justify-content: center;">
  <i class="bi bi-twitter-x"></i>
</a>


    <!-- LinkedIn (blue) -->
    <a href="https://www.linkedin.com/company/champions11cricketleague/posts/?feedView=all" target="_blank"
      class="rounded-circle" style="width: 45px; height: 45px; background-color: #0077b5; color: white; display: flex; align-items: center; justify-content: center;">
      <i class="bi bi-linkedin" style="font-size: 20px;"></i>
    </a>
  </div>
</div>

    </div>
  </div>

  <script src="/Panel/assets/js/bootstrap.bundle.min.js"></script>
  <script>
    // Registration success popup with details + QR code
    Swal.fire({
      title: '<span style="color:#28a745;">&#127881; Registration Successful!</span>',
      html: `
        <div style="text-align:left; font-size:14px; line-height:2; border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:12px;">
          <p style="margin:0;"><strong>Name:</strong> <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></p>
          <p style="margin:0;"><strong>Age &amp; Role:</strong> <?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?> yrs | <?php echo htmlspecialchars($player, ENT_QUOTES, 'UTF-8'); ?></p>
          <p style="margin:0;"><strong>City:</strong> <?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($state, ENT_QUOTES, 'UTF-8'); ?></p>
          <p style="margin:0;"><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div style="text-align:center; margin-bottom:10px;">
          <p style="margin:0 0 4px; font-size:13px; color:#555;">Your Registration Number</p>
          <div style="background:#fff3cd; border:2px dashed #ffc107; border-radius:10px; padding:8px 16px; display:inline-block;">
            <span style="font-size:22px; font-weight:900; color:#dc2618; letter-spacing:2px;">
              <?php echo htmlspecialchars($reg, ENT_QUOTES, 'UTF-8'); ?>
            </span>
          </div>
          <p style="font-size:11px; color:#888; margin:4px 0 0;">Save this — use it for all trial entries &amp; communication</p>
        </div>
        <div style="text-align:center;">
          <img src="<?php echo htmlspecialchars($qrUrl, ENT_QUOTES, 'UTF-8'); ?>" width="130" style="border:3px solid #e0e0e0; border-radius:10px; padding:4px;" alt="QR Code">
          <p style="font-size:11px; color:#888; margin:6px 0 0;">Scan this QR at your trial entry gate</p>
        </div>
      `,
      confirmButtonText: 'View Full Details',
      confirmButtonColor: '#dc2618',
      allowOutsideClick: false,
      allowEscapeKey: false,
      width: '380px',
      showClass: { popup: 'animate__animated animate__fadeInDown animate__faster' },
      hideClass: { popup: 'animate__animated animate__fadeOutUp animate__faster' }
    });

    // Prevent back navigation
    history.pushState(null, null, location.href);
    window.onpopstate = function () { location.href = "https://www.c11cl.com"; };
  </script>
  <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '727837786776844');
fbq('track', 'PageView');
</script>

<noscript>
<img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=727837786776844&ev=PageView&noscript=1"/>
</noscript>
<!-- End Meta Pixel Code -->
</body>

</html>
