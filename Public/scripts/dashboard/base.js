//? MENU DESPLEGABLE    
const userIcon = document.querySelector('.header__action-icon');
const userMenu = document.getElementById('userMenu');

// Mostrar/Ocultar el menú desplegable
userIcon.addEventListener('click', function () {
    userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
});

// Ocultar el menú desplegable al hacer clic fuera de él
window.addEventListener('click', function (event) {
    if (event.target !== userIcon && !userIcon.contains(event.target) && event.target !== userMenu && !userMenu.contains(event.target)) {
        userMenu.style.display = 'none';
    }
});