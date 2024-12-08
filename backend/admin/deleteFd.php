<?php 

    session_start();
    require_once("../reports/reports.php");

    if(isset($_POST["id"]))
    {
        $feedback_id = $_POST["id"];
        $admin_id = $_SESSION["admin_id"];

        $query = "DELETE FROM tbl_item_feedback WHERE fd_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $feedback_id);
        $stmt->execute();
        echo "success";

        $query2 = "SELECT ac_username FROM tbl_account WHERE account_id = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $admin_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $username = $data["ac_username"];
            $act = "Deleted Feedback ID: $feedback_id";
            $type = "Admin";
            report($conn, $admin_id, $username, $act, $type);
        }
    }

?>