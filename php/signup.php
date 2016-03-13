//Add a New User 

<?php 
	session_start();
	include("db-connection.php"); 
?>
<h3>Thank you!</h3>

<?php 
	
	try{
		// prepare sql and bind parameters
		$query = "INSERT INTO users VALUES (NULL, :username, :password, :email,CURDATE())";
		$stmt = $db -> prepare($query);
		$stmt -> bindParam(':username',$user);
		$stmt -> bindParam(':password',$pash_hash);
		$stmt -> bindParam(':email',$email);
		// insert a row
		$user =  $_POST['username'];
		$pass = $_POST['newpassword'];
		$email = $_POST['email'];
		$pash_hash = password_hash($pass,PASSWORD_DEFAULT);
		
		$stmt->execute();
		$_SESSION["username"] = $user;
		header("Location: carpooling.php");
		
	}catch(PDOException $e){
		file_put_contents('log.txt',$e->getMessage(),FILE_APPEND);
	}
	$db = null;


?>
