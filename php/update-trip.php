<?php

/* 
 * Author: Muhammad Zubair
 * Description: process updating a trip request into the database
 */
include("db-connection.php");

session_start();
$data = array('result', 'failed');
   
    if (isset($_POST['status'])) {
        $status = filter_input(INPUT_POST, "status");
    } else {
        $status = '';
    }

    if (isset($_POST['status_id'])) {
        $status_id = filter_input(INPUT_POST, "status_id");
    } else {
        $status_id = '';
    }

    if ($status != "" && $status_id != "") {
    $username = $_SESSION["username"];
    $query2 = "SELECT user_id FROM users WHERE username = :username";
    $stmt = $db -> prepare($query2);
    $stmt->bindValue(':username',$username);
    $stmt->execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    $user_id = $row['user_id'];  
     $stmt = $db->prepare("UPDATE trips SET trip_text = :trip_text WHERE "
                . "trip_id = :trip_id AND user_id = :user_id");
        $stmt->execute(array(':trip_text' => $status, ':trip_id' => $status_id,
            ':user_id' => $user_id));

        $data = array('result', 'success');
}

echo json_encode($data);
