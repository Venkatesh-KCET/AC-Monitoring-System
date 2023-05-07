<?php
include '../../includes/functions.php'; //include functions
include '../../includes/connect.php'; //include connection
SessionCheck();
//Check user role is true
if (!isset($_SESSION['login']) || $_SESSION['role'] != "2") {
	header("Location:../../includes/logout.php");
}
?>
