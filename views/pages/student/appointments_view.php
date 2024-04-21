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
                                <th>Purpose of Registration</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
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
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm btn_cancel_appointment" appointment_id="<?= $appointment_data_row["id"] ?>" <?= $appointment_data_row["status"] != "Pending" ? "disabled" : null ?>>Cancel</button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once "views/pages/includes/footer.php" ?>