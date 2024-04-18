<?php
$current_tab = $_SESSION["current_tab"];

switch ($current_tab) {
    case "initial_config":
        $title = "Initial Configurations";

        break;
    case "student_login":
        $title = "Student Login";

        break;
    case "admin_login":
        $title = "Admin Login";

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
    <link rel="stylesheet" href="<?= $base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>dist/css/style.css">
</head>

<body>