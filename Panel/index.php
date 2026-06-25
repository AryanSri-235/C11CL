<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
} else {

switch ($_SESSION['status']) {
					case 'admin':
					case 'superadmin':
					case 'developer':
						header('location: dashboard.php');
						break;
					default:
						header('location: user-profile.php');
						break;
				}
}
?>

