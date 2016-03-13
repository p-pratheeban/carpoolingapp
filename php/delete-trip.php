<?php
/* 
 * Author: Muhammad Zubair
 * Description: process posting a trip request into the database
 */
    session_start();
    if(!isset($_SESSION['username'])){
			header("Location:./../index.php");
	}
    include("db-connection.php");

$rmvid = filter_input(INPUT_POST, "source11");
$username = $_SESSION["username"];
$query2 = "SELECT user_id FROM users WHERE username = :username";
$stmt = $db -> prepare($query2);
$stmt->bindValue(':username',$username);
$stmt->execute();
$row = $stmt -> fetch(PDO::FETCH_ASSOC);

$idd= $row['user_id'] ;
echo $idd;
$stmt3 = $db->prepare("SELECT user_id FROM trips WHERE trip_id=:id");
$stmt3->execute(array( ':id' => $rmvid));
$rows3 = $stmt3->fetchAll();

foreach ($rows3 as $row) {
  $useriddatabase=$row['user_id'];
}   

if ($rmvid != "" && $rmvid != null && $idd == $useriddatabase) {
    $stmt = $db->prepare("DELETE FROM trips WHERE trip_id=:tripid");
    $stmt->execute(array( ':tripid' => $rmvid));
    
    $stmt2 = $db->prepare("DELETE FROM comments WHERE trip_id=:tripid");
    $stmt2->execute(array( ':tripid' => $rmvid));

    $stmt3 = $db->prepare("DELETE FROM favorites WHERE trip_id=:tripid");
    $stmt3->execute(array( ':tripid' => $rmvid));
}


echo json_encode($useriddatabase);