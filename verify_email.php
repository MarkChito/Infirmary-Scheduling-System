<?php
require_once "./env/autoload.php";

$env_data = readFromEnvFile();

$version = $env_data["VERSION"];
$base_url = $env_data["BASE_URL"];
?>

<script src="<?= $base_url ?>plugins/jquery/jquery.min.js"></script>

<script>
    const searchParams = new URLSearchParams(window.location.search);
    const base_url = "<?= $base_url ?>";

    var params = {};

    searchParams.forEach((value, key) => {
        if (key == "student_number") {
            params.student_number = value;
        }
        if (key == "email") {
            params.email = value;
        }
    });

    var formData = new FormData();

    formData.append('student_number', params.student_number);
    formData.append('email', params.email);
    formData.append('verify_email', true);

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
</script>