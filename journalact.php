<!DOCTYPE html>
<html>
<head>	
	<title></title>
</head>
<body>
	<?php
		require  'php/dbconnection.php';
		require  'php/journal.php';
		$connect = new Dbconnection('doctorru', 'root', '', 'journal', 'localhost');
		echo Journal::get_form('php/tojournal.php','php/showjournal.php');
	?>
</body>
</html>