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
		include_once 'index.html';
	?>
	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><a href="patient_summary.php" class="page--previous">Patient Summary</a> > <span class="page--current">Add Patient</span></p>
		</div>
		<!-- Actual form -->
		<div class="form__container--mini">
			<form class="form--dashboard" onSubmit="return validInfo()" action="add_success.php", 
			method="POST">
			<!-- , enctype="multipart/form-data"-->
				<div class='section__container--report'>
					<!-- Patient Details -->
					<h3>Patient Information</h3>
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
					</select>
					</p>
					
					<p>
					<div class="error" id="error_dateofbirth"></div>
					Date of Birth: <input type="date" id="dateofbirth" name="dateofbirth" value=""
					onchange="DOB()"/>
					</p>
					
					<p>
					Upload image: <input type="file" id="patient_image" name="patient_image" value=""
					accept="image/*"/>
					</p>
					
					<p>
					<div class="error" id="error_weight"></div>
					Weight (kg): <input type="number" id="weight" name="weight" value=""
					onchange="Weight()"/>
					</p>
					
					<p>
					Diet: <select id="diet" name="diet">
						<option value="normal">Normal</option>
						<option value="weight_reduction">Weight Reduction</option>
						<option value="diabetes">Diabetes</option>
						<option value="gluten_free">Gluten Free</option>
					</select>
					</p>
					
				</div>

				<!-- Emergency Contact Information -->
				<div class='section__container--report'>
					<h3>Emergency Contact</h3>
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
					<h3>Medicare Information</h3>
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
				<input type="submit" value="Go" class="form__submit input__container--small">
			</form>
		</div>
	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("patients").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Add Patient";
		document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
	</script>
</body>

</html> 