<?php
$current_tab = $_SESSION["current_tab"];
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];

switch ($current_tab) {
    case "dashboard":
        $title = "Dashboard";

        break;
    case "profile":
        $title = "My Profile";

        break;
    case "appointments":
        $title = "My Appointments";

        break;
    default:
        // Ignore this line
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Infirmary Scheduling System - <?= $title ?></title>

    <link rel="shortcut icon" href="<?= $base_url ?>dist/img/image-placeholder.png" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                        <i class="far fa-bell"></i>
                        <!-- <span class="badge badge-danger navbar-badge">0</span> -->
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">0 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <h5 class="text-center text-muted py-3">No Available Data</h5>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link account_settings" href="javascript:void(0)" role="button">
                        <i class="fas fa-cog"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger logout" href="javascript:void(0)" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $base_url ?>dist/img/default-user-image.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= $user_type == "student" ? $base_url . "profile" : "javascript:void(0)" ?>" class="d-block" id="user_name">Loading...</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= $base_url ?>dashboard" class="nav-link <?= $_SESSION["current_tab"] == "dashboard" ? "active" : null ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <?php if ($user_type == "student") : ?>
                            <li class="nav-item">
                                <a href="<?= $base_url ?>appointments" class="nav-link <?= $_SESSION["current_tab"] == "appointments" ? "active" : null ?>">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>My Appointments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= $base_url ?>profile" class="nav-link <?= $_SESSION["current_tab"] == "profile" ? "active" : null ?>">
                                    <i class="nav-icon fas fa-user-alt"></i>
                                    <p>My Profile</p>
                                </a>
                            </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link logout">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>