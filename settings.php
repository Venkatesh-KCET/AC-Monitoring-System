<?php
include_once 'includes/connect.php'; //include connection
include_once 'includes/functions.php'; // include functions
if(!isset($_SESSION)){
	session_start();
}
SessionVerify();
 ?>
