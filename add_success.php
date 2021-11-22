<!DOCTYPE html>
<html>

<head>
	<title>New Patient</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_sheet.css">
</head>

<body>
	<?php
		include_once 'index.html';
	?>
	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
			<p><a href="dashboard.php" class="page--previous">Add Patient</a> ><span class="page--current">New Patient</span></p>
		</div>
		<!-- JavaScript to change PHP template -->
		<script type="text/javascript">
			document.getElementById("dashboard").classList.add("sidenav__link--anchor-primary");
			document.getElementById("heading").innerText = "Add Patient";
			document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
		</script>
		<?php
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$gender = $_POST['gender'];
			$roomNumber = $_POST['room_number'];
			$dob = $_POST['dateofbirth'];
			$patientImage = $_POST['patient_image'];
			$weight = $_POST['weight'];
			$diet = $_POST['diet'];
			$notes = $_POST['notes'];

			//add new patient to database

		?>
    	<!-- Top bar where heading, practitioner and logout are -->
		<div class="topnav">
			<h1 id="heading"><!-- Place heading here --></h1> 
			<ul class="nav__link--list">
				<li id="practitioner" class="nav__link--anchor">
					<!-- Name of Practitioner -->
				</li>
				<li class="nav__link--anchor">
					<a href="#" class="nav__link--anchor">Logout</a>
				</li>
			</ul>
		</div>
		
	</div>
</body>