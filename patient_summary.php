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
		include_once 'index2.html';
	?>
		<div class="main">
			<!-- Breadcrumb -->
			<div class="breadcrumb">
					<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Patient Summary</span></p>
			</div>

            <?php
                $patient_number = "001";
                // echo "<br> <p align=\"center\"> Patient ID is PA".$patient_number." </p> <br>";

                $conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);
                $sql = "SELECT * FROM Patient WHERE PatientID={$patient_number}";


                //Used to check the connection to the database was successful
                                                
                // if(!$conn){ 
                //     exit("Connection Failed: ". $conn); 
                // } else { 
                //     echo ("<p align=\"center\"> Connection Successful! </p>");
                // }

                //Executing the sql command and getting the result in rs
                $rs = odbc_exec($conn,$sql);

                //While loop as a counter to determine the amount of rows were returned
                //If result is zero then they are a new registrant and if not the system will either check for whether they are banned or just a duplicate 
                $items = 0;
                $i;
                // $array = array();
                while ($row = odbc_fetch_array($rs)){
                    $items++;
                    // foreach($row as $columnName => $value) {
                    //     // echo "<br><p align=\"center\"> Rows:".$row."</p>"; 
                    //     echo "<br><p align=\"center\"> Rows:".$columnName.$value."</p>"; 
                                    
                    // }
                    $Full_Name = $row["FirstName"]." ".$row["LastName"];
                    $Room_Number = $row["RoomNumber"];
                    $PR_ID = "PR00".$row["PractitionerID"];
                    //Get PR Name and DR Name after connecting the Databases
                    $PR_Name = "Julliette Smith";
                    $PA_DOB = $row["DOB"];
                    $PA_Gender = $row["Gender"];
                    $PA_Weight = $row["Weight"];
                    $PA_Diet_Regime = "Normal";      
                    $PA_Image = $row["Image"];
                    $PA_Notes = $row["Notes"];
                    
                    //Either change Gender in MA to full name or have an If statement to assign Male to M and Female to F
                    if ($PA_Gender=="F") {
                        $PA_Gender="Female";
                    } elseif ($PA_Gender=="M") {
                        $PA_Gender="Male";
                    }
                    //Change DOB date format --> how to echo it in the correct format
                    $PA_DOB_Date = new DateTime($PA_DOB);
                    // echo $PA_DOB_Date->format('d/m/Y')."<br>";
                    //Work out the age of the patient
                    $currentDate = date("d-m-Y");
                    $PA_Age = date_diff(date_create($PA_DOB), date_create($currentDate));
                    // echo "Current age is ".$PA_Age->format("%y");


                    //Write code to deal with a 2 digit or 3 digit patient ID?
                    // echo "<h2 class=\"section_title\" align = \"left\">".$row["FirstName"]." ".$row["LastName"]." (PA00".$row["PatientID"].") </h2> <br>";
                    // echo "<p><b>Gender: </b>".$row["Gender"]."</p><br>";
                    // echo "<p><b>Room Number: </b>".$row["RoomNumber"]."</p><br>";
                    // echo "<p><b>Date of Birth: </b>".$row["DOB"]."</p><br>";
                    //echo "<p><b>Patient Weight: </b>".$row["Gender"]."</p><br>";
                } 

                // Practitioner and Diet Regime join 
                $sql = "SELECT Practitioner.FirstName AS PAFirstName, Practitioner.LastName AS PALastName, DietRegime.DietName AS PADietName FROM 
                ((Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) INNER JOIN DietRegime ON Patient.DietRegimeID=DietRegime.DietRegimeID) 
                WHERE PatientID={$patient_number}";

                //Executing the sql command and getting the result in rs
                $rs = odbc_exec($conn,$sql);

                //While loop to grab the results
                while ($row = odbc_fetch_array($rs)){
                    $PR_Name_db = $row["PAFirstName"]." ".$row["PALastName"];
                    $DR_Name_db = $row["PADietName"];
                    //Get PR Name and DR Name after connecting the Databases
                    
                } 

                //Emergency contact details and Medicare together to avoid super long SQL queries 
                $sql = "SELECT EmergencyContact.FirstName AS ECFirstName, EmergencyContact.LastName AS ECLastName, EmergencyContact.Relationship AS ECRelation, 
                EmergencyContact.PhoneNumber AS ECNumber, EmergencyContact.Email AS ECEmail, Medicare.MedicareNumber AS MedicareNumber, 
                Medicare.MedicareReference AS MedicareReference, Medicare.Expiry AS MedicareExpiry FROM ((Patient 
                INNER JOIN EmergencyContact ON Patient.ContactID=EmergencyContact.ContactID) INNER JOIN Medicare ON Patient.MedicareID=Medicare.MedicareID) 
                WHERE PatientID={$patient_number}";

                //Executing the sql command and getting the result in rs
                $rs = odbc_exec($conn,$sql);

                //While loop to grab the results
                while ($row = odbc_fetch_array($rs)){
                    //Emergency Contact Details
                    $EC_Name_db = $row["ECFirstName"]." ".$row["ECLastName"];
                    $EC_Relation = $row["ECRelation"];
                    $EC_Number = $row["ECNumber"];
                    $EC_Email = $row["ECEmail"];
                    //Medicare Details
                    $Medicare_Number = $row["MedicareNumber"];
                    $Medicare_Reference = $row["MedicareReference"];
                    $Medicare_Expiry = $row["MedicareExpiry"]; 
                } 

                //Set Medicare Expiry to M/Y
                $Medicare_Expiry_Date = new DateTime($Medicare_Expiry);

                // echo "<br><p align=\"center\">Practitioner Name: ".$PR_Name_db."(".$PR_ID.")</p>";
                // echo "<br><p align=\"center\"> Diet Regime:".$DR_Name_db."</p>";
                // echo "<br><p align=\"center\"> Emergency Contact Name: ".$EC_Name_db."</p>";
                // echo "<br><p align=\"center\"> Medicare Number: ".$Medicare_Number."</p>";

                odbc_close($conn);
            ?>
			<!-- Patient Summary -->
			<section id="patient">
				<h2>Patient Summary</h2>
				<div class="section__container">
					<div class="patient__container--highlight">
						<div class="patient__highlight">
							<figure class="patient__highlight--box patient__picture--mask">
								<img src="./img/old_man.jpg" class="patient__picture" alt="Picture of patient">
                                <!-- <img src="<?php //echo $PA_Image; ?>" class="patient__picture" alt="Picture of Margaret"> -->
							</figure>
							<h2 class="patient__highlight--box patient__name">
                                <?php echo $Full_Name; ?>
							</h2>
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
					<div class="patient__details">
						<h2 class="patient__details--box patient__profile">Profile</h2>
						<p class="patient__details--box patient__age--label">Age</p>
						<p class="patient__details--box patient__age--number"> 
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
                        <p class="section__heading--edit">Edit</p>
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
                        <p class="section__heading--edit">Edit</p>
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
			<!-- Diet Regime -->
			<section id="diet-regime">
				<div class="section__heading">
					<h2 class="subheading">Medications</h2>
					<p class="section__heading--edit">Edit</p>
				</div>
				<div class="section__container--medications">
					<!-- <div class="section__table">
						<div class="section__table--heading-1">
							<p class="section__table--heading">Diet Regime</p>
						</div>
						<div class="section__table--heading-2">
							<p class="section__table--heading">Description</p>	
						</div>
						<div class="section__table--heading-3">
							<p class="section__table--heading">Exercise Recommendations</p>
						</div>
					</div> -->
                    <?php
                        $conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);
                        $sql = "SELECT DISTINCT PatientMedications.MedicationID AS MedID, Medications.MedicationName AS MedName, Medications.RecommendedDosage AS MedDosage, 
                        Medications.Route AS MedRoute, Medications.Type AS MedType, Medications.RecommendedFrequency AS MedFreq, Medications.ActiveIngredient AS MedIngredient, 
                        Medications.Condition AS MedCondition, Medications.InstructionsForUse AS MedInstructions FROM PatientMedications 
                        INNER JOIN Medications ON PatientMedications.MedicationID=Medications.MedicationID WHERE PatientID={$patient_number}";

                        //Used to check the connection to the database was successful                                
                        // if(!$conn){ 
                        //     exit("Connection Failed: ". $conn); 
                        // } else { 
                        //     echo ("<p align=\"center\"> Connection Successful! </p>");
                        // }

                        //Executing the sql command and getting the result in rs
                        $rs = odbc_exec($conn,$sql);
                        
                        //Print out for all of the registered people in the form of a table
                        echo "<table class=\"specific_patient_med_table\">";
                        echo "<tr><th id=\"MDName\"> Medication Name </th> <th id=\"MDDosage\"> Dosage  </th> <th id=\"MDRoute\">Route</th> <th id=\"MDType\">Type</th> <th id=\"MDFreq\">Frequency</th><th id=\"MDIngredient\"> Active Ingredient</th><th id=\"MDCondition\">Condition</th> <th id=\"MDInstructions\">Instructions for Use</th></tr>";
                        while (odbc_fetch_row($rs)) {
                            $Med_Name=odbc_result($rs,"MedName");
                            $Med_Dosage=odbc_result($rs,"MedDosage"); 
                            $Med_Route=odbc_result($rs,"MedRoute");
                            $Med_Type=odbc_result($rs,"MedType");
                            $Med_Frequency=odbc_result($rs,"MedFreq");
                            $Med_ActiveIngredient=odbc_result($rs,"MedIngredient");
                            $Med_Condition=odbc_result($rs,"MedCondition");
                            $Med_Instructions=odbc_result($rs,"MedInstructions");
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

                    <!-- <table class="specific_patient_med_table" cellpadding=30px> 
                        <tr> <th valign="middle">Medication Name </th> <th valign="middle"> Dosage </th> <th valign="middle"> Route</th><th valign="middle"> Type</th> <th valign="middle"> Frequency</th><th valign="middle"> Active Ingredient</th><th valign="middle"> Condition</th><th valign="middle"> Instructions for Use</th> </tr> 
                        <tr> <td valign="middle">Panadol 500 mg</td> <td align="center" valign="middle">2</td> <td valign="middle">Oral tablet</td> 
                                <td valign="middle">PRN</td> <td valign="middle">Every 4-6 hours as required </td> <td valign="middle">Paracetomol</td>
                                <td valign="middle">Temporary relief of pains, aches and fevers</td><td valign="middle">Maximum 8 tablets in 24 hours</td> </tr> 
                            
                    </table> -->
				</div>
			</section>
			<!-- Meal Plan -->
			<section id="patient_notes">
				<div class="section__heading">
					<h2 class="subheading">Notes</h2>
					<p class="section__heading--edit">Edit</p>
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
			document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
		</script>
</body>

</html>