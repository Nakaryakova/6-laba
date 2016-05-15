<?php 
require 'medoo.php';


class Patient
{
	private static $Name = '';	
	private static $Tel = '';	
	private static $Ail = '';	
	private static $patternName = '^[A-Za-z0-9_]{1,15}$';
	private static $patternTel = '(\+?\d[- .]*){11}';
	//private static $lastID = '';
	
	function __construct($nm, $tl, $ai) 
	{
		self::$Name = $this->clean($nm);
		self::$Ail = $this->clean($ai);
		self::$Tel = $this->clean($tl);		
		if ($this->check_length(self::$Name, 2, 16) || $this->check_length(self::$Tel, 2, 15) || $this->check_length(self::$Ail, 2, 15)) 
			throw new Exception("Неверно заполнены поля!");	
		if($this->check_Name())		
			throw new Exception("Пользователь с указанным именем уже есть в базе, пожалуйста, укажите другое имя!");	
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
		"name" => self::$Name
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
		"name" => self::$Name,
		"ail" => self::$Ail,
		"telephone" => self::$Tel));	
		
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
		
	
		$database->update(Dbconnection::get_table(), array(
		"name" => self::$Name,
		"ail" => self::$Ail,
		"telephone" => self::$Tel),
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
		"name",
		"ail",
		"telephone"));

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
		"name",
		"ail",
		"telephone"),
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
			<label for=\"alpha\">Что вас беспокоит?</label><br/>
			<select name=\"Ail\">
				<option>Uho</option>
				<option>Gorlo</option>
				<option>Nos</option>
				<option>Drugoe</option>
			</select><br/>
			<input id=\"alpha\" name=\"Name\" type=\"text\" pattern=\"".self::$patternName."\" placeholder=\"Введите ваше имя\" required> <br/>							
			<input type=\"tel\" name=\"Tel\" pattern=\"".self::$patternTel."\" placeholder=\"Введите ваш телефон\" required> <br/><br/>	
			<input type=\"submit\" name=\"submit\" value=\"Отправить заявку\">	<br/>									
		</form>
		<form>
		<p><button formaction=".$actionshow.">Show All Notes</button></p>
		</form>		
		<form>
		<p><button formaction=".$actionshowlast.">Show All Last Added Note</button></p>
		</form>	";
        return $form;
    }
	
}
?>