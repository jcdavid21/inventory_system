<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/font-awesome.js"></script>
    <style>
        .collapse-inner .collapse-item:hover {
            color: black !important;
        }
    </style>
</head>
<body>
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background: rgb(187,29,43);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-text mx-1">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="./dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Manage Equipments</div>

    <!-- Nav Item - Flower Lists Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed prod-type" href="./equipmentNoExp.php">
            <i class="fa-solid fa-fw fa-toolbox"></i> <span>No expiration</span>
        </a>
        <a class="nav-link collapsed prod-type" href="./equipmentWithExp.php">
            <i class="fa-solid fa-fw fa-toolbox"></i> <span>With expiration</span>
        </a>
       <a class="nav-link collapsed" href="./addprod.php">
            <i class="fa-solid fa-fw fa-plus"></i>
            <span>Add Equipments</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">Viewing</div>
    <li class="nav-item">
        <a class="nav-link collapsed prod-type" href="./history.php">
            <i class="fa-solid fa-fw fa-chart-line"></i>
            <span>History</span>
        </a>
        <a class="nav-link collapsed prod-type" href="./logs.php">
            <i class="fa-solid fa-person-running"></i>
            <span>Logs / Activity</span>
        </a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">Modify Accounts</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fa-solid fa-id-card"></i>
            <span>Accounts</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item text-white" href="./customers.php">Active</a>
                <a class="collapse-item text-white" href="./deactivated.php">Not Active</a>
                <div class="collapse-divider"></div>
                <a class="collapse-item text-white" href="./createAccount.php">Create Account</a>
            </div>
        </div>
    </li>
    <!-- 
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Transaction History</span></a>
    </li> -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    </ul>

</body>
</html>