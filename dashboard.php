<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AgedCare</title>
	<link rel="stylesheet" href="css/styles.css">
	<!-- <script src="js/main.js"></script> -->
</head>

<body>
		<?php
			include 'index.html';
			session_start();
			if(!isset($_SESSION["session_practitioner"])) { header("Location:login.php");}
			$practitioner_number = $_SESSION["session_practitioner"];
			$conn = odbc_connect('z5254640','','',SQL_CUR_USE_ODBC);
			if(!$conn){
				// Error checking for SQL
				header("Location:error.php");
			}
			$sql = "SELECT * FROM Practitioner WHERE PractitionerID={$practitioner_number}";
			$rs = odbc_exec($conn,$sql);
			if(!$rs){
				// Error checking for SQL
				header("Location:error.php");
			}

			while ($row = odbc_fetch_array($rs)){
				$_SESSION["session_practitioner_name"] = $row["FirstName"]." ".$row["LastName"];
			} 
		?> 

		<div class="main">
			<div class="form__container">
				<div class="form__content">
					<p class="form__subheading">Choose which medications and diet regimes to display.</p>
					<!-- Actual form -->
					<form id="form--dashboard" class="" method="POST">
						<!-- Date -->
						<div class="input__container">
							<label for="inputDate" type="date">Date</label><br>
							<input class="input__container--dash" name="inputDate" id="inputDate" type="date" value="2021-11-22" min="2021-11-22" max="2021-12-05">
						</div>
						<!-- Dropdown List of Time of Day -->
						<div class="input__container">
							<label for="time">Time of Day</label><br>
							<select class="input__container--dash" name="dropdown--time" id="dropdown--time">
								<option value="Morning">Morning</option>
								<option value="Afternoon">Afternoon</option>
								<option value="Evening">Evening</option>
							</select>
						</div>
						<!-- Dropdown List of Patients -->
						<div class="input__container">
							<label for="patient">Patient</label><br>
							<select class="input__container--dash" name="dropdown--patients" id="dropdown--patients">
								<!-- Obtain list of patients from database -->
								<?php
									ob_start();
									$prac = $_SESSION["session_practitioner"];
									$sql = "SELECT * FROM Patient WHERE PractitionerID=$prac";
									
									$rs = odbc_exec($conn,$sql);
									if(!$rs){
										// Error checking for SQL
										header("Location:error.php");
									}
									while ($row = odbc_fetch_array($rs)) {
										$name = $row["FirstName"]." ".$row["LastName"];
										$_SESSION[$name] = $row["PatientID"]; 
										echo "<option value='$name'>$name</option>";
									}
								?>
							</select>
						</div>
						<div class="input__container">
							<input type="submit" value="Go" class="form__submit input__container--dash" name="dash_submit">
						</div>
					</form>

					<!-- Bring information to results.php with PHP after form submission -->
					<?php
					
						if (isset($_POST["dash_submit"])) {
							$_SESSION["inputDate"] = $_POST["inputDate"]; 
							$_SESSION["time"] = $_POST["dropdown--time"];
							$_SESSION["patient"] = $_POST["dropdown--patients"];
							header("Location: results.php"); 
							ob_end_flush();
						}
					?>

				</div>
			</div>
		</div>
		<script type="text/javascript">
			document.getElementById("dashboard").classList.add("sidenav__link--anchor-primary");
			document.getElementById("heading").innerText = "Dashboard";
			document.getElementById("practitioner").innerText = "Dr. <?php echo $_SESSION["session_practitioner_name"];?> ";
		</script>
</body>

</html>