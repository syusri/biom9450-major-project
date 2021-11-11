<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AgedCare</title>
	<link rel="stylesheet" href="css/styles.css">
	<!-- <script src="js/main.js"></script> -->
</head>

<body>
	<?php
		include_once 'index.html';
	?>
		<div class="main">
			<!-- Breadcrumb -->
			<div class="breadcrumb">
					<p><span class="page--previous">Dashboard</span> > <span class="page--current">Medications and Diet Regimes</span></p>
			</div>
			<div class="patient__container">
				<div class="patient__container--highlight">
					<div class="patient__content">
						<figure class="patient__picture--mask">
							<img src="./img/margaret.jpg" class="patient__picture" alt="Picture of Margaret">
						</figure>
						<div class="patient__bio--brief">
							<h2 id="patient-name">Margaret Smith</h2>
							<p>Room number</p>
						</div>
					</div>

				</div>
			</div>
				
		</div>
		<script type="text/javascript">
			document.getElementById("dashboard").classList.add("sidenav__link--anchor-primary");
			document.getElementById("heading").innerText = "Dashboard";
			document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
		</script>
</body>

</html>