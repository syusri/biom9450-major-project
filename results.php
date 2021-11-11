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
	?>
		<div class="main">
			<!-- Breadcrumb -->
			<div class="breadcrumb">
					<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Medications and Diet Regimes</span></p>
			</div>
			<!-- Actual form -->
			<div class="form__container--mini">
				<form class="" action="results.php">
					<!-- Date -->
						<label for="date" type="date">Date</label>
						<input type="date" value="2021-11-22" min="2021-11-22" max="2021-12-05" class="input__container--small">
					<!-- Dropdown List of Time of Day -->
						<label for="time">Time of Day</label>
						<select name="dropdown--time" id="dropdown--time" class="input__container--small">
							<option value="Morning">Morning</option>
							<option value="Afternoon">Afternoon</option>
							<option value="Evening">Evening</option>
						</select>
					<!-- Dropdown List of Patients -->
						<label for="patient">Patient</label>
						<select name="dropdown--patients" id="dropdown--patients" class="input__container--small">
							<option value="Margaret">Margaret</option>
							<option value="Bob">Bob</option>
						</select>
						<input type="submit" value="Go" class="form__submit input__container--small">
				</form>
			</div>
			<!-- Patient Summary -->
			<section id="patient">
				<h2>Patient Summary</h2>
				<div class="section__container">
					<div class="patient__container--highlight">
						<div class="patient__highlight">
							<figure class="patient__highlight--box patient__picture--mask">
								<img src="./img/margaret.jpg" class="patient__picture" alt="Picture of Margaret">
							</figure>
							<h2 class="patient__highlight--box patient__name">
								Margaret Smith
							</h2>
							<p class="patient__highlight--box patient__room--label">
								Room number
							</p>
							<p class="patient__highlight--box patient__room--number">
								123
							</p>
							<p class="patient__highlight--box patient__prac--label">
								Practitioner
							</p>
							<p class="patient__highlight--box patient__prac--name">
								Dr. Juliette Smith
							</p>
						</div>
					</div>
					<div class="patient__details">
						<h2 class="patient__details--box patient__profile">Profile</h2>
						<p class="patient__details--box patient__age--label">Age</p>
						<p class="patient__details--box patient__age--number">70</p>
						<p class="patient__details--box patient__gender--label">Gender</p>
						<p class="patient__details--box patient__gender--gender">Female</p>
						<p class="patient__details--box patient__dob--label">Date of Birth</p>
						<p class="patient__details--box patient__dob--date">11/11/1951</p>
						<p class="patient__details--box patient__weight--label">Weight</p>
						<p class="patient__details--box patient__weight--number">60kg</p>
					</div>
				</div>
			</section>
			<!-- Medications -->
			<section id="medications">
				<div class="section__heading">
					<h2 class="subheading">Medications</h2>
					<p class="section__heading--edit">Edit</p>
				</div>
				<div class="section__container">
					<div class="section__table">
						<div class="section__table--heading-1">
							<p class="section__table--heading">Medication Name</p>
						</div>
						<div class="section__table--heading-2">
							<p class="section__table--heading">Dosage</p>	
						</div>
						<div class="section__table--heading-3">
							<p class="section__table--heading">Route</p>
						</div>
					</div>
				</div>
			</section>
			<!-- Diet Regime -->
			<section id="diet-regime">
				<div class="section__heading">
					<h2 class="subheading">Diet Regime</h2>
					<p class="section__heading--edit">Edit</p>
				</div>
				<div class="section__container">
					<div class="section__table">
						<div class="section__table--heading-1">
							<p class="section__table--heading">Diet Regime</p>
						</div>
						<div class="section__table--heading-2">
							<p class="section__table--heading">Description</p>	
						</div>
						<div class="section__table--heading-3">
							<p class="section__table--heading">Exercise Recommendations</p>
						</div>
					</div>
				</div>
			</section>
			<!-- Meal Plan -->
			<section id="meal-plan">
				<div class="section__heading">
					<h2 class="subheading">Meal</h2>
					<p class="section__heading--edit">Edit</p>
				</div>
				<div class="section__container">
					<div class="section__table">
					Eggs and toast
					</div>
				</div>
			</section>
		</div>
		<!-- JavaScript to change PHP template -->
		<script type="text/javascript">
			document.getElementById("dashboard").classList.add("sidenav__link--anchor-primary");
			document.getElementById("heading").innerText = "Medication and Diet Regime";
			document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
		</script>
</body>

</html>