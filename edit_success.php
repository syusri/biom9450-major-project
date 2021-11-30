<!DOCTYPE html>
<html>
<!-- FIX THIS PAGE-->
<head>
	<title>Edit Patient</title>
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
			<p><a href="edit_patient.php" class="page--previous">Edit Patient</a> ><span class="page--current">Updated Patient</span></p>
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
                //get patient id
                $patient_id = $_POST['patient_id'];
                //sql statement to see if anything has changed
                $sql_patient = "SELECT * FROM Patient WHERE PatientID={$patient_id}";
                $rs = odbc_exec($conn, $sql_patient);
                if (!$rs) {
                    exit ("Error in SQL patient");
                }
                while (odbc_fetch_row($rs)) {
                    $first_data = odbc_result($rs,"FirstName");
                    $last_data = odbc_result($rs,"LastName");
                    $gender_data = odbc_result($rs,"Gender");
                    $room_data = odbc_result($rs,"RoomNumber");
                    $dr_id = odbc_result($rs,"PractitionerID");
                    $contact_data = odbc_result($rs,"ContactID");
                    $dob_data = odbc_result($rs,"DOB");
                    $dob_data = new DateTime($dob_data);
                    $weight_data = odbc_result($rs,"Weight");
                    $diet_id_data = odbc_result($rs,"DietRegimeID");
                    $medicare_data = odbc_result($rs,"MedicareID");
                    $notes_data = odbc_result($rs,"Notes");
                }
                $sql_diet = "SELECT DietName FROM DietRegime WHERE DietRegimeID=$diet_id_data";
                $ds = odbc_exec($conn, $sql_diet);
                if (!$ds) {
                    exit ("Error in SQL diet");
                }
                odbc_fetch_row($ds);
                $diet_name_data = odbc_result($ds, "DietName");

                $sql_CONTACT = "SELECT * FROM EmergencyContact WHERE ContactID=$contact_data";
                $rs = odbc_exec($conn, $sql_CONTACT);
                if(!$rs) {
                    exit("Error in SQL"); 
                }
                while (odbc_fetch_row($rs)) {
                    $first_contact_data = odbc_result($rs,"FirstName");
                    $last_contact_data = odbc_result($rs,"LastName");
                    $phone_contact_data = odbc_result($rs,"PhoneNumber");
                    $email_contact_data = odbc_result($rs,"Email");
                    $relationship_contact_data = odbc_result($rs,"Relationship");
                }

                $sql_MEDICARE = "SELECT * FROM Medicare WHERE MedicareID=$medicare_data";
                $rs = odbc_exec($conn, $sql_MEDICARE);
                if (!$rs) {
                    exit ("Error in SQL");
                }
                while (odbc_fetch_row($rs)) {
                    $medicare_number_data = odbc_result($rs, "MedicareNumber");
                    $medicare_reference_data = odbc_result($rs, "MedicareReference");
                    $medicare_expiry_data = odbc_result($rs, "Expiry");
                    //$medicare_expiry_data = new DateTime($medicare_expiry_data);
                }
				
				//patient information
                if (isset($_POST['firstName'])) {
                    $firstName = $_POST['firstName'];
                    //check if firstName is changed
                    if (strcmp($firstName, $first_data) != 0) { //update
                        $sql_update = "UPDATE Patient SET FirstName='$firstName' WHERE PatientID={$patient_id}";

                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update first"); 
                        }
                        //verify
                        $sql_check = "SELECT FirstName FROM Patient WHERE PatientID={$patient_id}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $First_check = odbc_result($rs, "FirstName");
                            echo "First name has been changed to: $First_check<br>";
                        }
                    }
                }
                
                if (isset($_POST['lastName'])) {
                    $lastName = $_POST['lastName'];
                    //check if lastName is changed
                    if (strcmp($lastName, $last_data) != 0) { //update
                        $sql_update = "UPDATE Patient SET LastName='$lastName' WHERE PatientID={$patient_id}";

                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update last"); 
                        }
                        //verify
                        $sql_check = "SELECT LastName FROM Patient WHERE PatientID={$patient_id}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $Last_check = odbc_result($rs, "LastName");
                            echo "Last name has been changed to: $Last_check<br>";
                        }
                    }
                }
                
                if (isset($_POST['room_number'])) {
                    $room_number = $_POST['room_number'];
                    if ($room_number != $room_data) { //update
                        $sql_update = "UPDATE Patient SET RoomNumber={$room_number} WHERE PatientID={$patient_id}";

                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update room"); 
                        }
                        //verify
                        $sql_check = "SELECT RoomNumber FROM Patient WHERE PatientID={$patient_id}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $Room_check = odbc_result($rs, "RoomNumber");
                            echo "Room has been changed to: $Room_check<br>";
                        }
                    }
                }
                              
                if (isset($_POST['weight'])) {
                    $weight = $_POST['weight'];
                    if ($weight != $weight_data) { //update
                        $sql_update = "UPDATE Patient SET Weight={$weight} WHERE PatientID={$patient_id}";

                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update weight"); 
                        }
                        //verify
                        $sql_check = "SELECT Weight FROM Patient WHERE PatientID={$patient_id}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $Weight_check = odbc_result($rs, "Weight");
                            echo "Weight has been changed to: $Weight_check kg<br>";
                        }
                    }
                }
                
                if (isset($_POST['diet'])) {
                    $diet = $_POST['diet'];
                    //get dietregime id 
                    $sql_get_id = "SELECT DietRegimeID FROM DietRegime WHERE DietName='$diet'";
                    $rs = odbc_exec($conn, $sql_get_id);
                    odbc_fetch_row($rs);
                    $new_diet_id = odbc_result($rs, "DietRegimeID");
                    if(!$rs) {
                        exit("Error in SQL get diet id"); 
                    }
                    if (strcmp(strtolower($diet), strtolower($diet_name_data)) != 0) { //update
                        $sql_update = "UPDATE Patient SET DietRegimeID='00$new_diet_id' WHERE PatientID={$patient_id}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update diet"); 
                        }
                        //verify
                        $sql_check = "SELECT DietRegimeID FROM Patient WHERE PatientID={$patient_id}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $diet_id_check = odbc_result($rs, "DietRegimeID");
                            $sql_diet = "SELECT DietName FROM DietRegime WHERE DietRegimeID={$diet_id_check}";
                            $test = odbc_exec($conn, $sql_diet);
                            while (odbc_fetch_row($test)) {
                                $diet_name = odbc_result($test, "DietName");
                                echo "Diet has been changed to: $diet_name (DR00$diet_id_check)<br>";
                            }
                        }
                    }
                }
                
                if (isset($_POST['notes'])) {
                    $notes = $_POST['notes'];
                    if (strcmp($notes, $notes_data) != 0) { //update
                        $sql_update = "UPDATE Patient SET Notes='$notes' WHERE PatientID={$patient_id}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update notes"); 
                        }
                        //verify
                        //to fix: not printing update message, but still updates
                        $sql_check = "SELECT Notes FROM Patient WHERE PatientID={$patient_id}";
                        $rs = odbc_exec($conn, $sql_check);
                        if (!$rs) {
                            exit("Error in SQL check notes");
                        }
                        while (odbc_fetch_row($rs)) {
                            $Notes_check = odbc_result($rs, "Notes");
                            echo "Notes have been updated to: $Notes_check<br>";
                        }
                    }
                }
                
                if (isset($_POST['firstName_contact'])) {
                    $firstName_contact = $_POST['firstName_contact'];
                    //check if firstName_contact is changed
                    if (strcmp($first_contact_data, $firstName_contact) != 0) { //update
                        $sql_update = "UPDATE EmergencyContact SET FirstName='$firstName_contact' WHERE ContactID={$contact_data}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update first_contact"); 
                        }
                        //verify
                        $sql_check = "SELECT FirstName FROM EmergencyContact WHERE ContactID={$contact_data}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $first_check = odbc_result($rs, "FirstName");
                            echo "Emergency contact first name has been changed to: $first_check<br>";
                        }
                    }
                }
                
				if (isset($_POST['lastName_contact'])) {
                    $lastName_contact = $_POST['lastName_contact'];
                    //check if lastName_contact is changed
                    if (strcmp($last_contact_data, $lastName_contact) != 0) { //update
                        $sql_update = "UPDATE EmergencyContact SET LastName='$lastName_contact' WHERE ContactID={$contact_data}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update last_contact"); 
                        }
                        //verify
                        $sql_check = "SELECT LastName FROM EmergencyContact WHERE ContactID={$contact_data}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $last_check = odbc_result($rs, "LastName");
                            echo "Emergency contact last name has been changed to: $last_check<br>";
                        }
                    }
                }
                
				if (isset($_POST['phone'])) {
                    $phone = $_POST['phone'];
                    //check if phone is changed
                    if (strcmp($phone_contact_data, $phone) != 0) { //update
                        $sql_update = "UPDATE EmergencyContact SET PhoneNumber='$phone' WHERE ContactID={$contact_data}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update phone_contact"); 
                        }
                        //verify
                        $sql_check = "SELECT PhoneNumber FROM EmergencyContact WHERE ContactID={$contact_data}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $phone_check = odbc_result($rs, "PhoneNumber");
                            echo "Emergency contact phone number has been changed to: $phone_check<br>";
                        }
                    }
                }
                
				if (isset($_POST['email'])) {
                    $email_contact = $_POST['email'];
                    //check if email is changed
                    if (strcmp($email_contact_data, $email_contact) != 0) { //update
                        $sql_update = "UPDATE EmergencyContact SET Email='$email_contact' WHERE ContactID={$contact_data}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update email_contact"); 
                        }
                        //verify
                        $sql_check = "SELECT Email FROM EmergencyContact WHERE ContactID={$contact_data}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $email_check = odbc_result($rs, "Email");
                            echo "Emergency contact email address has been changed to: $email_check<br>";
                        }
                    }
                }
                
				if (isset($_POST['relationship'])) {
                    $relationship = $_POST['relationship'];
                    //check if relationship is changed
                    if (strcmp($relationship_contact_data, $relationship) != 0) { //update
                        $sql_update = "UPDATE EmergencyContact SET Relationship='$relationship' WHERE ContactID={$contact_data}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update relationship_contact"); 
                        }
                        //verify
                        $sql_check = "SELECT Relationship FROM EmergencyContact WHERE ContactID={$contact_data}";
                        $rs = odbc_exec($conn, $sql_check);
                        while (odbc_fetch_row($rs)) {
                            $rel_check = odbc_result($rs, "Relationship");
                            echo "Emergency contact relationship has been changed to: $rel_check<br>";
                        }
                    }
                }
				
				//medicare information
                if (isset($_POST['number'])) {
                    $number = $_POST['number'];
                    //check if phone is changed
                    if (strcmp($medicare_number_data, $number) != 0) { //update
                        $sql_update = "UPDATE Medicare SET MedicareNumber='$number' WHERE MedicareID={$medicare_data}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update medicare_num"); 
                        }
                        //verify
                        //fix not printing output
                        $sql_check = "SELECT MedicareNumber FROM Medicare WHERE MedicareID={$medicare_data} ";
                        $test = odbc_exec($conn, $sql_check);
                        if (!$test) {
                            exit ("Error in number check");
                        }
                        while (odbc_fetch_row($test)) {
                            $med_check = odbc_result($test, "MedicareNumber");
                            echo "Medicare number has been changed to: $med_check<br>";
                        }
                    }
                }
                
                if (isset($_POST['IRN'])) {
                    $IRN = $_POST['IRN'];
                    if (strcmp($medicare_reference_data, $IRN) != 0) { //update
                        $sql_update = "UPDATE Medicare SET MedicareReference='$IRN' WHERE MedicareID={$medicare_data}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update medicare_irn"); 
                        }
                        //verify
                        $sql_check = "SELECT MedicareReference FROM Medicare WHERE MedicareID={$medicare_data}";
                        $test = odbc_exec($conn, $sql_check);
                        if (!$test) {
                            exit ("Error in irn check");
                        }
                        while (odbc_fetch_row($test)) {
                            $irn_check = odbc_result($test, "MedicareReference");
                            echo "Medicare reference number has been changed to: $irn_check<br>";
                        }
                    }
                }
                
				if (isset($_POST['expiry'])) {
                    $expiry = $_POST['expiry'];
                    //edit expiry to correct format
                    $new_Date = "01/".$expiry;
                    //change format
                    $ex = "$medicare_expiry_data";
                    $ex = $medicare_expiry_data[8];
                    $ex .= $medicare_expiry_data[9];
                    $ex .= "/";
                    $ex .= $medicare_expiry_data[5];
                    $ex .= $medicare_expiry_data[6];
                    $ex .= "/";
                    $ex .= $medicare_expiry_data[0];
                    $ex .= $medicare_expiry_data[1];
                    $ex .= $medicare_expiry_data[2];
                    $ex .= $medicare_expiry_data[3];
                    
                    if (strcmp($ex, $new_Date) != 0) { //update
                        $sql_update = "UPDATE Medicare SET Expiry='$new_Date' WHERE MedicareID={$medicare_data}";
                        $update = odbc_exec($conn, $sql_update);
                        if(!$update) {
                            exit("Error in SQL update medicare_expiry"); 
                        }
                        //verify
                        $sql_check = "SELECT Expiry FROM Medicare WHERE MedicareID={$medicare_data}";
                        $test = odbc_exec($conn, $sql_check);
                        if (!$test) {
                            exit ("Error in expiry check");
                        }
                        while (odbc_fetch_row($test)) {
                            $expiry_check = odbc_result($test, "Expiry");
                            $expiry_check = new DateTime($expiry_check);
                            echo "Medicare expiry has been changed to: ";
                            echo $expiry_check->format("m/Y");
                            echo "<br>";
                        }
                    }
                }
				
			?>
		</div>
		<!-- JavaScript to change PHP template -->
	</div>
	<script type="text/javascript">
		document.getElementById("patients").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Edit Patient";
		document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
	</script>
</body>
</html>