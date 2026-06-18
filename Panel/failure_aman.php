<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Falied</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="shortcut icon" href="../dashboard/assets/images/fevikon.png">
        
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
 fbq('init', '443481814419231'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=443481814419231&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
</head>

<body>
    <style>
        .thanks {
            text-align: center;
            background-color: #D80001;
            padding: 75px 0px;
            color: white;
        }

        .thanks h1 {
            font-weight: 700;
            font-size: 64px;
        }

        .content {
            display: flex;
            justify-content: center;
            text-align: center;
            padding: 20px 0;
        }

        .content .card {
            border: none;
        }

        .content .card img {
            width: 100px;
        }

        .card-title {
            font-weight: 700;
            font-size: 40px;
        }
        p {
            font-size: 25px;
            font-weight: 600;
        }

        .card-body a {
            color: #D80001;
            font-weight: 700;
            border: 5px solid #D80001;
            padding: 18px;
        }

        .card-body a:hover {
            background-color: #D80001;
            color: white;
            font-weight: 700;
        }
    </style>

    <div class="thanks">
        <h1>Oops! </h1>
    </div>
    <section class="content">
        <div class="card">
            <div class="icon">
                <img src="dashboard/assets/images/icon_pf.png" class="card-img-top" alt="ICON">
            </div>
            <div class="card-body">
                <h5 class="card-title">Payment Failed</h5>
                <p>It seems we have not recieved money. Please contact our customer support</p>
                <a href="registration" class="btn">Try Again</a>
            </div>
        </div>
    </section>
</body>

</html>