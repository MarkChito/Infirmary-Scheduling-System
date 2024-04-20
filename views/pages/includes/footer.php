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
                        <div class="page-loading d-none">
                            <div class="loading-parent">
                                <div class="loading-container">
                                    <div class="loading"></div>
                                    <div id="loading-text">Loading</div>
                                </div>
                            </div>
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
                                <label for="update_account_password">New Password</label>
                                <input type="password" class="form-control" id="update_account_password" required>
                                <small class="text-danger d-none" id="error_update_account_password">Passwords do not match</small>
                            </div>
                            <div class="form-group">
                                <label for="update_account_confirm_password">Confirm New Password</label>
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

    <!-- Generate Schedule Modal -->
    <div class="modal fade" id="generate_schedule_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generate Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" id="generate_schedule_form">
                    <div class="modal-body">
                        <div class="page-loading py-4 d-none">
                            <div class="loading-parent">
                                <div class="loading-container">
                                    <div class="loading"></div>
                                    <div id="loading-text">Loading</div>
                                </div>
                            </div>
                        </div>
                        <div class="actual-form">
                            <div class="form-group" id="form_group_1">
                                <label class="d-block">Purpose of Registration</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="generate_schedule_walk_in" name="purpose_of_registration" value="Walk In" checked>
                                            <label class="form-check-label" for="generate_schedule_walk_in">Walk In</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="generate_schedule_annuak_physical_exam" name="purpose_of_registration" value="Annual Physical Exam">
                                            <label class="form-check-label" for="generate_schedule_annuak_physical_exam">Annual Physical Exam</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="form_group_2">
                                <label for="generate_schedule_date">Date</label>
                                <div class="input-group date" id="datepicker">
                                    <input class="form-control" placeholder="DD-MM-YYYY" id="generate_schedule_date" required />
                                    <span class="input-group-append input-group-addon" id="btn_generate_schedule_date">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                                <small class="text-danger d-none" id="error_generate_schedule_date">Date must be 2 days ahead</small>
                            </div>
                            <div class="form-group" id="form_group_3">
                                <label for="generate_schedule_time">Time</label>
                                <div class="input-group time" id="timepicker">
                                    <input class="form-control" placeholder="HH:MM AM/PM" id="generate_schedule_time" required />
                                    <span class="input-group-append input-group-addon" id="btn_generate_schedule_time">
                                        <span class="input-group-text">
                                            <i class="fa fa-clock"></i>
                                        </span>
                                    </span>
                                </div>
                                <small class="text-danger d-none" id="error_generate_schedule_time">Time must be from 8:00 AM to 5:00 PM only</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="generate_schedule_submit">Submit</button>
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
    <script src="<?= $base_url ?>plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?= $base_url ?>plugins/datetimepicker/js/datetimepicker.js"></script>
    <script src="<?= $base_url ?>dist/js/adminlte.js"></script>

    <script>
        jQuery(document).ready(function() {
            const base_url = "<?= $base_url ?>";
            const user_id = "<?= $user_id ?>";
            const user_type = "<?= $user_type ?>";
            const current_tab = "<?= $current_tab ?>";
            const notification = <?= isset($_SESSION["notification"]) ? json_encode($_SESSION["notification"]) : json_encode(null) ?>;

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
                $(".page-loading").removeClass("d-none");
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

                        $(".page-loading").addClass("d-none");
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
                    const actual_form_height = $(".actual-form").height();

                    $(".page-loading").height(actual_form_height);

                    $(".actual-form").addClass("d-none");
                    $(".page-loading").removeClass("d-none");

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

                                $(".page-loading").addClass("d-none");
                                $(".actual-form").removeClass("d-none");
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

            $("#generate_schedule").click(function() {
                $("#generate_schedule_modal").modal("show");
            })

            $("#generate_schedule_form").submit(function() {
                const schedule_purpose = $("input[name='purpose_of_registration']:checked").val();
                const schedule_date = $("#generate_schedule_date").val();
                const schedule_time = $("#generate_schedule_time").val();

                let errors = 0;

                if (schedule_purpose == "Walk In") {
                    if (error_walk_in_date(schedule_date)) {
                        $("#error_generate_schedule_date").text(error_walk_in_date(schedule_date));
                        $("#error_generate_schedule_date").removeClass("d-none");
                        $("#generate_schedule_date").addClass("is-invalid");

                        errors++;
                    }

                    if (error_walk_in_time(schedule_time, schedule_date)) {
                        $("#error_generate_schedule_time").text(error_walk_in_time(schedule_time));
                        $("#error_generate_schedule_time").removeClass("d-none");
                        $("#generate_schedule_time").addClass("is-invalid");

                        errors++;
                    }
                } else {
                    if (error_annual_physical_exam_date(schedule_date)) {
                        $("#error_generate_schedule_date").text(error_annual_physical_exam_date(schedule_date));
                        $("#error_generate_schedule_date").removeClass("d-none");
                        $("#generate_schedule_date").addClass("is-invalid");

                        errors++;
                    }

                    if (error_annual_physical_exam_time(schedule_time)) {
                        $("#error_generate_schedule_time").text(error_annual_physical_exam_time(schedule_time));
                        $("#error_generate_schedule_time").removeClass("d-none");
                        $("#generate_schedule_time").addClass("is-invalid");

                        errors++;
                    }
                }

                if (errors == 0) {
                    const actual_form_height = $("#form_group_1").height() + $("#form_group_2").height() + $("#form_group_3").height();

                    $(".page-loading").height(actual_form_height);

                    $(".actual-form").addClass("d-none");
                    $(".page-loading").removeClass("d-none");

                    $("#generate_schedule_submit").text("Please wait...");
                    $("#generate_schedule_submit").attr("disabled", true);

                    var formData = new FormData();

                    formData.append('account_id', user_id);
                    formData.append('purpose_of_registration', schedule_purpose);
                    formData.append('appointment_date', schedule_date);
                    formData.append('appointment_time', schedule_time);

                    formData.append('generate_schedule', true);

                    $.ajax({
                        url: 'server.php',
                        data: formData,
                        type: 'POST',
                        dataType: 'JSON',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response) {
                                location.href = base_url + "dashboard";
                            } else {
                                $("#error_generate_schedule_date").text("This Date and Time is already unavailable");
                                $("#error_generate_schedule_date").removeClass("d-none");
                                $("#generate_schedule_date").addClass("is-invalid");

                                $("#error_generate_schedule_time").text("This Date and Time is already unavailable");
                                $("#error_generate_schedule_time").removeClass("d-none");
                                $("#generate_schedule_time").addClass("is-invalid");

                                $(".actual-form").removeClass("d-none");
                                $(".page-loading").addClass("d-none");

                                $("#generate_schedule_submit").removeAttr("disabled");
                                $("#generate_schedule_submit").text("Submit");
                            }
                        },
                        error: function(_, _, error) {
                            console.error(error);
                        }
                    });
                }
            })

            $("#btn_generate_schedule_date").click(function() {
                $("#error_generate_schedule_date").addClass("d-none");
                $("#generate_schedule_date").removeClass("is-invalid");
            })

            $("#btn_generate_schedule_time").click(function() {
                $("#error_generate_schedule_time").addClass("d-none");
                $("#generate_schedule_time").removeClass("is-invalid");
            })

            $("input[name='purpose_of_registration']").change(function() {
                const selectedValue = $("input[name='purpose_of_registration']:checked").val();

                $("#error_generate_schedule_date").addClass("d-none");
                $("#generate_schedule_date").removeClass("is-invalid");

                $("#error_generate_schedule_time").addClass("d-none");
                $("#generate_schedule_time").removeClass("is-invalid");
            });

            function error_walk_in_time(time_input, date_input) {
                const date = new Date();
                const day = date.getDate();
                const month = date.toLocaleString('default', {
                    month: 'short'
                });
                const year = date.getFullYear();
                const current_day = `${day}-${month}-${year}`;
                const current_hour = date.getHours();

                var timeRegex = /^(1[0-2]|0?[1-9]):([0-5][0-9]) ([AaPp][Mm])$/;

                if (timeRegex.test(time_input)) {
                    var parts = time_input.split(':');
                    var hours = parseInt(parts[0]);
                    var minutes = parseInt(parts[1].split(' ')[0]);
                    var period = parts[1].split(' ')[1].toUpperCase();

                    if (period === 'PM' && hours < 12) {
                        hours += 12;
                    } else if (period === 'AM' && hours === 12) {
                        hours = 0;
                    }

                    if (date_input == current_day) {
                        if (current_hour >= 8 && current_hour <= 17) {
                            if (hours < current_hour) {
                                return "Time must be ahead of the current time";
                            }
                        }
                        if (hours >= 8 && hours <= 17) {
                            return false;
                        }
                    } else {
                        if (hours >= 8 && hours <= 17) {
                            return false;
                        }
                    }
                }

                return "Time must be between 8:00 AM and 5:00 PM";
            }

            function error_annual_physical_exam_time(time_input) {
                var timeRegex = /^(1[0-2]|0?[1-9]):([0-5][0-9]) ([AaPp][Mm])$/;

                if (timeRegex.test(time_input)) {
                    var parts = time_input.split(':');
                    var hours = parseInt(parts[0]);
                    var minutes = parseInt(parts[1].split(' ')[0]);
                    var period = parts[1].split(' ')[1].toUpperCase();

                    if (period === 'PM' && hours < 12) {
                        hours += 12;
                    } else if (period === 'AM' && hours === 12) {
                        hours = 0;
                    }

                    if (hours >= 8 && hours <= 17) {
                        return false;
                    }
                }

                return "Time must be between 8:00 AM and 5:00 PM";
            }

            function error_walk_in_date(date_input) {
                var today = new Date();
                var validDate = new Date(today);

                validDate.setDate(validDate.getDate() - 1);

                var input = new Date(date_input);

                if (input.getTime() >= validDate.getTime()) {
                    return false;
                } else {
                    return "Date must be at least today";
                }
            }

            function error_annual_physical_exam_date(date_input) {
                var today = new Date();
                var validDate = new Date(today);

                validDate.setDate(validDate.getDate() + 1);

                var input = new Date(date_input);

                if (input.getTime() >= validDate.getTime()) {
                    return false;
                } else {
                    return "Date must be at least 2 days ahead from today";
                }
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