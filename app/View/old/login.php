<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>template</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="assets/js/bootstrap.js"></script>
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
</head>
<body class="bg-dark">
<div class="mt-5"></div>
<div class="bg-body-tertiary m-auto rounded-3 my-5" style="max-width: 400px">
    <div class="p-4">
        <img src="logo-polinema.png" alt="logo-polinema" class="d-block mx-auto my-2">
        <form>
            <div class="mb-3">
                <label for="inputUsername" class="form-label">Username</label>
                <input type="text" class="form-control shadow-none" id="inputUsername" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" class="form-control shadow-none" id="inputPassword">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input shadow-none" id="showPassword">
                <label class="form-check-label" for="showPassword">Show Password</label>
            </div>
            <button type="submit" class="btn btn-success">Login
                <i class="bi bi-arrow-right-short"></i>
            </button>
        </form>
    </div>
    <div class="bg-secondary text-center text-start rounded-bottom-3">
        <div class="text-white p-1">
            <p>&copy; 2024 Kelompok 4 TI 2A</p>
        </div>
    </div>
</div>
<script>
    document.getElementById('showPassword').addEventListener('change', function () {
        let passwordField = document.getElementById('inputPassword');
        if (this.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    });
</script>
</body>
</html>