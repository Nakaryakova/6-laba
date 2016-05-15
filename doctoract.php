<!DOCTYPE html>
<html>
<head>	
	<title></title>
</head>
<body>	
	<?php
		require 'php/doctor.php';
		echo Doctor::get_form('php/todoctor.php','php/showdoctors.php','php/showlastdoctor.php');
	?>	
</body>
</html>