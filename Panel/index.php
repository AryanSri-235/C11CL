<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:login.php');
} else {

switch ($_SESSION['status']) {
					case 'admin':
						header('location: profile.php');
						break;
					default:
						header('location: profile.php');
						break;
				}
}
?>

