<!DOCTYPE html>
<html>

<head>
	<title>Display Report</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style_sheet.css">
	<script src=""></script>
</head>

<body>
	<?php
		include_once 'index.html';
	?>
	<div class="main">
		<!-- Breadcrumb -->
		<div class="breadcrumb">
				<p><a href="dashboard.php" class="page--previous">Generate Report</a> > <span class="page--current">Display Report</span></p>
		</div>
		
	</div>
	<!-- JavaScript to change PHP template -->
	<script type="text/javascript">
		document.getElementById("patient").classList.add("sidenav__link--anchor-primary");
		document.getElementById("heading").innerText = "Display Report";
		document.getElementById("practitioner").innerText = "Dr. Rosalind Franklin";
	</script>
</body>

</html> 