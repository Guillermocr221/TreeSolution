// Módulo de gestión de usuarios del dashboard admin
import { mostrarNotificacion } from './notificacionesAdmin.js';

/**
 * Configura los eventos y funcionalidades de la sección de usuarios
 */
export function configurarUsuarios() {
    configurarAccionesUsuarios();
    configurarFiltrosUsuarios();
}

/**
 * Configura los eventos de acciones de usuarios (deshabilitar/habilitar)
 */
function configurarAccionesUsuarios() {
    // Event listeners usando delegación para botones dinámicos
    document.addEventListener('click', function(e) {
        // Botón deshabilitar usuario
        if (e.target.closest('.button__eliminarUsuario')) {
            const btn = e.target.closest('.button__eliminarUsuario');
            const idUsuario = btn.getAttribute('data-id');
            deshabilitarUsuario(idUsuario);
        }
        
        // Botón habilitar usuario
        if (e.target.closest('.button__activarUsuario')) {
            const btn = e.target.closest('.button__activarUsuario');
            const idUsuario = btn.getAttribute('data-id');
            habilitarUsuario(idUsuario);
        }
    });
}

/**
 * Configura los filtros de usuarios
 */
function configurarFiltrosUsuarios() {
    // Filtro de búsqueda
    const userSearch = document.getElementById('userSearch');
    if (userSearch) {
        userSearch.addEventListener('input', function() {
            filtrarUsuarios(this.value);
        });
    }
    
    // Filtro por tipo de usuario
    const userTypeFilter = document.getElementById('userTypeFilter');
    if (userTypeFilter) {
        userTypeFilter.addEventListener('change', function() {
            filtrarUsuariosPorTipo(this.value);
        });
    }
}

/**
 * Deshabilita un usuario (cambia su estado a inactivo)
 * @param {string} idUsuario - El ID del usuario a deshabilitar
 */
async function deshabilitarUsuario(idUsuario) {
    if (!confirm('¿Estás seguro de que deseas deshabilitar este usuario? El usuario no podrá acceder al sistema.')) {
        return;
    }

    try {
        const datosFormulario = new FormData();
        datosFormulario.append('id_usuario', idUsuario);

        const respuesta = await fetch('/api/borrarUsuario', {
            method: 'POST',
            body: datosFormulario
        });

        if (respuesta.ok) {
            mostrarNotificacion('Usuario deshabilitado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarNotificacion('Error al deshabilitar el usuario', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión', 'error');
    }
}

/**
 * Habilita un usuario (cambia su estado a activo)
 * @param {string} idUsuario - El ID del usuario a habilitar
 */
async function habilitarUsuario(idUsuario) {
    if (!confirm('¿Estás seguro de que deseas habilitar este usuario? El usuario podrá acceder nuevamente al sistema.')) {
        return;
    }

    try {
        const datosFormulario = new FormData();
        datosFormulario.append('id_usuario', idUsuario);

        const respuesta = await fetch('/api/activarUsuario', {
            method: 'POST',
            body: datosFormulario
        });

        if (respuesta.ok) {
            mostrarNotificacion('Usuario habilitado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarNotificacion('Error al habilitar el usuario', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión', 'error');
    }
}

/**
 * Filtra usuarios por término de búsqueda
 * @param {string} termino - Término de búsqueda
 */
function filtrarUsuarios(termino) {
    const usuarios = document.querySelectorAll('.user-card');
    const terminoLower = termino.toLowerCase();
    
    usuarios.forEach(usuario => {
        const nombre = usuario.querySelector('.user-header h3').textContent.toLowerCase();
        const email = usuario.querySelector('.user-meta span:first-child').textContent.toLowerCase();
        
        if (nombre.includes(terminoLower) || email.includes(terminoLower)) {
            usuario.style.display = 'block';
        } else {
            usuario.style.display = 'none';
        }
    });
}

/**
 * Filtra usuarios por tipo
 * @param {string} tipo - Tipo de usuario ('todos', 'cliente', 'admin')
 */
function filtrarUsuariosPorTipo(tipo) {
    const usuarios = document.querySelectorAll('.user-card');
    
    usuarios.forEach(usuario => {
        const tipoUsuario = usuario.getAttribute('data-type');
        
        if (tipo === 'todos' || tipoUsuario === tipo) {
            usuario.style.display = 'block';
        } else {
            usuario.style.display = 'none';
        }
    });
}