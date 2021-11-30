<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Patient Profile Summary</title>
	<link rel="stylesheet" href="css/style_sheet.css">
	<script type="text/javascript" src="js/myscript.js"> </script> 
	<!-- <link href="css/html_layout_styles.css" rel="stylesheet" type="text/css"> -->
	<!-- <script src="js/main.js"></script> -->
</head>

<body>
	<!-- Header -->
    <?php
        include 'index.html';
    ?> 
    <div class="wrapper">

    <header class="header">

		<h1 class="page_title" align="center"> Patient Summary</h1>
													  
	</header>

	<!-- Main Content -->
    <article class="main">
	

        <?php
            $patient_number = "001";
            echo "<br> <p align=\"center\"> Patient ID is PA".$patient_number." </p> <br>"

            // $conn = odbc_connect('z5254640', '', '',SQL_CUR_USE_ODBC);

            // echo $conn;
								
			// $sql = "SELECT * FROM Patient WHERE PatientID={$patient_number}";

			// //Used to check the connection to the database was successful
								
		    // if(!$conn){ 
			// 	exit("Connection Failed: ". $conn); 
			// } else { 
			// 	echo ("<p align=\"center\"> Connection Successful! </p>");
			// }
								
			// //Executing the sql command and getting the result in rs
			// $rs = odbc_exec($conn,$sql);

            // //While loop as a counter to determine the amount of rows were returned
			// //If result is zero then they are a new registrant and if not the system will either check for whether they are banned or just a duplicate 
			// $items = 0;
			// while ($row = odbc_fetch_array($rs)){
			// 	$items++;                          
			// } 
			// echo "<br><p align=\"center\">total No. of rows:".$items."</p>";

            // odbc_close($conn);

        ?>



		<section id="patient_details_section">
			<div class="container">
				<div class="row patient_details">
                    <!-- <button class="patient_edit_button" align = "left" onclick="./patient_edit_page" id="myButton" class="float-left submit-button" >Edit</button> -->
					<h2 class="section_title" align = "left"> John Sutton (PA001) </h2> <br>
					<div class="patient_specifics">
                        <p><b>Gender:</b> Male</p> <br>
                        <p><b>Room Number:</b> 3</p> <br>
                        <p><b>DOB:</b> 30/09/1995</p> <br>
                        <p><b>Patient Weight:</b> 85 kg</p> <br>
                        <p><b>Diet Regime:</b> Normal</p> <br>
                        <p><b>Practitioner:</b> Michelle Johnson (PR002)</p> <br> <br>
                    </div>
                    <h3 align = "left"> Emergency Contact Details: </h3> <br>
					
                    <div class="patient_specifics">
                        <p><b>Name:</b> Henry Sutton</p> <br>
                        <p><b>Relation:</b> Son</p> <br>
                        <p><b>Phone Number:</b> 93333333</p> <br>
                        <p><b>Email:</b> <a href="mailto:h.sutton@hotmail.com">h.sutton@hotmail.com</a></p> <br>
                        <br>
                    </div>   
                    
                    <h3 align = "left"> Medicare Details: </h3> <br>
					
                    <div class="patient_specifics">
                        <p><b>Medicare Number:</b>  1266 95291 6</p> <br>
                        <p><b>Reference Number:</b> 1</p> <br>
                        <p><b>Expiry Date:</b> 01/04/2023</p> <br>
                        <br>
                    </div>   

                    <h3 align = "left"> Medication Table: </h3> <br> <br>
                    
                        <table class="specific_patient_med_table"> 
                            <tr> <th valign="middle">Medication Name </th> <th valign="middle"> Dosage </th> <th valign="middle"> Route</th><th valign="middle"> Type</th> <th valign="middle"> Frequency</th><th valign="middle"> Active Ingredient</th><th valign="middle"> Condition</th><th valign="middle"> Instructions for Use</th> </tr> 
                            <tr> <td valign="middle">Panadol 500 mg</td> <td align="center" valign="middle">2</td> <td valign="middle">Oral tablet</td> 
                                <td valign="middle">PRN</td> <td valign="middle">Every 4-6 hours as required </td> <td valign="middle">Paracetomol</td>
                                <td valign="middle">Temporary relief of pains, aches and fevers</td><td valign="middle">Maximum 8 tablets in 24 hours</td> </tr> 
                            
                        </table>
                    
                        <br><h3 align = "left"> Notes: </h3> <br>
					
                    <div class="patient_specifics">
                        <p>N/A</p> <br>
                        <p>Refer to database to grab any notes</p> <br>
                        
                        <br>
                    </div>   
                    
				</div>
			</div>
		</section>
		
	
    </article>
    <aside class="aside aside-1">
        Aside 1 <br> <br>
        <img class="patient_pic_details" src="/images/old_man.jpg" alt="old man">
    </aside>
    <aside class="aside aside-2">Aside 2</aside>
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

    </div>
</body>
</html>
