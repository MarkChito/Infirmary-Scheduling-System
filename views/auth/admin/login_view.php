<div class="login-wrapper">
    <div class="login-form">
        <div class="alert text-center fade d-none" id="div_alert_message" role="alert">
            <span id="span_alert_message"></span>
        </div>

        <div class="card bg-gray" style="width: 500px;">
            <div class="card-header text-center">
                <img src="./dist/img/image-placeholder.png" style="width: 150px; height: 150px; border-radius: 50%;" alt="Logo" class="mb-2 mt-3">
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