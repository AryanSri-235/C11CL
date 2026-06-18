<?php
session_start();

// Check if 'payreg' session variable is set
if (isset($_SESSION['payreg'])) {
    include 'dashboard/db.php';

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
<html lang="en" class="semi-dark">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="../dashboard/assets/images/fevikon.png" type="image/png" />

    <!-- loader-->
    <link href="/dashboard/assets/css/pace.min.css" rel="stylesheet" />
    <script src="/dashboard/assets/js/pace.min.js"></script>
    <!-- confetti.js library -->
    <script src="https://cdn.jsdelivr.net/gh/mathusummut/confetti.js/confetti.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="/dashboard/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/dashboard/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="/dashboard/assets/css/app.css" rel="stylesheet">
    <link href="/dashboard/assets/css/icons.css" rel="stylesheet">

    <style>
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
    </style>

    <title>YSCLEAGUE - Payment Done</title>
    <!-- particles.js library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '1826323691147684'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=1826323691147684&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

</head>

<body class="bg-login">
    <script>
  fbq('track', 'CompleteRegistration', {
    value: 999,
    currency: 'INR',
});
</script>
    <!--wrapper-->
    <div class="wrapper">
        <!-- Popup -->

        <div class="d-flex align-items-center justify-content-center my-5">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="card mb-0">
                            <div class="card-bodys">
                                <div class="p-4">
                                    <div class="mb-3 text-center">
                                        <img class="" src="/dashboard/assets/images/right.png" width="100px" alt="" />
                                    </div>
                                    <div class="text-center mb-4">
                                        <h2 class="">Payment Done</h2>
                                        <h5 class="mb-0">Your Registration Completed Successfully!</h5>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3">
                                            <div class="col-6">
                                                <label for="inputUsername" class="form-label">Date & Time</label>
                                                <h6 class="mb-0"><?php echo $paydate; ?></h6>
                                                <h6 class="mb-0"><?php echo $paytime; ?></h6><br>
                                                <h6 class="mb-0">To,</h6>
                                                <h5 class="mb-0"><?php echo $name ?></h5>
                                                <h6 class="mb-0"><?php echo "$age years | $player"; ?></h6>
                                                <h6 class="mb-0"><?php echo "$city | $state"; ?></h6>
                                                <h6 class="mb-0"><?php echo "Mob- $mobile"; ?></h6>
                                            </div>
                                            <div class="col-6">
                                                <?php echo '<img src="' . $filename . '" class="mb-0" width="100%" alt="" />'; ?>
                                                <br>
                                                <!-- Add Download PDF button -->
                                                <a href="pdf.php?pdf=<?php echo $reg; ?>" class="btn btn-primary">Download PDF</a>
                                            </div>
                                            <div class="text-center mb-4">
                                                <h3 class="">Congratulations </h3>
                                                <h6 class="mb-0">Your YSCLeague-Trials Registration No:</h6><br>
                                                <div class="d-grid">
                                                    <button type="button" style="vertical-align:middle;" class="btn btn-primary"><h2 style="color:white;"><?php echo $reg ?></h2></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class=" text-center "> <span>Follow Us on Social media </span>
                                        <hr/>
                                    </div>
                                    <div class="list-inline contacts-social text-center">
                                        <a href="https://www.youtube.com/channel/UCFKA83F43qh9CiC53vwxh5Q" class="list-inline-item bg-google text-white border-0 rounded-3"><i
                                                class="bx bxl-youtube"></i></a>
                                        <a href="https://www.instagram.com/ysclyoungstarscricketleague/?hl=en" class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i
                                                class="bx bxl-instagram"></i></a>
                                        <a href="https://www.facebook.com/ysclindia/" class="list-inline-item bg-facebook text-white border-0 rounded-3"><i
                                                class="bx bxl-facebook"></i></a>
                                        <a href="https://twitter.com/yscl_india" class="list-inline-item bg-twitter text-white border-0 rounded-3"><i
                                                class="bx bxl-twitter"></i></a>
                                        
                                    </div><br>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <img src="/dashboard/assets/images/ysclbl.png" class="mb-0" width="100%" alt="" />
                                        </div>
                                        <div class="col-6">
                                            </br>
                                            <h6 class="mb-0 text-center">You are about to embark on an innings of a Lifetime!!</h6></br>
                                            <H4 class="mb-0 text-center">CHEERS'!</H6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="/dashboard/assets/js/bootstrap.bundle.min.js"></script>

    <script>
        

        // Function to download PDF
          function downloadPDF() {
            // Set the default scaling to 50%
            if (window.matchMedia) {
                var mediaQueryList = window.matchMedia('print');
                mediaQueryList.mediaText = 'print and (min-resolution: 300dpi)';
            }

            window.print();
        }
    </script>
    <script>
    // Disable back button functionality
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>
    <script src="/dashboard/assets/js/app.js"></script>
</body>

</html>
