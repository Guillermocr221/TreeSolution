// Módulo de navegación del dashboard admin

/**
 * Configura los eventos de navegación entre secciones
 */
export function configurarNavegacion() {
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', (e) => {
            const seccion = e.currentTarget.dataset.section;
            cambiarSeccion(seccion);
        });
    });
}

/**
 * Cambia la sección activa del dashboard
 * @param {string} seccion - La sección a mostrar (users, products, sales)
 */
export function cambiarSeccion(seccion) {
    // Actualizar navegación
    document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelector(`[data-section="${seccion}"]`).classList.add('active');

    // Mostrar sección
    mostrarSeccion(seccion);
    window.seccionActual = seccion;
}

/**
 * Muestra la sección especificada y oculta las demás
 * @param {string} seccion - La sección a mostrar
 */
export function mostrarSeccion(seccion) {
    // Ocultar todas las secciones
    document.querySelectorAll('.content-section').forEach(sec => {
        sec.style.display = 'none';
    });

    // Mostrar sección objetivo
    const seccionObjetivo = document.getElementById(`${seccion}Section`);
    if (seccionObjetivo) {
        seccionObjetivo.style.display = 'block';
    }
}