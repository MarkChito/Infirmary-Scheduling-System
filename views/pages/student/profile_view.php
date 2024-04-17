<?php include_once "views/pages/includes/header.php" ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $base_url ?>dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?= $base_url ?>dist/img/default-user-image.png" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center" id="profile_name">Loading...</h3>

                            <p class="text-muted text-center" id="profile_program_year_level">Loading...</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Student Number</b> <a class="float-right" id="profile_student_number">Loading...</a>
                                </li>
                                <li class="list-group-item">
                                    <b>School Branch</b> <a class="float-right" id="profile_school_branch">Loading...</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right" id="profile_email">Loading...</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Mobile Number</b> <a class="float-right" id="profile_mobile_number">Loading...</a>
                                </li>
                            </ul>

                            <a href="javascript:void(0)" class="btn btn-primary btn-block account_settings"><b>Account Settings</b></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="tab-pane">
                                <form class="form-horizontal" action="javascript:void(0)" id="update_profile_form">
                                    <div class="form-group row">
                                        <label for="update_profile_student_number" class="col-sm-2 col-form-label">Student Number</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="update_profile_student_number" placeholder="Student Number" required>
                                            <small class="text-danger d-none" id="error_update_profile_student_number">Student Number is already in use</small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="update_profile_name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="update_profile_name" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="update_profile_email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="update_profile_email" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="update_profile_mobile_number" class="col-sm-2 col-form-label">Mobile Number</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="update_profile_mobile_number" placeholder="Mobile Number" required>
                                            <small class="text-danger d-none" id="error_update_profile_mobile_number">Mobile Number must be 11 digits long</small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="update_profile_school_branch" class="col-sm-2 col-form-label">School Branch</label>
                                        <div class="col-sm-10">
                                            <select id="update_profile_school_branch" class="custom-select" required>
                                                <option value="" selected disabled>-- Choose --</option>
                                                <option value="Manila">Manila</option>
                                                <option value="Quezon City">Quezon City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="update_profile_program" class="col-sm-2 col-form-label">Program</label>
                                        <div class="col-sm-10">
                                            <select id="update_profile_program" class="custom-select" required>
                                                <option value="" selected disabled>-- Choose --</option>
                                                <option value="BSCS">BSCS</option>
                                                <option value="BSIT">BSIT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="update_profile_year_level" class="col-sm-2 col-form-label">Year Level</label>
                                        <div class="col-sm-10">
                                            <select id="update_profile_year_level" class="custom-select" required>
                                                <option value="" selected disabled>-- Choose --</option>
                                                <option value="1st Year">1st Year</option>
                                                <option value="2nd Year">2nd Year</option>
                                                <option value="3rd Year">3rd Year</option>
                                                <option value="4th Year">4th Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <input type="hidden" id="old_update_profile_student_number">

                                        <div class="col-sm-2">
                                            <!-- Pass -->
                                        </div>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary w-100" id="update_profile_submit">Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once "views/pages/includes/footer.php" ?>