<?php
    
    session_start();
    require_once("../reports/reports.php");

    if(isset($_POST["equipmentId"]) && isset($_POST["quantity"]) && isset($_POST["warranty"]) && isset($_POST["buyers_name"]) && isset($_POST["buyers_contact"]))
    {
        $equipmentId = $_POST["equipmentId"];
        $quantity = $_POST["quantity"];
        $warranty = $_POST["warranty"];
        $buyers_name = $_POST["buyers_name"];
        $buyers_contact = $_POST["buyers_contact"];
        $admin_id = $_SESSION["admin_id"];
        $date = date("Y-m-d");

        $query = "SELECT * FROM tbl_equipments WHERE equipment_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $equipmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $data = $result->fetch_assoc();
            $name = $data["name"];
            $model_number = $data["model_number"];
            $manufacturer = $data["manufacturer"];
            $category = $data["category"];
            $storage_location = $data["storage_location"];
            $quantity_in_stock = $data["quantity_in_stock"];
            $item_price = $data["item_price"];
            $description = $data["description"];
            $status_id = $data["status_id"];

            if($quantity > $quantity_in_stock){
                echo "Quantity is greater than the available stock.";
                exit;
            }

            $query2 = "INSERT INTO tbl_sales (equipment_id, quantity, warranty, buyers_name, buyers_contact, purchase_date, item_price)
                       VALUES(?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param("iissssd", $equipmentId, $quantity, $warranty, $buyers_name, $buyers_contact, $date, $item_price);
            $stmt2->execute();

            $query3 = "UPDATE tbl_equipments SET quantity_in_stock = ? WHERE equipment_id = ?";
            $new_qnty = intval($quantity_in_stock) - intval($quantity);
            $stmt3 = $conn->prepare($query3);
            $stmt3->bind_param("ii", $new_qnty, $equipmentId);
            $stmt3->execute();

            $query4 = "SELECT acc_username FROM tbl_account WHERE account_id = ?";
            $stmt4 = $conn->prepare($query4);
            $stmt4->bind_param("i", $admin_id);
            $stmt4->execute();
            $result = $stmt4->get_result();
            if($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $username = $data["acc_username"];
                $act = "Purchase Equipment: $name";
                report($conn, $admin_id, $username, $date, $act);
            }

            echo "success";
        }
        
    }
?>