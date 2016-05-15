<?php
header("Content-Type: text/html; charset=utf-8"); 
require  'dbconnection.php';
require  'journal.php';
//Объявляем переменные:
$Patient = $_GET["Patient"];
$Doctor = $_GET["Doctor"];
$Comment = $_GET["Comment"];
$connect = new Dbconnection('doctorru', 'root', '', 'journal', 'localhost');
try
{
	$journal = new Journal($Patient, $Doctor, $Comment);	
	$journal->save();
	echo "Готово!";
}
catch (Exception $e)
{
	echo $e->getMessage();
	echo $Patient;
	echo $Doctor;
}
?>