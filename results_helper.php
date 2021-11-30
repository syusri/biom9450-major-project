<?php
	session_start();

	ob_start();
	$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
	$patientID = $_SESSION[$_SESSION["patient"]];
	
	// Get all patient details immediately available in Patient table
	$sql = "SELECT * FROM Patient WHERE PatientID={$patientID}";
	$rs = odbc_exec($conn,$sql);
	while ($row = odbc_fetch_array($rs)){
		$gender = $row["Gender"];
		$room = $row["RoomNumber"];
		$weight = $row["Weight"];
		$dob = date_create($row["DOB"]);
	} 
	
	// Formatting information for display
	($gender == 'M') ? $gender = "Male" : $gender = "Female";
	$dob = date_format($dob, 'd-m-Y');
	$age = date_diff(date_create($dob), date_create(date("d-m-Y")))->format("%y");
	
	// Get patient's practitioner
	function getPrac() {
		$patientID = $_SESSION[$_SESSION["patient"]];
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$sql2 = 
		"SELECT pr.PractitionerID, pr.FirstName, pr.LastName 
		FROM Practitioner AS pr
		INNER JOIN Patient AS pa
		ON pr.PractitionerID = pa.PractitionerID 
		WHERE pa.PatientID={$patientID}
		";
		$rs2 = odbc_exec($conn,$sql2);
		while ($row = odbc_fetch_array($rs2)){
			$practitioner = $row["FirstName"]." ".$row["LastName"];
		} 
		return $practitioner;
	}

	// Get list of patients
	function getPatientList() {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$sql = "SELECT * FROM Patient";
		$rs = odbc_exec($conn,$sql);
		while ($row = odbc_fetch_array($rs)) {
			$name = $row["FirstName"]." ".$row["LastName"];
			if ($name == $_SESSION["patient"]) {
				echo "<option value='$name' selected>$name</option>";
			} else {
				echo "<option value='$name'>$name</option>";
			}
		}
	}
	
	// Get list of medication statuses
	function getMedStatus($medStatus, $patientMedID) {
		$name = 'medStatus'.$patientMedID;
		echo "<select name='$name' id='select__med--status'>";
		switch ($medStatus) {
			case 'Given':
				echo "<option selected id='Given' value='Given'>Given</option>";
				echo "<option id='Due' value='Due'>Due</option>";
				echo "<option id='Missed' value='Missed'>Missed</option>";
				echo "<option id='Refused' value='Refused'>Refused</option>";
				echo "<option id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option id='No stock' value='No stock'>No stock</option>";
				echo "<option id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option id='Not required' value='Not required'>Not required</option>";
				break;
			case 'Due':
				echo "<option id='Given' value='Given'>Given</option>";
				echo "<option selected id='Due' value='Due'>Due</option>";
				echo "<option id='Missed' value='Missed'>Missed</option>";
				echo "<option id='Refused' value='Refused'>Refused</option>";
				echo "<option id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option id='No stock' value='No stock'>No stock</option>";
				echo "<option id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option id='Not required' value='Not required'>Not required</option>";
				break;
			case 'Missed':
				echo "<option id='Given' value='Given'>Given</option>";
				echo "<option id='Due' value='Due'>Due</option>";
				echo "<option selected id='Missed' value='Missed'>Missed</option>";
				echo "<option id='Refused' value='Refused'>Refused</option>";
				echo "<option id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option id='No stock' value='No stock'>No stock</option>";
				echo "<option id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option id='Not required' value='Not required'>Not required</option>";
				break;
			case 'Refused':
				echo "<option id='Given' value='Given'>Given</option>";
				echo "<option id='Due' value='Due'>Due</option>";
				echo "<option id='Missed' value='Missed'>Missed</option>";
				echo "<option selected id='Refused' value='Refused'>Refused</option>";
				echo "<option id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option id='No stock' value='No stock'>No stock</option>";
				echo "<option id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option id='Not required' value='Not required'>Not required</option>";
				break;
			case 'Fasting':
				echo "<option id='Given' value='Given'>Given</option>";
				echo "<option id='Due' value='Due'>Due</option>";
				echo "<option id='Missed' value='Missed'>Missed</option>";
				echo "<option id='Refused' value='Refused'>Refused</option>";
				echo "<option selected id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option id='No stock' value='No stock'>No stock</option>";
				echo "<option id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option id='Not required' value='Not required'>Not required</option>";
				break;
			case 'No stock':
				echo "<option id='Given' value='Given'>Given</option>";
				echo "<option id='Due' value='Due'>Due</option>";
				echo "<option id='Missed' value='Missed'>Missed</option>";
				echo "<option id='Refused' value='Refused'>Refused</option>";
				echo "<option id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option selected id='No stock' value='No stock'>No stock</option>";
				echo "<option id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option id='Not required' value='Not required'>Not required</option>";
				break;
			case 'Ceased':
				echo "<option id='Given' value='Given'>Given</option>";
				echo "<option id='Due' value='Due'>Due</option>";
				echo "<option id='Missed' value='Missed'>Missed</option>";
				echo "<option id='Refused' value='Refused'>Refused</option>";
				echo "<option id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option id='No stock' value='No stock'>No stock</option>";
				echo "<option selected id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option id='Not required' value='Not required'>Not required</option>";
				break;
			case 'Not required':
				echo "<option id='Given' value='Given'>Given</option>";
				echo "<option id='Due' value='Due'>Due</option>";
				echo "<option id='Missed' value='Missed'>Missed</option>";
				echo "<option id='Refused' value='Refused'>Refused</option>";
				echo "<option id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option id='No stock' value='No stock'>No stock</option>";
				echo "<option id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option selected id='Not required' value='Not required'>Not required</option>";
				break;
			default:
				echo "<option id='Given' value='Given'>Given</option>";
				echo "<option id='Due' value='Due'>Due</option>";
				echo "<option id='Missed' value='Missed'>Missed</option>";
				echo "<option id='Refused' value='Refused'>Refused</option>";
				echo "<option id='Fasting' value='Fasting'>Fasting</option>";
				echo "<option id='No stock' value='No stock'>No stock</option>";
				echo "<option id='Ceased' value='Ceased'>Ceased</option>";
				echo "<option id='Not required' value='Not required'>Not required</option>";
				break;
		}
		echo "</select>";
	}

	// Get patient medication details
	function getPatientMeds() {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$time=$_SESSION["time"];
		$date = $_SESSION['inputDate'];
		$patientID = $_SESSION[$_SESSION["patient"]];
		// $medIDArray = array();
		$sql3 = 
		"SELECT m.MedicationName, pm.TimeOfDay, m.RecommendedDosage, m.Route, m.InstructionsForUse,
		pa.FirstName,pm.Date, pm.MedicationPacked, pm.StatusOfMedication, pm.PatientMedID
		FROM (PatientMedications pm
		INNER JOIN Patient pa
		ON pm.PatientID = pa.PatientID) 
		INNER JOIN Medications m
		ON pm.MedicationID = m.MedicationID
		WHERE (pa.PatientID={$patientID} 
		AND pm.TimeOfDay='{$time}'
		AND pm.Date=#$date#);
		";
		$rs3 = odbc_exec($conn,$sql3);
		while ($row = odbc_fetch_array($rs3)){
			// $timeOfDay = $row["TimeOfDay"];
			$medName = $row["MedicationName"];
			$dosage = $row["RecommendedDosage"];
			$route = $row["Route"];
			$instructions = $row["InstructionsForUse"];
			// $medPacked = $row["MedicationPacked"] == 1 ? "Yes" : "No";
			// $medPacked = $row["MedicationPacked"];
			$medStatus = $row["StatusOfMedication"];
			$patientMedID = $row["PatientMedID"];
			
			// echo "<div><p>$time</p></div>";
			echo "<div><p>$medName</p></div>";
			echo "<div><p>$dosage</p></div>";
			echo "<div><p>$route</p></div>";
			echo "<div><p>$instructions</p></div>";
			// echo "<div style=checkbox--center><p><input type='checkbox' id='$patientMedID' name=$patientMedID checked=$medPacked></p></div>";
			$row["MedicationPacked"] == 1
			? $medPacked = "<div style=checkbox--center><p><input type='checkbox' id='$patientMedID' name='$patientMedID' checked></p></div>"
			: $medPacked = "<div style=checkbox--center><p><input type='checkbox' id='$patientMedID' name='$patientMedID' ></p></div>";
			echo "<div><p>$medPacked</p></div>";
			
			getMedStatus($medStatus, $patientMedID);
			// array_push($medIDArray, $row["PatientMedID"]);
			// echo "<div><p>$patientMedID</p></div>";
		} 
	}
	
	function submitMeds($medIDArray, $submit) {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$date = $_SESSION['inputDate'];
		$time=$_SESSION["time"];
		$patientID = $_SESSION[$_SESSION["patient"]];
		if (isset($_POST["$submit"])) {
			// $medPacked = $_POST['medPacked'];
			foreach($medIDArray as $medID) {
				// Update packed status
				// $checkName = $medID.".Packed";
				// echo "checkname is ", $checkName;
				(isset($_POST["$medID"])) ? $medPacked = 'TRUE': $medPacked = 'FALSE';
				echo $medID, " ";
				echo $medPacked, "\n";
				$sql_update = "UPDATE PatientMedications SET
				MedicationPacked=$medPacked
				WHERE PatientMedID={$medID}";
				$add = odbc_exec($conn, $sql_update);
				if(!$add) {
					exit("Error in SQL update medication packed status"); 
				}
				// Update medication status
				$name = 'medStatus'.$medID;
				if (isset($_POST["$name"])) {
					$medStatus = $_POST["$name"];
					echo $medStatus;
					$sql_update = "UPDATE PatientMedications SET
					StatusOfMedication='$medStatus'
					WHERE PatientMedID={$medID}";
					$add = odbc_exec($conn, $sql_update);
					if(!$add) {
						exit("Error in SQL update medication packed status"); 
					}
				}
			}
			header("Location: dashboard.php"); 
			ob_end_flush();
		}
	}

	function submitMeal($mealID, $submit) {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$date = $_SESSION['inputDate'];
		$time=$_SESSION["time"];
		$patientID = $_SESSION[$_SESSION["patient"]];
		if (isset($_POST["$submit"])) {
			
			// Update packed status
			(isset($_POST["mealPacked"])) ? $mealPacked = 'TRUE': $mealPacked = 'FALSE';
			$sql_update = "UPDATE Meal 
			SET MealPacked=$mealPacked
			WHERE MealID={$mealID}";
			$add = odbc_exec($conn, $sql_update);
			if(!$add) {
				exit("Error in SQL update - mealPacked"); 
			}
			echo $sql_update;
			$mealPacked == 'TRUE' ? $test = "yes" : $test = "no";
			echo " ", $test;
		}
	}

	// Get details for patient's meals
	function getDietRegime() {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$patientID = $_SESSION[$_SESSION["patient"]];
		$sql4 = 
		"SELECT d.* 
		FROM DietRegime d
		INNER JOIN Patient pa
		ON pa.DietRegimeID = d.DietRegimeID
		WHERE pa.PatientID={$patientID}
		";
		$rs4 = odbc_exec($conn,$sql4);
		while ($row = odbc_fetch_array($rs4)){
			$dietName = $row["DietName"];
			$desc = $row["Description"];
			$exercise = $row["Exercise"];
			$_SESSION["DietRegimeID"] = $row["DietRegimeID"];
			
			echo "<div><p>$dietName</p></div>";
			echo "<div><p>$desc</p></div>";
			echo "<div><p>$exercise</p></div>";
		} 
	}

	// Get the actual meal
	function getMeal() {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$patientID = $_SESSION[$_SESSION["patient"]];
		$dietRegimeID = $_SESSION["DietRegimeID"];
		$date = $_SESSION['inputDate'];
		$time=$_SESSION["time"];
		$sql4 = 
		"SELECT m.Meal, m.MealPacked, m.MealID
		FROM Meal m
		INNER JOIN Patient pa
		ON pa.DietRegimeID = m.DietRegimeID			
		WHERE pa.PatientID={$patientID}
		AND pa.DietRegimeID = {$dietRegimeID}
		AND DateOfMeal=#$date#
		AND TimeOfDay='$time'
		";
		$rs4 = odbc_exec($conn,$sql4);
		while ($row = odbc_fetch_array($rs4)){
			$mealID = $row["MealID"];
			$meal = $row["Meal"];
			// $mealPacked = $row["MealPacked"] == 1 ? "checked" : "";
			$mealPacked = $row["MealPacked"];

			echo "<div><p>$meal</p></div>";
			// echo "<div><p>$mealPacked</p></div>";
			$row["MealPacked"] == 1
			? $mealPacked = "<div style=checkbox--center><p><input type='checkbox' id='mealPacked' name='mealPacked' checked></p></div>"
			: $mealPacked = "<div style=checkbox--center><p><input type='checkbox' id='mealPacked' name='mealPacked' ></p></div>";
			echo $mealPacked;
		} 
	}

	// Get the meal ID
	function getMealID() {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$patientID = $_SESSION[$_SESSION["patient"]];
		$dietRegimeID = $_SESSION["DietRegimeID"];
		$date = $_SESSION['inputDate'];
		$time=$_SESSION["time"];
		$sql4 = 
		"SELECT m.MealID
		FROM Meal m
		INNER JOIN Patient pa
		ON pa.DietRegimeID = m.DietRegimeID			
		WHERE pa.PatientID={$patientID}
		AND pa.DietRegimeID = {$dietRegimeID}
		AND DateOfMeal=#$date#
		AND TimeOfDay='$time'
		";
		$rs4 = odbc_exec($conn,$sql4);
		while ($row = odbc_fetch_array($rs4)){
			$mealID = $row["MealID"];
		} 

		return $mealID;
	}

	function getMedIDs() {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$time=$_SESSION["time"];
		$date = $_SESSION['inputDate'];
		$patientID = $_SESSION[$_SESSION["patient"]];
		$medIDArray = array();
		$sql3 = 
		"SELECT m.MedicationName, pm.TimeOfDay, m.RecommendedDosage, m.Route, m.InstructionsForUse,
		pa.FirstName,pm.Date, pm.MedicationPacked, pm.StatusOfMedication, pm.PatientMedID
		FROM (PatientMedications pm
		INNER JOIN Patient pa
		ON pm.PatientID = pa.PatientID) 
		INNER JOIN Medications m
		ON pm.MedicationID = m.MedicationID
		WHERE (pa.PatientID={$patientID} 
		AND pm.TimeOfDay='{$time}'
		AND pm.Date=#$date#);
		";
		$rs3 = odbc_exec($conn,$sql3);
		while ($row = odbc_fetch_array($rs3)){
			array_push($medIDArray, $row["PatientMedID"]);
		} 
		return $medIDArray;
	}

	function submitEverything($submit) {
		submitMeds(getMedIDs(), $submit);
		submitMeal(getMealID(), $submit);
	}

?>