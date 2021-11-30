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
				//patient information
				$firstName = $_POST['firstName'];
				$lastName = $_POST['lastName'];
				$gender = $_POST['gender'];
				$roomNumber = $_POST['room_number'];
				$dob = $_POST['dateofbirth'];
				$weight = $_POST['weight'];
				$diet = $_POST['diet'];
				$notes = $_POST['notes'];

				//contact information
				$firstName_contact = $_POST['firstName_contact'];
				$lastName_contact = $_POST['lastName_contact'];
				$phone = $_POST['phone'];
				$email = $_POST['email_contact'];
				$relationship = $_POST['relationship'];

				//medicare information
				$medicare = $_POST['medicare'];
				$IRN = $_POST['IRN'];
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
				//add new medicare info into Medicare table
				$sql_insert_medi = "INSERT INTO Medicare (MedicareNumber, MedicareReference, Expiry)
				VALUES ('$medicare', $IRN, '$new_Date')";
				$add = odbc_exec($conn, $sql_insert_medi);
				
				//add new contact info into EmergencyContact table
				$sql_insert_emergency = "INSERT INTO EmergencyContact (FirstName, LastName, PhoneNumber, Email, Relationship)
				VALUES ('$firstName_contact', '$lastName_contact', '$phone', '$email', '$relationship')";
				$add = odbc_exec($conn, $sql_insert_emergency);
				if(!$add) {
					exit("Error in SQL emergency"); 
				}
				//get ID for new medicare information, new contact information and dietregimeid
				//get contact id
				$sql_get_id = "SELECT ContactID FROM EmergencyContact WHERE FirstName='$firstName_contact'";
				$rs = odbc_exec($conn, $sql_get_id);
				while (odbc_fetch_row($rs)) {
					$contact_id = odbc_result($rs, "ContactID");
				}
				if(!$rs){
                    // Error checking for SQL
                    header("Location:error.php");
                }
				//get medicare id
				$sql_get_id = "SELECT MedicareID FROM Medicare WHERE MedicareNumber='$medicare'";
				$rs = odbc_exec($conn, $sql_get_id);
				odbc_fetch_row($rs);
				$medicare_id = odbc_result($rs,"MedicareID");
				if(!$rs){
                    // Error checking for SQL
                    header("Location:error.php");
                }
				//get dietregime id 
				$sql_get_id = "SELECT DietRegimeID FROM DietRegime WHERE DietName='$diet'";
				$rs = odbc_exec($conn, $sql_get_id);
				odbc_fetch_row($rs);
				$diet_id = odbc_result($rs,"DietRegimeID");
				if(!$rs){
                    // Error checking for SQL
                    header("Location:error.php");
                }
				//get ID of current practitioner
				$prac_id = $practitioner_number;
				if ($prac_id != 1 || $prac_id != 2) {
					$prac_id = 1;
				}
				if ($contact_id >= 10) {
					$contact_id = "0$contact_id";
				} else {
					$contact_id = "00$contact_id";
				} 
				if ($medicare_id >= 10) {
					$medicare_id = "0$medicare_id";
				} else {
					$medicare_id = "00$medicare_id";
				} 
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
				if ($gender == "Female") {
					$gender = "F";
				} else {
					$gender = "M";
				}
				//add new patient
				
				$sql_insert_patient = "INSERT INTO Patient (FirstName, LastName, Gender, RoomNumber, PractitionerID,
				ContactID, DOB, Image, Weight, DietRegimeID, MedicareID, Notes)
				VALUES ('$firstName', '$lastName', '$gender', '$roomNumber', '00$prac_id', '$contact_id', '$newDate', 'default', '$weight',
				'00$diet_id', '$medicare_id', '$notes')";
				$add = odbc_exec($conn, $sql_insert_patient);
				if(!$add){
                    // Error checking for SQL
                    header("Location:error.php");
                }
				
				//check it added properly
				$sql_test = "SELECT FirstName, LastName FROM Patient";
				$rs = odbc_exec($conn, $sql_test);
				while (odbc_fetch_row($rs)) {
					$First = odbc_result($rs,"FirstName");
					$Last = odbc_result($rs,"LastName");
				}
				if(!$rs) {
					exit("<h2>Error - $firstName $lastName has not been added to the database.
					<br> Please try again later.</h2>"); 
				} else {
					echo "<h2>Successful - $firstName $lastName has been added to the database.</h2>";
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