<?php
header("Content-Type: text/html; charset=utf-8"); 
require  'dbconnection.php';
require  'patient.php';
session_start();
if ($_SESSION['test'] == md5($_SERVER['REMOTE_ADDR']))  
{
	//Сообщение, которое вернется пользователю
	$_SESSION['message']='';
	//Объявляем переменные:
	$Ail = $_GET["Ail"];
	$Name = $_GET["Name"];
	$Tel = $_GET["Tel"];	
	$connect = new Dbconnection('doctorru', 'root', '', 'patients', 'localhost');
	try 
	{
		$patient = new Patient($Name, $Tel, $Ail);
		//if ($_SESSION['saved'] == 'true')
		//{
		//	$note->resave_last();
		//}
		//else
		//{
		$patient->save();
		//$_SESSION['saved'] = 'true'; 
		//}	
		$_SESSION['message'] = $Name.' Ваша запись успешно занесена в базу, мы вам обязательно перезвоним на ваш номер - '.$Tel;
	}
	catch (Exception $e)
	{
		//echo $e->getMessage();
		$_SESSION['message'] = $e->getMessage();
	}
}
else {$_SESSION['message'] = 'Доступ закрыт.';}
back();
?>

<?php
function back()
{
	$back = $_SERVER['HTTP_REFERER']; 
	echo "
	<html>
	  <head>
	   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
	  </head>
	</html>";
}
?>
