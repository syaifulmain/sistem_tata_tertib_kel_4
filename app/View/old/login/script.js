// Event listener untuk menampilkan password
document.getElementById('showPassword').addEventListener('change', function() {
    const passwordField = document.getElementById('password');
    passwordField.type = this.checked ? 'text' : 'password';
});

// Validasi form login
document.getElementById('loginForm').addEventListener('submit', function(event) {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    const alertBox = document.getElementById('alert');

    if (username === "" || password === "") {
        event.preventDefault(); // Mencegah pengiriman form jika ada yang kosong
        alertBox.classList.remove('d-none');
        alertBox.innerText = "Harus diisi";
    } else {
        alertBox.classList.add('d-none');
    }
});