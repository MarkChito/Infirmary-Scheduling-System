<?php include_once "views/auth/includes/header.php" ?>

<div class="wrapper">
    <div class="login-form">
        <span class="alert alert-danger text-center d-none" id="alert_message"></span>

        <div class="card bg-gray" style="width: 500px;">
            <div class="card-header text-center">
                <img src="./dist/img/image-placeholder.png" style="width: 150px;" alt="Logo" class="mb-2 img-circle pt-3">
                <h1>Infirmary Scheduling System</h1>
            </div>
            <div class="card-body">
                <div class="text-center mb-5">
                    <p class="mb-0" style="font-size: 18px;">Please login to proceed</p>
                    <p style="font-size: 18px;">(Administrator)</p>
                </div>

                <form action="javascript:void(0)" id="admin_login_form">
                    <div class="form-group mb-3">
                        <label for="admin_login_username">Username</label>
                        <input type="text" class="form-control" id="admin_login_username" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="admin_login_password">Password</label>
                        <input type="password" class="form-control" id="admin_login_password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="admin_login_show_password">
                        <label class="form-check-label" for="admin_login_show_password">Show Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="admin_login_submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "views/auth/includes/footer.php" ?>