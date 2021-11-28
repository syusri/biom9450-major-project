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
		include 'results_helper.php';
	?>
	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Medication and Diet Regime</span></p>
		</div>

		<!-- Actual form -->
		<div class="form__container--mini">
			<form class="" method="POST">
				<!-- Date -->
					<label for="date" type="date">Date</label>
					<input name="inputDate" type="date" value="<?php echo $_SESSION["inputDate"] ?>"  min="2021-11-22" max="2021-12-05" class="input__container--small">
				<!-- Dropdown List of Time of Day -->
					<label for="time">Time of Day</label>
					<select name="dropdown--time" id="dropdown--time" class="input__container--small">
						<option id="Morning" value="Morning">Morning</option>
						<option id="Afternoon" value="Afternoon">Afternoon</option>
						<option id="Evening" value="Evening">Evening</option>
					</select>
				<!-- Dropdown List of Patients -->
					<label for="patient">Patient</label>
					<select name="dropdown--patients" id="dropdown--patients" class="input__container--small">
						<!-- Obtain list of patients from database -->
						<?php 
							// getPatientList(); 
							// $conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
							$sql = "SELECT * FROM Patient";
							$rs = odbc_exec($conn,$sql);
							while ($row = odbc_fetch_array($rs)) {
								$name = $row["FirstName"]." ".$row["LastName"];
								// if ($name == $_SESSION["patient"]) {
								// 	echo "<option value='$name' selected>$name</option>";
								// } else {
									echo "<option value='$name'>$name</option>";
								// }
							}
						?>
					</select>
					<input type="submit" value="Go" class="form__submit input__container--small" name="page_submit">
			</form>
		</div>

		<!-- Bring information to results.php with PHP after form submission -->
		<?php
			if (isset($_POST["page_submit"])) {
				$_SESSION["inputDate"] = $_POST["inputDate"]; 
				$_SESSION["time"] = $_POST["dropdown--time"];
				$_SESSION["patient"] = $_POST["dropdown--patients"];
			}
		?>

		<!-- Summary of what the user just input -->
		<?php
			// echo "<p>Date: ", $_SESSION['inputDate'], "</p>";
			// echo "<p>Time of Day: ", $_SESSION["time"], "</p>";
			// echo "<p>Patient: ", $_SESSION["patient"], "</p>";
			echo "<br><h2>Showing result for: ", $_SESSION["patient"], ", ", $_SESSION["time"], ", ", $_SESSION['inputDate'], "</h2>"
		?>

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
							<?php echo $_SESSION["patient"];?>
						</h2>
						<p class="patient__highlight--box patient__room--label">Room Number</p>
						<p class="patient__highlight--box patient__room--number"><?php echo $room;?></p>
						<p class="patient__highlight--box patient__prac--label">Practitioner</p>
						<p class="patient__highlight--box patient__prac--name">
							<?php getPrac(); ?>
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
		<!-- Medications -->
		<section id="medications">
			<div class="section__heading">
				<h2 class="subheading">Medications</h2>
				<p class="section__heading--edit">Edit</p>
			</div>
			<div class="section__container">
				<div class="med__table">
					<div class="section__table--heading"><p>Time of Day</p></div>
					<div class="section__table--heading"><p>Medication Name</p></div>
					<div class="section__table--heading"><p>Dosage</p></div>
					<div class="section__table--heading"><p>Route</p></div>
					<div class="section__table--heading"><p>Instructions</p></div>
					<div class="section__table--heading"><p>Packed?</p></div>
					<div class="section__table--heading"><p>Status</p></div>
					<?php getPatientMeds($_SESSION["time"]); ?>
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
				<p class="section__heading--edit">Edit</p>
			</div>
			<div class="section__container">
				<div class="meal__table">
					<?php getMeal(); ?>
				</div>
			</div>
		</section>
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