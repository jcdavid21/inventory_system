<?php
session_start();
require_once("../reports/reports.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemId = $_POST['item_id'];
    $cancelRemarks = $_POST['cancel_remarks'];

    $query = "UPDATE tbl_cart SET status_id = 5, cancel_remarks = ? WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $cancelRemarks, $itemId);

    if ($stmt->execute()) {
        echo 'Order canceled successfully';
    } else {
        echo 'Error canceling order';
    }
}
?>
