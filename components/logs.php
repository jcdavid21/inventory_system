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
                            <h4 class="mb-0">Activity Logs</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Activity ID</th>
                                            <th>User ID</th>
                                            <th>Username</th>
                                            <th>Full Name</th>
                                            <th>Activity Date</th>
                                            <th>Activity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "SELECT ta.*, CONCAT(td.first_name, ' ', td.middle_name, ' ', td.last_name) as full_name FROM tbl_logs ta INNER JOIN tbl_account_details td ON ta.user_id = td.account_id;";
                                            $result = mysqli_query($conn, $query);
                                            while($data = mysqli_fetch_assoc($result)){
                                                $formatted_date = date("F j, Y, g:i a", strtotime($data["activity_date"]));
                                        ?>
                                        <tr>
                                            <td><?php echo $data["log_id"]; ?></td>
                                            <td><?php echo $data["user_id"]; ?></td>
                                            <td><?php echo $data["user_name"]; ?></td>
                                            <td><?php echo $data["full_name"]; ?></td>
                                            <td><?php echo $formatted_date; ?></td>
                                            <td><?php echo $data["activity"]; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" id="<?php echo $data["log_id"] ?>" 
                                                data-bs-toggle="modal" data-bs-target="#equipmentDetails<?php echo $data["log_id"] ?>" 
                                                data-bs-whatever="@getbootstrap">
                                                   View Activity
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="equipmentDetails<?php echo $data["log_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="exampleModalLabel">Equipment Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="updateEquipmentForm<?php echo $data["log_id"]; ?>" method="post">

                                                            <div class="row">
                                                                <!-- Description -->
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="description<?php echo $data["log_id"]; ?>" class="form-label fw-bold">Description</label>
                                                                    <textarea id="description<?php echo $data["log_id"]; ?>" class="form-control" name="description" readonly><?php echo htmlspecialchars($data['activity']); ?></textarea>
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
