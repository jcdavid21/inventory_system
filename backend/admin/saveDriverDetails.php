<?php 

session_start();
require_once("../reports/reports.php");

if(isset($_POST["item_id"]) && isset($_POST["driverName"]) && isset($_POST["driverContact"]) && isset($_POST["driverRemarks"]))
{
    $item_id = $_POST["item_id"];
    $driverName = $_POST["driverName"];
    $driverContact = $_POST["driverContact"];
    $driverRemarks = $_POST["driverRemarks"];
    $account_id = $_SESSION["admin_id"];

    $query1 = "INSERT INTO tbl_rider_details (item_id, rider_name, rider_contact, rider_remarks) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query1);
    $stmt->bind_param("isss", $item_id, $driverName, $driverContact, $driverRemarks);
    $stmt->execute();

    $query2 = "SELECT ac_username FROM tbl_account WHERE account_id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $account_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    if($result->num_rows > 0){
        $data = $result->fetch_assoc();
        $username = $data["ac_username"];
        $act = "Updated Driver Details for Item ID: $item_id";
        $type = "Admin";
        report($conn, $account_id, $username, $act, $type);
    }

    echo "success";

    $stmt->close();
    $conn->close();
}


?>