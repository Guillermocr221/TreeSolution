document.addEventListener('DOMContentLoaded', function () {
    const darkModeButton = document.getElementById('darkModeButton');
    const loginButtons = document.querySelectorAll('#loginButton, #exploreButton');

    // Toggle Dark Mode
    darkModeButton.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
        document.querySelector('.header').classList.toggle('dark-mode');
        document.querySelector('.main').classList.toggle('dark-mode');
        document.querySelector('.footer').classList.toggle('dark-mode');
        document.querySelectorAll('.header__nav-link').forEach(link => link.classList.toggle('dark-mode'));
        document.querySelectorAll('.header__button').forEach(button => button.classList.toggle('dark-mode'));
        document.querySelector('.header__search').classList.toggle('dark-mode');
        document.querySelector('.header__search-button').classList.toggle('dark-mode');
        document.querySelector('.hero__button').classList.toggle('dark-mode');

        // Cambiar el icono del botón
        const icon = darkModeButton.querySelector('i');
        icon.classList.toggle('fa-lightbulb');
        icon.classList.toggle('fa-moon');
    });

    // Navigate to Login
    loginButtons.forEach(button => {
        button.addEventListener('click', function () {
            window.location.href = 'login.html';
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('registrarButton');

    logoutButton.addEventListener('click', function () {
        window.location.href = 'CrearCuenta.html'; // Redirige a la página de inicio
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('logoutButton');

    logoutButton.addEventListener('click', function () {
        window.location.href = 'Inicio.html'; // Redirige a la página de inicio
    });
});
