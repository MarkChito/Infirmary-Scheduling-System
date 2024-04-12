<?php include_once "views/auth/includes/header.php" ?>

<div class="wrapper">
    <div class="login-form">
        <span class="alert alert-danger text-center d-none" id="alert_message"></span>

        <div class="glass-card" style="width: 500px;">
            <div class="card-header text-center">
                <img src="./dist/img/logo.png" style="width: 150px;" alt="Logo" class="mb-2 pt-3">
                <h1>Infirmary Scheduling System</h1>
            </div>
            <div class="card-body">
                <p class="text-center mb-5" style="font-size: 18px;">Please login to proceed</p>

                <form action="javascript:void(0)" id="login_form">
                    <div class="form-group mb-3">
                        <label for="login_student_number">Student Number</label>
                        <input type="text" class="form-control" id="login_student_number" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="login_password">Password</label>
                        <input type="password" class="form-control" id="login_password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="login_show_password">
                        <label class="form-check-label" for="login_show_password">Show Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2" id="login_submit">Login</button>

                    <div class="mt-1">
                        <span>Don't have an account?</span>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#register_modal" class="text-light">Register here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "views/auth/includes/footer.php" ?>