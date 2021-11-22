<!DOCTYPE html>
<html>

<head>
	<title>Edit a Patient</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_sheet.css">
	<script src="add_patient_validation.js"></script>
</head>

<body>
	<?php
		include_once 'index.html';
	?>
	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Edit Patient</span></p>
		</div>
		<!-- Actual form -->
		<div class="form__container--mini">
			<form class="form--dashboard" onSubmit="return validInfo()" action="edit_success.php", method="POST">
				<!-- Patient Details -->
				<h3>Patient Information</h3>
				<?php
					$conn = odbc_connect('z5254640', '', '', SQL_CUR_USE_ODBC);
					if ($conn->connect_error) {
						echo "$conn->connect_error";
						die("Connection Failed\n");
					}
					//get full name of practitioners
					$sql_PATIENT = "SELECT * FROM Patient WHERE PatientID=1";
					$rs = odbc_exec($conn, $sql_PATIENT);
					if(!$rs) {
						exit("Error in SQL"); 
					}
					while (odbc_fetch_row($rs)) {
						$first = odbc_result($rs,"FirstName");
						$last = odbc_result($rs,"LastName");
						$gender = odbc_result($rs,"Gender");
						$room = odbc_result($rs,"RoomNumber");
						$dr = odbc_result($rs,"PractitionerID");
						$contact = odbc_result($rs,"ContactID");
						$dob = odbc_result($rs,"DOB");
						$weight = odbc_result($rs,"Weight");
						$diet_id = odbc_result($rs,"DietRegimeID");
						$medicare = odbc_result($rs,"MedicareID");
						$notes = odbc_result($rs,"Notes");
					}
					odbc_close($conn);

					echo "<div class='error' id='error_firstName'></div>'";
					echo "First Name: <input type='text' id='firstName' name='firstName' value='$first'  
					onchange='First_Name()'/>";
				?>
				<br></br>
				<?php
					echo "<div class='error' id='error_lastName'></div>";
					echo "Last Name: <input type='text' id='lastName' name='lastName' value='$last'
					onchange='Last_Name()'/>";
				?>
				<br></br>
				<?php
					echo "Room Number: <select id='room_number' name='room_number'>";
					echo "<option value='1'>1</option>";
					echo "<option value='2'>2</option>";
					echo "<option value='3'>3</option>";
					echo "<option value='4'>4</option>";
					echo "<option value='5'>5</option>";
					echo "</select>";
				
				?>
				<br></br>
				<?php
					//fix format of value
					echo "<div class='error' id='error_dateofbirth'></div>";
					echo "Date of Birth: <input type='text' id='dateofbirth' name='dateofbirth' value='$dob'
					onchange='DOB()'/>";
				?>
				<br></br>
				<?php
					echo "<div class='error' id='error_weight'></div>";
					echo "Weight (kg): <input type='number' id='weight' name='weight' value='$weight'
					onchange='Weight()'/>";
				?>
				<br></br>
				<?php 
					echo "Diet: <select id='diet' name='diet'>";
					echo "<option value='normal'>Normal</option>";
					echo "<option value='weight_reduction'>Weight Reduction</option>";
					echo "<option value='diabetes'>Diabetes</option>";
					echo "<option value='gluten_free'>Gluten Free</option>";
					echo "</select>";
				?>
				<br></br>
				<!-- Emergency Contact Information -->
				<h3>Emergency Contact</h3>
				<?php 
					$conn = odbc_connect('z5254640', '', '', SQL_CUR_USE_ODBC);
					if ($conn->connect_error) {
						echo "$conn->connect_error";
						die("Connection Failed\n");
					}
					//get full name of practitioners
					$sql_CONTACT = "SELECT * FROM EmergencyContact WHERE ContactID=$contact";
					$rs = odbc_exec($conn, $sql_CONTACT);
					if(!$rs) {
						exit("Error in SQL"); 
					}
					while (odbc_fetch_row($rs)) {
						$first = odbc_result($rs,"FirstName");
						$last = odbc_result($rs,"LastName");
						$phone = odbc_result($rs,"PhoneNumber");
						$email = odbc_result($rs,"Email");
						$relationship = odbc_result($rs,"Relationship");
						
					}
					odbc_close($conn);

					echo "<div class='error' id='error_first_contact'></div>";
					echo "First Name: <input type='text' id='firstName_contact' name='firstName_contact' value='$first' 
					onchange='First_Name_Contact()'/>";
					echo "<br></br>";
					echo "<div class='error' id='error_last_contact'></div>";
					echo "Last Name: <input type='text' id='lastName_contact' name='lastName_contact' value='$last' 
					onchange='Last_Name_Contact()'/>";
					echo "<br></br>";
					echo "<div class='error' id='error_phone'></div>";
					echo "Phone Number: <input type='number' id='phone' name='phone' value='$phone'
					onchange='Phone()'/>";
					echo "<br></br>";
					echo "<div class='error' id='error_relationship'></div>";
					echo "Relationship to patient: <input type='text' id='relationship' name='relationship' value='$relationship' 
					onchange='Relationship()'/>";
					echo "<br></br>";
				?>
				<!-- Medicare Details -->
				<h3>Medicare Information</h3>
				<?php 
					$conn = odbc_connect('z5254640', '', '', SQL_CUR_USE_ODBC);
					if ($conn->connect_error) {
						echo "$conn->connect_error";
						die("Connection Failed\n");
					}
					//get full name of practitioners
					$sql_MEDI = "SELECT * FROM Medicare WHERE MedicareID=$medicare";
					$rs = odbc_exec($conn, $sql_MEDI);
					if(!$rs) {
						exit("Error in SQL"); 
					}
					while (odbc_fetch_row($rs)) {
						$number = odbc_result($rs,"MedicareNumber");
						$reference = odbc_result($rs,"MedicareReference");
						$expiry = odbc_result($rs,"Expiry");
						
					}
					odbc_close($conn);
					echo "<div class='error' id='error_medicare'></div>";
					echo "Medicare Number: <input type='number' id='medicare' name='medicare' value='$number'
					onchange='Medicare()'/>";
					echo "<br></br>";
					echo "<div class='error' id='error_IRN'></div>";
					echo "Individual Reference Number: <input type='number' id='IRN' name='IRN' value='$reference' 
					onchange='IRN()'/>";
					echo "<br></br>";
					echo "<div class='error' id='error_expiry'></div>";
					echo "Expiry date: <input type='text' id='expiry' name='expiry' value='$expiry'
					onchange='Medicare_Expiry()'/>";
					echo "<br></br>";
					echo "Additional notes:<br></br> <textarea name='notes' id='notes' cols='45' rows='5' value='$notes'></textarea>";
					echo "<br></br>";
					
				?>
				<!-- Submit Button-->
				<div class="error" id="submit_check"></div>
				<input type="submit" value="Go" class="form__submit input__container--small">
			</form>
		</div>
	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("dashboard").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Edit Patient";
		document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
	</script>
</body>

</html> 