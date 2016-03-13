<?php
/* 
 * Author: Muhammad Zubair
 * Description: process posting a trip request into the database
 */
    include("db-connection.php");    
  
     const GET_POST = "
          SELECT trips.*, users.username FROM trips INNER JOIN users ON trips.user_id = users.user_id ORDER BY trips.trip_id DESC";
         try {
            
        $stmt = $db->prepare(GET_POST);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($data);
            
    
        } catch(PDOException $ex) {
            var_dump($ex->getMessage());
    }

?>