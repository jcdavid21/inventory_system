<?php 
    require_once("../config/config.php");
    
    function report($conn, $user_id, $user_name, $activity_date, $activity)
    {
        $query = "INSERT INTO tbl_logs 
        (user_id, user_name, activity_date, activity) VALUES(?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $user_id, $user_name, $activity_date, $activity);
        $stmt->execute();
    }
    
?>