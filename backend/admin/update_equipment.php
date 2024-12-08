<?php
    session_start();
    require_once("../reports/reports.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve the POST data
    $equipmentId = intval($_POST['equipment_id']);
    $name = trim($_POST['name']);
    $modelNumber = trim($_POST['model_number']);
    $manufacturer = trim($_POST['manufacturer']);
    $category = trim($_POST['category']);
    $storageLocation = trim($_POST['storage_location']);
    $quantityInStock = intval($_POST['quantity_in_stock']);
    $itemPrice = floatval($_POST['item_price']);
    $description = trim($_POST['description']);
    $statusId = intval($_POST['status_id']);
    $admin_id = $_SESSION["admin_id"];

    // Validate the inputs
    if (empty($name) || empty($modelNumber) || empty($manufacturer) || empty($category) || empty($storageLocation) || $quantityInStock <= 0 || $itemPrice <= 0) {
        echo "All fields are required and must be valid.";
        exit;
    }

    // Update the equipment in the database
    $query = "UPDATE tbl_equipments SET 
        name = ?, 
        model_number = ?, 
        manufacturer = ?, 
        category = ?, 
        storage_location = ?, 
        quantity_in_stock = ?, 
        item_price = ?, 
        description = ?, 
        status_id = ? 
        WHERE equipment_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssdssii", $name, $modelNumber, $manufacturer, $category, $storageLocation, $quantityInStock, $itemPrice, $description, $statusId, $equipmentId);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $query4 = "SELECT acc_username FROM tbl_account WHERE account_id = ?";
    $stmt4 = $conn->prepare($query4);
    $stmt4->bind_param("i", $admin_id);
    $stmt4->execute();
    $result = $stmt4->get_result();
    if($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $username = $data["acc_username"];
        $act = "Update Product: $name";
        $date = date("Y-m-d");
        report($conn, $admin_id, $username, $date, $act);
    }

    
} else {
    echo "Invalid request method.";
}
?>
