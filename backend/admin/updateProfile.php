<?php 

session_start();
require_once("../reports/reports.php");

 if(isset($_POST["account_id"]) && isset($_POST["fName"]) && isset($_POST["mName"]) && isset($_POST["lName"]) && isset($_POST["contact"]) && isset($_POST["address"]) && isset($_POST["password"]))
{
    $account_id = $_POST["account_id"];
    $first_name = $_POST["fName"];
    $middle_name = $_POST["mName"];
    $last_name = $_POST["lName"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $admin_id = $_SESSION["admin_id"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE tbl_account_details SET first_name=?, middle_name=?, last_name=?, contact=?, address=? WHERE account_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $first_name, $middle_name, $last_name, $contact, $address, $account_id);
    $stmt->execute();

    $query2 = "UPDATE tbl_account SET acc_password=? WHERE account_id=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("si", $hashedPassword, $account_id);
    $stmt2->execute();

    $query3 = "SELECT acc_username FROM tbl_account WHERE account_id = ?";
    $stmt3 = $conn->prepare($query3);
    $stmt3->bind_param("i", $admin_id);
    $stmt3->execute();
    $result = $stmt3->get_result();
    if($result->num_rows > 0){
        $data = $result->fetch_assoc();
        $username = $data["acc_username"];
        $act = "Updated Profile ID: $account_id";
        $date = date("Y-m-d");
        report($conn, $admin_id, $username, $date, $act);
    }

    echo "success";
    exit();
}

?>