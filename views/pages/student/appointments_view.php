<?php include_once "views/pages/includes/header.php" ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">My Appointments</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $base_url ?>dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Appointments</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once "./env/autoload.php";

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
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-danger cancel_request" <?= $row["status"] != "Pending" ? "disabled" : null ?> schedule_id="<?= $row["schedule_id"] ?>">Cancel Request</button>
                                                </td>
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
    </section>
</div>

<?php include_once "views/pages/includes/footer.php" ?>