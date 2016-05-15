<?php
//require  'Dbconnection.php';
require 'medoo.php';

class Journal
{
	private static $Patient = '';
	private static $Doctor = '';
	private static $Comment = '';
	private static $patternName = '^[A-Za-z0-9_]{1,15}$';
	
	function __construct($patient, $doctor, $comment) 
	{
		self::$Patient = $this->clean($patient);
		self::$Doctor = $this->clean($doctor);
		self::$Comment = $this->clean($comment);		
		if ($this->check_length(self::$Patient, 1, 16) || $this->check_length(self::$Doctor, 1, 16)) 
			throw new Exception("Неверно заполнены поля!");	
	}		
	
	function clean($value = "") 
	{
		$value = trim($value);
		$value = stripslashes($value);
		$value = strip_tags($value);
		$value = htmlspecialchars($value);
	
		return $value;
	}

	function check_length($value = "", $min, $max) 
	{
		$result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
		
		return $result;
	}
	
	function save() 
	{			
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => Dbconnection::get_dbname(),
		'server' => Dbconnection::get_server(),
		'username' => Dbconnection::get_user(),
		'password' => Dbconnection::get_pass()));	
		
		$datas = $database->select("patients", array(
		"id"),
		array(
		"name" => self::$Patient
		));		
		$ClientID = $datas[0]['id'];	
		
		$datas = $database->select("doctors", array(
		"id"),
		array(
		"doctor" => self::$Doctor
		));		
		$MasterID = $datas[0]['id'];
		
		if ($ClientID == '' || $MasterID == '') 
		{
			throw new Exception("Указанные имена отсутствуют в базе!");	
			return;
		}
		echo $ClientID;
		echo $MasterID;
		
		$database->insert(Dbconnection::get_table(), array(
		"note_id" => $ClientID,
		"doctor_id" => $MasterID,
		"comment" => self::$Comment));	
		
	}	
	
	function show_journal() 
	{		
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => Dbconnection::get_dbname(),
		'server' => Dbconnection::get_server(),
		'username' => Dbconnection::get_user(),
		'password' => Dbconnection::get_pass()));		
	
		$datas = $database->query("SELECT  `patients`.`name` as patient,  `doctors`.`doctor` as doctor,  `journal`.`comment` 
		FROM  `journal` ,  `patients` ,  `doctors` 
		WHERE  `journal`.`note_id` =  `patients`.`id` &&  `journal`.`doctor_id` =  `doctors`.`id` ")->fetchAll();

		return $datas;		
	}
	
	
	function delete_all_notes()
	{
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => Dbconnection::get_dbname(),
		'server' => Dbconnection::get_server(),
		'username' => Dbconnection::get_user(),
		'password' => Dbconnection::get_pass()));		
		
		$database->delete(Dbconnection::get_table(), array("id[>]" => "1"));
	}
	
	function get_form($action,$actionshow)
    {
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => Dbconnection::get_dbname(),
		'server' => Dbconnection::get_server(),
		'username' => Dbconnection::get_user(),
		'password' => Dbconnection::get_pass()));
		
		$data1 = $database->select("doctors", array(
		"doctor"));
		
		$data2 = $database->select("patients", array(
		"name"));
		
		foreach($data1 as $data)
		{
			$masters = $masters."<option>".$data["doctor"]."</option>";
		}
		
		foreach($data2 as $data)
		{
			$clients = $clients."<option>".$data["name"]."</option>";
		}
		$form = "<form id=\"input\" action=".$action." method=\"get\">	
		<label for=\"alpha\">Patient</label><br/>
		<select name=\"Patient\">"
		.$clients.
		"</select><br/>
		<label for=\"alpha\">Doctor</label><br/>
		<select name=\"Doctor\">"
		.$masters.
		"</select><br/>			
		<label for=\"alpha\">Comment</label><br/>
		<input type=\"alpha\" name=\"Comment\" placeholder=\"Comment\"> <br/><br/>	
		<input type=\"submit\" name=\"submit\" value=\"submit\">	<br/>	
		</form>
		<form>
			<p><button formaction=".$actionshow.">ShowJournal</button></p>
		</form>	";
        return $form;
    }
	
}
?>