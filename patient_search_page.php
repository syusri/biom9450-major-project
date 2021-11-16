<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Patient Summary</title>
	<link rel="stylesheet" href="css/style_sheet_new.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- <script src="js/main.js"></script> -->
</head>
<body>
	<?php
		include_once 'index2.html';
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
					
                    <form class="search_patients" action="action_page.php">
                        <input type="text" placeholder="Search..." name="search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>

                    <br><br><br>
					<p> <b>Showing (n) results for "PA001"</b> </p><br>
                    <table id="patient_list" align="left" width="700" border="1" cellpadding="5"> 
                        <tr> <th width="20%" valign="middle"> Patient Image </th> <th valign="middle"> Patient Details </th> 
                        <tr> <td valign="middle"><img class="patient_pic" src="./img/old_man.jpg" alt="old man"></td> <td align="laft" valign="left">John Sutton (PA003) <br> Room Number: 3</td> </tr>
                        <tr> <td valign="middle"><img class="patient_pic" src="./img/old_man.jpg" alt="old man"></td> <td align="laft" valign="left">John Sutton (PA003) <br> Room Number: 3</td> </tr>
                        <!-- Will need to add in the info with php but for now an example-->
                        <!-- Make each row clickable like a link-->
                        
                    </table>
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
			document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
	</script>

</body>
</html>
