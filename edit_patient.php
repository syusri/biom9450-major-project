<!DOCTYPE html>
<html>

<head>
	<title>Edit a Patient</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_sheet_new.css">
	<script src="add_patient_validation.js"></script>
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
				<p><a href="patient_summary.php" class="page--previous">Patient Summary</a> > <span class="page--current">Edit Patient</span></p>
		</div>
		<?php 
			$conn = odbc_connect('z5254640', '', '',SQL_CUR_USE_ODBC);

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
		<div class="form__container--mini">
			<form class="form--dashboard" onSubmit="return validInfo()" action="edit_success.php" method="POST" align="center">
				
				<!-- Patient Details -->
				<h3><br>Patient Information</h3>
				<?php
					// Grab the patient ID from the summary page 
					if (!$_POST["submit_edit_patient_ID"]) {
						// If this page is not directed from the search page so a patient ID has not come through it will show the page for patient PA001
						$patient_number = "1";
					} else {
						$patient_number = $_POST["submit_edit_patient_ID"];
					}
					//hidden field for patient_number to send to next page
					echo "<input type='hidden' name='patient_id' value=$patient_number>";
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
					
					$sql_diet = "SELECT DietName FROM DietRegime WHERE DietRegimeID=$diet_id";
					$ds = odbc_exec($conn, $sql_diet);
					if (!$ds) {
						exit ("Error in SQL diet");
					}
					odbc_fetch_row($ds);
					$diet_name = odbc_result($ds, "DietName");
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
				<option value='1'<?php if ($room == 1) echo ' selected="selected"'; ?>>1</option>
				<option value='2'<?php if ($room == 2) echo ' selected="selected"'; ?>>2</option>
				<option value='3'<?php if ($room == 3) echo ' selected="selected"'; ?>>3</option>
				<option value='4'<?php if ($room == 4) echo ' selected="selected"'; ?>>4</option>
				<option value='5'<?php if ($room == 5) echo ' selected="selected"'; ?>>5</option>
				<option value="6"<?php if ($room == 6) echo ' selected="selected"'; ?>>6</option>
				<option value="7"<?php if ($room == 7) echo ' selected="selected"'; ?>>7</option>
				<option value="8"<?php if ($room == 8) echo ' selected="selected"'; ?>>8</option>
				<option value="9"<?php if ($room == 9) echo ' selected="selected"'; ?>>9</option>
				<option value="10"<?php if ($room == 10) echo ' selected="selected"'; ?>>10</option>
				</select>
				<br></br>
				

				<div class='error' id='error_weight'></div>
				Weight (kg): <input type='number' id='weight' name='weight' value='<?php echo $weight;?>'
				onchange='Weight()'/>
				<br></br>

				Diet: <select id='diet' name='diet'>
				<option value='Normal'<?php if ($diet_name == "Normal") echo ' selected="selected"'; ?>>Normal</option>
				<option value='Weight reduction'<?php if ($diet_name == "Weight reduction") echo ' selected="selected"'; ?>>Weight reduction</option>
				<option value='Diabetes'<?php if ($diet_name == "Diabetes") echo ' selected="selected"'; ?>>Diabetes</option>
				<option value='Gluten free'<?php if ($diet_name == "Gluten free") echo ' selected="selected"'; ?>>Gluten free</option>
				</select>
				<br></br>

				<!-- Emergency Contact Information -->
				<h3><br>Emergency Contact</h3>
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
				value='<?php echo $relationship;?>' onchange='Relationship()'/>
				<br></br>

				<!-- Medicare Details -->
				<h3><br>Medicare Information</h3>
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
				Medicare Number: <input type='number' id='number' name='number' value='<?php echo $number;?>'
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

				Additional notes:<br></br> <textarea name='notes' id='notes' cols='45' rows='5' value=''><?php echo $notes;?></textarea>
				<br></br>

				<!-- Submit Button-->
				<div class="error" id="submit_check"></div>
				<input type="submit" value="Go" class="form__submit input__container--small">
			</form>
		</div>
	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("patients").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Edit Patient";
		document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
	</script>
</body>

</html> 