<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register Page</title>
<link href="html_layout_styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="myscript.js"> </script> 


</head>
<body>
	<!-- Header -->
    <nav>
        <ul class="nav_option_list">
            <li class="nav_option"><a class="nav_link" href="./login.php"> Login </a></li>
            <li class="nav_option"><a class="nav_link" href="./register.php">Register</a></li>
        </ul>		

    </nav>

		<h1 class="page_title" align="center"> Welcome to the Info Sis Nursing Home Online System</h1>
													  
	</header>

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
					<h2 class="section_title" align = "center"> New Practitioner Registration Form </h2> <br>
					
					<!-- Form -->
					<form id="register_form" onsubmit="return validInfo()"  method="GET" action="practitioner_home_page.html" align = "center">

                        <!-- Is this assigned as an autonumber when the new practitioner is added into the system?-->
                        <label for="practioner_ID">Practitioner ID:</label> 
						<input type="text" id="practioner_ID" name="practioner_ID" placeholder="PR000" onChange="validUsername()"> <br> <br>
						<!-- <p id="username_result" class="result_message"> </p> <br> -->

                        <label for="fname">First name:</label> 
						<input type="text" id="fname" name="fname" placeholder="Enter First Name" onChange="validFName()">
						<p id="fname_result" class="result_message"> </p><br>

                        <label for="lname">Last name:</label>
						<input type="text" id="lname" name="lname" placeholder="Enter Last Name" onChange="validLName()">
						<p id="lname_result" class="result_message"> </p> <br>

                        <label for="email_address">Email:</label> 
						<input type="text" id="email_address" name="email_address" placeholder="Enter Email" onChange="validEmail()">
						<p id="email_result" class="result_message"> </p> <br>  

                        <label for="contact_number">Contact Number:</label> 
						<input type="text" id="contact_number" name="contact_number" placeholder="Enter Contact Number" onChange="validNumber()">
						<p id="contact_result" class="result_message"> </p> <br>  

						<label for="password">Password:</label>
						<input type="password" id="password" name="password" placeholder="Enter Password" onChange="validPassword()">
						<p id="password_result" class="result_message"> </p> <br>

						<label for="re_password">Re-enter Password:</label>
						<input type="password" id="re_password" name="re_password" placeholder="Repeat Password" 
						onChange="validPasswordMatch()">
						<p id="password_match_result" class="result_message"> </p><br>
						
						
						<label for="office_num"> Office Location:</label>
						<input type="text" id="office_num" name="office_num" maxlength="3" placeholder="E.g. 1A" onChange="validOfficeNumber()">
						<p id="office_result" class="result_message"> </p> <br> <br>
						
						<!-- Submit and cancel buttons -->
						<input type="button" value="Cancel" id="cancel" onclick="window.location='./register.html'"/>
						<button type="submit" id="submit" value="Register">Register</button>

					</form>

				</div>
			</div>
		</section>
		
	</main>
	
	<!-- End Main Content -->
	
	<!-- Footer -->
	<div class="row footer_row">
		<a href="#" class="footer_anchor">
			<figure class="footer_logo">
				<img src="static/images/HMCDC logo__.png" class="footer_logo_img" alt="HMCDC Logo">
			</figure>
		</a>
		<div class="footer_copyright">Copyright ?? 2021 Info Sis Association </div>
	</div>


</body>
</html>
