// Módulo de gestión de productos del dashboard admin
import { abrirModalEditarProducto } from './modalAdmin.js';
import { validarFormularioProducto } from './validacionesAdmin.js';
import { mostrarNotificacion } from './notificacionesAdmin.js';

// Variables globales para gestión de inventario
let combinacionesProducto = [];
let productoActualId = null;

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
    // Event listeners usando delegación para botones dinámicos
    document.addEventListener('click', function(e) {
        // Botón editar producto
        if (e.target.closest('.symbol--editar')) {
            const btn = e.target.closest('.symbol--editar');
            const id = btn.getAttribute('data-id');
            const nombre = btn.getAttribute('data-nombre');
            const descripcion = btn.getAttribute('data-descripcion');
            const precio = btn.getAttribute('data-precio');
            const categoria = btn.getAttribute('data-categoria');
            const stock = btn.getAttribute('data-stock');
            const imagen = btn.getAttribute('data-imagen');

            // Llenar el formulario con los datos existentes
            document.getElementById('ID_Producto').value = id;
            document.getElementById('nombreNuevo').value = nombre;
            document.getElementById('nuevaDescripcion').value = descripcion;
            document.getElementById('nuevoPrecio').value = precio;
            document.getElementById('nuevaCategoria').value = categoria;
            document.getElementById('nuevoStock').value = stock;
            document.getElementById('imagenPVistaPrevia').src = `/imagenes/store/${imagen}`;

            // Configurar gestión de inventario
            productoActualId = id;
            combinacionesProducto = [];
            
            // Cargar combinaciones existentes
            cargarCombinacionesProducto(id);
            
            // Configurar event listeners para la gestión de inventario
            configurarGestionInventario();
            
            // Abrir modal (asumo que tienes esta función en modalAdmin.js)
            window.abrirModal('modificarProductModal');
        }
        
        // Botón eliminar producto
        if (e.target.closest('.symbol-borrar')) {
            const btn = e.target.closest('.symbol-borrar');
            const id = btn.getAttribute('data-id');
            eliminarProducto(id);
        }
        
        // Botón habilitar producto
        if (e.target.closest('.symbol-habilitar')) {
            const btn = e.target.closest('.symbol-habilitar');
            const id = btn.getAttribute('data-id');
            habilitarProducto(id);
        }
    });
}

/**
 * Configura los eventos de los formularios de productos
 */
function configurarFormulariosProductos() {
    // Formulario de modificar producto
    const modificarForm = document.getElementById('modificarProductForm');
    if (modificarForm) {
        modificarForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Primero guardar las combinaciones
            const combinacionesGuardadas = await guardarCombinacionesProducto();
            
            if (combinacionesGuardadas || combinacionesProducto.length === 0) {
                // Si las combinaciones se guardaron correctamente o no hay combinaciones, enviar el formulario principal
                mostrarNotificacion('Guardando producto...', 'info');
                this.submit();
            } else {
                // Si hubo error, permitir al usuario decidir si continuar
                const continuar = confirm('Hubo un error al guardar las combinaciones de talla/color. ¿Deseas continuar con la actualización del producto?');
                if (continuar) {
                    this.submit();
                }
            }
        });
    }
    
    // Preview de imágenes
    configurarPreviewImagenes();
}

/**
 * Configurar preview de imágenes
 */
function configurarPreviewImagenes() {
    // Preview para agregar producto
    const inputImagen = document.getElementById('product_imagen');
    const previewImagen = document.getElementById('imagenVistaPrevia');
    
    if (inputImagen && previewImagen) {
        inputImagen.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImagen.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Preview para modificar producto
    const inputImagenModificar = document.getElementById('nueva_imagen');
    const previewImagenModificar = document.getElementById('imagenPVistaPrevia');
    
    if (inputImagenModificar && previewImagenModificar) {
        inputImagenModificar.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImagenModificar.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

// =========================
// GESTIÓN DE INVENTARIO
// =========================

/**
 * Configura la gestión de inventario por tallas y colores
 */
function configurarGestionInventario() {
    const agregarCombinacionBtn = document.getElementById('agregarCombinacion');
    const cantidadInput = document.getElementById('cantidadInput');
    
    if (agregarCombinacionBtn) {
        // Remover event listeners previos si existen
        agregarCombinacionBtn.removeEventListener('click', manejarClickAgregar);
        
        // Agregar nuevo event listener
        agregarCombinacionBtn.addEventListener('click', manejarClickAgregar);
    }

    // Event listeners para validar la entrada
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function() {
            if (this.value < 0) this.value = 0;
        });
    }
}

/**
 * Maneja el click del botón agregar combinación
 */
function manejarClickAgregar(e) {
    e.preventDefault();
    e.stopPropagation();
    console.log('Botón agregar clickeado'); // Debug
    agregarCombinacion();
}

/**
 * Agrega una nueva combinación de talla/color/cantidad
 */
function agregarCombinacion() {
    const tallaSelect = document.getElementById('tallaSelect');
    const colorSelect = document.getElementById('colorSelect');
    const cantidadInput = document.getElementById('cantidadInput');

    if (!tallaSelect || !colorSelect || !cantidadInput) {
        mostrarNotificacion('Error: No se encontraron los elementos del formulario', 'error');
        return;
    }

    const tallaId = tallaSelect.value;
    const colorId = colorSelect.value;
    const cantidad = parseInt(cantidadInput.value) || 0;

    if (!tallaId || !colorId) {
        mostrarNotificacion('Por favor selecciona una talla y un color', 'warning');
        return;
    }

    if (cantidad < 0) {
        mostrarNotificacion('La cantidad no puede ser negativa', 'warning');
        return;
    }

    const tallaNombre = tallaSelect.options[tallaSelect.selectedIndex].text;
    const colorNombre = colorSelect.options[colorSelect.selectedIndex].text;

    // Verificar si ya existe esta combinación
    const combinacionExistente = combinacionesProducto.find(c => 
        c.id_talla == tallaId && c.id_color == colorId
    );

    if (combinacionExistente) {
        // Actualizar cantidad existente
        combinacionExistente.cantidad = cantidad;
        mostrarNotificacion(`Cantidad actualizada para ${tallaNombre} - ${colorNombre}`, 'info');
    } else {
        // Agregar nueva combinación
        combinacionesProducto.push({
            id_talla: tallaId,
            id_color: colorId,
            talla_nombre: tallaNombre,
            color_nombre: colorNombre,
            cantidad: cantidad
        });
        mostrarNotificacion(`Combinación agregada: ${tallaNombre} - ${colorNombre}`, 'success');
    }

    // Limpiar formulario
    tallaSelect.value = '';
    colorSelect.value = '';
    cantidadInput.value = '';

    // Actualizar vista
    actualizarVistaCombinaciones();
}

/**
 * Actualiza la vista de combinaciones
 */
function actualizarVistaCombinaciones() {
    const container = document.getElementById('combinationsContainer');
    if (!container) return;

    container.innerHTML = '';

    combinacionesProducto.forEach((combinacion, index) => {
        const combinacionElement = document.createElement('div');
        combinacionElement.className = 'combination-item';
        combinacionElement.innerHTML = `
            <span class="combination-talla">${combinacion.talla_nombre}</span>
            <span class="combination-color">${combinacion.color_nombre}</span>
            <div class="combination-quantity">
                <input type="number" 
                       value="${combinacion.cantidad}" 
                       min="0" 
                       onchange="actualizarCantidadCombinacion(${index}, this.value)"
                       class="quantity-input">
            </div>
            <button type="button" 
                    class="btn btn-danger btn-sm" 
                    onclick="eliminarCombinacion(${index})">
                <span class="material-symbols-outlined">delete</span>
            </button>
        `;
        container.appendChild(combinacionElement);
    });
}

/**
 * Actualiza la cantidad de una combinación específica
 */
window.actualizarCantidadCombinacion = function(index, nuevaCantidad) {
    const cantidad = parseInt(nuevaCantidad) || 0;
    if (cantidad < 0) return;
    
    combinacionesProducto[index].cantidad = cantidad;
};

/**
 * Elimina una combinación
 */
window.eliminarCombinacion = function(index) {
    combinacionesProducto.splice(index, 1);
    actualizarVistaCombinaciones();
    mostrarNotificacion('Combinación eliminada', 'info');
};

/**
 * Carga las combinaciones existentes para un producto
 */
async function cargarCombinacionesProducto(idProducto) {
    try {
        const response = await fetch('/api/obtenerCombinacionesProducto', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_producto=${idProducto}`
        });

        if (response.ok) {
            const combinaciones = await response.json();
            combinacionesProducto = combinaciones.map(c => ({
                id_talla: c.id_talla,
                id_color: c.id_color,
                talla_nombre: c.nombre_talla || 'Sin talla',
                color_nombre: c.nombre_color || 'Sin color',
                cantidad: parseInt(c.cantidad) || 0
            }));
            
            actualizarVistaCombinaciones();
        }
    } catch (error) {
        console.error('Error al cargar combinaciones:', error);
        mostrarNotificacion('Error al cargar combinaciones existentes', 'error');
    }
}

/**
 * Guarda todas las combinaciones del producto
 */
async function guardarCombinacionesProducto() {
    if (!productoActualId) {
        console.error('No hay producto seleccionado');
        return false;
    }

    if (combinacionesProducto.length === 0) {
        return true; // No hay combinaciones que guardar
    }

    try {
        const response = await fetch('/api/guardarCombinacionesProducto', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_producto=${productoActualId}&combinaciones=${JSON.stringify(combinacionesProducto)}`
        });

        if (response.ok) {
            const resultado = await response.json();
            if (resultado.success) {
                mostrarNotificacion('Combinaciones guardadas exitosamente', 'success');
                return true;
            } else {
                mostrarNotificacion('Error al guardar combinaciones', 'error');
                return false;
            }
        } else {
            mostrarNotificacion('Error de conexión al guardar combinaciones', 'error');
            return false;
        }
    } catch (error) {
        console.error('Error al guardar combinaciones:', error);
        mostrarNotificacion('Error al guardar combinaciones', 'error');
        return false;
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
            mostrarNotificacion('Producto deshabilitado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
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
            mostrarNotificacion('Producto habilitado correctamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarNotificacion('Error al habilitar el producto', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarNotificacion('Error de conexión', 'error');
    }
}