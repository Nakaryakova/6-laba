<?php
//require  'Dbconnection.php';
require 'medoo.php';

class Doctor
{
	private static $Doctor = '';
	private static $Specialization = '';
	private static $patternName = '^[A-Za-z0-9_]{1,15}$';
	
	function __construct($dc, $spec) 
	{
		self::$Doctor = $this->clean($dc);
		self::$Specialization = $this->clean($spec);
		if ($this->check_length(self::$Doctor, 1, 25) || $this->check_length(self::$Specialization, 0, 25))
			throw new Exception("Неверно заполнены поля!");
		if($this->check_Name())		
			throw new Exception("Пользователь с указанным именем уже есть в базе!");	
	}	

	function check_Name()
	{
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => Dbconnection::get_dbname(),
		'server' => Dbconnection::get_server(),
		'username' => Dbconnection::get_user(),
		'password' => Dbconnection::get_pass()));
		
		$datas = $database->select(Dbconnection::get_table(), array(
		"id"),
		array(
		"doctor" => self::$Doctor
		));
		if($datas[0]['id'] == '')
				return false;
			else
				return true;
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
		
		$database->insert(Dbconnection::get_table(), array(
		"doctor" => self::$Doctor,
		"specialization" => self::$Specialization));	
		
	}	
	
	function resave_last() 
	{		
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => Dbconnection::get_dbname(),
		'server' => Dbconnection::get_server(),
		'username' => Dbconnection::get_user(),
		'password' => Dbconnection::get_pass()));
		
		$data = $database->query("select max(id) from ".Dbconnection::get_table())->fetchAll();					
		$ID = $data[0]['max(id)'];		
	
		$database->insert(Dbconnection::get_table(), array(
		"doctor" => self::$Doctor,
		"specialization" => self::$Specialization),	
		array(
		"id" => $ID
		));			
	}
	
	function show_all() 
	{		
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => Dbconnection::get_dbname(),
		'server' => Dbconnection::get_server(),
		'username' => Dbconnection::get_user(),
		'password' => Dbconnection::get_pass()));		
	
		$datas = $database->select(Dbconnection::get_table(), array(
		"doctor",
		"specialization"));

		return $datas;		
	}
	
	function show_last() 
	{		
		$database = new medoo(array(
		'database_type' => 'mysql',
		'database_name' => Dbconnection::get_dbname(),
		'server' => Dbconnection::get_server(),
		'username' => Dbconnection::get_user(),
		'password' => Dbconnection::get_pass()));		
		
		$data = $database->query("select max(id) from ".Dbconnection::get_table())->fetchAll();					
		$ID = $data[0]['max(id)'];
		
		$datas = $database->select(Dbconnection::get_table(), array(
		"doctor",
		"specialization"),
		array(
		"id" => $ID
		));
		
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
	
	//function __toString()
	function get_form($action,$actionshow,$actionshowlast)
    {
		$form = "<form id=\"input\" action=".$action." method=\"get\">	
		<label for=\"alpha\">Name</label><br/>
		<input type=\"text\" name=\"Name\" pattern=".self::$patternName." placeholder=\"Name\" required> <br/>
		<label for=\"alpha\">Specialization</label><br/>
		<input type=\"text\" name=\"Spec\" pattern=".self::$patternName." placeholder=\"Specialization\" > <br/>
		<input type=\"submit\" name=\"submit\" value=\"submit\">	<br/>	
	</form>	
	
	<form>
		<p><button formaction=".$actionshow.">Show All Doctors</button></p>
	</form>	
	<form>
		<p><button formaction=".$actionshowlast.">Show Last Added Doctor</button></p>
	</form>";
        return $form;
    }
	
}
?>