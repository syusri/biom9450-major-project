<!DOCTYPE html>
<html>

<head>
	<title>Generate Report</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
</head>

<body>
	<?php
		include 'index2.html';
        //Grab information of the patient ID from the search page
        session_start();
        if(! isset($_SESSION["session_practitioner"])) {
            header("Location:login.php");
        }
	?>

	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><span class="page--current">Generate Report</span></p>
		</div>
		<?php 
			$conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);

			session_start();
			$practitioner_number = $_SESSION["session_practitioner"];
			$practitioner_name = $_SESSION["session_practitioner_name"];

			$sql = "SELECT * FROM Practitioner WHERE PractitionerID={$practitioner_number}";
			$rs = odbc_exec($conn,$sql);
			// Finds the practitioner that is logged in

			// Get the practitioner name that is logged in
			while ($row = odbc_fetch_array($rs)){
				$practitioner_name_loggedin = $row["FirstName"]." ".$row["LastName"];
			} 
		?>
		<!-- Actual form -->
		<div>
			<form class="form--dashboard" action="reports_display.php" method="POST">
				<div class="section__container--report">
					<legend><h2>&nbsp;&nbsp;Patient</h2><legend>
						<?php 
							//connect to database
							$conn = odbc_connect('z5254640', '', '', SQL_CUR_USE_ODBC);
							if ($conn->connect_error) {
								echo "$conn->connect_error";
								die("Connection Failed\n");
							}
							//get full name of patients
							$sql_PATIENT = "SELECT PatientID, FirstName, LastName FROM Patient";
							$rs = odbc_exec($conn, $sql_PATIENT);
							if(!$rs) {
								exit("Error in SQL"); 
							}
							
							//print practitioners
							$num = 1;
							while (odbc_fetch_row($rs)) {
								$first = odbc_result($rs,"FirstName");
								$last = odbc_result($rs, "LastName");
								$id = odbc_result($rs, "PatientID");
								echo "<div>";
								echo "<input type='checkbox' name='$num' id='$num'/>";
								echo "$first $last (PA00$id)";
								echo "</div>";
								$num += 1;
							}
							odbc_close($conn);
						?>
				</div>
				

				<div class="section__container--report">
					<legend><h2>&nbsp;&nbsp;Information</h2><legend>
					<div>
						<input type="checkbox" name="Medication"/>Medication
						<br>
						<input type="checkbox" name="Diet" id="Diet"/>Diet
						<br>
					</div>			
				</div>

				<div class="section__container--report">
					<div>
						<legend><h2>&nbsp;&nbsp;Week</h2><legend>
						<input type="checkbox" name="Last" id="Last"/>Last Week
						<br>
						<input type="checkbox" name="This" id="This"/>This Week
						<br>
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
		// Change this PR Name to the PR that is logged in 
		document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
	</script>
</body>

</html> 