import { activarPanelProductos, activarPanelUsuario,activarPanelVentas } from './alertasAdmin.js';

export const sidebarItems = document.querySelectorAll('.sidebar__item');

// Función para manejar la activación de los elementos del menú
export function activateMenuItem(selectedItem) {
    sidebarItems.forEach(item => {
        item.classList.remove('sidebar__item--active');
    });
    selectedItem.classList.add('sidebar__item--active');
}

document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('logoutButton');
    const productsButton = document.getElementById('productsButton');
    const usersButton = document.getElementById('usersButton');
    const employeesButton = document.getElementById('employeesButton');   

    // Redirigir al hacer clic en "Cerrar sesión"
    logoutButton.addEventListener('click', function () {
        window.location.href = 'Inicio.html';
    });

    // Mostrar la sección de productos
    productsButton.addEventListener('click', activarPanelProductos)
    // Mostrar la sección de usuarios
    usersButton.addEventListener('click', activarPanelUsuario);
    // Mostrar la sección de ventas
    employeesButton.addEventListener('click', activarPanelVentas);
   
});