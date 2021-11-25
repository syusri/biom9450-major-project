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
	$sql2 = 
	"SELECT pr.PractitionerID, pr.FirstName, pr.LastName 
	FROM Practitioner p
	INNER JOIN Patient pa
	ON p.PractitionerID = pa.PractitionerID 
	WHERE pa.PatientID={$patientID}
	";
	$sql2 = "SELECT * FROM Practitioner";
	$rs2 = odbc_exec($conn,$sql2);
	while ($row = odbc_fetch_array($rs2)){
		$patients_prac = $row["FirstName"]." ".$row["LastName"];
	} 

?>