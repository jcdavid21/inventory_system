<?php
session_start();
if(empty($_SESSION["admin_id"])){
  header('Location:logout.php');
}
require_once("../backend/config/config.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Panel</title>
    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <script src="../scripts/font-awesome.js"></script>
    <script src="../scripts/sweetalert2.js"></script>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../styles/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  </head>
  <body class="page-top">
    
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "navbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">No expiration equipments</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Equipment ID</th>
                                            <th>Name</th>
                                            <th>Model Number</th>
                                            <th>Category</th>
                                            <th>Storage Loc.</th>
                                            <th>Quantity Stock</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $lowStockItems = [];
                                            $query = "SELECT te.*, ts.status_name FROM tbl_equipments te
                                            JOIN tbl_equipment_status ts ON te.status_id = ts.status_id
                                            WHERE te.expiration_date IS NULL";
                                            $result = mysqli_query($conn, $query);
                                            while($data = mysqli_fetch_assoc($result)){
                                                $formatted_date = date("F j, Y", strtotime($data["date_added"]));
                                                $formatted_price = number_format($data["item_price"], 2);
                                                $low_stock_threshold = 5;  // Define the low stock threshold

                                                // Check if quantity is low
                                                if ($data["quantity_in_stock"] <= $low_stock_threshold) {
                                                    // Add the item to the lowStockItems array
                                                    $lowStockItems[] = [
                                                        'name' => $data['name'],
                                                        'quantity' => $data['quantity_in_stock'],
                                                    ];
                                                }
                                        ?>
                                        <tr>
                                            <th>
                                                <div class="img-con" style="height: 70px; width: 70px;">
                                                    <img src="../<?php echo str_replace("../", "", $data["item_img"]) ?>" alt=""
                                                    style="object-fit: contain; width: 100%; height: 100%;">
                                                </div>
                                            </th>
                                            <td><?php echo $data["equipment_id"]; ?></td>
                                            <td><?php echo $data["name"]; ?></td>
                                            <td><?php echo $data["model_number"]; ?></td>
                                            <td><?php echo $data["category"]; ?></td>
                                            <td><?php echo $data["storage_location"]; ?></td>
                                            <td><?php echo $data["quantity_in_stock"]; ?></td>
                                            <td>₱<?php echo $formatted_price; ?></td>
                                            <td><?php echo $data["status_name"]; ?></td>
                                            <td>
                                                <?php  
                                                    if($data["quantity_in_stock"] > 0 && $data["status_id"] == 1){
                                                ?>
                                                <button type="button" class="btn btn-success"
                                                data-bs-toggle="modal" data-bs-target="#purchaseDetails<?php echo $data["equipment_id"] ?>" 
                                                data-bs-whatever="@getbootstrap">
                                                    Purchase
                                                </button>
                                                <?php
                                                    }
                                                ?>
                                                <button type="button" class="btn btn-primary" id="<?php echo $data["equipment_id"] ?>" 
                                                data-bs-toggle="modal" data-bs-target="#equipmentDetails<?php echo $data["equipment_id"] ?>" 
                                                data-bs-whatever="@getbootstrap">
                                                   Edit
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="equipmentDetails<?php echo $data["equipment_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="exampleModalLabel">Equipment Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="updateEquipmentForm<?php echo $data['equipment_id']; ?>" method="post">
                                                            <!-- Equipment ID (Hidden) -->
                                                            <input type="hidden" name="equipment_id" value="<?php echo $data['equipment_id']; ?>">

                                                            <!-- Date Added -->
                                                            <div class="mb-3">
                                                                <label for="dateAdded<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Date Added</label>
                                                                <input type="text" id="dateAdded<?php echo $data['equipment_id']; ?>" class="form-control" value="<?php echo $formatted_date; ?>" readonly>
                                                            </div>

                                                            <!-- Name Fields -->
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="name<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Equipment Name</label>
                                                                    <input type="text" id="name<?php echo $data['equipment_id']; ?>" class="form-control" name="name" value="<?php echo htmlspecialchars($data['name']); ?>">
                                                                </div>

                                                                <!-- Model Number -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="modelNumber<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Model Number</label>
                                                                    <input type="text" id="modelNumber<?php echo $data['equipment_id']; ?>" class="form-control" name="model_number" value="<?php echo htmlspecialchars($data['model_number']); ?>">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <!-- Manufacturer -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="manufacturer<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Manufacturer</label>
                                                                    <input type="text" id="manufacturer<?php echo $data['equipment_id']; ?>" class="form-control" name="manufacturer" value="<?php echo htmlspecialchars($data['manufacturer']); ?>">
                                                                </div>

                                                                <!-- Category -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="category<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Category</label>
                                                                    <input type="text" id="category<?php echo $data['equipment_id']; ?>" class="form-control" name="category" value="<?php echo htmlspecialchars($data['category']); ?>">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                 <!-- Price -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="itemPrice<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Price</label>
                                                                    <input type="number" id="itemPrice<?php echo $data['equipment_id']; ?>" class="form-control" name="item_price" value="<?php echo $data['item_price']; ?>">
                                                                </div>

                                                                <!-- Quantity in Stock -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="quantityInStock<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Quantity in Stock</label>
                                                                    <input type="number" id="quantityInStock<?php echo $data['equipment_id']; ?>" class="form-control" name="quantity_in_stock" value="<?php echo $data['quantity_in_stock']; ?>">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="storageLocation<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Storage Location</label>
                                                                    <input type="text" id="storageLocation<?php echo $data['equipment_id']; ?>" class="form-control" name="storage_location" value="<?php echo htmlspecialchars($data['storage_location']); ?>">
                                                                </div>

                                                                <!-- Description -->
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="description<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Description</label>
                                                                    <textarea id="description<?php echo $data['equipment_id']; ?>" class="form-control" name="description"><?php echo htmlspecialchars($data['description']); ?></textarea>
                                                                </div>
                                                            </div>

                                                            <!-- Status -->
                                                            <div class="mb-3">
                                                                <label for="status<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Status</label>
                                                                <select id="status<?php echo $data['equipment_id']; ?>" class="form-control" name="status_id">
                                                                    <?php 
                                                                        $query2 = "SELECT * FROM tbl_equipment_status";
                                                                        $result2 = mysqli_query($conn, $query2);
                                                                        while($data2 = mysqli_fetch_assoc($result2)){
                                                                    ?>
                                                                    <option value="<?php echo $data2['status_id']; ?>" <?php if($data2['status_id'] == $data['status_id']){ echo "selected"; } ?>>
                                                                        <?php echo $data2['status_name']; ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary updateAccount" id="updateBtn<?php echo $data['equipment_id']; ?>">Update</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="modal fade" id="purchaseDetails<?php echo $data["equipment_id"] ?>"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >

                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="exampleModalLabel">Buyer Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="updateEquipmentForm<?php echo $data['equipment_id']; ?>" method="post">
                                                            <!-- Equipment ID (Hidden) -->
                                                            <input type="hidden" name="equipment_id" value="<?php echo $data['equipment_id']; ?>">

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="equipmentName<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Equipment Name</label>
                                                                    <input type="text" id="equipmentName<?php echo $data['equipment_id']; ?>" class="form-control" value="<?php echo $data['name']; ?>" readonly>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label for="equipmentPrice<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Price</label>
                                                                    <input type="text" id="equipmentPrice<?php echo $data['equipment_id']; ?>" class="form-control" value="₱<?php echo $formatted_price; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <!-- buyers name -->
                                                            <div class="mb-3">
                                                                <label for="buyerName<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Buyer's Name</label>
                                                                <input type="text" id="buyerName<?php echo $data['equipment_id']; ?>" class="form-control" name="buyer_name"
                                                                oninput="validateNameInput(this)">
                                                            </div>

                                                            <!-- buyers contact -->
                                                            <div class="mb-3">
                                                                <label for="buyerContact<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Buyer's Contact</label>
                                                                <input type="text" id="buyerContact<?php echo $data['equipment_id']; ?>" class="form-control" name="buyer_contact" maxlength="11" oninput="validateContactInput(this)">
                                                            </div>

                                                            <!-- warranty -->
                                                            <div class="mb-3">
                                                                <label for="warranty<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Warranty</label>
                                                                <input type="date" id="warranty<?php echo $data['equipment_id']; ?>" class="form-control" name="warranty">
                                                            </div>

                                                            <!-- quantity -->
                                                            <div class="mb-3">
                                                                <label for="quantity<?php echo $data['equipment_id']; ?>" class="form-label fw-bold">Quantity</label>
                                                                <input type="number" id="quantity<?php echo $data['equipment_id']; ?>" class="form-control" name="quantity"
                                                                oninput="validateContactInput(this)">
                                                            </div>

                                                            

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger buyProd" id="buyProd<?php echo $data['equipment_id']; ?>">Proceed</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <?php
                                            }
                                        ?>
                                        </tbody>

                                        
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

                <input type="hidden" id="lowStockItems" value='<?php echo json_encode($lowStockItems); ?>'>

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->


    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
    <script src="../jquery/deactivate.js"></script>
    <script src="../jquery/updateEquipment.js"></script>
    <script src="../jquery/buyProd.js"></script>
    <script>
        function validateNameInput(input) {
            const regex = /^[A-Za-z\s]*$/; // Allows only letters and spaces
            if (!regex.test(input.value)) {
                input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Remove invalid characters
            }
        }

        function validateContactInput(input) {
            const regex = /^[0-9]*$/; // Allows only numbers
            if (!regex.test(input.value)) {
                input.value = input.value.replace(/[^0-9]/g, ''); // Remove invalid characters
            }
        }

    </script>
    <script>
        const lowStockItems = JSON.parse(document.getElementById('lowStockItems').value);
        if (lowStockItems.length > 0) {
            let lowStockItemsString = '';
            lowStockItems.forEach(item => {
                lowStockItemsString += `${item.name} (${item.quantity} left)\n`;
            });
            Swal.fire({
                icon: 'warning',
                title: 'Low Stock Items',
                text: lowStockItemsString,
            });
        }
    </script>

    <script src="../scripts/toggle.js"></script>


  </body>
</html>
