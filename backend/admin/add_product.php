<?php
    session_start();
    require_once("../reports/reports.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $prodName = trim($_POST['prod_name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $manufacturer = trim($_POST['manufacturer'] ?? '');
    $modelNumber = trim($_POST['model_number'] ?? '');
    $quantityInStock = intval($_POST['quantity_in_stock'] ?? 0);
    $itemPrice = floatval($_POST['item_price'] ?? 0);
    $storageLocation = trim($_POST['storage_location'] ?? '');
    $statusId = intval($_POST['status_id'] ?? 0);
    $supplierName = trim($_POST['supplier_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $expirationDate = !empty($_POST['expiration_date']) ? $_POST['expiration_date'] : null;
    $admin_id = $_SESSION["admin_id"];

    // Validate required fields
    if (empty($prodName) || empty($category) || empty($manufacturer) || 
        empty($modelNumber) || empty($quantityInStock) || 
        empty($itemPrice) || empty($storageLocation) || 
        empty($statusId) || empty($supplierName)) {
        echo "All required fields must be filled.";
        exit;
    }

    if($quantityInStock > 100)
    {
        echo "Quantity in stock must be less than or equal to 100.";
        exit;
    }

    // Additional validations
    if ($quantityInStock <= 0) {
        echo "Quantity in stock must be greater than equal to 1.";
        exit;
    }

    if (!empty($expirationDate)) {
        $expirationDate = new DateTime($expirationDate);
        $minExpirationDate = new DateTime();
        $minExpirationDate->modify('+7 days');
        if ($expirationDate < $minExpirationDate) {
            echo "Expiration date must be at least 7 days from today.";
            exit;
        }
        $expirationDate = $expirationDate->format('Y-m-d'); // Format for database
    }

    // Handle file upload (if an image is provided)
    $itemImgPath = null;
    if (!empty($_FILES['item_img']['name'])) {
        $targetDir = "../../imgs/equipments/";
        $fileName = basename($_FILES['item_img']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit;
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['item_img']['tmp_name'], $targetFilePath)) {
            $itemImgPath = $targetFilePath;
        } else {
            echo "Error uploading the image.";
            exit;
        }
    }

    // Insert data into the database
    $query = "INSERT INTO tbl_equipments 
    (name, category, manufacturer, model_number, quantity_in_stock, item_price, storage_location, status_id, supplier_name, description, expiration_date, item_img) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssidsissss", $prodName, $category, $manufacturer, $modelNumber, $quantityInStock, $itemPrice, $storageLocation, $statusId, $supplierName, $description, $expirationDate, $itemImgPath);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $query2 = "SELECT acc_username FROM tbl_account WHERE account_id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $admin_id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    if($result->num_rows > 0){
        $data = $result->fetch_assoc();
        $username = $data["acc_username"];
        $act = "Add Product: $prodName";
        $date = date("Y-m-d");
        report($conn, $admin_id, $username, $date, $act);
    }
    

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
