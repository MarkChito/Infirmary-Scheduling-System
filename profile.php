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

    header("Location: " . $base_url);
} else {
    $version = $env_data["VERSION"];
    $base_url = $env_data["BASE_URL"];

    if (isset($_SESSION["user_id"]) && $_SESSION["user_type"] == "student") {
        $_SESSION["current_tab"] = "profile";

        include "./views/pages/student/profile_view.php";
    } else {
        $_SESSION["notification"] = array(
            "title" => "Oops..",
            "text" => "You must login first!",
            "icon" => "error",
        );

        header("Location: " . $base_url);
    }
}
