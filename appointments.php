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
        $_SESSION["current_tab"] = "appointments";

        $server_name = $env_data["SERVER_NAME"];
        $database = $env_data["DATABASE"];
        $uid = $env_data["UID"];
        $pwd = $env_data["PWD"];

        $connection_info = array(
            "Database" => $database,
            "Uid" => $uid,
            "PWD" => $pwd
        );

        $conn = sqlsrv_connect($server_name, $connection_info);

        $sql = "SELECT id, purpose_of_registration, appointment_date, appointment_time, status FROM tbl_appointments WHERE account_id = '" . $_SESSION["user_id"] . "' ORDER BY id DESC";
        $stmt = sqlsrv_query($conn, $sql);

        $appointment_data = [];

        if ($stmt !== false) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $appointment_data[] = $row;
            }
        }

        include_once "views/pages/includes/header.php";
        include_once "./views/pages/student/appointments_view.php";
        include_once "views/pages/includes/footer.php";
    } else {
        $_SESSION["notification"] = array(
            "title" => "Oops..",
            "text" => "You must login first!",
            "icon" => "error",
        );

        header("Location: " . $base_url);
    }
}
