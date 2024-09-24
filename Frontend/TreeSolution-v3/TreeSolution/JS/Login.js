document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const loginForm = document.getElementById('loginForm');

    // Mostrar/Ocultar contraseña
    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Manejar el envío del formulario de inicio de sesión
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const email = document.querySelector('#email').value;
            const passwordValue = password.value;

            if (email === 'cliente@unmsm.edu.pe' && passwordValue === 'treesolution2024') {
                window.location.href = 'Dashboard.html';
            } else if (email === 'admin@unmsm.edu.pe' && passwordValue === 'admin2024') {
                window.location.href = 'Dashboard_admin.html';
            } else {
                alert('Credenciales incorrectas. Por favor, inténtalo de nuevo.');
            }
        });
    }
});
