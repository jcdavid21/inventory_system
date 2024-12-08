<?php
session_start();
if (empty($_SESSION["admin_id"])) {
    header('Location:logout.php');
    exit;
}
require_once("../backend/config/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../styles/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .statistics-details {
            background: linear-gradient(90deg, rgba(230,88,100,1) 0%, rgba(209,215,224,1) 100%);
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .statistics-details div {
            background: #ffffff; 
            padding: 15px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .statistics-title {
            font-size: 22px;
            color: #bb1d2b;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .rate-percentage {
            font-size: 38px;
            color: #343a40;
            font-weight: bold;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .statistics-details {
                grid-template-columns: 1fr;
                }
                .statistics-title {
                    font-size: 24px;
                }
                .rate-percentage {
                    font-size: 36px;
                }
            }

            @media (max-width: 480px) {
                .statistics-details {
                    padding: 10px;
                }
                .statistics-title {
                    font-size: 20px;
                }
                .rate-percentage {
                    font-size: 28px;
                }
                .statistics-details div {
                    padding: 10px 20px;
                }
            }
    </style>

</head>

<body id="page-top">

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
                    <div class="statistics-details">
                        <!-- Total Sales -->
                        <div>
                            <?php 
                                $query1 = "SELECT COUNT(equipment_id) AS total_equipments FROM tbl_equipments";
                                $stmt1 = $conn->prepare($query1);
                                $stmt1->execute();
                                $result1 = $stmt1->get_result();
                                $data1 = $result1->fetch_assoc();
                            ?>
                            <p class="statistics-title">
                                <i class="fa-solid fa-stethoscope" style="color: red;"></i>
                                Total Equipments
                            </p>
                            <h3 class="rate-percentage">
                                <?php echo $data1["total_equipments"]; ?>
                            </h3>
                        </div>

                        <!-- Available Equipments -->
                        <div>
                            <?php 
                                $query2 = "SELECT COUNT(equipment_id) AS available_equipments FROM tbl_equipments WHERE status_id = 1";
                                $stmt2 = $conn->prepare($query2);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                $data2 = $result2->fetch_assoc();
                            ?>
                            <p class="statistics-title">
                                <i class="fa-solid fa-clipboard-check" style="color: red;"></i>
                                Available Equipments
                            </p>
                            <h3 class="rate-percentage">
                                <?php echo $data2["available_equipments"]; ?>
                            </h3>
                        </div>

                        <!-- Unavailable Equipments
                        <div>
                            <?php 
                                $query3 = "SELECT COUNT(equipment_id) AS unavailable_equipments FROM tbl_equipments WHERE status_id IN (2, 3)";
                                $stmt3 = $conn->prepare($query3);
                                $stmt3->execute();
                                $result3 = $stmt3->get_result();
                                $data3 = $result3->fetch_assoc();
                            ?>
                            <p class="statistics-title">
                                <i class="fa-solid fa-virus-slash" style="color: red;"></i>
                                Unavailable Equipments
                            </p>
                            <h3 class="rate-percentage">
                                <?php echo $data3["unavailable_equipments"]; ?>
                            </h3>
                        </div> -->


                        <!-- Number of Users -->
                        <div>
                            <?php
                            $query = "SELECT COUNT(account_id) AS total_users FROM tbl_account WHERE status_id = 1";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $data = $result->fetch_assoc();
                            ?>
                            <p class="statistics-title">
                                <i class="fa-solid fa-users" style="color: red;"></i>
                                Number of Users
                            </p>
                            <h3 class="rate-percentage"><?php echo $data["total_users"]; ?></h3>
                        </div>

                        <!-- total sales -->
                        <div>
                            <?php
                            $query = "SELECT IFNULL(SUM(item_price * quantity), 0) AS total_sales FROM tbl_sales";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $data = $result->fetch_assoc();
                            ?>
                            <p class="statistics-title">
                                <i class="fa-solid fa-money-bill" style="color: red;"></i>
                                Total Sales
                            </p>
                            <h3 class="rate-percentage">₱<?php echo number_format($data["total_sales"], 2); ?></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-danger">Monthly Sales</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $currentYear = date("Y");
                                    $monthlyQuery = "SELECT 
                                                        m.MonthName AS Dates,
                                                        IFNULL(SUM(
                                                            tc.item_price * tc.quantity
                                                        ), 0) AS serviceRequestBcCount
                                                    FROM
                                                        (SELECT 'January' AS MonthName, 1 AS MonthNumber UNION ALL
                                                        SELECT 'February', 2 UNION ALL
                                                        SELECT 'March', 3 UNION ALL
                                                        SELECT 'April', 4 UNION ALL
                                                        SELECT 'May', 5 UNION ALL
                                                        SELECT 'June', 6 UNION ALL
                                                        SELECT 'July', 7 UNION ALL
                                                        SELECT 'August', 8 UNION ALL
                                                        SELECT 'September', 9 UNION ALL
                                                        SELECT 'October', 10 UNION ALL
                                                        SELECT 'November', 11 UNION ALL
                                                        SELECT 'December', 12) AS m
                                                    LEFT JOIN tbl_sales tc ON MONTH(tc.purchase_date) = m.MonthNumber 
                                                        AND YEAR(tc.purchase_date) = ?
                                                    GROUP BY m.MonthNumber
                                                    ORDER BY m.MonthNumber;";
                                    $stmt = $conn->prepare($monthlyQuery);
                                    $stmt->bind_param("i", $currentYear);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    $monthlyBc = [];
                                    $serviceRequestBcCount = [];
                                    while ($row = $result->fetch_assoc()) {
                                        $monthlyBc[] = $row['Dates'];
                                        $serviceRequestBcCount[] = $row['serviceRequestBcCount'];
                                    }
                                    ?>
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                    <hr>
                                    
                                </div>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script>
        var monthlyBc = <?php echo json_encode($monthlyBc); ?>;
        var serviceRequestBcCount = <?php echo json_encode($serviceRequestBcCount); ?>;
    </script>
    <script src="../js/demo/chart-area-demo.js"></script>

</body>

</html>
