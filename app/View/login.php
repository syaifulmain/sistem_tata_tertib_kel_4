<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $model['title']; ?></title>
    <link rel="stylesheet" href="<?php echo APP_URL ?>/assets/css/bootstrap-edit.css">
</head>
<body class="bg-primary">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="container-xsm card p-4 rounded-2 p-3" id="loginCard">
        <div class="text-center mb-3">
            <img src="<?php echo APP_URL ?>/assets/image/logo-polinema.png" class="mb-3" alt="logo-polinema"
                 style="width: 250px; height: auto">
        </div>
        <div id="alertDiv" class="alert alert-danger text-center d-none"
             role="alert">
        </div>
        <form>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
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
            $('#alertDiv').addClass('d-none');
            $.ajax({
                url: '<?php echo APP_URL ?>/login',
                method: 'POST',
                data: {
                    username: $('#username').val(),
                    password: $('#password').val()
                },
                success: function (response) {
                    location.reload();
                },
                error: function (response) {
                    let error = JSON.parse(response);
                    $('#alertDiv').text(error['error']).removeClass('d-none');
                }
            });
        }
    });
</script>
</body>
</html>
