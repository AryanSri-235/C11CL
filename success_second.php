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
        $row = $result->fetch_assoc();
        $reg2     = $row["reg2"];
        $paydate  = $row["paydate"];
        $paytime  = $row["paytime"];
        $name     = $row["name"];
        $age      = $row["age"];
        $player   = $row["player"];
        $city     = $row["city"];
        $state    = $row["state"];
        $mobile   = $row["mobile"];
        // Naye fields fetch karein (Ensure these columns exist in your DB)
        $tshirt_size = !empty($row["tshirt_size"]) ? $row["tshirt_size"] : 'Not Selected';
        $lower_size  = !empty($row["lower_size"]) ? $row["lower_size"] : 'Not Selected';
        $food_pref   = !empty($row["food_pref"]) ? $row["food_pref"] : 'Not Selected';
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
if (!file_exists($PNG_TEMP_DIR)) { mkdir($PNG_TEMP_DIR); }
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
    .card { border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1); background: #fff; }
    .success-header { background: #28a745; color: #fff; padding: 20px; border-radius: 12px; }
    .success-header img { width: 70px; }
    .player-section, .qr-section, .reg-section { padding: 20px; }
    .qr-section { background-color: #f8f9fa; border-top: 1px solid #ddd; }
    .reg-section { background: #fff3cd; border-top: 1px solid #ffeeba; text-align: center; }
    .social-links a { display: inline-flex; align-items: center; justify-content: center; width: 45px; height: 45px; border-radius: 50%; color: white; text-decoration: none; }
    .details-box { background: #f0f4f8; padding: 15px; border-radius: 10px; margin-top: 10px; border-left: 5px solid #28a745; }
  </style>
</head>

<body>
  <!-- Celebration Popup -->
  <div class="celebration-popup" id="celebration" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: flex; justify-content: center; align-items: center; z-index: 9999;">
    <div class="celebration-content animate__animated animate__zoomIn" style="background: white; padding: 30px; text-align: center; border-radius: 20px;">
      <img src="/Panel/assets/images/ok.png.webp" width="80" alt="Success">
      <h2 style="color: #28a745;">Congratulations 🎉</h2>
      <p>Your Phase 2 Registration was successful!</p>
    </div>
  </div>

  <div class="container mt-4">
    <div class="card mx-auto" style="max-width: 600px;">
      <div class="success-header text-center position-relative">
        <a href="https://c11cl.com/" class="position-absolute top-0 end-0 m-3" style="color: white; font-size: 36px; text-decoration: none;">&times;</a>
        <img src="/Panel/assets/images/ok.png.webp" alt="Success" class="mb-2">
        <h2 class="fw-bold text-white">Registration Successful</h2>
        <p class="text-white mb-0">Welcome to <strong>C11CL</strong></p>
      </div>

      <div class="player-section">
        <h5 class="fw-bold text-success border-bottom pb-2">Player Details</h5>
        <div class="row">
            <div class="col-6"><p><strong>Name:</strong> <?php echo $name; ?></p></div>
            <div class="col-6"><p><strong>Mobile:</strong> <?php echo $mobile; ?></p></div>
            <div class="col-12"><p><strong>Age & Role:</strong> <?php echo "$age years | $player"; ?></p></div>
        </div>

        <!-- Yaha User ke Dress/Food details show honge -->
        <div class="details-box">
            <h6 class="fw-bold"><i class="bi bi-person-badge"></i> Kit & Food Preferences:</h6>
            <p class="mb-1">T-Shirt: <span id="disp-tshirt" class="badge bg-primary"><?php echo $tshirt_size; ?></span></p>
          
            <p class="mb-2">Food: <span id="disp-food" class="badge bg-info text-dark"><?php echo $food_pref; ?></span></p>
            
            <button type="button" class="btn btn-dark btn-sm w-100" data-bs-toggle="modal" data-bs-target="#kitModal">
                <i class="bi bi-plus-circle"></i> Add / Update Dress Size & Food
            </button>
        </div>
      </div>

      <div class="reg-section">
        <h5 class="fw-bold">C11CL Registration No.</h5>
        <h3 class="text-primary fw-bold"><?php echo $reg2; ?></h3>
        <p class="small">Use this ID for all trial entries.</p>
      </div>

      <div class="qr-section text-center">
        <img src="https://c11cl.com/wp-content/uploads/2025/05/favicon-3.png" width="100" alt="Logo" class="mb-3">
        <br>
        <?php echo '<img src="' . $filename . '" class="img-fluid border p-2 bg-white" width="140" alt="QR Code">'; ?>
        <br><br>
        <a href="pdf2.php?reg2=<?php echo urlencode($reg2); ?>" class="btn btn-outline-primary rounded-pill">📄 Download Registration PDF</a>
      </div>

      <!-- Social Links -->
      <div class="text-center py-3">
        <p class="mb-2 fw-bold">Stay Connected</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap social-links">
          <a href="https://www.youtube.com/@champions11cricketleague" target="_blank" style="background-color: #FF0000;"><i class="bi bi-youtube"></i></a>
          <a href="https://www.instagram.com/champions11cricketleague" target="_blank" style="background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);"><i class="bi bi-instagram"></i></a>
          <a href="https://www.facebook.com/profile.php?id=61575926537950" target="_blank" style="background-color: #3b5998;"><i class="bi bi-facebook"></i></a>
          <a href="https://x.com/champions11cl" target="_blank" style="background-color:black;"><i class="bi bi-twitter-x"></i></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Dress Size & Food -->
  <div class="modal fade" id="kitModal" tabindex="-1" aria-labelledby="kitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="kitModalLabel">Select Kit Size & Food</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="kitForm">
          <div class="modal-body">
            <input type="hidden" name="reg2" value="<?php echo $reg2; ?>">
            
           <div class="mb-3">
  <label class="form-label fw-bold">T-Shirt Size</label>
  <select class="form-select" name="tshirt" required>
    <option value="">-- Choose Size --</option>
    <option value="34 (XS)">34 - XS</option>
    <option value="36 (S)">36 - S</option>
    <option value="38 (M)">38 - M</option>
    <option value="40 (L)">40 - L</option>
    <option value="42 (XL)">42 - XL</option>
    <option value="44 (XXL)">44 - XXL</option>
    <option value="46 (XXXL)">46 - XXXL</option>
    <option value="48 (4XL)">48 - 4XL</option>
  </select>
</div>

            <!--<div class="mb-3">-->
            <!--  <label class="form-label fw-bold">Lower Size</label>-->
            <!--  <select class="form-select" name="lower" required>-->
            <!--    <option value="">-- Choose Size --</option>-->
            <!--    <option value="28">28</option>-->
            <!--    <option value="30">30</option>-->
            <!--    <option value="32">32</option>-->
            <!--    <option value="34">34</option>-->
            <!--    <option value="36">36</option>-->
            <!--    <option value="38">38</option>-->
            <!--    <option value="40">40</option>-->
            <!--  </select>-->
            <!--</div>-->

            <div class="mb-3">
              <label class="form-label fw-bold">Food Preference</label>
              <select class="form-select" name="food" required>
                <option value="">-- Choose Food --</option>
                <option value="Veg">Pure Veg</option>
                <option value="Jain">Jain Food</option>
              </select>
            </div>

            <div id="responseMsg"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="saveBtn" class="btn btn-success">Save Details</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Celebration Hide
    setTimeout(() => { 
        document.getElementById('celebration').classList.add('animate__animated', 'animate__fadeOut');
        setTimeout(() => { document.getElementById('celebration').style.display = 'none'; }, 1000);
    }, 3000);

    // Form Submit via AJAX
    $('#kitForm').on('submit', function(e){
        e.preventDefault();
        $('#saveBtn').prop('disabled', true).text('Saving...');
        
        $.ajax({
            url: 'update_kit.php', // Is file ko niche diye gaye code se banayein
            type: 'POST',
            data: $(this).serialize(),
            success: function(response){
                if(response == "success") {
                    $('#responseMsg').html('<div class="alert alert-success">Saved Successfully!</div>');
                    // UI Update
                    $('#disp-tshirt').text($('select[name="tshirt"]').val());
                    $('#disp-lower').text($('select[name="lower"]').val());
                    $('#disp-food').text($('select[name="food"]').val());
                    
                    setTimeout(() => {
                        $('#kitModal').modal('hide');
                        $('#responseMsg').html('');
                        $('#saveBtn').prop('disabled', false).text('Save Details');
                    }, 1500);
                } else {
                    $('#responseMsg').html('<div class="alert alert-danger">Error saving data.</div>');
                    $('#saveBtn').prop('disabled', false).text('Save Details');
                }
            }
        });
    });

    // Browser back button control
    history.pushState(null, null, location.href);
    window.onpopstate = function () { location.href = "https://www.c11cl.com"; };
  </script>
</body>
</html>