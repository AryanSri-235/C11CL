<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

if (!isset($_GET['pdf'])) {
    header('location:/');
    exit;
}

include 'db.php';

$reg  = $_GET['pdf'];
$name = $age = $sp = $date = $time = '';

if ($con) {
    $stmt = $con->prepare("SELECT name, age, player, reg, paydate, paytime FROM register WHERE reg = ?");
    if ($stmt) {
        $stmt->bind_param('s', $reg);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $name = $row['name']    ?? '';
            $age  = $row['age']     ?? '';
            $sp   = $row['player']  ?? '';
            $reg  = $row['reg']     ?? $reg;
            $date = $row['paydate'] ?? '';
            $time = $row['paytime'] ?? '';
        }
        $stmt->close();
    }
}

$qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($reg) . '&size=150x150&margin=5';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>C11CL Registration - <?= htmlspecialchars($reg) ?></title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: Arial, sans-serif; background: #f0f0f0; }

  .print-btn {
    display: block;
    text-align: center;
    padding: 14px;
    background: #dc2618;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    border: none;
    width: 100%;
    letter-spacing: 1px;
  }
  .print-btn:hover { background: #b81e12; }

  .page {
    width: 794px;
    margin: 20px auto;
    background: #fff;
    padding: 40px 50px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  }

  .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; border-bottom: 3px solid #dc2618; padding-bottom: 20px; }
  .header img { height: 80px; }
  .header-qr img { width: 110px; height: 110px; border: 2px solid #e0e0e0; border-radius: 6px; }

  .to-block { margin-bottom: 25px; }
  .to-block p { font-size: 14px; color: #333; line-height: 1.8; }
  .to-block .label { font-weight: bold; color: #000; }

  .congrats-box { text-align: center; margin: 30px 0; }
  .congrats-box h1 { font-size: 32px; font-weight: 900; color: #dc2618; margin-bottom: 8px; }
  .congrats-box p { font-size: 15px; color: #444; }

  .reg-badge { text-align: center; margin: 25px 0; }
  .reg-badge .label { font-size: 14px; color: #666; margin-bottom: 8px; }
  .reg-badge .code {
    display: inline-block;
    background: #4CAF50;
    color: #fff;
    font-size: 22px;
    font-weight: bold;
    padding: 12px 40px;
    border-radius: 30px;
    border: 2px solid #388E3C;
    letter-spacing: 2px;
  }

  .info-msg { text-align: center; margin: 20px 0; font-size: 14px; color: #444; line-height: 1.8; }
  .info-msg strong { color: #000; }

  .social-row { display: flex; justify-content: center; gap: 20px; margin: 25px 0; flex-wrap: wrap; }
  .social-row a { font-size: 13px; color: #2563eb; text-decoration: none; font-weight: bold; }
  .social-row a:hover { text-decoration: underline; }

  .footer-bar { border-top: 2px solid #dc2618; padding-top: 14px; text-align: center; font-size: 13px; color: #555; margin-top: 20px; }

  @media print {
    body { background: #fff; }
    .print-btn { display: none !important; }
    .page { width: 100%; margin: 0; padding: 30px 40px; box-shadow: none; }
    a { color: #000 !important; text-decoration: none; }
  }
</style>
</head>
<body>

<button class="print-btn" onclick="window.print()">&#11015; Download / Print PDF</button>

<div class="page">

  <!-- Header -->
  <div class="header">
    <div>
      <img src="uploads/img/pdf.png" alt="C11CL Logo" onerror="this.style.display='none'">
    </div>
    <div class="header-qr">
      <img src="<?= htmlspecialchars($qrUrl) ?>" alt="QR Code">
    </div>
  </div>

  <!-- To Block -->
  <div class="to-block">
    <p><span class="label">To,</span></p>
    <p><strong><?= htmlspecialchars($name) ?></strong></p>
    <p><?= htmlspecialchars($age) ?> Years &nbsp;|&nbsp; <?= htmlspecialchars($sp) ?></p>
    <?php if ($date): ?>
    <p><?= htmlspecialchars($date) ?> &nbsp;|&nbsp; <?= htmlspecialchars($time) ?></p>
    <?php else: ?>
    <p style="color:#888;">Date &amp; Time: To be announced</p>
    <?php endif; ?>
  </div>

  <!-- Congratulations -->
  <div class="congrats-box">
    <h1>Congratulations!</h1>
    <p>You've successfully registered for <strong>Champions 11 Cricket League</strong>.</p>
  </div>

  <!-- Registration Badge -->
  <div class="reg-badge">
    <div class="label">Your Trial Registration Number:</div>
    <div class="code"><?= strtoupper(htmlspecialchars($reg)) ?></div>
  </div>

  <!-- Info Message -->
  <div class="info-msg">
    <strong>Trial Details:</strong><br>
    Date, Time &amp; Venue will be shared soon.<br><br>
    Stay updated by following our official social media channels listed below.
  </div>

  <!-- Social Links -->
  <div class="social-row">
    <a href="https://www.instagram.com/c11cl_official/" target="_blank">Instagram</a>
    <a href="https://www.facebook.com/profile.php?id=61575926537950" target="_blank">Facebook</a>
    <a href="https://x.com/champions11cl" target="_blank">Twitter / X</a>
    <a href="https://www.linkedin.com/company/champions11cricketleague/" target="_blank">LinkedIn</a>
    <a href="https://www.youtube.com/@C11CLOfficial" target="_blank">YouTube</a>
  </div>

  <!-- Footer -->
  <div class="footer-bar">
    www.c11cl.com &nbsp;&nbsp;|&nbsp;&nbsp; info@c11cl.com &nbsp;&nbsp;|&nbsp;&nbsp; +91 9599505213
  </div>

</div>

</body>
</html>
