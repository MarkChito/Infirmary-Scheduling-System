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
        "title" => "Success!",
        "text" => "Your account has been successfully saved in the database.",
        "icon" => "success",
    );

    sqlsrv_close($conn);

    echo json_encode(true);
}

if (isset($_POST["student_login"])) {
    $response = false;

    $student_number = $_POST["student_number"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM tbl_accounts WHERE student_number = '" . $student_number . "'";
    $stmt = sqlsrv_query($conn, $sql);

    $rows = 0;

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $db_user_id = $row["id"];
        $db_name = $row["name"];
        $db_password = $row["password"];
        $db_user_type = $row["user_type"];

        $rows++;
    }

    if ($rows) {
        if (password_verify($password, $db_password)) {
            $_SESSION["user_id"] = $db_user_id;
            $_SESSION["user_type"] = $db_user_type;

            $_SESSION["notification"] = array(
                "title" => "Success!",
                "text" => "Welcome, " . $db_name . "!",
                "icon" => "success",
            );

            $response = true;
        } else {
            $_SESSION["notification"] = array(
                "title" => "Oops..",
                "text" => "Invalid Student Number or Password",
                "icon" => "error",
            );

            $response = false;
        }
    } else {
        $_SESSION["notification"] = array(
            "title" => "Oops..",
            "text" => "Invalid Student Number or Password",
            "icon" => "error",
        );

        $response = false;
    }

    sqlsrv_close($conn);

    echo json_encode($response);
}

if (isset($_POST["admin_login"])) {
    $response = false;

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM tbl_accounts WHERE username = '" . $username . "'";
    $stmt = sqlsrv_query($conn, $sql);

    $rows = 0;

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $db_password = $row["password"];

        $rows++;
    }

    if ($rows) {
        if (password_verify($password, $db_password)) {
            $_SESSION["notification"] = array(
                "title" => "Success!",
                "text" => "Administrator account is valid!",
                "icon" => "success",
            );

            $response = true;
        } else {
            $_SESSION["notification"] = array(
                "title" => "Oops..",
                "text" => "Invalid Username or Password",
                "icon" => "error",
            );

            $response = false;
        }
    } else {
        $_SESSION["notification"] = array(
            "title" => "Oops..",
            "text" => "Invalid Username or Password",
            "icon" => "error",
        );

        $response = false;
    }

    sqlsrv_close($conn);

    echo json_encode($response);
}

if (isset($_POST["get_user_data"])) {
    $user_id = $_POST["user_id"];

    $sql = "SELECT * FROM tbl_accounts WHERE id = '" . $user_id . "'";
    $stmt = sqlsrv_query($conn, $sql);

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $response = array(
            "name" => $row["name"],
        );
    }

    sqlsrv_close($conn);

    echo json_encode($response);
}

if (isset($_POST["get_student_data"])) {
    $user_id = $_POST["user_id"];

    $sql_1 = "SELECT * FROM tbl_accounts WHERE id = '" . $user_id . "'";
    $stmt_1 = sqlsrv_query($conn, $sql_1);

    while ($row_1 = sqlsrv_fetch_array($stmt_1, SQLSRV_FETCH_ASSOC)) {
        $student_number = $row_1["student_number"];
    }

    $sql_2 = "SELECT * FROM tbl_students WHERE student_number = '" . $student_number . "'";
    $stmt_2 = sqlsrv_query($conn, $sql_2);

    while ($row_2 = sqlsrv_fetch_array($stmt_2, SQLSRV_FETCH_ASSOC)) {
        $response = array(
            "student_number" => $row_2["student_number"],
            "name" => $row_2["name"],
            "email" => $row_2["email"],
            "program" => $row_2["program"],
            "school_branch" => $row_2["school_branch"],
            "mobile_number" => $row_2["mobile_number"],
            "year_level" => $row_2["year_level"],
        );
    }

    sqlsrv_close($conn);

    echo json_encode($response);
}

if (isset($_POST["get_schedule"])) {
    $day = $_POST["day"];

    $sql = "SELECT TOP 1 * FROM tbl_available_schedules WHERE day = '" . $day . "' AND status = 'Available'";
    $stmt = sqlsrv_query($conn, $sql);

    $row_count = 0;

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $row_count++;

        if ($row_count > 0) {
            $response = array(
                "id" => $row["id"],
                "day" => $row["day"],
                "start_time" => $row["start_time"],
                "end_time" => $row["end_time"],
            );
        }
    }

    sqlsrv_close($conn);

    echo json_encode($response);
}

if (isset($_POST["add_appointment"])) {
    $user_id = $_POST["user_id"];
    $schedule_id = $_POST["schedule_id"];
    $day = $_POST["day"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    $sql_1 = "SELECT * FROM tbl_appointments WHERE student_id = '" . $user_id . "' AND status = 'Pending'";
    $stmt_1 = sqlsrv_query($conn, $sql_1);

    $row_count = 0;

    while ($row = sqlsrv_fetch_array($stmt_1, SQLSRV_FETCH_ASSOC)) {
        $row_count++;
    }

    if ($row_count == 0) {
        $sql_2 = "INSERT INTO tbl_appointments (student_id, day, start_time, end_time, status) VALUES ('" . $user_id . "', '" . $day . "', '" . $start_time . "', '" . $end_time . "', 'Pending')";
        sqlsrv_query($conn, $sql_2);

        $sql_3 = "UPDATE tbl_available_schedules SET status = 'Not Available' WHERE id = '" . $schedule_id . "'";
        sqlsrv_query($conn, $sql_3);

        $_SESSION["notification"] = array(
            "title" => "Success!",
            "text" => "Your request has been submited. Please wait for the confirmation from the Administrator.",
            "icon" => "success",
        );
    } else {
        $_SESSION["notification"] = array(
            "title" => "Oops...",
            "text" => "You still have a pending request. Please contact your Administrator for more help.",
            "icon" => "error",
        );
    }

    sqlsrv_close($conn);

    echo json_encode(true);
}

if (isset($_POST["logout"])) {
    unset($_SESSION["user_id"], $_SESSION["user_type"]);

    $_SESSION["notification"] = array(
        "title" => "Success",
        "text" => "You had been signed out.",
        "icon" => "success",
    );

    echo json_encode(true);
}
