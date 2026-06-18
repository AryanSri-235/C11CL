<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if 'payreg2' session variable is set
if (isset($_SESSION['payreg2'])) {
    include 'db.php';

    // Fetch data from register2 table
    $sql = "SELECT * FROM `register-second` WHERE reg2 = '{$_SESSION['payreg2']}' AND status = 'Success'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reg2     = $row["reg2"];
            $paydate  = $row["paydate"];
            $paytime  = $row["paytime"];
            $name     = $row["name"];
            $age      = $row["age"];
            $player   = $row["player"];
            $city     = $row["city"];
            $state    = $row["state"];
            $mobile   = $row["mobile"];
        }
    } else {
        header('location:failure.php');
        exit();
    }
} else {
    header('location:failure.php');
    exit();
}

// QR Code generation
include 'phpqrcode/qrlib.php';
$PNG_TEMP_DIR = 'temp/';

if (!file_exists($PNG_TEMP_DIR)) {
    mkdir($PNG_TEMP_DIR);
}

$filename = $PNG_TEMP_DIR . 'test' . md5($reg2) . '.png';
QRcode::png($reg2, $filename);
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: linear-gradient(to bottom right, #f2f6fc, #e6efff); font-family: 'Roboto', sans-serif; padding: 20px; }
    .card { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1); }
    .success-header { background: #28a745; color: #fff; padding: 20px; border-radius: 12px; }
    .success-header img { width: 70px; }
    .player-section, .qr-section, .reg-section { padding: 20px; }
    .qr-section { background-color: #f8f9fa; border-top: 1px solid #ddd; }
    .reg-section { background: #fff3cd; border-top: 1px solid #ffeeba; text-align: center; }
    .social-links a { display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; border-radius: 50%; color: white; }
  </style>
</head>

<body>
  <div class="celebration-popup" id="celebration" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: flex; justify-content: center; align-items: center; z-index: 9999;">
    <div class="celebration-content" style="background: white; padding: 30px; text-align: center; border-radius: 20px;">
      <img src="/Panel/assets/images/ok.png.webp" width="80" alt="Success">
      <h2 style="color: #28a745;">Congratulations 🎉</h2>
      <p>Your Phase 2 Registration was successful!</p>
    </div>
  </div>

  <div class="container">
    <div class="card">
      <div class="success-header text-center position-relative">
        <a href="https://c11cl.com/" class="position-absolute top-0 end-0 m-3" style="color: white; font-size: 36px;">&times;</a>
        <img src="/Panel/assets/images/ok.png.webp" alt="Success" class="mb-2">
        <h2 class="fw-bold text-white">Registration Successful</h2>
        <p class="text-white mb-0">Welcome to <strong>C11CL</strong> – Your Cricketing Journey Begins</p>
      </div>

      <div class="player-section">
        <h5 class="mb-3">Player Details</h5>
        <p><strong>Date & Time:</strong> <?php echo $paydate; ?> | <?php echo $paytime; ?></p>
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Age & Role:</strong> <?php echo "$age years | $player"; ?></p>
        <p><strong>City & State:</strong> <?php echo "$city | $state"; ?></p>
        <p><strong>Mobile:</strong> <?php echo $mobile; ?></p>
      </div>

      <div class="reg-section">
        <h5 class="fw-bold">C11CL Registration No.</h5>
        <h3 class="text-primary fw-bold"><?php echo $reg2; ?></h3>
        <p>Use this ID for all trial entries and communication.</p>
      </div>

      <div class="qr-section text-center">
        <img src="https://c11cl.com/wp-content/uploads/2025/05/favicon-3.png" width="140" alt="Logo"><br>
        <?php echo '<img src="' . $filename . '" class="img-fluid rounded mb-2" width="120" alt="QR Code">'; ?>
        <br><br>
        <h5 class="fw-bold">C11CL Registration Slip.</h5>
       <a href="pdf2.php?reg2=<?php echo urlencode($reg2); ?>" class="btn btn-outline-primary rounded-pill mt-2">📄 Download Registration PDF</a>

      </div>

      <!-- Social Links -->
      <div class="text-center py-3">
        <p class="mb-2 fw-bold">Stay Connected</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
          <a href="https://www.youtube.com/@champions11cricketleague" target="_blank" style="background-color: #FF0000;"><i class="bi bi-youtube"></i></a>
          <a href="https://www.instagram.com/champions11cricketleague" target="_blank" style="background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);"><i class="bi bi-instagram"></i></a>
          <a href="https://www.facebook.com/profile.php?id=61575926537950" target="_blank" style="background-color: #3b5998;"><i class="bi bi-facebook"></i></a>
          <a href="https://x.com/champions11cl" target="_blank" style="background-color:black;"><i class="bi bi-twitter-x"></i></a>
          <a href="https://www.linkedin.com/company/champions11cricketleague/posts/?feedView=all" target="_blank" style="background-color: #0077b5;"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>
  </div>

  <script src="/Panel/assets/js/bootstrap.bundle.min.js"></script>
  <script>
    setTimeout(() => { document.getElementById('celebration').style.display = 'none'; }, 3000);
    history.pushState(null, null, location.href);
    window.onpopstate = function () { location.href = "https://www.c11cl.com"; };
  </script>
</body>
</html>
