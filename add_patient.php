<!DOCTYPE html>
<html>

<head>
	<title>Add a Patient</title>
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
				<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Add Patient</span></p>
		</div>
		<!-- Actual form -->
		<div class="form__container--mini">
			<form class="form--dashboard" onSubmit="return validInfo()" action="add_success.php", method="POST">
			<div class="error" id="error_firstName"></div>
				First Name: <input type="text" id="firstName" name="firstName" value="" 
				onchange="First_Name()"/>
				<br></br>
				<div class="error" id="error_lastName"></div>
				Last Name: <input type="text" id="lastName" name="lastName" value=""
				onchange="Last_Name()"/>
				<br></br>
				Gender: <select id="gender" name="gender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Other">Other</option>
				</select>
				<br></br>
				Room Number: <select id="room_number" name="room_number">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<br></br>
				<div class="error" id="error_dateofbirth"></div>
				Date of Birth: <input type="date" id="dateofbirth" name="dateofbirth" value=""
				onchange="DOB()"/>
				<br></br>
				Upload image: <input type="file" id="patient_image" name="patient_image" value=""/>
				<br></br>
				<div class="error" id="error_weight"></div>
				Weight (kg): <input type="number" id="weight" name="weight" value=""
				onchange="Weight()"/>
				<br></br>
				Diet: <select id="diet" name="diet">
					<option value="normal">Normal</option>
					<option value="weight_reduction">Weight Reduction</option>
					<option value="diabetes">Diabetes</option>
					<option value="gluten_free">Gluten Free</option>
				</select>
				<br></br>
				Additional notes:<br></br> <textarea name="notes" id="notes" cols="45" rows="5"></textarea>
				<br></br>
				<div class="error" id="submit_check"></div>
				<input type="submit" value="Go" class="form__submit input__container--small">
			</form>
		</div>
	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("dashboard").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Add Patient";
		document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
	</script>
</body>

</html> 