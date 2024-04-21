<?php
require_once "./env/autoload.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$env_data = readFromEnvFile();

if (empty($env_data)) {
    $REQUEST_SCHEME = $_SERVER["REQUEST_SCHEME"];
    $SERVER_NAME = $_SERVER["SERVER_NAME"];
    $SCRIPT_FILENAME = explode("/", $_SERVER["SCRIPT_FILENAME"])[3];

    $version = "1.0.0";
    $base_url = $REQUEST_SCHEME . "://" . $SERVER_NAME . "/" . $SCRIPT_FILENAME . "/";
    
    $_SESSION["current_tab"] = "initial_config";

    include_once "./views/auth/includes/header.php";
    include_once "./views/initial_configurations_view.php";
    include_once "./views/auth/includes/footer.php";
} else {
    $version = $env_data["VERSION"];
    $base_url = $env_data["BASE_URL"];

    $_SESSION["current_tab"] = "student_login";

    include_once "./views/auth/includes/header.php";
    include_once "./views/auth/student/login_view.php";
    include_once "./views/auth/includes/footer.php";
}
