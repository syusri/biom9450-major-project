<!DOCTYPE html>
<html>

<head>
	<title>New Patient</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_sheet_new.css">
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
			<p><a href="add_patient.php" class="page--previous">Add Patient</a> ><span class="page--current">New Patient</span></p>
		</div>
		<div class="section__container--report">
			<?php 
				$conn = odbc_connect('z5254640', '', '',SQL_CUR_USE_ODBC);

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
                // Grab the patient ID from the summary page 
                if (!$_POST["submit_edit_patient_ID"]) {
                    // If this page is not directed from the search page so a patient ID has not come through it will show the page for patient PA001
                    $patient_number = "1";
                } else {
                    $patient_number = $_POST["submit_edit_patient_ID"];
                }

				//patient information
                if (isset($_POST['firstName'])) {
                    $firstName = $_POST['firstName'];
                    $sql_update = "UPDATE Patient SET
                    FirstName='$firstName'
                    WHERE PatientID='$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update first"); 
                    }
                }
                if (isset($_POST['lastName'])) {
                    $lastName = $_POST['lastName'];
                    $sql_update = "UPDATE Patient SET
                    FirstName='$lastName'
                    WHERE PatientID='$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
                if (isset($_POST['gender'])) {
                    $gender = $_POST['gender'];
                    if ($gender == "Female") {
                        $gender = "F";
                    } else {
                        $gender = "M";
                    }
                    $sql_update = "UPDATE Patient SET
                    Gender='$gender'
                    WHERE PatientID='$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
                if (isset($_POST['room_number'])) {
                    $roomNumber = $_POST['room_number'];
                    $sql_update = "UPDATE Patient SET
                    RoomNumber='$roomNumber'
                    WHERE PatientID='$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
                if (isset($_POST['dateofbirth']) {
                    $dob = $_POST['dateofbirth'];
                    //edit dob to correct format
                    $dob = "$dob";
                    $newDate = $dob[8];
                    $newDate .= $dob[9];
                    $newDate .= "/";
                    $newDate .= $dob[5];
                    $newDate .= $dob[6];
                    $newDate .= "/";
                    $newDate .= $dob[0];
                    $newDate .= $dob[1];
                    $newDate .= $dob[2];
                    $newDate .= $dob[3];
                    $sql_update = "UPDATE Patient SET
                    DOB='$newDate'
                    WHERE PatientID='$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
                if (isset($_POST['weight'])) {
                    $weight = $_POST['weight'];
                    $sql_update = "UPDATE Patient SET
                    Weight='$weight'
                    WHERE PatientID='$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
                if (isset($_POST['diet'])) {
                    $diet = $_POST['diet'];
                    //get dietregime id 
                    $sql_get_id = "SELECT DietRegimeID FROM DietRegime WHERE DietName='$diet'";
                    $rs = odbc_exec($conn, $sql_get_id);
                    odbc_fetch_row($rs);
                    $diet_id = odbc_result($rs,"DietRegimeID");
                    if(!$rs) {
                        exit("Error in SQL get diet id"); 
                    }
                    $sql_update = "UPDATE Patient SET
                    Diet='$diet'
                    WHERE PatientID='$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
                if (isset($_POST['notes'])) {
                    $notes = $_POST['notes'];
                    $sql_update = "UPDATE Patient SET
                    Notes='$Notes'
                    WHERE PatientID='$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }

                if (isset($_POST['firstName_contact'])) {
                    $firstName_contact = $_POST['firstName_contact'];
                    $sql_update = "UPDATE EmergencyContact SET
                    FirstName='$firstName_contact'
                    WHERE ContactID='00$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
				if (isset($_POST['lastName_contact'])) {
                    $firstName_contact = $_POST['lastName_contact'];
                    $sql_update = "UPDATE EmergencyContact SET
                    LastName='$lastName_contact'
                    WHERE ContactID='00$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
				if (isset($_POST['phone'])) {
                    $phone = $_POST['phone'];
                    $sql_update = "UPDATE EmergencyContact SET
                    PhoneNumber='$phone'
                    WHERE ContactID='00$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
				if (isset($_POST['email'])) {
                    $firstName_contact = $_POST['email'];
                    $sql_update = "UPDATE EmergencyContact SET
                    Email='$email'
                    WHERE ContactID='00$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
				if (isset($_POST['relationship'])) {
                    $relationship = $_POST['relationship'];
                    $sql_update = "UPDATE EmergencyContact SET
                    Relationship='$relationship'
                    WHERE ContactID='00$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
				
				//medicare information
                if (isset($_POST['number'])) {
                    $number = $_POST['number'];
                    $sql_update = "UPDATE EmergencyContact SET
                    MedicareNumber='$number'
                    WHERE MedicareID='00$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
                if (isset($_POST['IRN'])) {
                    $IRN = $_POST['IRN'];
                    $sql_update = "UPDATE EmergencyContact SET
                    MedicareReference='$IRN'
                    WHERE MedicareID='00$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
				if (isset($_POST['relationship'])) {
                    $expiry = $_POST['expiry'];
                    //edit expiry to correct format
                    $expiry = "$expiry";
                    $new_Date = $expiry[8];
                    $new_Date .= $expiry[9];
                    $new_Date .= "/";
                    $new_Date .= $expiry[5];
                    $new_Date .= $expiry[6];
                    $new_Date .= "/";
                    $new_Date .= $expiry[0];
                    $new_Date .= $expiry[1];
                    $new_Date .= $expiry[2];
                    $new_Date .= $expiry[3];
                    $sql_update = "UPDATE EmergencyContact SET
                    Expiry='$new_Date'
                    WHERE MedicareID='00$patient_number'";
                    $add = odbc_exec($conn, $sql_update);
                    if(!$add) {
                        exit("Error in SQL update last"); 
                    }
                }
				
			?>
		</div>
		<!-- JavaScript to change PHP template -->
	</div>
	<script type="text/javascript">
		document.getElementById("patients").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Add Patient";
		document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
	</script>
</body>
</html>