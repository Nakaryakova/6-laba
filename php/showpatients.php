<?php
require  'dbconnection.php';
require  'patient.php';
session_start();
//Объявляем переменные:

$connect = new Dbconnection('doctorru', 'root', '', 'patients', 'localhost');

//Выводит все записи
$datas = Patient::show_all();
foreach($datas as $data)
{
	echo "Name:" . $data["name"] . "<br/>". " - Telephone:" . $data["telephone"] . "<br/>". " - Ail:" . $data["ail"] . "<br/><br/>";
}
?>