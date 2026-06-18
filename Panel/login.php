<?php
session_start();
include 'db.php';
if (isset($_POST['login'])) {
	$uname = $_POST['uname'];
	$password = $_POST['password'];
	$sql = "SELECT * FROM user WHERE username = '$uname' AND password = '$password' ";
	$result = $con->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if ($row['stoper'] == 'Stop') {
			$denied = '<span class="text-danger">Access denied you are not allowed to perform this operation</span>';
		} else {
			date_default_timezone_set('Asia/Kolkata');
	$logout = date("Y-m-d h:i:s A");
	$sql = "UPDATE history 
	SET logout = '$logout' 
	WHERE username = '$uname' AND logout = 'Active'";

	if ($con->query($sql) === TRUE) {
			$_SESSION['uname'] = $row['username'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['password'] = $row['password'];
			$_SESSION['status'] = $row['status'];
			$_SESSION['picture'] = $row['picture'];
			$_SESSION['last-active'] = time();
			date_default_timezone_set('Asia/Kolkata');
			$login = date("Y-m-d h:i:s A");
			$ip = $_SERVER['REMOTE_ADDR'];
			$sql = "INSERT INTO history (username, password, status, ip, login, logout)
  VALUES ('$_SESSION[uname]', '$_SESSION[password]', '$_SESSION[status]', '$ip', '$login', 'Active')";
		if ($con->query($sql) === TRUE) {
    // isActive status update karna
    $sql2 = "UPDATE user SET isActive = 1 WHERE username = '{$_SESSION['uname']}'";
    $con->query($sql2);
    
    // Role based redirection logic
    switch ($_SESSION['status']) {
        case 'developer':
            header('location: blog_list.php');
            break;
        case 'sale-leader':
            header('location: phase1data_user.php');
            break;
        case 'admin':
            // Agar superadmin ko bhi blog list par bhejna hai toh yahan add kar sakte hain
            header('location: blog_list.php'); 
            break;
        default:
            header('location: phase1data.php');
            break;
    }
    exit(); // Header ke baad hamesha exit() lagana best practice hai

} else {
    echo "Error inserting into history table: " . $con->error;
}

		}
	}

	} else {
		$_SESSION['wrong'] = "WRONG USERNAME AND PASSWORD";
	}
}


// .......................... logout..........................................  
if (isset($_GET['logout']) && isset($_SESSION['uname'])) {
	//   $uname = $_SESSION['uname'];
	date_default_timezone_set('Asia/Kolkata');
	$logout = date("Y-m-d h:i:s A");
	$sql = "UPDATE history 
	SET logout = '$logout' 
	WHERE username = '{$_SESSION['uname']}' AND logout = 'Active'";

	if ($con->query($sql) === TRUE) {
	    
	    $sql2 = "UPDATE user SET isActive = 0 WHERE username = '{$_SESSION['uname']}'";
                $con->query($sql2);
                
		unset($_SESSION['uname']);
		unset($_SESSION['password']);
		header('location: login.php');
	} else {
		echo "Error updating record: " . $con->error;
	}
}
?>

<!doctype html>
<html lang="en" class="semi-dark">

<head>
	<!-- Required meta tags -->

	<!--favicon-->
	<link rel='icon' href='assets/images/fevikondashoard.png' type='image/png' />
	<!--plugins-->
	<link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
	<link rel="stylesheet" href="assets/css/semi-dark.css" />
	<link rel="stylesheet" href="assets/css/header-colors.css" />
	<link rel="stylesheet" href="assets/css/style.css">
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CLLCL Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-login">
	<!--wrapper-->
<!DOCTYPE html>
<html lang="en">

<head>
  
  <style>
    body {
      background: linear-gradient(135deg, #0f172a, #1e293b);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
      padding: 40px;
      width: 100%;
      max-width: 400px;
    }

    .login-logo img {
      width: 100px;
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #0f172a;
      border-color: #0f172a;
    }

    .btn-primary:hover {
      background-color: #1e293b;
      border-color: #1e293b;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(31, 41, 55, 0.25);
      border-color: #1e293b;
    }

    .error-message {
      color: red;
      font-weight: 600;
      font-size: 14px;
      margin-top: 10px;
    }

    .text-brand {
      color: #0f172a;
      font-weight: 700;
      font-size: 24px;
    }
  </style>
</head>

<body>
  <div class="login-card">
    <div class="text-center login-logo">
      <img src="https://c11cl.com/wp-content/uploads/2025/05/favicon-3.png" alt="CLLCL Logo" />
    </div>
    <div class="text-center mb-3">
      <div class="text-brand">CLLCL</div>
      <p class="text-muted">Please log in to your account</p>

      <?php if (isset($_SESSION['wrong'])) { ?>
        <div class="error-message"><?= $_SESSION['wrong']; unset($_SESSION['wrong']); ?></div>
      <?php } ?>
      <?php if (isset($denied)) { ?>
        <div class="error-message"><?= $denied; ?></div>
      <?php } ?>
    </div>

    <form method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="uname" class="form-control" id="username" placeholder="e.g. ABC123" required />
      </div>
      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required />
      </div>
      <div class="d-grid">
        <button type="submit" name="login" class="btn btn-primary">Sign In</button>
      </div>
    </form>
  </div>
</body>

</html>

	<!--end wrapper-->