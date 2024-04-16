<?php
require_once "./env_functions.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$env_data = readFromEnvFile();

if (empty($env_data)) {
    $version = "1.0.0";
    $base_url = "http://localhost/Infirmary-Scheduling-System/";

    header("Location: " . $base_url);
} else {
    $version = $env_data["VERSION"];
    $base_url = $env_data["BASE_URL"];

    if (isset($_SESSION["user_id"]) && $_SESSION["user_type"] == "student") {
        $_SESSION["current_tab"] = "appointments";

        include "./views/pages/student/appointments_view.php";
    } else {
        $_SESSION["notification"] = array(
            "title" => "Oops..",
            "text" => "You must login first!",
            "icon" => "error",
        );

        header("Location: " . $base_url);
    }
}
