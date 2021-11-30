<!DOCTYPE html>
<html>

<head>
	<title>Add a Patient</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css">
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
				<p><a href="patient_search_age.php" class="page--previous">Patient Search</a> > <span class="page--current">Add Patient</span></p>
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
			<form action="add_success.php" onSubmit="return validInfo()" method="POST" align="center">
				<div class='section__container--report'>
					<!-- Patient Details -->
					<h3><br>Patient Information</h3>
					<p>
						<div class="error" id="error_firstName"></div>
						First Name: <input type="text" id="firstName" name="firstName" value="" 
						onchange="First_Name()"/>
					</p>
					
					<p>
						<div class="error" id="error_lastName"></div>
						Last Name: <input type="text" id="lastName" name="lastName" value=""
						onchange="Last_Name()"/>
					</p>
				
					<p>
					Gender: <select id="gender" name="gender">
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Other">Other</option>
					</select>
					</p>					
					
					<p>
					Room Number: <select id="room_number" name="room_number">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					</select>
					</p>
					
					<p>
					<div class="error" id="error_dateofbirth"></div>
					Date of Birth: <input type="date" id="dateofbirth" name="dateofbirth" value=""
					onchange="DOB()"/>
					</p>
					
					<p>
					<div class="error" id="error_weight"></div>
					Weight (kg): <input type="number" id="weight" name="weight" value=""
					onchange="Weight()"/>
					</p>
					
					<p>
					Diet: <select id="diet" name="diet">
						<option value="Normal">Normal</option>
						<option value="Weight reduction">Weight Reduction</option>
						<option value="Diabetes">Diabetes</option>
						<option value="Glutenfree">Gluten Free</option>
					</select>
					</p>
					
				</div>

				<!-- Emergency Contact Information -->
				<div class='section__container--report'>
					<h3><br>Emergency Contact</h3>
					<p>
					<div class="error" id="error_first_contact"></div>
					First Name: <input type="text" id="firstName_contact" name="firstName_contact" value="" 
					onchange="First_Name_Contact()"/>
					</p>
					
					<p>
					<div class="error" id="error_last_contact"></div>
					Last Name: <input type="text" id="lastName_contact" name="lastName_contact" value="" 
					onchange="Last_Name_Contact()"/>
					</p>
					
					<p>
					<div class="error" id="error_phone"></div>
					Phone Number: <input type="number" id="phone" name="phone" value=""
					onchange="Phone()"/>
					</p>
					
					<p>
					<div class="error" id="error_email_contact"></div>
					Email: <input type="text" id="email_contact" name="email_contact" value="" 
					onchange=""/>
					</p>
					
					<p>
					<div class="error" id="error_relationship"></div>
					Relationship to patient: <input type="text" id="relationship" name="relationship" value="" 
					onchange="Relationship()"/>
					</p>
					
				</div>
				<div class='section__container--report'>
					<!-- Medicare Details -->
					<h3><br>Medicare Information</h3>
					<p>
					<div class="error" id="error_medicare"></div>
					Medicare Number: <input type="number" id="medicare" name="medicare" value=""
					onchange="Medicare()"/>
					</p>
					
					<p>
					<div class="error" id="error_IRN"></div>
					Individual Reference Number: <input type="number" id="IRN" name="IRN" value="" 
					onchange="IRN()"/>
					</p>
					
					<p>
					<div class="error" id="error_expiry"></div>
					Expiry date: <input type="date" id="expiry" name="expiry" value=""
					onchange="Medicare_Expiry()"/>
					</p>
					<br>
					<p>
					Additional notes:<br> <p><textarea name="notes" id="notes" cols="45" rows="5"></textarea></p>
					</p>
					
				</div>

				<div class="error" id="submit_check"></div>
				<!-- Submit Button-->
				<input type="submit" value="Go" class="form__submit input__container--small"/>
			</form>
		</div>
	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("patients").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Add Patient";
		document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
	</script>
</body>

</html> 