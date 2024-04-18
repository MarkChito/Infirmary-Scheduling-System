<?php
require_once "./env/autoload.php";
require_once "./phpmailer/autoload.php";

date_default_timezone_set('Asia/Manila');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$env_data = readFromEnvFile();

$php_mailer = new EMail("Infirmary Scheduling System", "phpmailer.00001@gmail.com", "vhmfoycjdqbnqeqq");

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

    $base_url = $env_data["BASE_URL"];
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

if (isset($_POST["validate_student_number_and_email"])) {
    $email = $_POST["email"];
    $student_number = $_POST["student_number"];

    $response = null;
    $student_number_error = null;
    $email_error = null;

    $sql_1 = "SELECT student_number FROM tbl_accounts WHERE student_number = '" . $student_number . "'";
    $stmt_1 = sqlsrv_query($conn, $sql_1);

    if (sqlsrv_has_rows($stmt_1)) {
        $student_number_error = "Student Number is already in use";
    }

    $sql_2 = "SELECT email FROM tbl_students WHERE email = '" . $email . "'";
    $stmt_2 = sqlsrv_query($conn, $sql_2);

    if (sqlsrv_has_rows($stmt_2)) {
        $email_error = "Email is already in use";
    }

    if ($student_number_error || $email_error) {
        $response = array(
            "student_number_error" => $student_number_error,
            "email_error" => $email_error,
        );
    }

    sqlsrv_close($conn);

    echo json_encode($response);
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

    $message = "
        <p>Dear " . $name . ",</p>
        <p>Thank you for signing up with us! To ensure the security of your account and to activate all features, we kindly ask you to verify your email address.</p>
        <p>Please click on the following link to complete the verification process:</p>
        <p><a href='" . $base_url . "verify_email.php?guid=" . md5(strval(date("h:i:s"))) . "&student_number=" . $student_number . "&encryption=" . sha1(strval(date("h:i:s"))) . "&email=" . $email . "&cacheid=" . password_hash(strval(date("h:i:s")), PASSWORD_ARGON2I) . "'>Verify Email Address</a></p>
        <p>If the link does not work, you can copy and paste it into your browser's address bar.</p>
        <p>Thank you for choosing us! If you have any questions or need further assistance, feel free to contact our support team.</p>
        <p>Best regards,<br>Infirmary Scheduling System</p>
    ";

    if ($php_mailer->send($name, $email, "Email Verification", $message)) {
        $account_data = array(
            "created_at" => date("Y-m-d H:i:s"),
            "created_by" => $name,
            "name" => $name,
            "student_number" => $student_number,
            "password" => $password,
            "user_type" => "student",
            "is_verified" => 0,
        );

        $sql_1 = "INSERT INTO tbl_accounts (" . implode(", ", array_keys($account_data)) . ") VALUES ('" . implode("', '", $account_data) . "')";
        sqlsrv_query($conn, $sql_1);

        $sql_2 = "SELECT id FROM tbl_accounts WHERE student_number = '" . $student_number . "'";
        $stmt_2 = sqlsrv_query($conn, $sql_2);

        while ($row = sqlsrv_fetch_array($stmt_2, SQLSRV_FETCH_ASSOC)) {
            $db_user_id = $row["id"];
        }

        $student_data = array(
            "created_at" => date("Y-m-d H:i:s"),
            "created_by" => $name,
            "student_id" => $db_user_id,
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
            "title" => "Attention!",
            "text" => "Please visit your email to verify your account.",
            "icon" => "warning",
        );

        sqlsrv_close($conn);
    } else {
        $_SESSION["notification"] = array(
            "title" => "Oops..",
            "text" => "There was a problem while processing your request.",
            "icon" => "error",
        );
    }

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
        $db_is_verified = $row["is_verified"];

        $rows++;
    }

    if ($rows) {
        if (password_verify($password, $db_password)) {
            if ($db_is_verified == "1") {
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
                    "title" => "Attention!",
                    "text" => "Please verify this account first.",
                    "icon" => "warning",
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
            "student_number" => $row["student_number"],
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

if (isset($_POST["get_profile_data"])) {
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

    $response = false;

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

    $sql_1 = "SELECT * FROM tbl_appointments WHERE student_id = '" . $user_id . "' AND (status = 'Pending' OR status = 'Approved')";
    $stmt_1 = sqlsrv_query($conn, $sql_1);

    $row_count = 0;

    while ($row = sqlsrv_fetch_array($stmt_1, SQLSRV_FETCH_ASSOC)) {
        $row_count++;
    }

    if ($row_count == 0) {
        $sql_2 = "INSERT INTO tbl_appointments (student_id, schedule_id, status) VALUES ('" . $user_id . "', '" . $schedule_id . "', 'Pending')";
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
            "text" => "You still have an active schedule or pending request. Please contact your Administrator for more help.",
            "icon" => "error",
        );
    }

    sqlsrv_close($conn);

    echo json_encode(true);
}

if (isset($_POST["update_profile"])) {
    $student_number = $_POST["student_number"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile_number = $_POST["mobile_number"];
    $school_branch = $_POST["school_branch"];
    $program = $_POST["program"];
    $year_level = $_POST["year_level"];
    $old_student_number = $_POST["old_student_number"];

    $response = false;
    $errors = 0;

    if ($student_number != $old_student_number) {
        $sql_1 = "SELECT * FROM tbl_accounts WHERE student_number = '" . $student_number . "'";
        $stmt_1 = sqlsrv_query($conn, $sql_1);

        $row_count = 0;

        while ($row = sqlsrv_fetch_array($stmt_1, SQLSRV_FETCH_ASSOC)) {
            $row_count++;
        }

        if ($row_count > 0) {
            $errors++;
        }
    }

    if ($errors == 0) {
        $sql_2 = "SELECT * FROM tbl_accounts WHERE student_number = '" . $old_student_number . "'";
        $stmt_2 = sqlsrv_query($conn, $sql_2);

        while ($row = sqlsrv_fetch_array($stmt_2, SQLSRV_FETCH_ASSOC)) {
            $db_user_id = $row["id"];
        }

        $sql_3 = "UPDATE tbl_accounts SET student_number = '" . $student_number . "', name = '" . $name . "' WHERE id = '" . $db_user_id . "'";
        sqlsrv_query($conn, $sql_3);

        $sql_4 = "UPDATE tbl_students SET student_number = '" . $student_number . "', name = '" . $name . "', email = '" . $email . "', mobile_number = '" . $mobile_number . "', school_branch = '" . $school_branch . "', program = '" . $program . "', year_level = '" . $year_level . "' WHERE student_id = '" . $db_user_id . "'";
        sqlsrv_query($conn, $sql_4);

        $_SESSION["notification"] = array(
            "title" => "Success!",
            "text" => "Your profile has been successfully updated.",
            "icon" => "success",
        );

        $response = true;
    }

    sqlsrv_close($conn);

    echo json_encode($response);
}

if (isset($_POST["update_account"])) {
    $student_number = $_POST["student_number"];
    $current_password = $_POST["current_password"];
    $password = $_POST["password"];

    $response = false;

    $sql = "SELECT * FROM tbl_accounts WHERE student_number = '" . $student_number . "'";
    $stmt = sqlsrv_query($conn, $sql);

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $db_password = $row["password"];
    }

    if (password_verify($current_password, $db_password)) {
        $sql_2 = "UPDATE tbl_accounts SET password = '" . password_hash($password, PASSWORD_BCRYPT) . "' WHERE student_number = '" . $student_number . "'";
        sqlsrv_query($conn, $sql_2);

        $response = true;

        $_SESSION["notification"] = array(
            "title" => "Success!",
            "text" => "Your password has been successfully updated.",
            "icon" => "success",
        );
    }

    sqlsrv_close($conn);

    echo json_encode($response);
}

if (isset($_POST["cancel_request"])) {
    $user_id = $_POST["user_id"];
    $schedule_id = $_POST["schedule_id"];

    $sql_1 = "UPDATE tbl_appointments SET status = 'Cancelled' WHERE student_id = '" . $user_id . "' AND schedule_id = '" . $schedule_id . "'";
    sqlsrv_query($conn, $sql_1);

    $sql_2 = "UPDATE tbl_available_schedules SET status = 'Available' WHERE id = '" . $schedule_id . "'";
    sqlsrv_query($conn, $sql_2);

    $_SESSION["notification"] = array(
        "title" => "Success!",
        "text" => "A schedule has been cancelled.",
        "icon" => "success",
    );

    sqlsrv_close($conn);

    echo json_encode(true);
}

if (isset($_POST["get_pending_schedule"])) {
    $user_id = $_POST["user_id"];

    $response = false;

    $sql_1 = "SELECT TOP 1 * FROM tbl_appointments WHERE student_id = '" . $user_id . "' AND status = 'Pending'";
    $stmt_1 = sqlsrv_query($conn, $sql_1);

    $row_count = 0;

    while ($row_1 = sqlsrv_fetch_array($stmt_1, SQLSRV_FETCH_ASSOC)) {
        $db_schedule_id = $row_1["schedule_id"];

        $row_count++;
    }

    if ($row_count > 0) {
        $sql_2 = "SELECT start_time, end_time FROM tbl_available_schedules WHERE id = '" . $db_schedule_id . "'";
        $stmt_2 = sqlsrv_query($conn, $sql_2);

        while ($row_2 = sqlsrv_fetch_array($stmt_2, SQLSRV_FETCH_ASSOC)) {
            $response = array(
                "start_time" => $row_2["start_time"],
                "end_time" => $row_2["end_time"],
            );
        }
    }

    echo json_encode($response);
}

if (isset($_POST["verify_email"])) {
    $student_number = $_POST["student_number"];
    $email = $_POST["email"];

    $sql_1 = "SELECT name FROM tbl_students WHERE student_number = '" . $student_number . "' AND email = '" . $email . "'";
    $stmt_1 = sqlsrv_query($conn, $sql_1);

    if (sqlsrv_has_rows($stmt_1)) {
        while ($row = sqlsrv_fetch_array($stmt_1, SQLSRV_FETCH_ASSOC)) {
            $name = $row["name"];
        }

        $sql_2 = "UPDATE tbl_accounts SET modified_at = '" . date("Y-m-d H:i:s") . "', modified_by = '" . $name . "', is_verified = '1' WHERE student_number = '" . $student_number . "'";
        sqlsrv_query($conn, $sql_2);

        $_SESSION["notification"] = array(
            "title" => "Success!",
            "text" => "Your account has been verified. You can now login.",
            "icon" => "success",
        );
    } else {
        $_SESSION["notification"] = array(
            "title" => "Oops...",
            "text" => "Invalid or expired link.",
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
