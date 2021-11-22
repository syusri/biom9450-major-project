<!DOCTYPE html>
<html>

<head>
	<title>Generate Report</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_sheet.css">
	<script src="reports_script.js"></script>
</head>

<body>
	<?php
		include_once 'index.html';	
	?>

	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Generate Report</span></p>
		</div>
		<!-- Actual form -->
		<div>
			<form class="form--dashboard" action="reports_display.php", method="POST">
				<div class="multiselect">
					<!-- Javascript to display checkboxes-->
					<div class="selectBox" onclick="showCheckboxes()">
					<select>
						<option selected hidden>Patient</option>
					</select>
					<div class="overSelect"></div>
					</div>
					<div id="checkboxes">
						<p>
							<?php 
								//connect to database
								$conn = odbc_connect('z5254640', '', '', SQL_CUR_USE_ODBC);
								if ($conn->connect_error) {
									echo "$conn->connect_error";
									die("Connection Failed\n");
								}
								//get full name of practitioners
								$sql_PATIENT = "SELECT PatientID, FirstName, LastName FROM Patient";
								$rs = odbc_exec($conn, $sql_PATIENT);
								if(!$rs) {
									exit("Error in SQL"); 
								}
								
								//print practitioners
								$counter = 1;
								while (odbc_fetch_row($rs)) {
									$first = odbc_result($rs,"FirstName");
									$last = odbc_result($rs, "LastName");
									$id = odbc_result($rs, "PatientID");
									echo "<label for='$counter'>";
									echo "<input type='checkbox' id='$counter' /> $first $last (PA00$id)";
									echo "</label>";
									echo "<br>";
									$counter += 1;
								}
								odbc_close($conn);
							?>
						</p>
					</div>
				</div>
				<div class="multiselect">
					<!-- Javascript to display checkboxes-->
					<div class="selectBox" onclick="showCheckboxes()">
					<select>
						<option selected hidden>Information</option>
					</select>
					<div class="overSelect"></div>
					</div>
					<div id="checkboxes">
						<p>
							<label for="1">
								<input type="checkbox" id="1" /> Medications
							</label>
							<br>
							<label for="2">
								<input type="checkbox" id="2" /> Diet
							</label>
							<br>
						</p>
					</div>
				</div>
				<div class="multiselect">
					<div class="selectBox" onclick="showCheckboxes()">
					<select>
						<option selected hidden>Week</option>
					</select>
					<div class="overSelect"></div>
					</div>
					<div id="checkboxes">
						<p>
							<label for="1">
								<input type="checkbox" id="1" /> Last Week
							</label>
							<br>
							<label for="2">
								<input type="checkbox" id="2" /> This Week
							</label>
							<br>
						</p>
					</div>
				</div>
				<div class="error" id="submit_check"></div>
				<!-- Submit Button-->
				<input type="submit" value="Go" class="form__submit input__container--small">
			</form>
		</div>
	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("reports").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Generate Report";
		document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
	</script>
</body>

</html> 