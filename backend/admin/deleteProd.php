<?php

session_start();
require_once("../reports/reports.php");

if(isset($_POST["prod_id"])){

    $prod_id = $_POST["prod_id"];
    $account_id = $_SESSION["admin_id"];

    $query = "DELETE FROM tbl_products WHERE prod_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $prod_id);
    $stmt->execute();

    $query2 = "SELECT ac_username FROM tbl_account WHERE account_id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $account_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    if($result->num_rows > 0){
        $data = $result->fetch_assoc();
        $username = $data["ac_username"];
        $act = "Deleted Product ID: $prod_id";
        $type = "Admin";
        report($conn, $account_id, $username, $act, $type);
    }

    echo "deleted";

    $stmt->close();
    $conn->close();
}


?>