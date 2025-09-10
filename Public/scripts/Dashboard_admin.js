// Dashboard Admin - Archivo principal con imports ES6
import { configurarNavegacion, mostrarSeccion } from './admin/navegacionAdmin.js';
import { configurarModales, abrirModal, cerrarModal } from './admin/modalAdmin.js';
import { configurarFiltros } from './admin/filtrosAdmin.js';
import { configurarProductos } from './admin/productosAdmin.js';
import { configurarUsuarios } from './admin/usuariosAdmin.js';
import { configurarVentas, alternarDetallesVenta } from './admin/ventasAdmin.js';
import { mostrarNotificacion } from './admin/notificacionesAdmin.js';

// Variables globales
let seccionActual = 'products';

// Inicialización cuando el DOM está cargado
document.addEventListener('DOMContentLoaded', function() {
    inicializarDashboardAdmin();
    manejarParametrosURL();
});

/**
 * Inicializa el dashboard admin configurando todos los eventos y funcionalidades
 */
function inicializarDashboardAdmin() {
    configurarNavegacion();
    configurarModales();
    configurarFiltros();
    configurarProductos();
    configurarUsuarios();
    configurarVentas();
    mostrarSeccion(seccionActual);
}

/**
 * Maneja los parámetros de URL para mostrar notificaciones
 */
function manejarParametrosURL() {
    const parametrosURL = new URLSearchParams(window.location.search);
    const estado = parametrosURL.get('estado');
    
    if (estado) {
        const mensajes = {
            'regProdExitoso': 'Producto registrado exitosamente',
            'modProdExitoso': 'Producto modificado exitosamente',
            'elimProdExitoso': 'Producto deshabilitado exitosamente',
            'habProdExitoso': 'Producto habilitado exitosamente',
            'regAdminExitoso': 'Administrador registrado exitosamente',
            'correoExistente': 'El correo ya está registrado'
        };
        
        if (mensajes[estado]) {
            const tipo = estado === 'correoExistente' ? 'error' : 'success';
            mostrarNotificacion(mensajes[estado], tipo);
        }
    }
}

// Funciones globales para compatibilidad con HTML onclick handlers
window.abrirModal = abrirModal;
window.cerrarModal = cerrarModal;
window.alternarDetallesVenta = alternarDetallesVenta;
