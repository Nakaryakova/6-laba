<?php
header("Content-Type: text/html; charset=utf-8"); 
require  'dbconnection.php';
require  'journal.php';

$connect = new Dbconnection('doctorru', 'root', '', 'doctors', 'localhost');
//Выводит все записи
$datas = Journal::show_journal();
foreach($datas as $data)
{
	echo "Patient:" . $data["patient"] . "<br/>". " - Doctor:" . $data["doctor"] . "<br/>". " - Comment:" . $data["comment"] . "<br/><br/>";
}
?>