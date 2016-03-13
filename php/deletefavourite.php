<?php
	session_start();
	if(!isset($_SESSION['username'])){
			header("Location:./../index.php");
	}
	include("db-connection.php");
	try{
			//Get Trip Id
			$trippost = $_POST['trippost'];
			$query = "SELECT trip_id FROM trips WHERE trip_text = :triptext";
			$stmt = $db -> prepare($query);
			$stmt->bindValue(':triptext',$trippost);
			$stmt->execute();
			$row = $stmt -> fetch(PDO::FETCH_ASSOC);
			$tripid = $row['trip_id'];
			
			//Get User Id
			$username = $_SESSION["username"];
			$query1 = "SELECT user_id FROM users WHERE username = :username";
			$stmt = $db -> prepare($query1);
			$stmt->bindValue(':username',$username);
			$stmt->execute();
			$row = $stmt -> fetch(PDO::FETCH_ASSOC);
			$userid = $row['user_id'];
			
			//Delete Favourite
			$query2 = "DELETE FROM favorites WHERE user_id=:user_id AND trip_id=:tripid";
			$stmt = $db -> prepare($query2);
			$stmt->bindValue(':user_id',$userid);
			$stmt->bindValue(':tripid',$tripid);
			$stmt->execute();
			
		
	}catch(PDOException $e){
		file_put_contents('log.txt',$e->getMessage(),FILE_APPEND);
	}
	$db = null;
?>
