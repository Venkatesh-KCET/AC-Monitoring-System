<?php 
	include 'settings.php'; //include settings 
	if(isset($_GET["delete"])) {
		$Dsql =  "DELETE FROM users WHERE `users`.`id` = ".$_GET["delete"];
	}
	$fail = false;
	if(isset($_GET["username"])) {
		$username = $_GET["username"];
		$mail = $_GET["mail"];
		$password = md5($_GET["password"]);
		$dept = $_GET["dept"];
		$role = $_GET["role"];
		$Isql = "INSERT INTO `users` (`name`, `login`, `password`, `dept`, `role`) VALUES ('$username', '$mail', '$password', '$dept', '$role')";
		if(!mysqli_query($conn, $Isql)) {
			$fail = true;
		}

	}
	// username=tech3&mail=support-in%40google.com&password=admin&dept=ECE&role=0

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Report</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style.css">
	<link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<div class="container-contact100">
		<div class="wrap-contact100" style="width:1100px;">
			<form class="contact100-form validate-form" method="GET">
				<?php if($fail) { ?>
				<div style="position: relative;padding: 0.75rem 1.25rem;border: 1px solid #28a745;border-radius: 0.25rem;background-color: #28a745;margin-bottom: 2em;color: white;font-weight: 700;">
					<?php echo "Error: " . mysqli_error($conn); ?>
				</div>
				<?php } else if (isset($_GET["username"])) { ?>
					<div style="position: relative;padding: 0.75rem 1.25rem;border: 1px solid #28a745;border-radius: 0.25rem;background-color: #28a745;margin-bottom: 2em;color: white;font-weight: 700;">
					Successfully New User Created
					</div>
				<?php } ?>
				<?php if(isset($_GET["delete"]) && mysqli_query($conn, $Dsql)) { ?>
				<div style="position: relative;padding: 0.75rem 1.25rem;border: 1px solid #28a745;border-radius: 0.25rem;background-color: #28a745;margin-bottom: 2em;color: white;font-weight: 700;">
					Successfully Deleted
				</div>
				<?php } ?>

				<span class="contact100-form-title">Add User</span>
				<div class="container">
					<div class="row">
						<div class="col-sm">

							<div class="wrap-input100 validate-input" data-validate="Username is required">
								<span class="label-input100">Username</span>
								<input class="input100" type="text" name="username" placeholder="Username" value="">
								<span class="focus-input100"></span>
							</div>
							<div class="wrap-input100 validate-input" data-validate="Mail ID is required">
								<span class="label-input100">Mail ID</span>
								<input class="input100" type="text" name="mail" placeholder="Mail ID" value="">
								<span class="focus-input100"></span>
							</div>

							<div class="wrap-input100 validate-input" data-validate="Password is required">
								<span class="label-input100">Password</span>
								<input class="input100" type="text" name="password" placeholder="Password" value="">
								<span class="focus-input100"></span>
							</div>

						<div class="wrap-input100 validate-input" data-validate="Dept is required">
								<span class="label-input100">Dept</span>
								<input class="input100" type="text" list="dept" name="dept" placeholder="Dept" value="">
								<datalist id="dept">
<?php
	$DeptSQL = "SELECT DISTINCT(dept) FROM `users`;";
	$DeptResult = mysqli_query($conn, $DeptSQL);

	if (mysqli_num_rows($DeptResult) > 0) {
		// output data of each row
		while($DeptRow = mysqli_fetch_assoc($DeptResult)) {
			echo '<option value="' . $DeptRow["dept"] . '">';
		}
	}
?>
								</datalist>
								<span class="focus-input100"></span>
							</div>

							<div class="wrap-input100 validate-input select2-container" style="width:100% !important;" data-validate="User Role is required">
								<span class="label-input100">User Role</span>
								<select name="role" id="role" class="input100 select2-selection--single">
									<option value="0">Admin</option>
									<option value="1">Principal</option>
									<option value="2">HOD</option>
									<option value="3">Technician</option>
								</select>
								<span class="focus-input100"></span>
							</div>

						</div>



					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-sm">
							<div class="container-contact100-form-btn">
								<div class="wrap-contact100-form-btn">
									<div class="contact100-form-bgbtn"></div>
									<button class="contact100-form-btn"><span>Submit<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i></span></button>
								</div>
							</div>
						</div>
						<div class="col-sm">
							<div class="container-contact100-form-btn">
								<div class="wrap-contact100-form-btn">
									<div class="contact100-form-bgbtn"></div>
									<a href="index.php" class="contact100-form-btn">Home</a>
								</div>
							</div>
						</div>
						<div class="col-sm">
							<div class="container-contact100-form-btn">
								<div class="wrap-contact100-form-btn">
									<div class="contact100-form-bgbtn"></div>
									<a href="../../includes/logout.php" class="contact100-form-btn">Logout</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php 
					$sql = "SELECT `id`,`name`,`login`,`dept`,`role`, CONCAT(\"<a href='?delete=\", `id`, \"'>Delete</a>\") as 'delete' FROM `users`;";
					$result = mysqli_query($conn, $sql);

					echo '<table class="cont table table-hover" style="margin-top:41px;"><thead><tr>';
						$outputData = array();
						#$outputData = mysqli_fetch_assoc($result);
						if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								if(empty($outputData)) {
									$outputData = $row;
									foreach($outputData as $col => $val) {
										echo "<th scope='col'>" . $col . '</th>';
									}
									echo '</tr></thead><tbody>'; 
								}
								echo '<tr>';
								foreach($row as $data) {
									echo '<td>'.$data.'</td>';
								}
								echo '</tr>';
							}
						}
						echo '</tbody></table>';
				?>
		
			</form>

		</div>
	</div>
	<div id="dropDownSelect1"></div>
</body>
</html>