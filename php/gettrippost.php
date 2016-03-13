<?php
	include("db-connection.php");
	try{
			$query = "SELECT u.username,t.trip_text, t.created_date, f.favorite_id 
			FROM trips t 
			INNER JOIN users u ON t.user_id = u.user_id 
			LEFT JOIN
			favorites f ON f.trip_id = t.trip_id
			order by t.created_date DESC";
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