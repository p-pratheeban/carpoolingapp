<?php
/* 
 * Author: Muhammad Zubair
 * Description: process posting a trip request into the database
 */
    session_start();
    include("db-connection.php");
    const INSERT_POST = "
        INSERT INTO trips VALUES (NULL, :postTrip, :userID, :createdDate)
    ";
  
     const GET_POST = "
        SELECT * FROM trips WHERE trip_id = :tripid
        ORDER BY trip_id DESC
    ";
        
        try { 
            //Get User Id
            $username = $_SESSION["username"];
            $query2 = "SELECT user_id FROM users WHERE username = :username";
            $stmt = $db -> prepare($query2);
            $stmt->bindValue(':username',$username);
            $stmt->execute();
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            $userid = $row['user_id'];           

            $stmt = $db->prepare(INSERT_POST);
            $stmt = $stmt->execute(array(
                    ':postTrip' => $_POST['postTripText'],
                    ':userID' =>$userid,
                    ':createdDate' => date("Y-m-d H:i:s"),
                ));
            
                
        $id = $db->lastInsertId();
      
        $stmt = $db->prepare(GET_POST);
        $stmt->execute(array(':tripid' => $id));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($data);
        


        } catch(PDOException $ex) {
            var_dump($ex->getMessage());
        }

       
?>