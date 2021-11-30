<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Patient Search</title>
	<link rel="stylesheet" href="css/style_sheet_new.css">
	<!-- Style sheet link below is for the magnifying glass symbol in the search button -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- <script src="js/main.js"></script> -->
</head>
<body>
	<?php
		// reference index.html for styling, nav and logout features
		include 'index.html';
		// session assigned in the login page 
		session_start();
		if(! isset($_SESSION["session_practitioner"])) {
            header("Location:login.php");
        }
		$practitioner_number = $_SESSION["session_practitioner"];
		$practitioner_name = $_SESSION["session_practitioner_name"];
		
	?>

	<!-- Main Content -->
	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Patient Search</span></p>
		</div>
	
		<section id="search_patients_section">
			<div class="container">
				<div class="row">
					<!-- Page subtitle -->
					<h2 class="section_title"> Current Patients </h2> <br>
					<!-- Instructions on how to use the search bar -->
					<h3 class="section_title"> Search Patient ID (PA000) or Patient Name </h3> <br>
					<div class="top_container">
						<div class="middle__container--first">
							<!-- Form used for the search bar and search button -->
							<form class="search_patients" method="POST">
								<input type="text" class="search-box" placeholder="Search..." name="search" id="search">
								<button type="submit" id="submit" name="submit" value="search"><i class="fa fa-search"></i></button>
							</form>
						</div>
						<div class="middle__container--second">
							<!-- Form for the Add Patient button on the right of the screen -->
							<form class="section__heading--edit" action="./add_patient.php" method="POST"> 
							<button class="add_patient_button" type="submit" id="submit_add_patient_ID" name="submit_add_patient_ID">
							Add Patients </button> </form>
						</div>
					</div>
                    <br><br><br>

					<?php
						// Connecting to the database
						$conn = odbc_connect('z5254640', '', '',SQL_CUR_USE_ODBC);

						if(!$conn){
							// Error checking for database connection
							header("Location:error.php");
						} 

						$sql = "SELECT * FROM Practitioner WHERE PractitionerID={$practitioner_number}";
						$rs = odbc_exec($conn,$sql);

						if(!$rs){
							// Error checking for SQL
							header("Location:error.php"); 
						} 

						// If the user has not pressed the search button then all of the patients will show otherwise it will show the specific patient
						// Checks the search form has been submitted
						if(isset($_POST["submit"])){ 
							// Checks if the $_POST['search'] is not empty, if it is not empty it will continue within the if statement
							if(!empty($_POST['search'])) { 
								// This variable was added to ensure a panel does not appear if nothing is put in the search bar
								$noresults = 0;
								// Assigns the search term into $search_term
								$search_term = $_POST["search"];

								// If statement to determine if the user has put in a name or a patient ID
								// First If statement checks if it matches the Patient ID format
								$PA_check = $search_term[0].$search_term[1];
								if ($PA_check == "PA" AND strlen($search_term) < 6) {
									// Confirms its a patient ID then grabs the patient number to be used in the SQL statement
									$patient_number_searched = $search_term[2].$search_term[3].$search_term[4];

									$sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
									Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
									(Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) WHERE PatientID={$patient_number_searched}";
								} else {
									// Otherwise explodes the string into separate words to compare against the first and last name 
									$array_searchString = explode(" ", $search_term ); // split string with space (white space) as a delimiter.

									// Check if one or two names were searched 
									if (count(array_searchString) == 1) {
										// If one word is searched it will only need to check against the first and last name one string
										$sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
										Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
										(Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) WHERE Patient.FirstName LIKE ('%{$array_searchString[0]}%') OR
										Patient.LastName LIKE ('%{$array_searchString[0]}%')";
										
									} elseif (count(array_searchString) == 2) {
										// If two words is searched it will check two strings against the first and last name
										$sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
										Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
										(Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) WHERE Patient.FirstName LIKE ('%{$array_searchString[0]}%') OR
										Patient.LastName LIKE ('%{$array_searchString[0]}%') OR Patient.FirstName LIKE ('%{$array_searchString[1]}%') OR Patient.LastName LIKE ('%{$array_searchString[1]}%')";
										
									} else {
										// echo "<br> Please enter a Patient ID (PA000) or Patient Name to search.<br><br>";
									}
								}

							} else {  
								// Message if the search button is pressed but there is nothing in the search bar
								echo "<p align=\"center\"> <br> Please enter a Patient ID (PA000) or Patient Name to search. </p> <br>";
								// This variable is used to make sure an empty patient does not print when there is nothing in the search bar 
								$noresults = 1;
							}
						} else {
							// If the search form is not submitted it will show all of the patients since there is no WHERE constraint
							$sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
							Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
							(Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID)";

							// set search term to an empty string this is for the message where the it shows the number of results and the search term
							$search_term = " ";
						}

						//Executing the sql command and getting the result in rs
						$rs = odbc_exec($conn,$sql);

						if(!$rs){
							// Error checking for SQL
							header("Location:error.php"); 
						} 
		
						//While loop as a counter to determine the amount of rows were returned
						//If result is zero then they are a new registrant and if not the system will either check for whether they are banned or just a duplicate 
						$items = 0;
						// Determine the number of results 
						while ($row = odbc_fetch_array($rs)){
							$items++;
						} 

						// If there is no results the number of items is set to zero since previously it was setting to 1 if the search button was pressed with an empty search bar
						if ($noresults == 1) {
							$items = 0;
						}
						// Print out the number of results 
						echo "<p> <b>Showing (".$items.") results for \"".$search_term."\"</b> </p><br>";

						// Print out the results 
						$rs = odbc_exec($conn,$sql);

						if(!$rs){
							// Error checking for SQL
							header("Location:error.php"); 
						} 

						// For each patient that matched the above SQL statement their details are collected and printed 
						while ($row = odbc_fetch_array($rs)){
							$items++;
							// Collect details
							$Full_Name = $row["PAFirstName"]." ".$row["PALastName"];
							$PA_ID_Num = $row["PAT_ID"];
							$PA_ID = "PA00".$row["PAT_ID"];
							$Room_Number = $row["PARoomNumber"];
							$PR_ID = "PR00".$row["PRA_ID"];
							$PR_Name = $row["PRFirstName"]." ".$row["PRLastName"];
							
							// Only print the form if there ...
							if ($noresults != 1) {
								echo "<form class=\"select_patient_form\" action=\"./patient_summary.php\" method=\"POST\">";

									echo "<button class=\"select_patient_button\" type=\"submit\" id=\"submit_search_ID\" name=\"submit_search_ID\" value=".$PA_ID_Num.">";
										echo "<div class=\"section__container--search\">";
											echo "<div class=\"search__highlight\">";
												echo "<figure class=\"search__highlight--box search__picture--mask\">";
													// echo "<img src=\"./images/".$PA_ID.".jpg\" class=\"search__picture\" alt=\"Picture of patient\"></figure>";
													if ($PA_ID_Num < 10) {
														echo "<img src=\"./images/PA00".$PA_ID_Num.".jpg\" class=\"search__picture\" alt=\"Picture of patient\">";
													} else {
														echo "<img src=\"./images/default.jpg\" class=\"search__picture\" alt=\"Picture of patient\">";
													}
												echo "</figure>";
												echo "<h2 class=\"search__highlight--box search__name\">".$Full_Name." (".$PA_ID.")</h2>";
												echo "<p class=\"search__highlight--box search__room--label\"> Room number </p>";
												echo "<p class=\"search__highlight--box search__room--number\">".$Room_Number."</p>";
												echo "<p class=\"search__highlight--box search__prac--label\"> Practitioner </p>";
												echo "<p class=\"search__highlight--box search__prac--name\"> Dr. ".$PR_Name." (".$PR_ID.")</p>";
											echo "</div>";
										echo "</div> <br>";
									echo "</button>";
								echo "</form>";
							}
						} 
					?>
				</div>
			</div>
		</section>


	</div>
	
	<!-- End Main Content -->
	
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
			document.getElementById("heading").innerText = "Patient Search";
			// Change this PR Name to the PR that is logged in 
			document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
	</script>

</body>
</html>
