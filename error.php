<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Error</title>
	<link rel="stylesheet" href="css/style_sheet_new.css">
	<!-- <script src="js/main.js"></script> -->
</head>

<body>
	<?php
		include 'index2.html';
        //Grab information of the patient ID from the search page
        session_start();
        
        if(! isset($_SESSION["session_practitioner"])) {
            header("Location:login.php");
        }
        
        $practitioner_number = $_SESSION["session_practitioner"];
		$practitioner_name = $_SESSION["session_practitioner_name"];
	?>
		<div class="main">
            <br><br><br><br><br><br><br>
            <h2 align="center"> Oops! There seems to be an error with the database connection... </h2>
            <h2 align="center"> Please contact admin for support or direct to a different page using the naviagtion bar. </h2>
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
			// document.getElementById("patients").classList.add("sidenav__link--anchor-primary");
			document.getElementById("heading").innerText = "Error";
			// Change this PR Name to the PR that is logged in 
			document.getElementById("practitioner").innerText = "Dr. <?php echo $practitioner_name;?>";
		</script>
</body>

</html>