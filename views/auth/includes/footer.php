    <!-- Register Modal -->
    <div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create an Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" id="register_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="register_student_number">Student Number</label>
                                    <input type="number" class="form-control" id="register_student_number" required>
                                    <small class="text-danger d-none" id="error_register_student_number">Invalid Student Number</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="register_name">Name</label>
                                    <input type="text" class="form-control" id="register_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="register_email">Email</label>
                                    <input type="email" class="form-control" id="register_email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="register_mobile_number">Mobile Number</label>
                                    <input type="number" class="form-control" id="register_mobile_number" required>
                                    <small class="text-danger d-none" id="error_register_mobile_number">Invalid Mobile Number</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="register_school_branch">School Branch</label>
                                    <select id="register_school_branch" class="custom-select" required>
                                        <option value="" selected disabled>-- Choose --</option>
                                        <option value="Manila">Manila</option>
                                        <option value="Quezon City">Quezon City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="register_program">Program</label>
                                    <select id="register_program" class="custom-select" required>
                                        <option value="" selected disabled>-- Choose --</option>
                                        <option value="BSCS">BSCS</option>
                                        <option value="BSIT">BSIT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="register_year_level">Year Level</label>
                                    <select id="register_year_level" class="custom-select" required>
                                        <option value="" selected disabled>-- Choose --</option>
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="register_password">Password</label>
                                    <input type="password" class="form-control" id="register_password" required>
                                    <small class="text-danger d-none" id="error_register_password">Passwords do not match</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="register_confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="register_confirm_password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="register_submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= $base_url ?>plugins/jquery/jquery.min.js?v=<?= $version ?>"></script>
    <script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js?v=<?= $version ?>"></script>
    <script src="<?= $base_url ?>dist/js/adminlte.min.js?v=<?= $version ?>"></script>
    <script src="<?= $base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        jQuery(document).ready(function() {
            const base_url = "<?= $base_url ?>";
            const notification = <?= isset($_SESSION["notification"]) ? json_encode($_SESSION["notification"]) : json_encode(null) ?>;

            if (notification) {
                sweetalert(notification);
            }

            $("#initial_configurations_form").submit(function() {
                const server_name = $("#initial_configurations_server_name").val();
                const database = $("#initial_configurations_database_name").val();
                const uid = $("#initial_configurations_uid").val();
                const pwd = $("#initial_configurations_password").val();

                $(".initial-configurations-form").addClass("d-none");
                $(".loading").removeClass("d-none");

                var formData = new FormData();

                formData.append('server_name', server_name);
                formData.append('database', database);
                formData.append('uid', uid);
                formData.append('pwd', pwd);
                formData.append('check_database_connection', true);

                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response) {
                            const status = response.status;

                            if (status == 200) {
                                setTimeout(function() {
                                    location.href = base_url;
                                }, 1500);
                            } else {
                                $(".loading").addClass("d-none");

                                $("#alert_message").text(response.message);
                                $("#alert_message").removeClass("d-none");
                                $("#alert_message").addClass("d-block");
                                $(".initial-configurations-form").removeClass("d-none");
                            }
                        }
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            })

            $("#login_show_password").change(function() {
                var passwordField = $("#login_password");
                var passwordFieldType = passwordField.attr("type");

                if ($(this).is(":checked")) {
                    passwordField.attr("type", "text");
                } else {
                    passwordField.attr("type", "password");
                }
            })

            $('#initial_configurations_authentication').change(function() {
                if ($(this).val() == 'Windows Authentication') {
                    $('#initial_configurations_sql_server_authentication').collapse('hide');

                    $('#initial_configurations_uid').removeAttr("required");
                    $('#initial_configurations_password').removeAttr("required");
                } else {
                    $('#initial_configurations_sql_server_authentication').collapse('show');

                    $('#initial_configurations_uid').attr("required", true);
                    $('#initial_configurations_password').attr("required", true);
                }
            })

            $("#register_form").submit(function() {
                const student_number = $("#register_student_number").val();
                const name = $("#register_name").val();
                const email = $("#register_email").val();
                const mobile_number = $("#register_mobile_number").val();
                const school_branch = $("#register_school_branch").val();
                const program = $("#register_program").val();
                const year_level = $("#register_year_level").val();
                const password = $("#register_password").val();
                const confirm_password = $("#register_confirm_password").val();

                var errors = 0;

                if (error_student_number(student_number)) {
                    $("#error_register_student_number").text(error_student_number(student_number));
                    $("#error_register_student_number").removeClass("d-none");
                    $("#register_student_number").addClass("is-invalid");

                    errors++;
                }

                if (error_mobile_number(mobile_number)) {
                    $("#error_register_mobile_number").text(error_mobile_number(mobile_number));
                    $("#error_register_mobile_number").removeClass("d-none");
                    $("#register_mobile_number").addClass("is-invalid");

                    errors++;
                }

                if (error_password(password, confirm_password)) {
                    $("#error_register_password").text(error_password(password, confirm_password));
                    $("#error_register_password").removeClass("d-none");

                    $("#register_password").addClass("is-invalid");
                    $("#register_confirm_password").addClass("is-invalid");

                    errors++;
                }

                if (errors == 0) {
                    $("#register_submit").text("Please wait...");
                    $("#register_submit").attr("disabled", true);

                    var formData = new FormData();

                    formData.append('student_number', student_number);
                    formData.append('check_student_number', true);

                    $.ajax({
                        url: 'server.php',
                        data: formData,
                        type: 'POST',
                        dataType: 'JSON',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response) {
                                var formData = new FormData();

                                formData.append('student_number', student_number);
                                formData.append('name', name);
                                formData.append('email', email);
                                formData.append('mobile_number', mobile_number);
                                formData.append('school_branch', school_branch);
                                formData.append('program', program);
                                formData.append('year_level', year_level);
                                formData.append('password', password);

                                formData.append('register', true);

                                $.ajax({
                                    url: 'server.php',
                                    data: formData,
                                    type: 'POST',
                                    dataType: 'JSON',
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        if (response) {
                                            location.href = base_url;
                                        }
                                    },
                                    error: function(_, _, error) {
                                        console.error(error);
                                    }
                                });
                            } else {
                                $("#error_register_student_number").text("Student Number is already in use");
                                $("#error_register_student_number").removeClass("d-none");
                                $("#register_student_number").addClass("is-invalid");
                                
                                $("#register_submit").removeAttr("disabled");
                                $("#register_submit").text("Submit");
                            }
                        },
                        error: function(_, _, error) {
                            console.error(error);
                        }
                    })
                }
            })

            $("#register_student_number").keydown(function() {
                $("#register_student_number").removeClass("is-invalid");
                $("#error_register_student_number").addClass("d-none");
            })

            $("#register_mobile_number").keydown(function() {
                $("#register_mobile_number").removeClass("is-invalid");
                $("#error_register_mobile_number").addClass("d-none");
            })

            $("#register_password").keydown(function() {
                $("#register_password").removeClass("is-invalid");
                $("#register_confirm_password").removeClass("is-invalid");

                $("#error_register_password").addClass("d-none");
            })

            $("#register_confirm_password").keydown(function() {
                $("#register_password").removeClass("is-invalid");
                $("#register_confirm_password").removeClass("is-invalid");

                $("#error_register_password").addClass("d-none");
            })

            $("#login_form").submit(function(){
                const student_number = $("#login_student_number").val();
                const password = $("#login_password").val();

                var formData = new FormData();
                
                formData.append('student_number', student_number);
                formData.append('password', password);

                formData.append('student_login', true);
                
                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    // dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            })

            function error_student_number(student_number) {
                if (student_number.length != 7) {
                    return "Student Number must be 7 digits long";
                } else {
                    return false;
                }
            }

            function error_mobile_number(mobile_number) {
                var pattern = /^09/;

                if (mobile_number.length != 11) {
                    return "Mobile Number must be 11 digits long";
                } else if (!pattern.test(mobile_number)) {
                    return "Mobile Number must start with 09";
                } else {
                    return false;
                }
            }

            function error_password(password, confirm_password) {
                if (password != confirm_password) {
                    return "Passwords do not match";
                } else if (password.length < 8) {
                    return "Password must be at least 8 digits long";
                } else {
                    return false;
                }
            }

            function sweetalert(notification) {
                Swal.fire({
                    title: notification.title,
                    text: notification.text,
                    icon: notification.icon
                });
            }
        })
    </script>
    </body>

    </html>

    <?php unset($_SESSION["notification"]) ?>