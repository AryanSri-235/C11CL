
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<?php
session_start();

// Check if 'payreg' session variable is set
if (isset($_SESSION['payreg'])) {
    include 'db.php';

    $sql = "SELECT * FROM register WHERE reg = '{$_SESSION['payreg']}' AND status = 'Success' ";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reg = $row["reg"];
            $paydate = $row["paydate"];
            $paytime = $row["paytime"];
            $name = $row["name"];
            $age = $row["age"];
            $player = $row["player"];
            $city = $row["city"];
            $state = $row["state"];
            $mobile = $row["mobile"];
        }
    } else {
        echo "0 results";
         header('location:failure.php');
    exit();
    }
} else {
    header('location:failure.php');
    exit();
}

// bar code----------------------------------
include 'phpqrcode/qrlib.php';
$PNG_TEMP_DIR = 'temp/';

if (!file_exists($PNG_TEMP_DIR)) {
    mkdir($PNG_TEMP_DIR);
}

$filename = $PNG_TEMP_DIR . 'test.png'; // Corrected extension to .png

$codeString = $reg;

$filename = $PNG_TEMP_DIR . 'test' . md5($codeString) . '.png';
QRcode::png($codeString, $filename);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C11CL - Registration Success</title>
  <link rel="icon" href="../Panel/assets/images/fevikon.png" type="image/png">
  <link href="/Panel/assets/css/bootstrap.min.css" rel="stylesheet">
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

    .celebration-popup {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .celebration-content {
      background: white;
      padding: 30px;
      text-align: center;
      border-radius: 20px;
      animation: confetti 0.7s ease-out;
    }

    .celebration-content h2 {
      color: #28a745;
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
  <!-- Celebration popup -->
  <div class="celebration-popup" id="celebration">
    <div class="celebration-content">
      <img src="/Panel/assets/images/ok.png.webp" width="80" alt="Success">
      <h2>Congratulations 🎉</h2>
      <p>Your registration was successful!</p>
    </div>
  </div>

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
        <?php echo '<img src="' . $filename . '" class="img-fluid rounded mb-2" width="120" alt="QR Code">'; ?>
        <br><br>
        <h5 class="fw-bold">C11CL Registration Slip.</h5>
        <a href="pdf.php?pdf=<?php echo $reg; ?>" class="btn btn-outline-primary rounded-pill mt-2">📄 Download Registration PDF</a>
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
    // Hide celebration popup after 3 seconds
    setTimeout(() => {
      document.getElementById('celebration').style.display = 'none';
    }, 3000);
  </script>
  
   <script>
    // Prevent back navigation and redirect to homepage
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
      location.href = "https://www.c11cl.com";
    };
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
