    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="<?= $base_url ?>dashboard">Infirmary Scheduling System</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> <?= $version ?>
        </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <!-- Update Account Modal -->
    <div class="modal fade" id="update_account_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" id="update_account_form">
                    <div class="modal-body">
                        <div class="loading d-flex justify-content-center">
                            <img src="<?= $base_url ?>dist/img/loading-2.gif" alt="Loading">
                        </div>
                        <div class="actual-form d-none">
                            <div class="form-group">
                                <label for="update_account_student_number">Student Number</label>
                                <input type="number" class="form-control" id="update_account_student_number" readonly>
                            </div>
                            <div class="form-group">
                                <label for="update_account_current_password">Current Password</label>
                                <input type="password" class="form-control" id="update_account_current_password" required>
                                <small class="text-danger d-none" id="error_update_account_current_password">Password is incorrect</small>
                            </div>
                            <div class="form-group">
                                <label for="update_account_password">Password</label>
                                <input type="password" class="form-control" id="update_account_password" required>
                                <small class="text-danger d-none" id="error_update_account_password">Passwords do not match</small>
                            </div>
                            <div class="form-group">
                                <label for="update_account_confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" id="update_account_confirm_password" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="update_account_submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= $base_url ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?= $base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= $base_url ?>plugins/uibutton/uibutton.js"></script>
    <script src="<?= $base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $base_url ?>plugins/chart.js/Chart.min.js"></script>
    <script src="<?= $base_url ?>plugins/sparklines/sparkline.js"></script>
    <script src="<?= $base_url ?>plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= $base_url ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="<?= $base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="<?= $base_url ?>plugins/moment/moment.min.js"></script>
    <script src="<?= $base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?= $base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="<?= $base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
    <script src="<?= $base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="<?= $base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= $base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= $base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= $base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= $base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= $base_url ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= $base_url ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= $base_url ?>plugins/jszip/jszip.min.js"></script>
    <script src="<?= $base_url ?>plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= $base_url ?>plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= $base_url ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= $base_url ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= $base_url ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?= $base_url ?>dist/js/adminlte.js"></script>

    <script>
        jQuery(document).ready(function() {
            const base_url = "<?= $base_url ?>";
            const user_id = "<?= $user_id ?>";
            const user_type = "<?= $user_type ?>";
            const current_tab = "<?= $current_tab ?>";
            const notification = <?= isset($_SESSION["notification"]) ? json_encode($_SESSION["notification"]) : json_encode(null) ?>;
            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const current_date = new Date();
            const dayOfWeek = current_date.getDay();

            disable_developer_functions(true);

            get_account_data(user_id);

            if (user_type == "student") {
                if (current_tab == "dashboard") {
                    get_student_data(user_id);
                }

                if (current_tab == "profile") {
                    get_profile_data(user_id);
                }
            }

            if (notification) {
                sweetalert(notification);
            }

            $('.data-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            })

            $(".logout").click(function() {
                var formData = new FormData();

                formData.append('logout', true);

                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.href = base_url;
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            })

            $("#update_profile_form").submit(function() {
                const student_number = $("#update_profile_student_number").val();
                const first_name = $("#update_profile_first_name").val();
                const middle_name = $("#update_profile_middle_name").val();
                const last_name = $("#update_profile_last_name").val();
                const email = $("#update_profile_email").val();
                const mobile_number = $("#update_profile_mobile_number").val();
                const school_branch = $("#update_profile_school_branch").val();
                const program = $("#update_profile_program").val();
                const year_level = $("#update_profile_year_level").val();

                const old_student_number = $("#old_update_profile_student_number").val();

                let name = first_name + " " + last_name;

                if (middle_name) {
                    const middle_initial = middle_name.trim().charAt(0).toUpperCase() + ".";

                    name = first_name + " " + middle_initial + " " + last_name;
                }

                let errors = 0;

                if (error_student_number(student_number)) {
                    $("#error_update_profile_student_number").text(error_student_number(student_number));
                    $("#error_update_profile_student_number").removeClass("d-none");
                    $("#update_profile_student_number").addClass("is-invalid");

                    errors++;
                }

                if (error_mobile_number(mobile_number)) {
                    $("#error_update_profile_mobile_number").text(error_mobile_number(mobile_number));
                    $("#error_update_profile_mobile_number").removeClass("d-none");
                    $("#update_profile_mobile_number").addClass("is-invalid");

                    errors++;
                }

                if (errors == 0) {
                    $("#update_profile_submit").text("Please wait...");
                    $("#update_profile_submit").attr("disabled", true);

                    var formData = new FormData();

                    formData.append('student_number', student_number);
                    formData.append('first_name', first_name);
                    formData.append('middle_name', middle_name);
                    formData.append('last_name', last_name);
                    formData.append('name', name);
                    formData.append('email', email);
                    formData.append('mobile_number', mobile_number);
                    formData.append('school_branch', school_branch);
                    formData.append('program', program);
                    formData.append('year_level', year_level);
                    formData.append('old_student_number', old_student_number);

                    formData.append('update_profile', true);

                    $.ajax({
                        url: 'server.php',
                        data: formData,
                        type: 'POST',
                        dataType: 'JSON',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response) {
                                location.href = base_url + "profile";
                            } else {
                                $("#error_update_profile_student_number").text("Student Number is already in use");
                                $("#error_update_profile_student_number").removeClass("d-none");
                                $("#update_profile_student_number").addClass("is-invalid");

                                $("#update_profile_submit").removeAttr("disabled");
                                $("#update_profile_submit").text("Update Profile");
                            }
                        },
                        error: function(_, _, error) {
                            console.error(error);
                        }
                    });
                }
            })

            $("#update_profile_mobile_number").keydown(function() {
                $("#error_update_profile_mobile_number").addClass("d-none");
                $("#update_profile_mobile_number").removeClass("is-invalid");
            })

            $("#update_profile_student_number").keydown(function() {
                $("#error_update_profile_student_number").addClass("d-none");
                $("#update_profile_student_number").removeClass("is-invalid");
            })

            $(".account_settings").click(function() {
                $(".loading").removeClass("d-none");
                $(".loading").addClass("d-flex");
                $(".actual-form").addClass("d-none");

                $("#update_account_modal").modal("show");

                var formData = new FormData();

                formData.append('user_id', user_id);
                formData.append('get_user_data', true);

                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#update_account_student_number").val(response.student_number);

                        $(".loading").addClass("d-none");
                        $(".loading").removeClass("d-flex");
                        $(".actual-form").removeClass("d-none");
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            })

            $("#update_account_form").submit(function() {
                const student_number = $("#update_account_student_number").val();
                const current_password = $("#update_account_current_password").val();
                const password = $("#update_account_password").val();
                const confirm_password = $("#update_account_confirm_password").val();

                if (error_password(password, confirm_password)) {
                    $("#error_update_account_password").text(error_password(password, confirm_password));
                    $("#error_update_account_password").removeClass("d-none");
                    $("#update_account_password").addClass("is-invalid");
                    $("#update_account_confirm_password").addClass("is-invalid");
                } else {
                    $("#update_account_submit").text("Please wait...");
                    $("#update_account_submit").attr("disabled", true);

                    var formData = new FormData();

                    formData.append('student_number', student_number);
                    formData.append('current_password', current_password);
                    formData.append('password', password);
                    
                    formData.append('update_account', true);

                    $.ajax({
                        url: 'server.php',
                        data: formData,
                        type: 'POST',
                        dataType: 'JSON',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response) {
                                location.href = base_url + current_tab;
                            } else {
                                $("#error_update_account_current_password").removeClass("d-none");
                                $("#update_account_current_password").addClass("is-invalid");

                                $("#update_account_submit").removeAttr("disabled");
                                $("#update_account_submit").text("Submit");
                            }
                        },
                        error: function(_, _, error) {
                            console.error(error);
                        }
                    });
                }
            })

            $("#update_account_password").keydown(function() {
                $("#error_update_account_password").addClass("d-none");
                $("#update_account_password").removeClass("is-invalid");
                $("#update_account_confirm_password").removeClass("is-invalid");
            })

            $("#update_account_confirm_password").keydown(function() {
                $("#error_update_account_password").addClass("d-none");
                $("#update_account_password").removeClass("is-invalid");
                $("#update_account_confirm_password").removeClass("is-invalid");
            })

            $("#update_account_current_password").keydown(function() {
                $("#error_update_account_current_password").addClass("d-none");
                $("#update_account_current_password").removeClass("is-invalid");
            })

            function convert_time(timeString) {
                const [hours, minutes] = timeString.split(":");
                const hour = parseInt(hours);
                const date = new Date();

                date.setHours(hour);
                date.setMinutes(parseInt(minutes));

                const formattedTime = date.toLocaleString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });

                return formattedTime;
            }

            function get_account_data(user_id) {
                var formData = new FormData();

                formData.append('user_id', user_id);
                formData.append('get_user_data', true);

                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let name = response.first_name + " " + response.last_name;

                        if (response.middle_name) {
                            const middle_initial = response.middle_name.trim().charAt(0).toUpperCase() + ".";

                            name = response.first_name + " " + middle_initial + " " + response.last_name;
                        }

                        $("#user_name").text(name);
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            }

            function get_profile_data(user_id) {
                var formData = new FormData();

                formData.append('user_id', user_id);
                formData.append('get_profile_data', true);

                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let name = response.first_name + " " + response.last_name;

                        if (response.middle_name) {
                            const middle_initial = response.middle_name.trim().charAt(0).toUpperCase() + ".";

                            name = response.first_name + " " + middle_initial + " " + response.last_name;
                        }

                        $("#profile_name").text(name);
                        $("#profile_program").text(response.program);
                        $("#profile_year_level").text(response.year_level);
                        $("#profile_student_number").text(response.student_number);
                        $("#profile_school_branch").text(response.school_branch);
                        $("#profile_email").text(response.email);
                        $("#profile_mobile_number").text(response.mobile_number);

                        $("#update_profile_student_number").val(response.student_number);
                        $("#update_profile_first_name").val(response.first_name);
                        $("#update_profile_middle_name").val(response.middle_name);
                        $("#update_profile_last_name").val(response.last_name);
                        $("#update_profile_email").val(response.email);
                        $("#update_profile_mobile_number").val(response.mobile_number);
                        $("#update_profile_school_branch").val(response.school_branch);
                        $("#update_profile_program").val(response.program);
                        $("#update_profile_year_level").val(response.year_level);

                        $("#old_update_profile_student_number").val(response.student_number);
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            }

            function get_student_data(user_id) {
                var formData = new FormData();

                formData.append('user_id', user_id);
                formData.append('get_student_data', true);

                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let name = response.first_name + " " + response.last_name;

                        if (response.middle_name) {
                            const middle_initial = response.middle_name.trim().charAt(0).toUpperCase() + ".";

                            name = response.first_name + " " + middle_initial + " " + response.last_name;
                        }

                        $("#dashboard_student_number").text(response.student_number);
                        $("#dashboard_name").text(name);
                        $("#dashboard_program").text(response.program);
                        $("#dashboard_year_level").text(response.year_level);
                        $("#dashboard_school_branch").text(response.school_branch);
                        $("#dashboard_email").text(response.email);
                        $("#dashboard_mobile_number").text(response.mobile_number);
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            }

            function disable_developer_functions(enabled) {
                if (enabled) {
                    $(document).on('contextmenu', function() {
                        return false;
                    });

                    $(document).on('keydown', function(event) {
                        if (event.ctrlKey && event.shiftKey) {
                            if (event.keyCode === 74) {
                                return false;
                            }

                            if (event.keyCode === 67) {
                                return false;
                            }

                            if (event.keyCode === 73) {
                                return false;
                            }
                        }

                        if (event.ctrlKey && event.keyCode === 85) {
                            return false;
                        }
                    });
                }
            }

            function sweetalert(notification) {
                Swal.fire({
                    position: "top-end",
                    icon: notification.icon,
                    title: notification.text,
                    showConfirmButton: false,
                    timer: 1500
                });
            }

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
        })
    </script>
    </body>

    </html>

    <?php unset($_SESSION["notification"]) ?>