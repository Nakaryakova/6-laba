<?php
	
class Dbconnection
{
	private static  $dbname = '';//'pcmaster';
	private static  $user = '';//'pcmasterru';
	private static  $pass = '';//'pcmaster';
	private static  $table = '';//'clients';
	private static  $server = '';//localhost
	
	function __construct($name, $usr, $pw, $tbl, $serv) 
	{
       self::$dbname = $name;
	   self::$user = $usr;
	   self::$pass = $pw;
	   self::$table = $tbl;
	   self::$server = $serv;	  
	}

	function get_dbname()
	{
		return self::$dbname;
	}
	
	function get_user()
	{
		return self::$user;
	}
	
	function get_pass()
	{
		return self::$pass;
	}
	
	function get_table()
	{
		return self::$table;
	}
	
	function get_server()
	{
		return self::$server;
	}
	
}
?>