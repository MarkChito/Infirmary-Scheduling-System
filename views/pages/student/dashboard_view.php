<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-primary float-right" id="generate_schedule" disabled>
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
                        <div class="inner pb-4">
                            <h5 id="dashboard_todays_schedule">No Available Data</h5>

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
                        <div class="inner pb-4">
                            <h5 id="dashboard_pending_schedule">No Available Data</h5>

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
                        <div class="inner pb-4">
                            <h5 id="dashboard_expired_schedules">0</h5>

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

                            <p class="text-muted text-center" id="dashboard_student_number">Loading...</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>School Branch</b> <a class="float-right" id="dashboard_school_branch">Loading...</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Program</b> <a class="float-right" id="dashboard_program">Loading...</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Year Level</b> <a class="float-right" id="dashboard_year_level">Loading...</a>
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
                                            <th>Purpose of Registration</th>
                                            <th>Appointment Date</th>
                                            <th>Appointment Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($appointment_data) : ?>
                                            <?php foreach ($appointment_data as $appointment_data_row) : ?>
                                                <?php
                                                switch ($appointment_data_row["status"]) {
                                                    case "Pending":
                                                        $status_color = "text-success";

                                                        break;
                                                    case "Approved":
                                                        $status_color = "text-primary";

                                                        break;
                                                    case "Rejected":
                                                        $status_color = "text-danger";

                                                        break;
                                                    case "Expired":
                                                        $status_color = "text-danger";

                                                        break;
                                                    case "Cancelled":
                                                        $status_color = "text-danger";

                                                        break;
                                                    default:
                                                        $status_color = null;
                                                }
                                                ?>
                                                <tr>
                                                    <td><?= $appointment_data_row["purpose_of_registration"] ?></td>
                                                    <td><?= date("F j, Y", strtotime($appointment_data_row["appointment_date"])) ?></td>
                                                    <td><?= $appointment_data_row["appointment_time"] ?></td>
                                                    <td class="<?= $status_color ?>"><?= $appointment_data_row["status"] ?></td>
                                                </tr>
                                            <?php endforeach ?>
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