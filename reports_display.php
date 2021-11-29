<!DOCTYPE html>
<html>
<head>
	<title>Display Report</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_sheet_new.css">
	<script src=""></script>
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
				<p><a href="reports_generate.php" class="page--previous">Generate Report</a> > <span class="page--current">Display Report</span></p>
		</div>
		<?php 
			$conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);

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
		<?php 
			//connect to database
			$conn = odbc_connect('z5254640', '', '', SQL_CUR_USE_ODBC);
			if ($conn->connect_error) {
				echo "$conn->connect_error";
				die("Connection Failed\n");
			}

			//sql to determine how many patient there are
			$SQL_count = "SELECT Count(FirstName) AS P_COUNT FROM Patient";
			$rs = odbc_exec($conn, $SQL_count);
			if(!$rs) {
				exit("Error in SQL"); 
			}
			//save each patient's value
			$counter = "1";
			$patient_count = odbc_result($rs, "P_COUNT");
			//we don't have a 0th patient so always set to 0
			$p[0] = 0;

			//loop through all patients and add to list
			while ($counter <= $patient_count) {
				$temp = $_POST["$counter"];
				//set 'on' to 1 and 'off' to 0
				if ($temp == "on") {
					$temp = 1;
				} else {
					$temp = 0;
				}
				//add value to p array
				$p[$counter] = $temp;
				$counter += 1; 
			}
			//get values for all other checkboxes
			$Medication = $_POST["Medication"];
			if ($Medication == "on") {
				$Medication = 1;
			} else {
				$Medication = 0;
			}
			$Diet = $_POST["Diet"];
			if ($Diet == "on") {
				$Diet = 1;
			} else {
				$Diet = 0;
			}
			$This = $_POST["This"];
			if ($This == "on") {
				$This = 1;
			} else {
				$This = 0;
			}
			$Last = $_POST["Last"];
			if ($Last == "on") {
				$Last = 1;
			} else {
				$Last = 0;
			}
			
			odbc_close($conn);
		?>
		<!-- Print all patients which have been ticked, separated by practitioner -->
		<?php 
			//connect to database
			$conn = odbc_connect('z5254640', '', '', SQL_CUR_USE_ODBC);
			if ($conn->connect_error) {
				echo "$conn->connect_error";
				die("Connection Failed\n");
			}
			//first we want to get the list of patients
			//sql to determine patient names
			$SQL_patient = "SELECT Patient.PatientID, Patient.FirstName, Patient.LastName, Patient.DietRegimeID,
			Practitioner.FirstName AS PR_First, Practitioner.LastName AS PR_Last
			FROM Patient
			INNER JOIN Practitioner ON Patient.PractitionerID = Practitioner.PractitionerID
			ORDER BY Patient.PractitionerID, Patient.PatientID";
			$aa = odbc_exec($conn, $SQL_patient);
			if(!$aa) {
				exit("Error in SQL_patient"); 
			}
			while (odbc_fetch_row($aa)) {
				$first = odbc_result($aa,"FirstName");
				$last = odbc_result($aa, "LastName");
				$patient_id = odbc_result($aa, "PatientID");
				$meal_id = odbc_result($aa, "DietRegimeID");
				$dr_first = odbc_result($aa, "PR_First");
				$dr_last = odbc_result($aa, "PR_Last");
				$dr_full = ($dr_first . ' ' . $dr_last);
				//check if each patient was ticked or not
				if ($p["$patient_id"] == "1") { //on
					echo "<div class='patient__container--highlight'>";
						echo "<div class='patient__highlight'>";
							//insert image of patient
							echo "<figure class='patient__highlight--box patient__picture--mask'>";
								echo "<img src='images/PA00$patient_id.jpg' class='patient__picture' alt='Picture of patient'>";
							echo "</figure>";
							//header for patient name
							echo "<h2 class='patient__highlight--box patient__name'>$first $last</h2>";
							//patient id
							echo "<p class='patient__highlight--box patient__number--label'>Patient ID</p>";
							echo "<p class='patient__highlight--box patient__number--number'>PA00$patient_id</p>";
							//practitioner name
							echo "<p class='patient__highlight--box patient__number--label'><br><br>Practitioner</p>";
							echo "<p class='patient__highlight--box patient__number--number'><br><br>Dr. $dr_full</p>";
						echo "</div>";
					echo "</div>";
					$check = new DateTime('2021-11-28');
					if ($Diet == 1) { //on
						$i = 1;
						echo "<h2>Diet</h2>";
						//get diet information
						if ($Last == 1) { //last week information
							echo "<div class='section__container--report'>";
								echo "<div class='report'>";
								echo "<h2>Last Week (22/11/2021-28/11/2021)</h2>";
								echo "<table class='specific_patient_med_table' style='text-align:left'>";
									//customise column widths
									echo "<col style='width:5%'>";
									echo "<col style='width:15%'>";
									echo "<col style='width:15%'>";
									echo "<col style='width:15%'>";
									echo "<tr><th>Date</th><th>Breakfast</th><th>Lunch</th><th>Dinner</th></tr>";
									//sql query to get last week's diet information
									$SQL_meals_last = "SELECT Meal, DateOfMeal FROM Meal
									WHERE DietRegimeID=$meal_id";
									$ls = odbc_exec($conn, $SQL_meals_last);
									if(!$ls) {
										exit("Error in SQL_meals_last"); 
									}
									while (odbc_fetch_row($ls)) {
										$Meal = odbc_result($ls,"Meal");
										$date = odbc_result($ls, "DateOfMeal");
										$today = new DateTime($date);
										//check if date is before 28/11/2021
										if ($today <= $check) {
											if ($i == 1) {
												echo "<tr><td>";
												//print day
												echo $today->format('d/m/Y');
												echo "</td>";
											} elseif ($i == 4) {
												echo "</tr>";
												$i = 0;
											}
											//print meal
											echo "<td>$Meal</td>";
										}
										if ($i == 3) {
											$i = 0;
										}
										$i += 1;
									}
									
								echo "</table>";
								echo "</div>";
							echo "</div>";
							echo "<br>";
						}
						if ($This == 1) { //upcoming week information
							$i = "1";
							echo "<div class='section__container--report'>";
								echo "<h2>This Week (29/11/2021-05/12/2021)</h2>";
								echo "<table class='specific_patient_med_table' style='text-align:left'>";
									echo "<col style='width:5%'>";
									echo "<col style='width:15%'>";
									echo "<col style='width:15%'>";
									echo "<col style='width:15%'>";
									echo "<tr><th>Date</th><th>Breakfast</th><th>Lunch</th><th>Dinner</th></tr>";
									//sql query to get last week's diet information
									$SQL_meals_this = "SELECT Meal, DateOfMeal FROM Meal
									WHERE DietRegimeID=$meal_id";
									$ts = odbc_exec($conn, $SQL_meals_this);
									if(!$ts) {
										exit("Error in SQL_meals_this"); 
									}
									$j = 1;
									while (odbc_fetch_row($ts)) {
										$Meal = odbc_result($ts,"Meal");
										$date = odbc_result($ts, "DateOfMeal");
										$today = new DateTime($date);
										$checks = new DateTime('2021-11-28');
										
										if ($today > $checks) {
											//print the date and meals for that day
											if ($j == 1) {
												echo "<tr><td>";				
												echo $today->format('d/m/Y');
												echo "</td>";
											} elseif ($j == 4) {
												echo "</tr>";
												$j = 0;
											}
											echo "<td>$Meal</td>";
										}
										if ($j == 3) {
											$j = 0;
										}
										$j += 1;
									}	
								echo "</table>";
							echo "</div>";
							echo "<br>";
						}
						
					}
					if ("$Medication" == 1) { //print patient medications information if this box is ticked
						echo "<h2>Medications</h2>";
						if ($Last == 1) {
							echo "<div class='section__container--report'>";
								echo "<h2>Last Week (22/11/2021-28/11/2021)</h2>";
								
								$SQL_medication = "SELECT Medications.MedicationName, PatientMedications.Date, PatientMedications.TimeOfDay, 
								PatientMedications.MedicationPacked, PatientMedications.StatusOfMedication
								FROM PatientMedications 
								INNER JOIN Medications ON PatientMedications.MedicationID=Medications.MedicationID
								WHERE PatientID=$patient_id";
								$med = odbc_exec($conn, $SQL_medication);
								if(!$med) {
									exit("Error in SQL_patient"); 
								}
								$cur_date = New DateTime('2021-11-21');
								while (odbc_fetch_row($med)) {
									$Med_Name = odbc_result($med, "MedicationName");
									$Date = odbc_result($med, "Date");
									//new date
									$Date = new DateTime($Date);

									$Time = odbc_result($med,"TimeOfDay");
									$Packed = odbc_result($med,"MedicationPacked");
									$Status = odbc_result($med,"StatusOfMedication");
									//check date and print only last week
									if ($Date <= $check) {
										if ($Date == $cur_date) {
												//print information
												echo "<tr><td>$Med_Name</td>";
												//set times
												if ($Time == "Morning") {
													$Time = "9:00am";
												} elseif ($Time == "Afternoon") {
													$Time = "1:00pm";
												} elseif ($Time == "Evening") {
													$Time = "6:00pm";
												} else {
													$Time = "As required";
												}
												echo "<td>$Time</td>";
												//checkbox for packed
												if ($Packed == 1) {
													echo "<td>Yes</td>";
												} else {
													echo "<td>No</td>";
												}
												echo "<td>$Status</td></tr>";
												$cur_date = $Date;
										} else {
											//close previous day's table
											echo "</table>";
											echo "<br><br>";
											//print new date
											echo "<h4>";
											echo $Date->format('d/m/Y');
											echo "</h4>";
											//open new table
											echo "<table class='specific_patient_med_table' style='text-align:left'>";
												//customise column widths
												echo "<col style='width:15%'>";
												echo "<col style='width:15%'>";
												echo "<col style='width:5%'>";
												echo "<col style='width:15%'>";
												echo "<tr><th>Medication Name</th><th>Time</th><th>Packed</th><th>Status</th></tr>";		
											
											//print information
											echo "<tr><td>$Med_Name</td>";
											//set times
											if ($Time == "Morning") {
												$Time = "9:00am";
											} elseif ($Time == "Afternoon") {
												$Time = "1:00pm";
											} elseif ($Time == "Evening") {
												$Time = "6:00pm";
											} else {
												$Time = "As required";
											}
											echo "<td>$Time</td>";
											//checkbox for packed
											if ($Packed == 1) {
												echo "<td>Yes</td>";
											} else {
												echo "<td>No</td>";
											}
											//make status red if "missed"
											if ($Status == "Missed") {
												echo "<td>$Status</td></tr>";
											} else {
												echo "<td>$Status</td></tr>";
											}
											$cur_date = $Date;
										}
									}
								}
							echo "</table>";
							echo "</p>";
							echo "</div>";
							echo "<br>";
							
						}
						if ($This == 1) {
							echo "<div class='section__container--report'>";
								echo "<h2>This Week (29/11/2021-05/12/2021)</h2>";
								
								//first we want to get the list of patients
								//sql to determine patient names
								$SQL_medication = "SELECT Medications.MedicationName, PatientMedications.Date, PatientMedications.TimeOfDay, 
								PatientMedications.MedicationPacked, PatientMedications.StatusOfMedication
								FROM PatientMedications 
								INNER JOIN Medications ON PatientMedications.MedicationID=Medications.MedicationID
								WHERE PatientID=$patient_id";
								$med = odbc_exec($conn, $SQL_medication);
								if(!$med) {
									exit("Error in SQL_patient"); 
								}
								while (odbc_fetch_row($med)) {
									$Med_Name = odbc_result($med, "MedicationName");
									$Date = odbc_result($med, "Date");
									//new date
									$Date = new DateTime($Date);

									$Time = odbc_result($med,"TimeOfDay");
									$Packed = odbc_result($med,"MedicationPacked");
									$Status = odbc_result($med,"StatusOfMedication");
									//check date and print only last week
									if ($Date > $check) {
										if ($Date == $cur_date) {
												//print information
												echo "<tr><td>$Med_Name</td>";
												//set times
												if ($Time == "Morning") {
													$Time = "9:00am";
												} elseif ($Time == "Afternoon") {
													$Time = "1:00pm";
												} elseif ($Time == "Evening") {
													$Time = "6:00pm";
												} else {
													$Time = "As required";
												}
												echo "<td>$Time</td>";
												//checkbox for packed
												if ($Packed == 1) {
													echo "<td>Yes</td>";
												} else {
													echo "<td>No</td>";
												}
												echo "<td>$Status</td></tr>";
												$cur_date = $Date;
										} else {
											//close previous day's table
											echo "</table>";
											echo "<br><br>";
											//print new date
											echo "<h4>";
											echo $Date->format('d/m/Y');
											echo "</h4>";
											//open new table
											echo "<table class='specific_patient_med_table' style='text-align:left'>";
												//customise column widths
												echo "<col style='width:15%'>";
												echo "<col style='width:15%'>";
												echo "<col style='width:5%'>";
												echo "<col style='width:15%'>";
												echo "<tr><th>Medication Name</th><th>Time</th><th>Packed</th><th>Status</th></tr>";		
											$cur_date = $Date;
											//print information
											echo "<tr><td>$Med_Name</td>";
											//set times
											if ($Time == "Morning") {
												$Time = "9:00am";
											} elseif ($Time == "Afternoon") {
												$Time = "1:00pm";
											} elseif ($Time == "Evening") {
												$Time = "6:00pm";
											} else {
												$Time = "As required";
											}
											echo "<td>$Time</td>";
											//checkbox for packed
											if ($Packed == 1) {
												echo "<td>Yes</td>";
											} else {
												echo "<td>No</td>";
											}
											//make status red if "missed"
											if ($Status == "Missed") {
												echo "<td>$Status</td></tr>";
											} else {
												echo "<td>$Status</td></tr>";
											}
											
										}
									}
								}
							echo "</table>";
							echo "</div>";
							echo "<br>";
							
						}

					}
				}
			}
		?>
	</div>	
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("reports").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Generate Report";
		// Change this PR Name to the PR that is logged in 
		document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
	</script>
</body>

</html> 