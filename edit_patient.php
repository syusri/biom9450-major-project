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
				<p><a href="patient_summary.php" class="page--previous">Patient Summary</a> > <span class="page--current">Edit Patient</span></p>
		</div>
		<!-- Actual form -->
		<div class="form__container--mini">
			<form class="form--dashboard" onSubmit="return validInfo()" action="edit_success.php", method="POST">
				<!-- Patient Details -->
				<h3>Patient Information</h3>
				<?php
					// Grab the patient ID from the summary page 
					if (!$_POST["submit_edit_patient_ID"]) {
						// If this page is not directed from the search page so a patient ID has not come through it will show the page for patient PA001
						$patient_number = "1";
					} else {
						$patient_number = $_POST["submit_edit_patient_ID"];
					}

					$conn = odbc_connect('z5254640', '', '', SQL_CUR_USE_ODBC);
					if ($conn->connect_error) {
						echo "$conn->connect_error";
						die("Connection Failed\n");
					}
					//get full name of practitioners
					$sql_PATIENT = "SELECT * FROM Patient WHERE PatientID={$patient_number}";
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
									
					$dob = new DateTime($dob);
					odbc_close($conn);
				?>

				<div class='error' id='error_firstName'></div>
				First Name: <input type='text' id='firstName' name='firstName' value='<?php echo $first;?>'  
				onchange='First_Name()'/>
				<br></br>
				
				<div class='error' id='error_lastName'></div>
				Last Name: <input type='text' id='lastName' name='lastName' value='<?php echo $last;?>'
				onchange='Last_Name()'/>
				<br></br>

				Room Number: <select id='room_number' name='room_number'>
				<option value='1'>1</option>
				<option value='2'>2</option>
				<option value='3'>3</option>
				<option value='4'>4</option>
				<option value='5'>5</option>
				</select>
				<br></br>

				<div class="error" id="error_dateofbirth"></div>
				Date of Birth: <input type="text" id="dateofbirth" name="dateofbirth"
				value='<?php echo $dob->format("d/m/Y");?>' onchange="DOB()"/>
				<br></br>

				<div class='error' id='error_weight'></div>
				Weight (kg): <input type='number' id='weight' name='weight' value='<?php echo $weight;?>'
				onchange='Weight()'/>
				<br></br>

				Diet: <select id='diet' name='diet'>
				<option value='normal'>Normal</option>
				<option value='weight_reduction'>Weight Reduction</option>
				<option value='diabetes'>Diabetes</option>
				<option value='gluten_free'>Gluten Free</option>
				</select>
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
				?>

				<div class='error' id='error_first_contact'></div>
				First Name: <input type='text' id='firstName_contact' name='firstName_contact' 
				value='<?php echo $first;?>' onchange='First_Name_Contact()'/>
				<br></br>
				
				<div class='error' id='error_last_contact'></div>
				Last Name: <input type='text' id='lastName_contact' name='lastName_contact' 
				value='<?php echo $last;?>' onchange='Last_Name_Contact()'/>
				<br></br>
				
				<div class='error' id='error_phone'></div>
				Phone Number: <input type='number' id='phone' name='phone' 
				value='<?php echo $phone;?>' onchange='Phone()'/>
				<br></br>
				
				<div class='error' id='error_relationship'></div>
				Relationship to patient: <input type='text' id='relationship' name='relationship' 
				value='$relationship' onchange='Relationship()'/>
				<br></br>

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
					$expiry = new DateTime($expiry);
				?>
				<div class="error" id="error_medicare"></div>
				Medicare Number: <input type='number' id='medicare' name='medicare' value='<?php echo $number;?>'
				onchange='Medicare()'/>
				<br></br>

				<div class='error' id='error_IRN'></div>
				Individual Reference Number: <input type='number' id='IRN' name='IRN' value='<?php echo $reference;?>' 
				onchange='IRN()'/>
				<br></br>

				<div class='error' id='error_expiry'></div>
				Expiry date: <input type='text' id='expiry' name='expiry' value='<?php echo $expiry->format("m/Y");?>'
				onchange='Medicare_Expiry()'/>
				<br></br>

				Additional notes:<br></br> <textarea name='notes' id='notes' cols='45' rows='5' value='<?php echo $notes;?>'></textarea>
				<br></br>

				<!-- Submit Button-->
				<div class="error" id="submit_check"></div>
				<input type="submit" value="Go" class="form__submit input__container--small">
			</form>
		</div>
	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("patient").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Edit Patient";
		document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
	</script>
</body>

</html> 