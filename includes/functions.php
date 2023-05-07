<?php
function LoginSystem() {
	session_start(); // Starting Session
	global $error;
	if (!isset($_POST['submit'])) {
		if (empty($_POST['login']) || empty($_POST['password'])) {
			$error = "Username or Password is invalid";
		}
	} else {
		include 'connect.php';
		global $conn;
		// Define $username and $password
		$username = $_POST['login'];
		$password = md5($_POST['password']);
		// SQL query to fetch information of registerd users and finds user match.
		$query = "SELECT login, password FROM users WHERE (login=? OR name=?) AND password=? LIMIT 1";
		// To protect MySQL injection for Security purpose
		$stmt = $conn->prepare($query);
		$stmt->bind_param("sss", $username, $username, $password);
		$stmt->execute();
		$stmt->bind_result($username, $password);
		$stmt->store_result();
		if($stmt->fetch()) { //fetching the contents of the row 
			$_SESSION['login'] = $username; // Initializing Session
		}
		if($stmt->num_rows == 0) {
			header("Location: ../index.php?error");
			exit;
		}
		#mysqli_close($conn); // Closing Connection
	}
}

function SessionVerify() {
	if(isset($_SESSION['login'])){
		// Check user session and role
		SessionCheck();
		UserType();
	}
}

function SessionCheck() {
	global $conn;
	if(!isset($_SESSION)){
		session_start();// Starting Session
	}
	// Storing Session
	$user_check = $_SESSION['login'];
	// SQL Query To Fetch Complete Information Of User
	$query = "SELECT * FROM users WHERE login = '$user_check'";
	$ses_sql = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($ses_sql);
	$_SESSION["id"] = $row["id"];
	$_SESSION["name"] = $row["name"];
	$_SESSION["role"] = $row["role"];
	$_SESSION["dept"] = $row["dept"];
}
	
function UserType() {
	//if user role is 1, redirect to admin page
	if ($_SESSION["role"] == 0) {
		header("Location:../user/admin/");
	} else 

	//if user role is 0, redirect to user page
	if ($_SESSION["role"] == 1) {
		header("Location:../user/principal/");
	} else 

	//if user role is 0, redirect to user page
	if ($_SESSION["role"] == 2) {
		header("Location:../user/hod/");
	} else 

	//if user role is 0, redirect to user page
	if ($_SESSION["role"] == 3) {
		header("Location:../user/technician/");
	} else {
		session_start();
		session_unset();
		session_destroy();
		header("Location: ../index.php");		
	}
}

function UserName() {
	$username = $_SESSION["name"];
	echo $username;
}