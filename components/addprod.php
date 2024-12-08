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
    <title>Add Product</title>
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
                <div class="container-fluid px-4">

                    <div class="card mb-5">
                        <div class="card-header bg-danger text-white">
                            <h4 class="mb-0">Add Equipment</h4>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="post" id="addProd">
                                <!-- Product Name -->
                                <div class="col-md-6 mt-2">
                                    <label for="prod_name" class="form-label fw-bold">Equipment Name</label>
                                    <input required type="text" name="prod_name" class="form-control" id="prod_name" placeholder="Enter product name" oninput="validInput(this)">
                                </div>

                                <!-- Category -->
                                <div class="col-md-6 mt-2">
                                    <label for="category" class="form-label fw-bold">Category</label>
                                    <input required type="text" name="category" class="form-control" id="category" placeholder="Enter category" oninput="validInput(this)" >
                                </div>

                                <!-- Manufacturer -->
                                <div class="col-md-6 mt-2">
                                    <label for="manufacturer" class="form-label fw-bold">Manufacturer</label>
                                    <input required type="text" name="manufacturer" class="form-control" id="manufacturer" placeholder="Enter manufacturer name" oninput="validInput(this)">
                                </div>

                                <!-- Model Number -->
                                <div class="col-md-6 mt-2">
                                    <label for="model_number" class="form-label fw-bold">Model Number</label>
                                    <input required type="text" name="model_number" class="form-control" id="model_number" placeholder="Enter model number" oninput="validateNumberInput(this)">
                                </div>

                                <!-- Quantity in Stock -->
                                <div class="col-md-6 mt-2">
                                    <label for="quantity_in_stock" class="form-label fw-bold">Quantity in Stock</label>
                                    <input required type="number" name="quantity_in_stock" class="form-control" id="quantity_in_stock" placeholder="Enter quantity" oninput="validateNumberInput(this)">
                                </div>

                                <!-- Item Price -->
                                <div class="col-md-6 mt-2">
                                    <label for="item_price" class="form-label fw-bold">Item Price</label>
                                    <input required type="number" name="item_price" class="form-control" id="item_price" placeholder="Enter item price" step="0.01" >
                                </div>

                                <!-- Storage Location -->
                                <div class="col-md-6 mt-2">
                                    <label for="storage_location" class="form-label fw-bold">Storage Location</label>
                                    <input required type="text" name="storage_location" class="form-control" id="storage_location" placeholder="Enter storage location">
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mt-2">
                                    <label for="status_id" class="form-label fw-bold">Status</label>
                                    <select id="status_id" name="status_id" class="form-control">
                                        <option value="" selected disabled>Select status</option>
                                        <?php   
                                            $query = "SELECT * FROM tbl_equipment_status";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($data = $result->fetch_assoc()) {
                                                $statusId = $data["status_id"];
                                                $statusName = $data["status_name"];
                                                echo '<option value="'.$statusId.'">'.$statusName.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <!-- Supplier Name -->
                                <div class="col-md-6 mt-2">
                                    <label for="supplier_name" class="form-label fw-bold">Supplier Name</label>
                                    <input required type="text" name="supplier_name" class="form-control" id="supplier_name" placeholder="Enter supplier name" oninput="validInput(this)">
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
                                </div>

                                <!-- Expiration Date -->
                                <div class="col-md-6 mt-2">
                                    <label for="expiration_date" class="form-label fw-bold">Expiration Date (optional)</label>
                                    <input type="date" name="expiration_date" class="form-control" id="expiration_date">
                                </div>

                                <!-- Item Image -->
                                <div class="col-md-6 mt-2">
                                    <label for="item_img" class="form-label fw-bold">Item Image</label>
                                    <input required type="file" name="item_img" class="form-control" id="item_img" accept="image/*">
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" id="submit" class="btn btn-primary btn-lg">Add Equipment</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

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
    <script src="../jquery/sideBarProd.js"></script>
    <script src="../jquery/addprod.js"></script>
    <script src="../scripts/toggle.js"></script>
    <script>
        function validateNumberInput(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }
        
        function validInput(input){
            input.value = input.value.replace(/[^A-Za-z\s]/g, '');
        }
    </script>

  </body>
</html>
