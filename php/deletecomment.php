<?php
	session_start();
	if(!isset($_SESSION['username'])){
			header("Location:./../index.php");
	}
	include("db-connection.php");
	try{
			//Get Trip Id
			$comment = $_POST['comment'];
			
			//Get User Id
			$username = $_SESSION["username"];
			$query1 = "SELECT user_id FROM users WHERE username = :username";
			$stmt = $db -> prepare($query1);
			$stmt->bindValue(':username',$username);
			$stmt->execute();
			$row = $stmt -> fetch(PDO::FETCH_ASSOC);
			$userid = $row['user_id'];
			echo $username;
			//Delete comment
			$query2 = "DELETE FROM comments WHERE user_id=:user_id AND comment_text=:comment";
			$stmt = $db -> prepare($query2);
			$stmt->bindValue(':user_id',$userid);
			$stmt->bindValue(':comment',$comment);
			$stmt->execute();
			
		
	}catch(PDOException $e){
		file_put_contents('log.txt',$e->getMessage(),FILE_APPEND);
	}
	$db = null;
?>
