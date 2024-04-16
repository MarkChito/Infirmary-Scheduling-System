<?php include_once "views/pages/includes/header.php" ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">My Appointments</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="appointments_data">
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

                    $sql = "SELECT * FROM tbl_appointments WHERE student_id = '" . $user_id . "'";
                    $stmt = sqlsrv_query($conn, $sql);
                    ?>

                    <?php if (sqlsrv_has_rows($stmt)) : ?>
                        <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) : ?>
                            <tr>
                                <td><?= $row["day"] ?></td>
                                <td><?= date("g:i A", strtotime($row["start_time"])) ?></td>
                                <td><?= date("g:i A", strtotime($row["end_time"])) ?></td>
                                <td><?= $row["status"] ?></td>
                            </tr>
                        <?php endwhile ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?php include_once "views/pages/includes/footer.php" ?>