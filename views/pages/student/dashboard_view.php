<?php include_once "views/pages/includes/header.php" ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-primary float-right" id="generate_schedule">
                        <i class="fas fa-calendar-plus mr-1"></i>
                        Generate Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3 id="dashboard_todays_schedule">N/A</h3>

                            <p>Today's Schedule</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <a href="<?= $base_url ?>appointments" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="dashboard_pending_schedule">N/A</h3>

                            <p>Pending Schedule</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="<?= $base_url ?>appointments" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="dashboard_expired_schedules">0</h3>

                            <p>Expired Schedules</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hourglass-end"></i>
                        </div>
                        <a href="<?= $base_url ?>appointments" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?= $base_url ?>dist/img/default-user-image.png" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center" id="dashboard_name">Loading...</h3>

                            <p class="text-muted text-center" id="dashboard_program_year_level">Loading...</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Student Number</b> <a class="float-right" id="dashboard_student_number">Loading...</a>
                                </li>
                                <li class="list-group-item">
                                    <b>School Branch</b> <a class="float-right" id="dashboard_school_branch">Loading...</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right" id="dashboard_email">Loading...</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Mobile Number</b> <a class="float-right" id="dashboard_mobile_number">Loading...</a>
                                </li>
                            </ul>

                            <a href="<?= $base_url ?>profile" class="btn btn-primary btn-block"><b>My Profile</b></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once "./env_functions.php";

                                        $env_data = readFromEnvFile();

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

                                        $sql = "SELECT * FROM tbl_appointments WHERE student_id = '" . $user_id . "' ORDER BY id DESC";
                                        $stmt = sqlsrv_query($conn, $sql);
                                        ?>

                                        <?php if (sqlsrv_has_rows($stmt)) : ?>
                                            <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) : ?>
                                                <?php
                                                $sql_2 = "SELECT * FROM tbl_available_schedules WHERE id = '" . $row["schedule_id"] . "'";
                                                $stmt_2 = sqlsrv_query($conn, $sql_2);
                                                ?>
                                                <?php if (sqlsrv_has_rows($stmt_2)) : ?>
                                                    <?php while ($row_2 = sqlsrv_fetch_array($stmt_2, SQLSRV_FETCH_ASSOC)) : ?>
                                                        <?php
                                                        switch ($row["status"]) {
                                                            case "Pending":
                                                                $status_color = "text-success";

                                                                break;
                                                            case "Approved":
                                                                $status_color = "text-primary";

                                                                break;
                                                            case "Expired":
                                                                $status_color = "text-danger";

                                                                break;
                                                            case "Cancelled":
                                                                $status_color = "text-danger";

                                                                break;
                                                            case "Rejected":
                                                                $status_color = "text-danger";

                                                                break;
                                                            default:
                                                                // Ignore this line
                                                        }
                                                        ?>

                                                        <tr>
                                                            <td><?= $row_2["day"] ?></td>
                                                            <td><?= date("g:i A", strtotime($row_2["start_time"])) ?></td>
                                                            <td><?= date("g:i A", strtotime($row_2["end_time"])) ?></td>
                                                            <td class="<?= $status_color ?>"><?= $row["status"] ?></td>
                                                        </tr>
                                                    <?php endwhile ?>
                                                <?php endif ?>
                                            <?php endwhile ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once "views/pages/includes/footer.php" ?>