<?php
session_start();
// if(empty($_SESSION["admin_id"])){
//   header('Location:logout.php');
// }
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
                <div class="container-fluid px-4">

                <div class="card mb-5 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Create Admin Account</h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" method="post" id="createEmpAcc">

                            <!-- Username -->
                            <div class="col-md-4">
                                <label for="uname" class="form-label">Username</label>
                                <input type="text" class="form-control" id="uname" placeholder="Enter username">
                            </div>

                            <!-- Password -->
                            <div class="col-md-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-4">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirmPassword">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- First Name -->
                            <div class="col-md-4 mt-2">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="fname" placeholder="Enter first name">
                            </div>

                            <!-- Middle Name -->
                            <div class="col-md-4 mt-2">
                                <label for="mname" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="mname" placeholder="Enter middle name">
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-4 mt-2">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lname" placeholder="Enter last name">
                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-4 mt-2">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact" placeholder="Enter contact number" 
                                 pattern="\d*" maxlength="11">
                            </div>

                            <!-- Gender -->
                            <div class="col-md-4 mt-2">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="" selected disabled>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Birthdate -->
                            <div class="col-md-4 mt-2">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control" id="birthdate">
                            </div>

                            <!-- Address -->
                            <div class="col-12 mt-2">
                                <label for="address" class="form-label">Address</label>
                                <textarea id="address" class="form-control" rows="3" placeholder="Enter address"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-end mt-4 text-center">
                                <button type="submit" id="submit" class="btn btn-danger btn-lg px-5">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>

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
    <script src="../jquery/createAccount.js"></script>
    <script>
        document.getElementById('fname').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Only letters and spaces allowed
        });
        document.getElementById('lname').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Only letters and spaces allowed
        });
        document.getElementById('mname').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^A-Za-z\s]/g, ''); // Only letters and spaces allowed
        });
        document.getElementById('contact').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, ''); // Only numbers allowed
        });
        document.getElementById('uname').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^A-Za-z0-9]/g, ''); // Only letters and numbers allowed
        });
        

    </script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.toggle-password').forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
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
    <script src="../scripts/toggle.js"></script>
    
  </body>
</html>
