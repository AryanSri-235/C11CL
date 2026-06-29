<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../dashboard/assets/images/fevikon.png">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .payment-failed-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 30px;
            text-align: center;
        }

        .failed-icon {
            width: 120px;
            margin-bottom: 20px;
        }

        .heading {
            font-size: 48px;
            font-weight: 700;
            color: #d9534f;
        }

        .subtext {
            font-size: 20px;
            color: #333;
            margin-bottom: 30px;
        }

        .retry-btn {
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 8px;
            transition: 0.3s;
            text-decoration: none;
        }

        .retry-btn:hover {
            background-color: #c9302c;
            color: #fff;
        }
    </style>
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

<noscript>
<img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=727837786776844&ev=PageView&noscript=1"/>
</noscript>
<!-- End Meta Pixel Code -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PHSBK2RF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <div class="payment-failed-container">
        <img src="https://cdn-icons-png.flaticon.com/512/753/753345.png" alt="Failed" class="failed-icon">
        <div class="heading">Payment Unsuccessful</div>
        <div class="subtext">
            Unfortunately, your payment couldn’t be processed.<br>
            Don’t worry — no amount has been charged.<br>
            You can try again or contact our support for help.
        </div>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="/registration/" class="retry-btn">Register Again</a>
            <a href="/" class="retry-btn" style="background-color:#0e1b30;">Go to Home</a>
        </div>
    </div>

</body>

</html>
