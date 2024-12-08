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
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0">Purchased History</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Order ID</th>
                                            <th>Buyers Name</th>
                                            <th>Buyers Contact</th>
                                            <th>Item Name</th>
                                            <th>Model Number</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Purchased Date</th>
                                            <th>Warranty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "SELECT te.name, te.equipment_id, te.category, te.manufacturer, te.model_number, te.supplier_name, te.expiration_date, te.description, te.item_img, tbs.* FROM tbl_sales tbs
                                            JOIN tbl_equipments te ON tbs.equipment_id = te.equipment_id
                                            ORDER BY te.equipment_id DESC";
                                            $result = mysqli_query($conn, $query);
                                            while($data = mysqli_fetch_assoc($result)){
                                                $formatted_date = date("F j, Y", strtotime($data["purchase_date"]));
                                                $formatted_warranty = date("F j, Y", strtotime($data["warranty"]));
                                                $formatted_price = number_format($data["item_price"], 2);
                                                $formatted_exp_date = $data["expiration_date"] ? date("F j, Y", strtotime($data["expiration_date"])) : "N/A";
                                        ?>
                                        <tr>
                                            <th>
                                                <div class="img-con" style="height: 70px; width: 70px;">
                                                    <img src="<?php echo $data["item_img"] ?>" alt=""
                                                    style="object-fit: contain; width: 100%; height: 100%;">
                                                </div>
                                            </th>
                                            <td><?php echo $data["sales_id"] ?></td>
                                            <td><?php echo $data["buyers_name"] ?></td>
                                            <td><?php echo $data["buyers_contact"] ?></td>
                                            <td><?php echo $data["name"] ?></td>
                                            <td><?php echo $data["model_number"] ?></td>
                                            <td><?php echo $data["category"] ?></td>
                                            <td>₱<?php echo $formatted_price ?></td>
                                            <td><?php echo $data["quantity"] ?></td>
                                            <td><?php echo $formatted_date ?></td>
                                            <td><?php echo $formatted_warranty ?></td>
                                            
                                            <td>
                                                <button type="button" class="btn btn-primary" id="<?php echo $data["sales_id"] ?>" 
                                                data-bs-toggle="modal" data-bs-target="#equipmentDetails<?php echo $data["sales_id"] ?>" 
                                                data-bs-whatever="@getbootstrap">
                                                   View Details
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="equipmentDetails<?php echo $data["sales_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="exampleModalLabel">Equipment Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="updateEquipmentForm<?php echo $data["sales_id"]; ?>" method="post">
                                                            <!-- Equipment ID (Hidden) -->
                                                            <input type="hidden" name="equipment_id" value="<?php echo $data["sales_id"]; ?>">

                                                            <!-- Name Fields -->
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="name<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Equipment Name</label>
                                                                    <input type="text" id="name<?php echo $data["sales_id"]; ?>" class="form-control" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" readonly>
                                                                </div>

                                                                <!-- Model Number -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="modelNumber<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Model Number</label>
                                                                    <input type="text" id="modelNumber<?php echo $data["sales_id"]; ?>" class="form-control" name="model_number" value="<?php echo htmlspecialchars($data['model_number']); ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <!-- Manufacturer -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="manufacturer<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Manufacturer</label>
                                                                    <input type="text" id="manufacturer<?php echo $data["sales_id"]; ?>" class="form-control" name="manufacturer" value="<?php echo htmlspecialchars($data['manufacturer']); ?>" readonly>
                                                                </div>
                                                                <!-- supplier -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="supplier<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Supplier</label>
                                                                    <input type="text" id="supplier<?php echo $data["sales_id"]; ?>" class="form-control" name="supplier" value="<?php echo htmlspecialchars($data['supplier_name']); ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <!-- Category -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="category<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Category</label>
                                                                    <input type="text" id="category<?php echo $data["sales_id"]; ?>" class="form-control" name="category" value="<?php echo htmlspecialchars($data['category']); ?>"
                                                                    readonly>
                                                                </div>

                                                                <!-- Expiration Date -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="expirationDate<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Expiration Date</label>
                                                                    <input type="text" id="expirationDate<?php echo $data["sales_id"]; ?>" class="form-control" name="expiration_date" value="<?php echo $formatted_exp_date; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                 <!-- Price -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="itemPrice<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Price</label>
                                                                    <input type="text" id="itemPrice<?php echo $data["sales_id"]; ?>" class="form-control" name="item_price" value="₱<?php echo number_format($data['item_price'], 2); ?>"
                                                                    readonly>
                                                                </div>

                                                                <!-- Quantity -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="quantity<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Quantity</label>
                                                                    <input type="text" id="quantity<?php echo $data["sales_id"]; ?>" class="form-control" name="quantity" value="<?php echo $data['quantity']; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <!-- Description -->
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="description<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Description</label>
                                                                    <textarea id="description<?php echo $data["sales_id"]; ?>" class="form-control" name="description" readonly><?php echo htmlspecialchars($data['description']); ?></textarea>
                                                                </div>
                                                            </div>

                                                            <!-- total -->
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="total<?php echo $data["sales_id"]; ?>" class="form-label fw-bold">Total</label>
                                                                    <input type="text" id="total<?php echo $data["sales_id"]; ?>" class="form-control" name="total" value="₱<?php echo number_format($data['item_price'] * $data["quantity"], 2); ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
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

    <script src="../js/demo/datatables-demo.js"></script>
    <script src="../scripts/toggle.js"></script>



  </body>
</html>
