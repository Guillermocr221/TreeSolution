document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('logoutButton');
    const productsButton = document.getElementById('productsButton');
    const usersButton = document.getElementById('usersButton');
    const employeesButton = document.getElementById('employeesButton');

    const usersSection = document.getElementById('usersSection');
    const productsSection = document.getElementById('productsSection');
    const employeesSection = document.getElementById('employeesSection');

    const sidebarItems = document.querySelectorAll('.sidebar__item');

    // Función para manejar la activación de los elementos del menú
    function activateMenuItem(selectedItem) {
        sidebarItems.forEach(item => {
            item.classList.remove('sidebar__item--active');
        });
        selectedItem.classList.add('sidebar__item--active');
    }

    // Redirigir al hacer clic en "Cerrar sesión"
    logoutButton.addEventListener('click', function () {
        window.location.href = 'Inicio.html';
    });

    // Mostrar la sección de productos
    productsButton.addEventListener('click', function () {
        activateMenuItem(productsButton);
        usersSection.style.display = 'none';
        productsSection.style.display = 'block';
        employeesSection.style.display = 'none';
    });

    // Mostrar la sección de usuarios
    usersButton.addEventListener('click', function () {
        activateMenuItem(usersButton);
        usersSection.style.display = 'block';
        productsSection.style.display = 'none';
        employeesSection.style.display = 'none';
    });

    // Mostrar la sección de empleados
    employeesButton.addEventListener('click', function () {
        activateMenuItem(employeesButton);
        usersSection.style.display = 'none';
        productsSection.style.display = 'none';
        employeesSection.style.display = 'block';
    });
});
