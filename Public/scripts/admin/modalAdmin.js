// Módulo de gestión de modales del dashboard admin

/**
 * Configura los eventos de los modales
 */
export function configurarModales() {
    // Cerrar modal al hacer clic fuera
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                cerrarModal(modal.id);
            }
        });
    });

    // Botones de cerrar modal
    document.querySelectorAll('.close').forEach(botonCerrar => {
        botonCerrar.addEventListener('click', (e) => {
            const modal = e.target.closest('.modal');
            if (modal) {
                cerrarModal(modal.id);
            }
        });
    });

    // Configurar vistas previas de imágenes
    configurarVistasPreviasImagenes();
}

/**
 * Abre un modal específico
 * @param {string} idModal - El ID del modal a abrir
 */
export function abrirModal(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.classList.add('show');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Cierra un modal específico
 * @param {string} idModal - El ID del modal a cerrar
 */
export function cerrarModal(idModal) {
    const modal = document.getElementById(idModal);
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        
        // Resetear formulario si existe
        const formulario = modal.querySelector('form');
        if (formulario) {
            formulario.reset();
            // Resetear vistas previas de imágenes
            const vistasPrevias = formulario.querySelectorAll('.image-preview img');
            vistasPrevias.forEach(img => {
                img.src = '/imagenes/store/productUndefined.png';
            });
        }
    }
}

/**
 * Abre el modal de edición de producto con datos prellenados
 * @param {Object} datosProducto - Los datos del producto a editar
 */
export function abrirModalEditarProducto(datosProducto) {
    // Llenar campos del formulario
    document.getElementById('ID_Producto').value = datosProducto.id;
    document.getElementById('nombreNuevo').value = datosProducto.nombre;
    document.getElementById('nuevaDescripcion').value = datosProducto.descripcion;
    document.getElementById('nuevoPrecio').value = datosProducto.precio;
    document.getElementById('nuevaCategoria').value = datosProducto.categoria;
    document.getElementById('nuevoStock').value = datosProducto.stock;
    
    // Configurar vista previa de imagen
    const vistaPrevia = document.getElementById('imagenPVistaPrevia');
    if (vistaPrevia && datosProducto.imagen) {
        vistaPrevia.src = `/imagenes/store/${datosProducto.imagen}`;
    }

    abrirModal('modificarProductModal');
}

/**
 * Configura la vista previa de imagen al seleccionar archivo
 * @param {HTMLInputElement} input - El input de archivo
 * @param {string} idVistaPrevia - El ID del elemento de vista previa
 */
export function configurarVistaPreviaImagen(input, idVistaPrevia) {
    const archivo = input.files[0];
    const vistaPrevia = document.getElementById(idVistaPrevia);
    
    if (archivo && vistaPrevia) {
        const lector = new FileReader();
        lector.onload = function(e) {
            vistaPrevia.src = e.target.result;
        };
        lector.readAsDataURL(archivo);
    }
}

/**
 * Configura las vistas previas de imágenes en los formularios
 */
function configurarVistasPreviasImagenes() {
    // Vista previa para agregar producto
    const imagenAgregar = document.getElementById('product_imagen');
    if (imagenAgregar) {
        imagenAgregar.addEventListener('change', (e) => {
            configurarVistaPreviaImagen(e.target, 'imagenVistaPrevia');
        });
    }

    // Vista previa para editar producto
    const imagenEditar = document.getElementById('nueva_imagen');
    if (imagenEditar) {
        imagenEditar.addEventListener('change', (e) => {
            configurarVistaPreviaImagen(e.target, 'imagenPVistaPrevia');
        });
    }
}