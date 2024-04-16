<?php include_once "views/pages/includes/header.php" ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container d-flex justify-content-center">
            <div class="card mt-5" style="width: 500px;">
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-4">
                        <img src="<?= $base_url ?>dist/img/default-user-image.png" alt="" style="width: 150px; height: 150px; border-radius: 50%;">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <strong>Student Number:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="dashboard_student_number">Loading...</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Student Name:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="dashboard_name">Loading...</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Program:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="dashboard_program">Loading...</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Year Level:</strong>
                        </div>
                        <div class="col-md-8">
                            <span id="dashboard_year_level">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="<?= $base_url ?>profile" class="btn btn-primary w-100">My Profile</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-success w-100" id="generate_schedule">Generate Schedule</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once "views/pages/includes/footer.php" ?>