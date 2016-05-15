<?php
header("Content-Type: text/html; charset=utf-8"); 
require  'dbconnection.php';
require  'doctor.php';

$connect = new Dbconnection('doctorru', 'root', '', 'doctors', 'localhost');

//Выводит все записи
$datas = Doctor::show_last();
foreach($datas as $data)
{
	echo "Name:" . $data["doctor"] . "<br/>". " - Specialization:" . $data["specialization"] . "<br/><br/>";
}
?>