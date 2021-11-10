<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="css/style_sheet.css">
	<script type="text/javascript" src="js/myscript.js"> </script> 
	<!-- <link href="css/html_layout_styles.css" rel="stylesheet" type="text/css"> -->
	<!-- <script src="js/main.js"></script> -->
</head>

<body>

	<nav>
	</nav>

    <!-- Side navigation bar -->
	<!-- Customise this for the login page-->
    <div class="sidenav">
        <div class="company__logo">
			<figure class="company__logo--img">
				<img src="./img/logo.png" class="company__logo--pic" alt="Logo">
			</figure>
			<a href="index.html" class="company__logo--text">
				AgedCare
			</a>
		</div>

		<!-- Got rid of the options for -->
		<!--
        <ul class="sidenav__link--list">
			<li class="sidenav__link">
				<a href="#" class="sidenav__link--anchor">Dashboard</a>
			</li>
			<li class="sidenav__link">
				<a href="#" class="sidenav__link--anchor">Patients</a>
			</li>
			<li class="sidenav__link">
				<a href="#" class="sidenav__link--anchor">Reports</a>
			</li>
			</li>
		</ul>
		-->
    </div>

    <!-- Top bar where heading, practitioner and logout are -->
    <div class="topnav">
        <h1><!-- Place heading here --></h1> 
        <ul class="nav__link--list">
            <li class="nav__link--anchor">
                <a class="nav_link" href="./login.php"> Login </a></li>
            </li>
            <li class="nav__link--list">
				<a class="nav_link" href="./register.php">Register</a>
            </li>
        </ul>
    </div>

	<!-- Main Content -->
	<main>
		<section id="venue">
			<div class="container">
				<div class="row">
					<h3 class="section_title"> </h3>
						<div class="information">
						</div>
				</div>
			</div>
		</section>

		<section id="form_requirements">
			<div class="main">
				<div class="row">
					<h2 class="section_title" align = "center"> Login </h2> <br>
					
					<!-- Form -->
					<form id="login_form"  method="POST" align="center">
						<label for="practitioner_ID">Username:</label> 
						<input type="text" id="practitioner_ID" name="practitioner_ID" placeholder="PR000">
						<!-- <p id="username_result" class="result_message"> </p> <br> -->
                        <br><br>
						<label for="password">Password:</label>
						<input type="password" id="password" name="password" placeholder="Enter Password">
						<!-- <p id="password_result" class="result_message"> </p> <br> --> <br> <br>

						
						<!-- Submit buttons -->
						<button type="submit" id="submit" name="submit" value="Login">Login</button>

					</form>

					<?php
						if(isset($_POST["submit"])){  

							// echo "<p align=\"center\"> <br> Hello </p> <br>";
  
							if(!empty($_POST['practitioner_ID']) && !empty($_POST['password'])) {  
								$username = $_POST["practitioner_ID"];
								$password_login = $_POST["password"];

								$practitioner_number = $username[2].$username[3].$username[4];

								// echo "<br><br><p align=\"center\">  Practitioner number is: ".$practitioner_number."<br></p>";

						 		// echo "<br><br><p align=\"center\">  Username: ".$username."<br> Password: ".$password_login."</p>";
								
								$conn = odbc_connect('z5165306', '', '',SQL_CUR_USE_ODBC);
								
								$sql = "SELECT * FROM Practitioner WHERE (PractitionerID={$practitioner_number} AND Password='{$password_login}')";

								//Used to check the connection to the database was successful
								
								// if(!$conn){ 
								// 	exit("Connection Failed: ". $conn); 
								// } else { 
								// 	echo ("<p align=\"center\"> Connection Successful! </p>");
								// }
								
								//Executing the sql command and getting the result in rs
								$rs = odbc_exec($conn,$sql);

								//While loop as a counter to determine the amount of rows were returned
								//If result is zero then they are a new registrant and if not the system will either check for whether they are banned or just a duplicate 
								$items = 0;
								while ($row = odbc_fetch_array($rs)){
									$items++;                          
								} 
								// echo "<br><p align=\"center\">total No. of rows:".$items."</p>";

								// https://www.c-sharpcorner.com/article/create-a-login-form-validation-using-php-and-wamp-xampp/

								$rs = odbc_exec($conn,$sql);

								if($items!=0)  {  
									while(odbc_fetch_row($rs))  {  
										$dbusername=odbc_result($rs,"PractitionerID");;  
										$dbpassword=odbc_result($rs,"Password");  
									}  

									echo "<br><br><p align=\"center\"> Database!  <br> Username: ".$dbusername."<br> Password: ".$dbpassword."</p>";
								
									if($practitioner_number == $dbusername && $password_login == $dbpassword)  {  
										odbc_close($conn);
										session_start();  
										$_SESSION["session_practitioner"]=$practitioner_number;  
										
										/* Redirect browser */  
										header("Location: login_success.php");  
										
									} else {  
										echo "<p align=\"center\"> <br> Invalid username or password!</p> <br>";  
										odbc_close($conn);
									}
								}  else {
									echo "<p align=\"center\"> <br> Invalid username or password!</p> <br>";
									odbc_close($conn);
								}
								
								
							} else {  
								echo "<p align=\"center\"> <br> All fields are required! </p> <br>";
							}
						}  
						
						
						


					?>

				</div>
			</div>
		</section>
		
	</main>
	
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


</body>
</html>
