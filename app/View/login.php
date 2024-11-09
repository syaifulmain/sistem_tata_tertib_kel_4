<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $model['title']; ?></title>
    <link rel="stylesheet" href="<?php echo APP_URL ?>/assets/css/bootstrap-edit.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
            integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
          integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous"/>
</head>
<body class="bg-primary">
<div class="container-fluid">
    <?php if (isset($model['error'])) { ?>
        <div id="alertDiv" class="alert alert-danger position-absolute ms-auto me-auto start-0 end-0 text-center"
             role="alert" style="width: 1440px;">
            <?= $model['error'] ?>
        </div>
    <?php } ?>
    <?php if (isset($model['alert'])) { ?>
        <div id="alertDiv" class="alert alert-warning position-absolute ms-auto me-auto start-0 end-0 text-center"
             role="alert"
             style="width: 1440px;">
            <?= $model['alert'] ?>
        </div>
    <?php } ?>
    <?php if (isset($model['success'])) { ?>
        <div id="alertDiv" class="alert alert-success position-absolute ms-auto me-auto start-0 end-0 text-center"
             role="alert"
             style="width: 1440px;">
            <?= $model['success'] ?>
        </div>
    <?php } ?>
</div>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="container-xsm card p-4 rounded-2 p-3" id="loginCard">
        <div class="text-center mb-3">
            <img src="<?php echo APP_URL ?>/assets/image/logo-polinema.png" class="mb-3" alt="logo-polinema"
                 style="width: 250px; height: auto">
        </div>
        <form action="/login" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control shadow-none" id="username" name="username">
                <span id="usernameError" class="text-danger d-none">Username tidak boleh kosong</span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control shadow-none" id="password" name="password">
                <span id="passwordError" class="text-danger d-none">Password tidak boleh kosong</span>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input shadow-none" id="showPassword">
                <label class="form-check-label" for="showPassword">Tampilkan Password</label>
            </div>
            <button type="button" id="submitBtn" class="mb-3 btn btn-primary w-100">Submit</button>
        </form>
        <div class="text-center mt-3 text-muted">
            2024 © Sistem Tata Tertib JTI
        </div>
    </div>
</div>
<script src="<?php echo APP_URL ?>/assets/js/http_ajax.googleapis.com_ajax_libs_jquery_3.5.1_jquery.js"></script>
<script>
    $('#username, #password').on('change', function () {
        let errorId = $(this).attr('id') + 'Error';
        $('#' + errorId).toggleClass('d-none', $(this).val().trim() !== '');
    });

    $('#showPassword').on('change', function () {
        $('#password').attr('type', this.checked ? 'text' : 'password');
    });

    $('#submitBtn').on('click', function () {
        let isValid = true;
        $('#username, #password').each(function () {
            let errorId = $(this).attr('id') + 'Error';
            if ($(this).val().trim() === '') {
                $('#' + errorId).removeClass('d-none');
                isValid = false;
            } else {
                $('#' + errorId).addClass('d-none');
            }
        });

        if (isValid) {
            $('form').submit();
        }
    });
</script>
</body>
</html>
