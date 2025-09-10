// Módulo de gestión de productos del dashboard admin
import { abrirModalEditarProducto } from './modalAdmin.js';
import { validarFormularioProducto } from './validacionesAdmin.js';
import { mostrarNotificacion } from './notificacionesAdmin.js';

/**
 * Configura los eventos y funcionalidades de la sección de productos
 */
export function configurarProductos() {
    configurarAccionesProductos();
    configurarFormulariosProductos();
}

/**
 * Configura los eventos de acciones de productos (editar, eliminar, habilitar)
 */
function configurarAccionesProductos() {
    // Botones de editar producto
    document.querySelectorAll('.symbol--editar').forEach(boton => {
        boton.addEventListener('click', (e) => {
            const datos = e.currentTarget.dataset;
            abrirModalEditarProducto(datos);
        });
    });

    // Botones de eliminar/deshabilitar producto
    document.querySelectorAll('.symbol-borrar').forEach(boton => {
        boton.addEventListener('click', (e) => {
            const idProducto = e.currentTarget.dataset.id;
            eliminarProducto(idProducto);
        });
    });

    // Botones de habilitar producto
    document.querySelectorAll('.symbol-habilitar').forEach(boton => {
        boton.addEventListener('click', (e) => {
            const idProducto = e.currentTarget.dataset.id;
            habilitarProducto(idProducto);
        });
    });
}

/**
 * Configura los eventos de los formularios de productos
 */
function configurarFormulariosProductos() {
    // Formulario de agregar producto
    const formularioAgregar = document.getElementById('añadirProductForm');
    if (formularioAgregar) {
        formularioAgregar.addEventListener('submit', (e) => {
            validarFormularioProducto(e);
        });
    }

    // Formulario de editar producto
    const formularioEditar = document.getElementById('modificarProductForm');
    if (formularioEditar) {
        formularioEditar.addEventListener('submit', (e) => {
            validarFormularioProducto(e);
        });
    }
}

/**
 * Elimina (deshabilita) un producto
 * @param {string} idProducto - El ID del producto a eliminar
 */
async function eliminarProducto(idProducto) {
    if (!confirm('¿Estás seguro de que deseas deshabilitar este producto?')) {
        return;
    }

    try {
        const datosFormulario = new FormData();
        datosFormulario.append('ID_Producto', idProducto);

        const respuesta = await fetch('/admin/eliminarProducto', {
            method: 'POST',
            body: datosFormulario
        });

        if (respuesta.ok) {
            location.reload();
        } else {
            mostrarNotificacion('Error al deshabilitar el producto', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión', 'error');
    }
}

/**
 * Habilita un producto que estaba deshabilitado
 * @param {string} idProducto - El ID del producto a habilitar
 */
async function habilitarProducto(idProducto) {
    if (!confirm('¿Estás seguro de que deseas habilitar este producto?')) {
        return;
    }

    try {
        const datosFormulario = new FormData();
        datosFormulario.append('ID_Producto', idProducto);

        const respuesta = await fetch('/admin/habilitarProducto', {
            method: 'POST',
            body: datosFormulario
        });

        if (respuesta.ok) {
            location.reload();
        } else {
            mostrarNotificacion('Error al habilitar el producto', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión', 'error');
    }
}