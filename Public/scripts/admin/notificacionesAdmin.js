// Módulo de notificaciones del dashboard admin

/**
 * Muestra una notificación toast en la pantalla
 * @param {string} mensaje - El mensaje a mostrar
 * @param {string} tipo - El tipo de notificación ('info', 'success', 'error', 'warning')
 */
export function mostrarNotificacion(mensaje, tipo = 'info') {
    // Crear elemento de notificación
    const notificacion = document.createElement('div');
    notificacion.className = `notificacion notificacion-${tipo}`;
    notificacion.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${obtenerColorNotificacion(tipo)};
        color: white;
        border-radius: var(--radius);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        z-index: 1001;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
        max-width: 400px;
        word-wrap: break-word;
    `;
    notificacion.textContent = mensaje;

    document.body.appendChild(notificacion);

    // Animar entrada
    setTimeout(() => {
        notificacion.style.opacity = '1';
        notificacion.style.transform = 'translateX(0)';
    }, 100);

    // Auto remover después de 3 segundos
    setTimeout(() => {
        ocultarNotificacion(notificacion);
    }, 3000);

    // Permitir cerrar al hacer clic
    notificacion.addEventListener('click', () => {
        ocultarNotificacion(notificacion);
    });
}

/**
 * Oculta y remueve una notificación
 * @param {HTMLElement} notificacion - El elemento de notificación a ocultar
 */
function ocultarNotificacion(notificacion) {
    notificacion.style.opacity = '0';
    notificacion.style.transform = 'translateX(100%)';
    
    setTimeout(() => {
        if (notificacion.parentNode) {
            notificacion.parentNode.removeChild(notificacion);
        }
    }, 300);
}

/**
 * Obtiene el color de fondo para un tipo de notificación
 * @param {string} tipo - El tipo de notificación
 * @returns {string} - El color CSS correspondiente
 */
function obtenerColorNotificacion(tipo) {
    const colores = {
        'success': 'var(--success)',
        'error': 'var(--danger)',
        'warning': 'var(--warning)',
        'info': 'var(--primary)'
    };
    
    return colores[tipo] || colores['info'];
}

/**
 * Muestra una notificación de éxito
 * @param {string} mensaje - El mensaje de éxito
 */
export function mostrarExito(mensaje) {
    mostrarNotificacion(mensaje, 'success');
}

/**
 * Muestra una notificación de error
 * @param {string} mensaje - El mensaje de error
 */
export function mostrarError(mensaje) {
    mostrarNotificacion(mensaje, 'error');
}

/**
 * Muestra una notificación de advertencia
 * @param {string} mensaje - El mensaje de advertencia
 */
export function mostrarAdvertencia(mensaje) {
    mostrarNotificacion(mensaje, 'warning');
}

/**
 * Muestra una notificación informativa
 * @param {string} mensaje - El mensaje informativo
 */
export function mostrarInfo(mensaje) {
    mostrarNotificacion(mensaje, 'info');
}