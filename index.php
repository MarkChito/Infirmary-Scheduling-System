<?php
require_once "./env_functions.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$env_data = readFromEnvFile();

if (empty($env_data)) {
    $version = "1.0.0";
    $base_url = "http://localhost/Infirmary-Scheduling-System/";

    $_SESSION["current_tab"] = "initial_config";

    include "./views/initial_configurations_view.php";
} else {
    $version = $env_data["VERSION"];
    $base_url = $env_data["BASE_URL"];

    $_SESSION["current_tab"] = "student_login";

    include "./views/auth/student/login_view.php";
}
