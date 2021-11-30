<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Test - Patient Profile Summary</title>
	<link rel="stylesheet" href="css/style_sheet.css">
	<script type="text/javascript" src="js/myscript.js"> </script> 
	<!-- <link href="css/html_layout_styles.css" rel="stylesheet" type="text/css"> -->
	<!-- <script src="js/main.js"></script> -->
</head>

<body>
    <?php
        include 'index.html';
    ?> 

    <header class="header">
        <h1 class="page_title" align="center"> Patient Summary</h1>                      
    </header>
    <article class="main">
        <section id="patient_details_section">
                <div class="container">
                    <div class="row patient_details">
                        <?php
                            $patient_number = "001";
                            echo "<br> <p align=\"center\"> Patient ID is PA".$patient_number." </p> <br>";

                            $conn = odbc_connect('z5254640', '', '',SQL_CUR_USE_ODBC);
                            // echo "Hello";

                            $sql = "SELECT * FROM Patient WHERE PatientID={$patient_number}";

                            //Used to check the connection to the database was successful
                                                
                            if(!$conn){ 
                                exit("Connection Failed: ". $conn); 
                            } else { 
                                echo ("<p align=\"center\"> Connection Successful! </p>");
                            }

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
                                //Write code to deal with a 2 digit or 3 digit patient ID?
                                echo "<h2 class=\"section_title\" align = \"left\">".$row["FirstName"]." ".$row["LastName"]." (PA00".$row["PatientID"].") </h2> <br>";
                                echo "<p><b>Gender: </b>".$row["Gender"]."</p><br>";
                                echo "<p><b>Room Number: </b>".$row["RoomNumber"]."</p><br>";
                                echo "<p><b>Date of Birth: </b>".$row["DOB"]."</p><br>";
                                //echo "<p><b>Patient Weight: </b>".$row["Gender"]."</p><br>";
                            } 


                            echo "<br><p align=\"center\">total No. of rows:".$items."</p>";

                            echo "<br><p align=\"center\"> Rows:".$row["Gender"]."</p>";

                            

                            // odbc_close($conn);

                            // $rs = odbc_exec($conn,$sql);

                            // if($items!=0)  {  
                            // 	while($array = odbc_fetch_array($rs))  {  
                            //     }
                            // }  
                            echo  "<br><p align=\"center\"> Rows:".$Full_Name."</p>";
                        ?>
                </div>
			</div>
		</section>
        <section id="patient_details_section">
			<div class="container">
				<div class="row patient_details">

                    <h2 class="section_title" align = "left"> <?php echo $Full_Name ?> (PA001) </h2> <br>
                    <div class="patient_specifics">
                        <?php 
                            echo  "<br><p align=\"center\"> Rows:".$Full_Name."</p>";
                        ?>
                        <p><b>Gender:</b> Male</p> <br>
                        <p><b>Room Number:</b> 3</p> <br>
                        <p><b>DOB:</b> 30/09/1995</p> <br>
                        <p><b>Patient Weight:</b> 85 kg</p> <br>
                        <p><b>Diet Regime:</b> Normal</p> <br>
                        <p><b>Practitioner:</b> Michelle Johnson (PR002)</p> <br> <br>
                    </div>
                </div>
			</div>
		</section>
    </article>

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