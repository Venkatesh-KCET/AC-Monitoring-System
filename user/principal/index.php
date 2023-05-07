<?php 
	include 'settings.php'; //include settings 
	if(isset($_GET['csv'])) {
		$delimiter = ","; 
		$filename = "report_" . date('Y-m-d') . ".csv"; 
     
		// Create a file pointer 
		$f = fopen('php://memory', 'w'); 

		$condition = '';
		if($_GET['place'] != '') {
			$condition .= " AND details.place = '".$_GET['place']."'";
		}
		if($_GET['dept'] != '') {
			$condition .= " AND details.dept = '".$_GET["dept"]."'";
		}
		if($_GET['Sdate'] != '') {
			$condition .= " AND entry.`date` between '".$_GET['Sdate']."' and '".$_GET['Edate']."'";
		}
		$sql = "SELECT details.id as 'DID', details.dept, details.place, entry.`id` as 'EID', entry.`date`, entry.`on_time`, entry.`off_time`, entry.`starting_reading`, entry.`ending_reading`, entry.`purpose` FROM details, entry, relation WHERE 
				relation.details = details.id AND relation.entry = entry.`id` ".$condition." ORDER BY `details`.`dept`, `details`.`place` ASC";

		$result = mysqli_query($conn, $sql);
						
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				if(empty($outputData)) {
					$outputData = $row;
					$fields = array();
					foreach($outputData as $col => $val) {
						$fields[] = $col;
					}
					// Set column headers 
					fputcsv($f, $fields, $delimiter); 
				}
				// Output each row of the data, format line as csv and write to file pointer 
				fputcsv($f, $row, $delimiter); 
			}
		}

		// Move back to beginning of file 
		fseek($f, 0); 
		// Set headers to download file rather than displayed 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
		//output all remaining data on a file pointer 
		fpassthru($f);
		exit;
	}
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
				<span class="contact100-form-title">Report</span>
				<div class="container">
					<div class="row">
						<div class="col-sm">
							<div class="wrap-input100 validate-input" data-validate="Dept is required">
								<span class="label-input100">Dept</span>
								<input class="input100" type="text" list="dept" name="dept" placeholder="Dept" id="Dept" value="" onblur="getPlace(this)">
								<datalist id="dept">
<?php
	$placeSQL = "SELECT DISTINCT dept FROM `details`";
	$placeResult = mysqli_query($conn, $placeSQL);

	if (mysqli_num_rows($placeResult) > 0) {
		// output data of each row
		while($placeRow = mysqli_fetch_assoc($placeResult)) {
			echo '<option value="' . $placeRow["dept"] . '">';
		}
	}
	
	$palaceArr = array();
	$placeSQL = "SELECT * FROM `details` ORDER BY `details`.`dept` ASC";
	$placeResult = mysqli_query($conn, $placeSQL);

	if (mysqli_num_rows($placeResult) > 0) {
		// output data of each row
		while($placeRow = mysqli_fetch_assoc($placeResult)) {
			$palaceArr[$placeRow["dept"]][] = $placeRow["place"];
		}
	}
?>
								</datalist>
								<span class="focus-input100"></span>
							</div>
						</div>
						<div class="col-sm">
							<div class="wrap-input100 validate-input" data-validate="Place is required">
								<span class="label-input100">Place</span>
								<input class="input100" type="text" list="place" name="place" placeholder="Place" value="">
								<datalist id="place"></datalist>
								<span class="focus-input100"></span>
							</div>
						</div>
						<div class="col-sm">
							<div class="wrap-input100 validate-input" data-validate="Date is required">
								<span class="label-input100">Starting Date</span>
								<input class="input100" type="date" name="Sdate" placeholder="Date" value="">
								<span class="focus-input100"></span>
							</div>
						</div>
						<div class="col-sm">
							<div class="wrap-input100 validate-input" data-validate="Date is required">
								<span class="label-input100">Ending Date</span>
								<input class="input100" type="date" name="Edate" placeholder="Date" value="">
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
					if(isset($_GET['place'])) {
						$condition = '';
						if($_GET['place'] != '') {
							$condition .= " AND details.place = '".$_GET['place']."'";
						}
						if($_GET['dept'] != '') {
							$condition .= " AND details.dept = '".$_GET["dept"]."'";
						}
						if($_GET['Sdate'] != '') {
							$condition .= " AND entry.`date` between '".$_GET['Sdate']."' and '".$_GET['Edate']."'";
						}

						$sql = "SELECT details.id as 'DID', details.dept, details.place, entry.`id` as 'EID', entry.`date`, entry.`on_time`, entry.`off_time`, entry.`starting_reading`, entry.`ending_reading`, entry.`purpose` FROM details, entry, relation WHERE 
						relation.details = details.id AND relation.entry = entry.`id` ".$condition." ORDER BY `details`.`dept`, `details`.`place` ASC";
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
			<div class="container-contact100-form-btn">
				<div class="wrap-contact100-form-btn">
					<div class="contact100-form-bgbtn"></div>
						<a href="<?php echo 'index.php?place='.$_GET['place'].'&Sdate='.$_GET['Sdate'].'&Edate='.$_GET['Edate'].'&csv='; ?>" class="contact100-form-btn">Download</a>
					</div>
				</div>
			</div>

				<?php	
					}
				?>
			</form>

		</div>
	</div>
	<div id="dropDownSelect1"></div>
	<script>
	function getPlace() {
		const val = document.querySelector("#Dept").value;
		console.log(val);
		var items = [];
	<?php
		foreach($palaceArr as $deptkey => $val) {
			for($i = 0; $i < count($val); $i++) {
				$val[$i] = "'".$val[$i]."'";
			}
			echo "items['".$deptkey."'] = [".implode(", ", $val)."];";
		}
	?>
		
		var outputt = '';
		for (let i = 0; i < items[val].length; i++) {
			outputt += '<option value="' + items[val][i] + '">';
		}

		document.getElementById("place").innerHTML = outputt;
	}	
	</script>
</body>
</html>