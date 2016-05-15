<?php
header("Content-Type: text/html; charset=utf-8"); 
require  'dbconnection.php';
require  'doctor.php';
//require 'medoo.php';
//Объявляем переменные:
$Doctor = $_GET["Name"];
$Specialization = $_GET["Spec"];
$connect = new Dbconnection('doctorru', 'root', '', 'doctors', 'localhost');
try 
{
	$doctor = new Doctor($Doctor, $Specialization);	
	$doctor->save();	
	echo 'Готово!';
}
catch (Exception $e)
{
	echo $e->getMessage();	
	echo $Doctor;
	echo $Specialization;
}
?>