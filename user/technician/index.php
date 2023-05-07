<?php 
	include 'settings.php'; //include settings 
	$success = 0;

	if(isset($_GET['endingReading'])) {	
		$search = "SELECT * FROM `details` WHERE `place` LIKE '".$_GET['place']."' AND `dept` LIKE '".$_SESSION["dept"]."'";
		$result = mysqli_query($conn, $search);

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$success += 1;
			$details_id = $row["id"];
		} else {
			$sql = "INSERT INTO `details` (`id`, `dept`, `place`) VALUES (NULL, '".$_SESSION["dept"]."', '".$_GET['place']."')";

			if (mysqli_query($conn, $sql)) {
				$success += 1;
				$details_id = mysqli_insert_id($conn);
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
				
		$sql = "INSERT INTO `entry` (`id`, `date`, `on_time`, `off_time`, `starting_reading`, `ending_reading`, `purpose`) VALUES (NULL, '".$_GET['date']."', '".$_GET['ontime']."', '".$_GET['offtime']."', '".$_GET['startingReading']."', '".$_GET['endingReading']."', '".$_GET['purpose']."')";

		if (mysqli_query($conn, $sql)) {
			$success += 1;
			$entry_id = mysqli_insert_id($conn);
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		$sql = "INSERT INTO `relation` (`id`, `details`, `entry`) VALUES (NULL, '$details_id', '$entry_id')";
		if (mysqli_query($conn, $sql)) {
			#$success += 1;
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Contact</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style.css">
	<link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" method="GET">
				<?php if($success == 2) { ?>
				<div style="position: relative;padding: 0.75rem 1.25rem;border: 1px solid #28a745;border-radius: 0.25rem;background-color: #28a745;margin-bottom: 2em;color: white;font-weight: 700;">
					Successfully Entered
				</div>
				<?php } ?>

				<span class="contact100-form-title">Hello <?php UserName(); //Show name who is in session user?>!</span>
				<!---<div class="wrap-input100 validate-input" data-validate="Department is required">
					<span class="label-input100">Your Department</span>
					<input class="input100" type="text" list="dept" name="dept" placeholder="Enter your Department" value="">
					<datalist id="dept">
						<option value="Edge">
						<option value="Firefox">
						<option value="Chrome">
						<option value="Opera">
						<option value="Safari">
					</datalist>
					<span class="focus-input100"></span>
				</div>--->
				<div class="wrap-input100 validate-input" data-validate="Place is required">
					<span class="label-input100">Place</span>
					<input class="input100" type="text" list="place" name="place" placeholder="Place" value="">
					<datalist id="place">
<?php
	$sql = "SELECT * FROM `details` WHERE `dept` LIKE '".$_SESSION["dept"]."'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			echo '<option value="' . $row["place"] . '">';
		}
	}
?>
					</datalist>
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Date is required">
					<span class="label-input100">Date</span>
					<input class="input100" type="date" name="date" placeholder="Date" value="">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="On Time is required">
					<span class="label-input100">On Time</span>
					<input class="input100" type="time" name="ontime" placeholder="On Time" value="">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Off Time is required">
					<span class="label-input100">Off Time</span>
					<input class="input100" type="time" name="offtime" placeholder="Off Time" value="">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Starting Reading is required">
					<span class="label-input100">Starting Reading</span>
					<input class="input100" type="text" name="startingReading" placeholder="Starting Reading" value="">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Ending Reading is required">
					<span class="label-input100">Ending Reading</span>
					<input class="input100" type="text" name="endingReading" placeholder="Ending Reading" value="">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Purpose is required">
					<span class="label-input100">Purpose</span>
					<textarea class="input100" name="purpose" placeholder="Your Purpose here..."></textarea>
					<span class="focus-input100"></span>
				</div>
				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button class="contact100-form-btn"><span>Submit<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i></span></button>
					</div>
				</div>

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<a href="report.php" class="contact100-form-btn">Report</a>
					</div>
				</div>

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<a href="../../includes/logout.php" class="contact100-form-btn">Logout</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div id="dropDownSelect1"></div>
</body>
</html>