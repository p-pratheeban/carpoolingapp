<?php
/* 
 * Author: Muhammad Zubair
 * Description: process posting a trip request into the database
 */
    session_start();
    include("db-connection.php");

      
        try {  
            
            $comment = filter_input(INPUT_POST, "source1");
            $item_id = filter_input(INPUT_POST, "source2");

           // $user_id = $_SESSION['userid'];

            $username = $_SESSION["username"];
            $query2 = "SELECT user_id FROM users WHERE username = :username";
            $stmt = $db -> prepare($query2);
            $stmt->bindValue(':username',$username);
            $stmt->execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            $idd= $row['user_id'];
            $len=  strlen($comment);

            if ($comment != "" && $comment != null && $len > 0) {
            $t = time();
            $today = date("Y-m-d H:i:s",$t);
            $stmt = $db->prepare("INSERT INTO comments VALUES(Null, :comment_text, :user_id, :trip_id, :created_date)");
            $stmt->execute(array(':comment_text' => $comment, ':user_id' => $idd, ':trip_id' => $item_id, ':created_date' =>                       $today));
            }


            $stmt2 = $db->prepare("SELECT * FROM comments");
            $stmt2->execute();
            $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rows);
          

        } catch(PDOException $ex) {
            var_dump($ex->getMessage());
        }

        
?>