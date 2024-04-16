    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="<?= $base_url ?>dashboard">Infirmary Scheduling System</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> <?= $version ?>
        </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
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
                get_student_data(user_id);
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
            });

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

            $("#generate_schedule").click(function() {
                var day = days[dayOfWeek + 1];

                var formData = new FormData();

                formData.append('day', day);
                formData.append('get_schedule', true);

                $.ajax({
                    url: 'server.php',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        const schedule_id = response.id;
                        const day = response.day;
                        const start_time = response.start_time;
                        const end_time = response.end_time;

                        Swal.fire({
                            title: "Schedule is Available",
                            html: `Your Schedule: <b>` + day + `, ` + convert_time(start_time) + ` - ` + convert_time(end_time) + `</b>.`,
                            icon: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Confirm"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var formData = new FormData();

                                formData.append('user_id', user_id);
                                formData.append('day', day);
                                formData.append('schedule_id', schedule_id);
                                formData.append('start_time', start_time);
                                formData.append('end_time', end_time);
                                formData.append('add_appointment', true);

                                $.ajax({
                                    url: 'server.php',
                                    data: formData,
                                    type: 'POST',
                                    dataType: 'JSON',
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        location.href = base_url + "dashboard";
                                    },
                                    error: function(_, _, error) {
                                        console.error(error);
                                    }
                                });
                            }
                        });
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
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
                        $("#user_name").text(response.name);
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
                        $("#dashboard_student_number").text(response.student_number);
                        $("#dashboard_name").text(response.name);
                        $("#dashboard_program").text(response.program);
                        $("#dashboard_year_level").text(response.year_level);
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