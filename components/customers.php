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
                            <h4 class="mb-0">Accounts Table</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Address</th>
                                            <th>Gender</th>
                                            <th>Birthdate</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "SELECT ta.account_id, CONCAT(tc.first_name, ' ', tc.middle_name, ' ', tc.last_name) AS full_name, tc.contact, tc.address, tc.first_name, tc.middle_name, tc.last_name, tc.gender, tc.birthdate FROM tbl_account ta INNER JOIN tbl_account_details tc ON tc.account_id = ta.account_id
                                            WHERE ta.status_id = 1;";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($data = $result->fetch_assoc()) {
                                                $formatted_date = date("F j, Y", strtotime($data["birthdate"]));
                                        ?>
                                        <tr>
                                            <td><?php echo $data['account_id'];?></td>
                                            <td><?php echo $data['full_name'];?></td>
                                            <td><?php echo $data['contact'];?></td>
                                            <td><?php echo $data['address'];?></td>
                                            <td><?php echo $data["gender"]; ?></td>
                                            <td><?php echo $formatted_date; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" id="<?php echo $data["account_id"] ?>" 
                                                data-bs-toggle="modal" data-bs-target="#accountDetails<?php echo $data["account_id"] ?>" 
                                                data-bs-whatever="@getbootstrap">
                                                   Edit
                                                </button>
                                                <button type="button" class="btn btn-danger deactivateResBtn" id="<?php echo $data["account_id"] ?>" >
                                                Deactivate
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="accountDetails<?php echo $data["account_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <!-- User ID -->
                                                            <div class="mb-3">
                                                                <label for="userId" class="form-label fw-bold">User ID</label>
                                                                <input type="text" id="userId" class="form-control updatedName" value="<?php echo $data['account_id']; ?>" disabled>
                                                            </div>

                                                            <!-- Name Fields -->
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="firstName" class="form-label fw-bold">First Name</label>
                                                                    <input type="text" id="firstName" class="form-control updateFname" value="<?php echo htmlspecialchars($data['first_name']); ?>" oninput="validateNameInput(this)">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="middleName" class="form-label fw-bold">Middle Name</label>
                                                                    <input type="text" id="middleName" class="form-control updateMname" value="<?php echo htmlspecialchars($data['middle_name']); ?>" oninput="validateNameInput(this)">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="lastName" class="form-label fw-bold">Last Name</label>
                                                                    <input type="text" id="lastName" class="form-control updateLname" value="<?php echo htmlspecialchars($data['last_name']); ?>" oninput="validateNameInput(this)">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="contact" class="form-label fw-bold">Contact</label>
                                                                    <input type="text" id="contact" class="form-control updateContact" value="<?php echo htmlspecialchars($data['contact']); ?>" oninput="validateContactInput(this)" maxlength="11" pattern="\d*">
                                                                </div>
                                                            </div>

                                                            <!-- Address -->
                                                            <div class="mb-3">
                                                                <label for="address" class="form-label fw-bold">Address</label>
                                                                <textarea id="address" class="form-control updateAddress" rows="2"><?php echo htmlspecialchars($data['address']); ?></textarea>
                                                            </div>

                                                            <!-- Password Fields -->
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="password" class="form-label fw-bold">Password</label>
                                                                    <div class="input-group">
                                                                        <input type="password" id="password" class="form-control updatePassword">
                                                                        <span class="input-group-text toggle-password" data-target="updatePassword" style="cursor: pointer;">
                                                                            <i class="fa-solid fa-eye icon"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="confirmPassword" class="form-label fw-bold">Confirm Password</label>
                                                                    <div class="input-group">
                                                                        <input type="password" id="confirmPassword" class="form-control updateConfirmpassword">
                                                                        <span class="input-group-text toggle-password" data-target="updateConfirmpassword" style="cursor: pointer;">
                                                                            <i class="fa-solid fa-eye icon"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary updateAccount" id="<?php echo $data["account_id"]; ?>">Update</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
    <script src="../jquery/deactivate.js"></script>
    <script src="../jquery/AdminUpdateProfile.js"></script>
    <script>
         document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const targetInput = $(this).closest('.input-group').find(`.${targetId}`)[0];
                    const icon = this.querySelector('.icon');

                    if (targetInput) {
                        if (targetInput.type === 'password') {
                            targetInput.type = 'text'; // Change input type to text
                            icon.classList.remove('fa-eye'); // Remove eye icon
                            icon.classList.add('fa-eye-slash'); // Add eye-slash icon
                        } else {
                            targetInput.type = 'password'; // Change input type back to password
                            icon.classList.remove('fa-eye-slash'); // Remove eye-slash icon
                            icon.classList.add('fa-eye'); // Add eye icon
                        }
                    } else {
                        console.error(`Input with id '${targetId}' not found.`);
                    }
                });
            });
        });
    </script>
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
    <script src="../scripts/toggle.js"></script>


  </body>
</html>
