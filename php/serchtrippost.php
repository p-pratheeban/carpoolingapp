<?php
	session_start();
	include("db-connection.php");
	try{
			$keyword = $_GET['keyword'];
			
			$query = "SELECT u.username,t.trip_text, t.created_date FROM trips t, users u where t.user_id = u.user_id AND t.trip_text LIKE '%$keyword%' order by t.created_date DESC";
			$stmt = $db -> prepare($query);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			header('Content-Type: application/json');
       		echo json_encode($results);	
		
	}catch(PDOException $e){
		file_put_contents('log.txt',$e->getMessage(),FILE_APPEND);
	}
	$db = null;
?>