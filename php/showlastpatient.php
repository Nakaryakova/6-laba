<?php
require  'dbconnection.php';
require  'patient.php';
session_start();


$connect = new Dbconnection('doctorru', 'root', '', 'patients', 'localhost');

//Выводит последнюю добавленную
$datas = Patient::show_last();
foreach($datas as $data)
{
	echo "Name:" . $data["name"] . "<br/>". " - Telephone:" . $data["telephone"] . "<br/>". " - Ail:" . $data["ail"] . "<br/><br/>";
}

?>