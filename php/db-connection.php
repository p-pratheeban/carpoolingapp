<?php
	$dbname = "carpoolingapp";
	$host = "localhost";
	$user = "root";
	$pass = "";
	try{
		$db = new PDO("mysql:dbname=$dbname;host=$host",$user,$pass);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "Database connected successfully";
	}catch(PDOException $e){
		file_put_contents('log.txt',$e->getMessage(),FILE_APPEND);
	}
?>