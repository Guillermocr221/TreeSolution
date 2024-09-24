document.addEventListener('DOMContentLoaded', function () {
    const loginButton = document.getElementById('loginButton');

    loginButton.addEventListener('click', function () {
        window.location.href = '/login'; // Redirige a la página de inicio de sesión

    });
});

document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('registrarButton');

    logoutButton.addEventListener('click', function () {
        window.location.href = '/registrarse'; // Redirige a la página de inicio
    });
});



document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('logoutButton');

    logoutButton.addEventListener('click', function () {
        window.location.href = '/'; // Redirige a la página de inicio
    });
});

// document.addEventListener('DOMContentLoaded', function () {
//     const exploButton = document.getElementById('exploButton');

//     exploButton.addEventListener('click', function () {
//         window.location.href = '/dashboard'; // Redirige a la página de inicio
//     });
// });
