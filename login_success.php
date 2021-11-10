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
	
	<?php
	  //include 'index.html'
	?>

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
			<div class="container">
				<div class="row">
					<h2 class="section_title" align = "center"> Login Success! </h2> <br>
					
					<!-- Success_message -->
					<p align="center"> Congrats you are a registered practitioner!</p>
					<?php
						session_start();
						$practitioner_number = $_SESSION["session_practitioner"];
						echo "<p align=\"center\"> Your practitioner ID is PR".$practitioner_number."</p>";
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
