<?php
	session_start();

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
		echo "Dr. ", $practitioner;
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
	
	// Get patient medication details
	function getPatientMeds($timee) {
		$conn = odbc_connect('z5205391','','',SQL_CUR_USE_ODBC);
		$time=$_SESSION["time"];
		$date = $_SESSION['inputDate'];
		$patientID = $_SESSION[$_SESSION["patient"]];
		$sql3 = 
		"SELECT m.MedicationName, pm.TimeOfDay, m.RecommendedDosage, m.Route, m.InstructionsForUse, pa.FirstName, pm.Date, pm.MedicationPacked, pm.StatusOfMedication
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
			$timeOfDay = $row["TimeOfDay"];
			$medName = $row["MedicationName"];
			$dosage = $row["RecommendedDosage"];
			$route = $row["Route"];
			$instructions = $row["InstructionsForUse"];
			$medPacked = $row["MedicationPacked"] == 1 ? "Yes" : "No";
			$medStatus = $row["StatusOfMedication"];

			echo "<div><p>$time</p></div>";
			echo "<div><p>$medName</p></div>";
			echo "<div><p>$dosage</p></div>";
			echo "<div><p>$route</p></div>";
			echo "<div><p>$instructions</p></div>";
			echo "<div><p>$medPacked</p></div>";
			echo "<div><p>$medStatus</p></div>";
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
		"SELECT m.Meal
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
			$meal = $row["Meal"];
			echo "<div><p>$meal</p></div>";
		} 
	}

?>