// Módulo de gestión de ventas del dashboard admin

/**
 * Configura los eventos y funcionalidades de la sección de ventas
 */
export function configurarVentas() {
    // No hay eventos específicos que configurar para ventas por ahora
    // Esta función se mantiene para consistencia y futuras expansiones
}

/**
 * Alterna la visibilidad de los detalles de una venta
 * @param {string} idVenta - El ID de la venta
 */
export function alternarDetallesVenta(idVenta) {
    const detalles = document.getElementById(`saleDetails${idVenta}`);
    if (detalles) {
        detalles.style.display = detalles.style.display === 'none' ? 'block' : 'none';
    }
}