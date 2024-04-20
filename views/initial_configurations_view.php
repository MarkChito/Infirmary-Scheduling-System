<?php include_once "views/auth/includes/header.php" ?>

<div class="login-wrapper">
    <div class="page-loading d-none">
        <div class="loading-parent">
            <div class="loading-container">
                <div class="loading"></div>
                <div id="loading-text">Loading</div>
            </div>
        </div>
    </div>

    <div class="initial-configurations-form">
        <span class="alert alert-danger text-center d-none" id="alert_message"></span>

        <div class="card bg-gray" style="width: 500px;">
            <div class="card-header text-center">
                <img src="<?= $base_url ?>dist/img/image-placeholder.png" style="width: 150px; height: 150px; border-radius: 50%;" alt="Logo" class="mb-2 mt-2">
                <h1>Infirmary Scheduling System</h1>
            </div>
            <div class="card-body">
                <div class="text-center mb-5">
                    <p class="mb-0" style="font-size: 18px;">Please setup initial configurations</p>
                    <p style="font-size: 18px;">(Developer Page)</p>
                </div>

                <form action="javascript:void(0)" id="initial_configurations_form">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="initial_configurations_server_name">Server Name</label>
                                <input type="text" class="form-control" id="initial_configurations_server_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="initial_configurations_database_name">Database Name</label>
                                <input type="text" class="form-control" id="initial_configurations_database_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="initial_configurations_authentication">Authentication</label>
                                <select class="form-control" id="initial_configurations_authentication">
                                    <option value="Windows Authentication">Windows Authentication</option>
                                    <option value="SQL Server Authentication">SQL Server Authentication</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="initial_configurations_sql_server_authentication">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="initial_configurations_uid">User ID</label>
                                    <input type="text" class="form-control" id="initial_configurations_uid">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="initial_configurations_password">Password</label>
                                    <input type="password" class="form-control" id="initial_configurations_password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2 mt-2" id="initial_configurations_submit">Connect</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "views/auth/includes/footer.php" ?>