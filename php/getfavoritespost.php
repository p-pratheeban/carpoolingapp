<?php
	include("db-connection.php");
	try{
			$query = "SELECT u.username,t.trip_text, t.created_date FROM trips t, users u, favorites f where f.user_id = u.user_id AND f.trip_id = t.trip_id";
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