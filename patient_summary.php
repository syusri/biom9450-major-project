<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Patient Summary</title>
	<link rel="stylesheet" href="css/style_sheet_new.css">
	<!-- <script src="js/main.js"></script> -->
</head>

<body>
	<?php
        // reference index2.html for styling, nav and logout features
		include 'index2.html';
        
        //Grab information of the practitioner ID and name for the session
        session_start();
        // If no session practitioner has been set, then the website will direct to the login page as a secure login feature
        if(! isset($_SESSION["session_practitioner"])) {
            header("Location:login.php");
        }
        
        // Grabbing the session details
        $practitioner_number = $_SESSION["session_practitioner"];
		$practitioner_name = $_SESSION["session_practitioner_name"];
	?>
		<div class="main">
			<!-- Breadcrumb -->
			<div class="breadcrumb">
					<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Patient Summary</span></p>
			</div>
            <?php
                //Connecting to the database 
                $conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);

                //Used to check the connection to the database was successful, direct to error page if issue                            
                if(!$conn){
                    header("Location:error.php");
                } 

                // 
                $sql = "SELECT * FROM Practitioner WHERE PractitionerID={$practitioner_number}";
                $rs = odbc_exec($conn,$sql);

                if(!$rs){
                    // Error checking for SQL
                    header("Location:error.php"); 
                } 

                // Checks the form submission from the patient search page 
                if (!$_POST["submit_search_ID"]) {
                    // If no patient number is submitted with the form it will direct back to the patient search page so a patient can be chosen
                    header("Location: ./patient_search_page.php");
                } else {
                    $patient_number = $_POST["submit_search_ID"];
                }

                // SQL Command to get all of the info for the specific pateient in the patient table via patient ID number
                $sql = "SELECT * FROM Patient WHERE PatientID={$patient_number}";

                //Executing the sql command and getting the result in rs
                $rs = odbc_exec($conn,$sql);

                if(!$rs){
                    // Error checking for SQL
                    header("Location:error.php"); 
                } 

                //While loop to fetch all of the information based off the above SQL statement
                $items = 0;
                while ($row = odbc_fetch_array($rs)){
                    $items++;
                    
                    $Full_Name = $row["FirstName"]." ".$row["LastName"];
                    $Room_Number = $row["RoomNumber"];
                    $PR_ID = "PR00".$row["PractitionerID"];
                    $PA_DOB = $row["DOB"];
                    $PA_Gender = $row["Gender"];
                    $PA_Weight = $row["Weight"];
                    $PA_Diet_Regime = "Normal";      
                    $PA_Image = $row["Image"];
                    $PA_Notes = $row["Notes"];
                    
                    //Assign Male fpr M and Female for F
                    if ($PA_Gender=="F") {
                        $PA_Gender="Female";
                    } elseif ($PA_Gender=="M") {
                        $PA_Gender="Male";
                    }

                    //Change DOB date format
                    $PA_DOB_Date = new DateTime($PA_DOB);
                    // echo $PA_DOB_Date->format('d/m/Y')."<br>";
                    
                    //Work out the age of the patient
                    $currentDate = date("d-m-Y");
                    $PA_Age = date_diff(date_create($PA_DOB), date_create($currentDate));
                    // echo "Current age is ".$PA_Age->format("%y");
                    
                } 

                // Practitioner and Diet Regime join 
                $sql = "SELECT Practitioner.FirstName AS PRFirstName, Practitioner.LastName AS PRLastName, DietRegime.DietName AS PADietName FROM 
                ((Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) INNER JOIN DietRegime ON Patient.DietRegimeID=DietRegime.DietRegimeID) 
                WHERE PatientID={$patient_number}";

                //Executing the sql command and getting the result in rs
                $rs = odbc_exec($conn,$sql);

                if(!$rs){
                    // Error checking for SQL
                    header("Location:error.php"); 
                } 

                //While loop to grab the results
                while ($row = odbc_fetch_array($rs)){
                    $PR_Name_db = $row["PRFirstName"]." ".$row["PRLastName"];
                    $DR_Name_db = $row["PADietName"];
                    
                } 

                // //Emergency contact details and Medicare together to avoid super long SQL queries 
                // $sql = "SELECT EmergencyContact.FirstName AS ECFirstName, EmergencyContact.LastName AS ECLastName, EmergencyContact.Relationship AS ECRelation, 
                // EmergencyContact.PhoneNumber AS ECNumber, EmergencyContact.Email AS ECEmail, Medicare.MedicareNumber AS MedicareNumber, 
                // Medicare.MedicareReference AS MedicareReference, Medicare.Expiry AS MedicareExpiry FROM ((Patient 
                // INNER JOIN EmergencyContact ON Patient.ContactID=EmergencyContact.ContactID) INNER JOIN Medicare ON Patient.MedicareID=Medicare.MedicareID) 
                // WHERE PatientID={$patient_number}";

                //Emergency contact details and Medicare together to avoid super long SQL queries 
                $sql = "SELECT EmergencyContact.FirstName AS ECFirstName, EmergencyContact.LastName AS ECLastName, EmergencyContact.Relationship AS ECRelation, 
                EmergencyContact.PhoneNumber AS ECNumber, EmergencyContact.Email AS ECEmail FROM (Patient 
                INNER JOIN EmergencyContact ON Patient.ContactID=EmergencyContact.ContactID) 
                WHERE PatientID={$patient_number}";

                //Executing the sql command and getting the result in rs
                $rs = odbc_exec($conn,$sql);

                if(!$rs){
                    // Error checking for SQL
                    header("Location:error.php"); 
                } 

                //While loop to grab the results
                while ($row = odbc_fetch_array($rs)){
                    //Emergency Contact Details
                    $EC_Name_db = $row["ECFirstName"]." ".$row["ECLastName"];
                    $EC_Relation = $row["ECRelation"];
                    $EC_Number = $row["ECNumber"];
                    $EC_Email = $row["ECEmail"];
                    // //Medicare Details
                    // $Medicare_Number = $row["MedicareNumber"];
                    // $Medicare_Reference = $row["MedicareReference"];
                    // $Medicare_Expiry = $row["MedicareExpiry"]; 
                } 

                //Emergency contact details and Medicare together to avoid super long SQL queries 
                $sql = "SELECT Medicare.MedicareNumber AS MedicareNumber, Medicare.MedicareReference AS MedicareReference, Medicare.Expiry AS MedicareExpiry FROM (Patient 
                INNER JOIN Medicare ON Patient.MedicareID=Medicare.MedicareID) 
                WHERE PatientID={$patient_number}";

                //Executing the sql command and getting the result in rs
                $rs = odbc_exec($conn,$sql);

                if(!$rs){
                    // Error checking for SQL
                    header("Location:error.php"); 
                } 

                //While loop to grab the results
                while ($row = odbc_fetch_array($rs)){
                    //Emergency Contact Details
                    // $EC_Name_db = $row["ECFirstName"]." ".$row["ECLastName"];
                    // $EC_Relation = $row["ECRelation"];
                    // $EC_Number = $row["ECNumber"];
                    // $EC_Email = $row["ECEmail"];
                    //Medicare Details
                    $Medicare_Number = $row["MedicareNumber"];
                    $Medicare_Reference = $row["MedicareReference"];
                    $Medicare_Expiry = $row["MedicareExpiry"]; 
                } 

                //Set Medicare Expiry to M/Y
                $Medicare_Expiry_Date = new DateTime($Medicare_Expiry);
                odbc_close($conn);
            ?>
			<!-- Patient Summary -->
			<section id="patient">
                <div class="top_container">
					<div class="sect__container--first">
                        <!-- Page title -->
				        <h2>Patient Summary</h2>
                    </div>
                    <div class="sect__container--second">
                        <!-- Edit Patient button as a form that sends the patient ID number to the Edit Patient Page -->
                        <form class="section__heading--edit" action="./edit_patient.php" method="POST"> 
                        <button class="edit_patient_button" type="submit" id="submit_edit_patient_ID" name="submit_edit_patient_ID" value="<?php echo $patient_number;?>">
                            Edit Patient </button> </form>
                    </div>
                </div>

				<div class="section__container">
					<div class="patient__container--highlight">
						<div class="patient__highlight">
							<figure class="patient__highlight--box patient__picture--mask">
                                <!-- 10 patient images were stored in the directory, 9 Patients with IDs and 1 default image. Therefore the following if statement
                                        checks if the patient ID is greater than 9 and if so prints the default image so the website can run smoothly -->
                                <?php 
                                    if ($patient_number < 10) {
                                        echo "<img src=\"./images/PA00".$patient_number.".jpg\" class=\"patient__picture\" alt=\"Picture of patient\">";
                                    } else {
                                        echo "<img src=\"./images/default.jpg\" class=\"patient__picture\" alt=\"Picture of patient\">";
                                    }
                                ?>
							</figure>
                            <!-- Prints the information of the patient in the green highlighted box to the left of the page -->
							<h2 class="patient__highlight--box patient__name">
                                <?php echo $Full_Name; ?>
							</h2>
                            <p class="patient__highlight--box patient__number--label">
								Patient ID
							</p>
							<p class="patient__highlight--box patient__number--number">
                                <?php echo "PA00".$patient_number; ?>
							</p>
							<p class="patient__highlight--box patient__room--label">
								Room number
							</p>
							<p class="patient__highlight--box patient__room--number">
                                <?php echo $Room_Number; ?>
							</p>
							<p class="patient__highlight--box patient__prac--label">
								Practitioner
							</p>
							<p class="patient__highlight--box patient__prac--name">
                                <?php echo "Dr. ".$PR_Name_db; ?>
							</p>
                            <p class="patient__highlight--box patient__diet--label">
								Diet Regime
							</p>
							<p class="patient__highlight--box patient__diet--name">
                                <?php echo $DR_Name_db; ?>
							</p>
						</div>
					</div>
                    <!-- Prints the profile details  -->
					<div class="patient__details">
						<h2 class="patient__details--box patient__profile">Profile</h2>
						<p class="patient__details--box patient__age--label">Age</p>
						<p class="patient__details--box patient__age--number">
                             <!-- In order to get the age in the right format -->
                            <?php echo $PA_Age->format("%y"); ?> </p>   
						<p class="patient__details--box patient__gender--label">Gender</p>
						<p class="patient__details--box patient__gender--gender"> <?php echo $PA_Gender; ?> </p>
						<p class="patient__details--box patient__dob--label">Date of Birth</p>
						<p class="patient__details--box patient__dob--date"> <?php echo $PA_DOB_Date->format('d/m/Y'); ?> </p>
						<p class="patient__details--box patient__weight--label">Weight</p>
						<p class="patient__details--box patient__weight--number"> <?php echo $PA_Weight." kg"; ?> </p>
					</div>
				</div>
			</section>
			<!-- Medicare and Emergency Contacts -->
            <div class="top__container">
                <!-- Emergency Contact details -->
                <section id="emergency_contact">
                    <div class="section__heading">
                        <h2 class="subheading">Emergency Contact Details</h2>
                    </div>
                    <div class="section__container--first">
                        <div class="details__highlight--emergency">
							<p class="details__highlight--box EC__name--label">
								Name
							</p>
							<p class="details__highlight--box EC__name--number">
                                <?php echo $EC_Name_db; ?>
							</p>
							<p class="details__highlight--box EC__relation--label">
								Relation
							</p>
							<p class="details__highlight--box EC__relation--name">
                                <?php echo $EC_Relation; ?>
							</p>
                            <p class="details__highlight--box EC__number--label">
								Number
							</p>
							<p class="details__highlight--box EC__number--name">
                                <?php echo $EC_Number; ?>
							</p>
                            <p class="details__highlight--box EC__email--label">
								Email
							</p>
							<p class="details__highlight--box EC__email--name">
                                <a href="mailto: <?php echo $EC_Email; ?>"><?php echo $EC_Email; ?></a>
							</p>
						</div>
                    </div>
                </section>
                <!-- Medicare -->
                <section id="medicare">
                    <div class="section__heading">
                        <h2 class="subheading">Medicare</h2>
                    </div>
                    <div class="section__container--second">
                        <div class="details__highlight--medicare">
                            <p class="details__highlight--box Medicare__Number--label">
                                Medicare Number
                            </p>
                            <p class="details__highlight--box Medicare__Number--number">
                                <?php echo $Medicare_Number; ?>
                            </p>
                            <p class="details__highlight--box Medicare__Reference--label">
                                Medicare Reference
                            </p>
                            <p class="details__highlight--box Medicare__Reference--name">
                                <?php echo $Medicare_Reference; ?>
                            </p>
                            <p class="details__highlight--box Medicare_Expiry--label">
                                Expiry Date
                            </p>
                            <p class="details__highlight--box Medicare_Expiry--name">
                                <?php echo $Medicare_Expiry_Date->format('m/Y'); ?>
                            </p>
                        </div>
                    </div>
                </section>
            </div>
			<!-- Medications -->
			<section id="medications">
				<div class="section__heading">
					<h2 class="subheading">Medications</h2>
				</div>
				<div class="section__container--medications">
                    <?php
                        // Connect to the database to gather information on the medications specific to this patient 
                        $conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);

                        if(!$conn){
                            // Error checking for SQL
                            header("Location:error.php"); 
                        } 

                        // Select the distinct patient medications from the patient medications table then grab the details of these medications from the Medications table 
                        $sql = "SELECT DISTINCT PatientMedications.MedicationID AS MedID, Medications.MedicationName AS MedName, Medications.RecommendedDosage AS MedDosage, 
                        Medications.Route AS MedRoute, Medications.Type AS MedType, Medications.RecommendedFrequency AS MedFreq, Medications.ActiveIngredient AS MedIngredient, 
                        Medications.Condition AS MedCondition, Medications.InstructionsForUse AS MedInstructions FROM PatientMedications 
                        INNER JOIN Medications ON PatientMedications.MedicationID=Medications.MedicationID WHERE PatientID={$patient_number}";

                        //Executing the sql command and getting the result in rs
                        $rs = odbc_exec($conn,$sql);

                        if(!$rs){
                            // Error checking for SQL
                            header("Location:error.php"); 
                        } 
                        
                        //Print out for all of the medication details in the form of a table
                        echo "<table class=\"specific_patient_med_table\">";
                        echo "<tr><th id=\"MDName\"> Medication Name </th> <th id=\"MDDosage\"> Dosage  </th> <th id=\"MDRoute\">Route</th> <th id=\"MDType\">Type</th> <th id=\"MDFreq\">Frequency</th><th id=\"MDIngredient\"> Active Ingredient</th><th id=\"MDCondition\">Condition</th> <th id=\"MDInstructions\">Instructions for Use</th></tr>";
                        while (odbc_fetch_row($rs)) {
                            // Fetching information
                            $Med_Name=odbc_result($rs,"MedName");
                            $Med_Dosage=odbc_result($rs,"MedDosage"); 
                            $Med_Route=odbc_result($rs,"MedRoute");
                            $Med_Type=odbc_result($rs,"MedType");
                            $Med_Frequency=odbc_result($rs,"MedFreq");
                            $Med_ActiveIngredient=odbc_result($rs,"MedIngredient");
                            $Med_Condition=odbc_result($rs,"MedCondition");
                            $Med_Instructions=odbc_result($rs,"MedInstructions");
                            // Printing information
                            echo "<tr><td> $Med_Name </td>"; 
                            echo "<td> $Med_Dosage </td>"; 
                            echo "<td> $Med_Route </td>"; 
                            echo "<td> $Med_Type </td>"; 
                            echo "<td> $Med_Frequency </td>"; 
                            echo "<td> $Med_ActiveIngredient </td>"; 
                            echo "<td> $Med_Condition </td>"; 
                            echo "<td>$Med_Instructions</td></tr>";
                        };
                        echo "</table>";

                        // odbc_close($conn);
                    ?>
				</div>
			</section>
			<!-- Patient Notes -->
			<section id="patient_notes">
				<div class="section__heading">
					<h2 class="subheading">Notes</h2>
				</div>
				<div class="section__container--notes">
					<div class="section__table">
                        <?php echo $PA_Notes; ?>
					</div>
				</div>
			</section>
		</div>

        <!-- Footer -->
        <div class="row footer_row">
            <!-- Need to work out how to get the footer to the bottom of the page-->
            
            <a href="#" class="footer_anchor">
                <figure class="footer_logo">
                    <img src="./img/logo.png" class="footer_logo_img" alt="Logo"> 
                </figure>
            </a>
            <br>
            <div class="footer_copyright" align="center" >Copyright © 2021 Info Sis Association </div>
        </div>
        
		<!-- JavaScript to change PHP template -->
		<script type="text/javascript">
			document.getElementById("patients").classList.add("sidenav__link--anchor-primary");
			document.getElementById("heading").innerText = "Patient Summary";
			// Change this PR Name to the PR that is logged in 
			document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
		</script>
</body>

</html>