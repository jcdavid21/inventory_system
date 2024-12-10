<?php 

session_start();
require_once("../reports/reports.php");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expirationItems = $_POST['expirationItems'];

    if(!empty($expirationItems)) {

        function updateExpiryDate($conn, $itemId) {
            $status_id = 3;
            $query = "UPDATE tbl_equipments SET status_id = ? WHERE equipment_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $status_id, $itemId);
            $stmt->execute();
        }


        foreach($expirationItems as $item) {
            updateExpiryDate($conn, $item['equipment_id']);
        }

        echo "success";
    }

}

?>