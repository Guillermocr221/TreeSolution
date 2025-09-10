// Módulo de gestión de usuarios del dashboard admin
import { mostrarNotificacion } from './notificacionesAdmin.js';

/**
 * Configura los eventos y funcionalidades de la sección de usuarios
 */
export function configurarUsuarios() {
    configurarAccionesUsuarios();
}

/**
 * Configura los eventos de acciones de usuarios (activar, desactivar)
 */
function configurarAccionesUsuarios() {
    // Botones de activar usuario
    document.querySelectorAll('.button__activarUsuario').forEach(boton => {
        boton.addEventListener('click', (e) => {
            const idUsuario = e.currentTarget.dataset.id;
            activarUsuario(idUsuario);
        });
    });

    // Botones de desactivar usuario
    document.querySelectorAll('.button__eliminarUsuario').forEach(boton => {
        boton.addEventListener('click', (e) => {
            const idUsuario = e.currentTarget.dataset.id;
            desactivarUsuario(idUsuario);
        });
    });
}

/**
 * Activa un usuario que estaba desactivado
 * @param {string} idUsuario - El ID del usuario a activar
 */
async function activarUsuario(idUsuario) {
    if (!confirm('¿Estás seguro de que deseas activar este usuario?')) {
        return;
    }

    try {
        const datosFormulario = new FormData();
        datosFormulario.append('ID_Usuario', idUsuario);

        const respuesta = await fetch('/api/activarUsuario', {
            method: 'POST',
            body: datosFormulario
        });

        if (respuesta.ok) {
            location.reload();
        } else {
            mostrarNotificacion('Error al activar el usuario', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión', 'error');
    }
}

/**
 * Desactiva un usuario
 * @param {string} idUsuario - El ID del usuario a desactivar
 */
async function desactivarUsuario(idUsuario) {
    if (!confirm('¿Estás seguro de que deseas desactivar este usuario?')) {
        return;
    }

    try {
        const datosFormulario = new FormData();
        datosFormulario.append('ID_Usuario', idUsuario);

        const respuesta = await fetch('/api/borrarUsuario', {
            method: 'POST',
            body: datosFormulario
        });

        if (respuesta.ok) {
            location.reload();
        } else {
            mostrarNotificacion('Error al desactivar el usuario', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión', 'error');
    }
}