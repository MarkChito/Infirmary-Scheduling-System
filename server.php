<?php
require_once "./env_functions.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$env_data = readFromEnvFile();

$server_name = null;
$database = null;
$uid = null;
$pwd = null;

$conn = null;

if (!empty($env_data)) {
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
}

if (isset($_POST["check_database_connection"])) {
    $response = null;

    $server_name = $_POST["server_name"];
    $database = $_POST["database"];
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];

    $connection_info = array(
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $pwd
    );

    $conn = sqlsrv_connect($server_name, $connection_info);

    if ($conn) {
        $data = array(
            "SERVER_NAME" => $server_name,
            "DATABASE" => $database,
            "UID" => $uid,
            "PWD" => $pwd,
            "VERSION" => "1.0.0",
            "BASE_URL" => "http://localhost/Infirmary-Scheduling-System/",
        );

        writeToEnvFile($data);

        $response = array(
            "status" => 200,
            "message" => "Database is connected!"
        );
    } else {
        $response = array(
            "status" => 404,
            "message" => "Can't connect to the database!"
        );
    }

    echo json_encode($response);
}

if (isset($_POST["check_student_number"])) {
    $student_number = $_POST["student_number"];

    $sql = "SELECT student_number FROM tbl_accounts WHERE student_number = '" . $student_number . "'";
    $stmt = sqlsrv_query($conn, $sql);

    $rows = 0;

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $rows++;
    }

    if ($rows > 0) {
        echo json_encode(false);
    } else {
        echo json_encode(true);
    }

    sqlsrv_close($conn);
}

if (isset($_POST["register"])) {
    $student_number = $_POST["student_number"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile_number = $_POST["mobile_number"];
    $school_branch = $_POST["school_branch"];
    $program = $_POST["program"];
    $year_level = $_POST["year_level"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $account_data = array(
        "name" => $name,
        "student_number" => $student_number,
        "username" => "_null",
        "password" => $password,
        "user_type" => "student",
    );

    $sql = "INSERT INTO tbl_accounts (" . implode(", ", array_keys($account_data)) . ") VALUES ('" . implode("', '", $account_data) . "')";
    sqlsrv_query($conn, $sql);

    $student_data = array(
        "student_number" => $student_number,
        "name" => $name,
        "email" => $email,
        "mobile_number" => $mobile_number,
        "school_branch" => $school_branch,
        "program" => $program,
        "year_level" => $year_level,
    );

    $sql_2 = "INSERT INTO tbl_students (" . implode(", ", array_keys($student_data)) . ") VALUES ('" . implode("', '", $student_data) . "')";
    sqlsrv_query($conn, $sql_2);

    $_SESSION["notification"] = array(
        "title" => "Success",
        "text" => "Your account has been successfully saved in the database.",
        "icon" => "success",
    );

    sqlsrv_close($conn);

    echo json_encode(true);
}

if (isset($_POST["student_login"])) {
    $student_number = $_POST["student_number"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM tbl_accounts WHERE student_number = '" . $student_number . "'";
    $stmt = sqlsrv_query($conn, $sql);

    $rows = 0;

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $db_password = $row["password"];

        $rows++;
    }

    if ($rows)
    {
        
    }

    if (password_verify($password, $db_password)) {
        echo json_encode(true);
    }

    // if ($rows > 0) {
    //     echo json_encode(false);
    // } else {
    //     echo json_encode(true);
    // }
}
