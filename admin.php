<?php
require_once "./env/autoload.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$env_data = readFromEnvFile();

if (empty($env_data)) {
    $version = "1.0.0";
    $base_url = "http://localhost/Infirmary-Scheduling-System/";

    $_SESSION["current_tab"] = "initial_config";

    header("location: " . $base_url);
} else {
    $version = $env_data["VERSION"];
    $base_url = $env_data["BASE_URL"];

    $_SESSION["current_tab"] = "admin_login";

    include "./views/auth/admin/login_view.php";
}
