    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="<?= $base_url ?>dashboard">Infirmary Scheduling System</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
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
    <script src="<?= $base_url ?>dist/js/adminlte.js"></script>

    <script>
        jQuery(document).ready(function() {
            const base_url = "<?= $base_url ?>";
            const notification = <?= isset($_SESSION["notification"]) ? json_encode($_SESSION["notification"]) : json_encode(null) ?>;

            disable_developer_functions(true);

            if (notification) {
                sweetalert(notification);
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