<?php
	session_start();
	include("db-connection.php");
	$username = $_POST["user"];
	$password = $_POST["pass"];

	try{
		if(isset($username)){
			$_SESSION["username"] = $username;
			$query = "SELECT * FROM users WHERE username = :username";
			$stmt = $db -> prepare($query);
			$stmt->bindValue(':username',$username);
			$stmt->execute();
			$row = $stmt -> fetch(PDO::FETCH_ASSOC);
			if(password_verify($password,$row['password'])){
				header("Location: carpooling.php");
			}
			else{
				$error="Invalid username or password";
				header("Location: ../index.php?error=$error"); 
			}
		}
	}catch(PDOException $e){
		file_put_contents('log.txt',$e->getMessage(),FILE_APPEND);
	}
	$db = null;
?>
