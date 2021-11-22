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
		include_once 'index.html';

		session_start();
		$practitioner_number = $_SESSION["session_practitioner"];

		// Shabrina grabs the practitioner name and save it in the session to be passed along
	?>
		<div class="main">
			<div class="form__container">
				<div class="form__content">
					<p class="form__subheading">Choose which medications and diet regimes to display.</p>
					<!-- Actual form -->
					<form id="form--dashboard" class="" action="results.php">
						<!-- Date -->
						<div class="input__container">
							<label for="date" type="date">Date</label><br>
							<input type="date" value="2021-11-22" min="2021-11-22" max="2021-12-05">
						</div>
						<!-- Dropdown List of Time of Day -->
						<div class="input__container">
							<label for="time">Time of Day</label><br>
							<select name="dropdown--time" id="dropdown--time">
								<option value="Morning">Morning</option>
								<option value="Afternoon">Afternoon</option>
								<option value="Evening">Evening</option>
							</select>
						</div>
						<!-- Dropdown List of Patients -->
						<div class="input__container">
							<label for="patient">Patient</label><br>
							<select name="dropdown--patients" id="dropdown--patients">
								<!-- <option value="Margaret">Margaret</option>
								<option value="Bob">Bob</option> -->
								<?php
									// Obtain list of patients from database
									$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
									$sql = "SELECT * FROM Patients WHERE (lcase(EmailAddress)='{$email}') OR (lcase(FirstName)='{$first_name}' AND lcase(LastName)='{$last_name}')";
									$rs = odbc_exec($conn,$sql);
									$row = odbc_fetch_array($rs);
								?>
							</select>
						</div>
						<div class="input__container">
							<input type="submit" value="Go" class="form__submit">
						</div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			document.getElementById("dashboard").classList.add("sidenav__link--anchor-primary");
			document.getElementById("heading").innerText = "Dashboard";
			document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
		</script>
</body>

</html>