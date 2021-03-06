<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AgedCare</title>
	<link rel="stylesheet" href="css/styles.css">
	<!-- <script src="js/results.js"></script> -->
</head>

<body>
	<?php
		include_once 'index.html';
		include 'results_helper.php';
		if(!isset($_SESSION["session_practitioner"])) { header("Location:login.php");}
	?>
	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Medication and Diet Regime</span></p>
		</div>

		<!-- Summary of what the user just input -->
		<br>
		<div class="result__container">
			<h2>
			<?php
				echo "Showing result for: ", $_SESSION["patient"], ", ", $_SESSION["time"], ", ", date_create($_SESSION['inputDate'])->format('d-m-Y'), "</h2>"
			?>
			</h2>
		</div>

		<!-- Patient Summary -->
		<section id="patient">
			<h2>Patient Summary</h2>
			<div class="section__container">
				<div class="patient__container--highlight">
					<div class="patient__highlight">
						<figure class="patient__highlight--box patient__picture--mask">
							<?php 
								$patientImg = "<img src=\"./images/PA00".$patientID.".jpg\" class=\"patient__picture\" alt=\"Picture of patient\">";
								$patientImgGeneric = "<img src=\"./images/default.jpg\" class=\"patient__picture\" alt=\"Picture of patient\">";
								($patientID < 10) ? $img = $patientImg : $img = $patientImgGeneric;
								echo $img;
                            ?>
						</figure>
						<h2 class="patient__highlight--box patient__name">
							<?php echo $_SESSION["patient"];?>
						</h2>
						<p class="patient__highlight--box patient__room--label">Room Number</p>
						<p class="patient__highlight--box patient__room--number"><?php echo $room;?></p>
						<p class="patient__highlight--box patient__prac--label">Practitioner</p>
						<p class="patient__highlight--box patient__prac--name">
							<?php echo "Dr. ", getPrac(); ?>
						</p>
					</div>
				</div>
				<div class="patient__details">
					<h2 class="patient__details--box patient__profile">Profile</h2>
					<p class="patient__details--box patient__age--label">Age</p>
					<p class="patient__details--box patient__age--number"><?php echo $age;?></p>
					<p class="patient__details--box patient__gender--label">Gender</p>
					<p class="patient__details--box patient__gender--gender"><?php echo $gender;?></p>
					<p class="patient__details--box patient__dob--label">Date of Birth</p>
					<p class="patient__details--box patient__dob--date"><?php echo $dob;?></p>
					<p class="patient__details--box patient__weight--label">Weight</p>
					<p class="patient__details--box patient__weight--number"><?php echo $weight;?>kg</p>
				</div>
			</div>
		</section>
		<form class='' method='POST'>
		<!-- Medications -->
		<section id="medications">
			<div class="section__heading">
				<h2 class="subheading">Medications</h2>
			</div>
			<!-- <form class='' method='POST'> -->
				<div class="section__container">
					<div class="med__table">
						<!-- <div class="section__table--heading"><p>Time of Day</p></div> -->
						<div class="section__table--heading"><p>Medication Name</p></div>
						<div class="section__table--heading"><p>Dosage</p></div>
						<div class="section__table--heading"><p>Route</p></div>
						<div class="section__table--heading"><p>Instructions</p></div>
						<div class="section__table--heading"><p>Packed?</p></div>
						<div class="section__table--heading"><p>Status</p></div>
						<?php getPatientMeds(); ?>
					</div>
				</div> 
				<!-- <input type='submit' value='Save' class='form__submit input__container--small' name='med_submit'> -->
			<!-- </form> -->
			<?php 
			// submitMeds(getMedIDs());
			?>
		</section>
		<!-- Diet Regime -->
		<section id="diet-regime">
			<div class="section__heading">
				<h2 class="subheading">Diet Regime</h2>
			</div>
			<div class="section__container">
				<div class="diet__table">
					<div class="section__table--heading"><p>Diet Regime</p></div>
					<div class="section__table--heading"><p>Description</p>	</div>
					<div class="section__table--heading"><p>Exercise Recommendations</p></div>
					<?php getDietRegime(); ?>
				</div>
			</div>
		</section>
		<!-- Meal Plan -->
		<section id="meal-plan">
			<div class="section__heading">
				<h2 class="subheading">Meal</h2>
			</div>
			<!-- <form class='mealForm' method='POST'  onsubmit='displayMeal()'> -->
				<div class="section__container" id='mealForm'>
					<div class="meal__table">
						<div class="section__table--heading"><p>Meal</p></div>
						<div class="section__table--heading"><p>Packed?</p></div>
						<?php getMeal(); ?>
					</div>
				</div>
				<!-- <input type='submit' value='Save' class='form__submit input__container--small' name='meal_submit'> -->
				<!-- Bring information to results.php with PHP after form submission -->
			</section>
			<input type='submit' value='Save' class='form__submit input__container--small' name='everything_submit'>
		</form>
		<?php
			// submitMeal(getMealID());
			submitEverything('everything_submit');
		?>

	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("dashboard").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Medication and Diet Regime";
		document.getElementById("practitioner").innerText = "Dr. <?php echo $_SESSION["session_practitioner_name"];?> ";
		document.getElementById("<?php echo $_SESSION["time"];?>").setAttribute("selected", "");
		document.getElementById("<?php echo $_SESSION["patient"];?>").setAttribute("selected", "");
	</script>
</body>

</html>