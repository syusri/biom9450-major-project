<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Patient Search</title>
	<link rel="stylesheet" href="css/style_sheet_new.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- <script src="js/main.js"></script> -->
</head>
<body>
	<?php
		include_once 'index.html';
		// session assigned in the login page 
		session_start();
		$practitioner_number = $_SESSION["session_practitioner"];

	?>
	<!-- Header -->
	<!-- <header>
		<nav>
			<ul class="nav_option_list">
				<li class="nav_option"><a class="nav_link" href="./practitioner_home_page.html"> Home </a></li>
				<li class="nav_option"><a class="nav_link" href="./patient_search_page.html">Patients</a></li>
				<li class="nav_option"><a class="nav_link" href="./generate_reports_page.html">Reports</a></li>
			</ul>		
		</nav>
		<h1 class="page_title" align="center"> Welcome to the Info Sis Nursing Home Online System</h1>											  
	</header> -->
	<!-- Main Content -->
	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><a href="dashboard.php" class="page--previous">Dashboard</a> > <span class="page--current">Patient Search</span></p>
		</div>
	
		<!-- <section id="venue">
			<div class="container">
				<div class="row">
					<h3 class="section_title"> </h3>
						<div class="information">
						</div>
				</div>
			</div>
		</section> -->

		<section id="search_patients_section">
			<div class="container">
				<div class="row">
					<h2 class="section_title"> Current Patients </h2> <br>
					<form class="section__heading--edit" action="./add_patient.php" method="POST"> 
                	<button class="add_patient_button" type="submit" id="submit_add_patient_ID" name="submit_add_patient_ID">
                    Add Patients </button> </form>
					<h3 class="section_title"> Search Patient ID (PA000) or Patient Name </h3> <br>
					
                    <form class="search_patients" method="POST">
                        <input type="text" class="search-box" placeholder="Search..." name="search" id="search">
                        <button type="submit" id="submit" name="submit" value="search"><i class="fa fa-search"></i></button>
                    </form>

                    <br><br><br>

					<?php
						 
						// Create an If statement for the action of the search form like for the login page
						$patient_number = "001";
						$patient_number_2 = "002";
		
						$conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);
						$sql = "SELECT * FROM Practitioner WHERE PractitionerID={$practitioner_number}";
						$rs = odbc_exec($conn,$sql);
						// Finds the practitioner that is logged in

						// Get the practitioner name that is logged in
						while ($row = odbc_fetch_array($rs)){
							$practitioner_name_loggedin = $row["FirstName"]." ".$row["LastName"];
						} 
						
						// How to avoid the confirm form resubmission page???

						// If the user has not pressed the search button then all of the patients will show otherwise it will show the specific patient
						if(isset($_POST["submit"])){ 
							if(!empty($_POST['search'])) { 
								$search_term = $_POST["search"];

								// Make an if statement to determine if the user has put in a name or a patient ID


								if ($search_term[0] == "P" && $search_term[1] == "A") {
									$patient_number_searched = $search_term[2].$search_term[3].$search_term[4];
									// echo "<br> Patient ID that was searched is PA".$patient_number_searched." <br>";
									$sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
									Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
									(Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) WHERE PatientID={$patient_number_searched}";
								} else {
									$array_searchString = explode(" ", $search_term ); // split string with space (white space) as a delimiter.
									// echo "<br> Name searched is ".$array_searchString[0]." ".$array_searchString[1]." <br>";
									// Check if one or two names were searched 
									if (count(array_searchString) == 1) {
										$sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
										Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
										(Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) WHERE Patient.FirstName LIKE ('%{$array_searchString[0]}%') OR
										Patient.LastName LIKE ('%{$array_searchString[0]}%')";
										// echo "<br>".$sql."<br><br>";
									} elseif (count(array_searchString) == 2) {
										$sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
										Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
										(Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) WHERE Patient.FirstName LIKE ('%{$array_searchString[0]}%') OR
										Patient.LastName LIKE ('%{$array_searchString[0]}%') OR Patient.FirstName LIKE ('%{$array_searchString[1]}%') OR Patient.LastName LIKE ('%{$array_searchString[1]}%')";
										// echo "<br>".$sql."<br><br>";
									} else {
										// echo "<br> Please enter a Patient ID (PA000) or Patient Name to search.<br><br>";
									}
								}

								// If statement for patient number or name or other 


								// $sql = "SELECT * FROM Patient WHERE PatientID={$patient_number}";
								// $sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
								// Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
								// (Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID) WHERE PatientID={$patient_number} OR PatientID={$patient_number_2}";
								// $sql = "SELECT * FROM Patient WHERE PatientID={$patient_number} OR PatientID={$patient_number_2}";
								// $search_term = "PA001";
							} else {  
								echo "<p align=\"center\"> <br> All fields are required! </p> <br>";
							}
						} else {
							$sql = "SELECT Patient.FirstName AS PAFirstName, Patient.LastName AS PALastName, Patient.PatientID AS PAT_ID, Practitioner.FirstName AS PRFirstName, 
							Practitioner.LastName AS PRLastName, Patient.PractitionerID AS PRA_ID, Patient.RoomNumber AS PARoomNumber FROM 
							(Patient INNER JOIN Practitioner ON Patient.PractitionerID=Practitioner.PractitionerID)";

							// set search term to an empty string
							$search_term = " ";
						}

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
						// Determine the number of results 
						while ($row = odbc_fetch_array($rs)){
							$items++;
						} 

						// Print out the number of results 
						// Change PA001 to whatever is searched in the form
						echo "<p> <b>Showing (".$items.") results for \"".$search_term."\"</b> </p><br>";

						// Print out the results 
						$rs = odbc_exec($conn,$sql);
						while ($row = odbc_fetch_array($rs)){
							$items++;
							// foreach($row as $columnName => $value) {
							//     // echo "<br><p align=\"center\"> Rows:".$row."</p>"; 
							//     echo "<br><p align=\"center\"> Rows:".$columnName.$value."</p>"; 
											
							// }
							$Full_Name = $row["PAFirstName"]." ".$row["PALastName"];
							$PA_ID_Num = $row["PAT_ID"];
							$PA_ID = "PA00".$row["PAT_ID"];
							$Room_Number = $row["PARoomNumber"];
							$PR_ID = "PR00".$row["PRA_ID"];
							// $PA_Image = $row["PAImage"];
							$PR_Name = $row["PRFirstName"]." ".$row["PRLastName"];
							

							echo "<form class=\"select_patient_form\" action=\"./patient_summary.php\" method=\"POST\">";

								echo "<button class=\"select_patient_button\" type=\"submit\" id=\"submit_search_ID\" name=\"submit_search_ID\" value=".$PA_ID_Num.">";
									echo "<div class=\"section__container--search\">";
										echo "<div class=\"search__highlight\">";
											echo "<figure class=\"search__highlight--box search__picture--mask\">";
												echo "<img src=\"./img/old_man.jpg\" class=\"search__picture\" alt=\"Picture of patient\"></figure>";

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
			document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name_loggedin;?>";
	</script>

</body>
</html>
