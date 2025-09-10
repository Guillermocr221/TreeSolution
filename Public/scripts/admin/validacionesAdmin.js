// Módulo de validaciones del dashboard admin

/**
 * Valida el formulario de producto antes del envío
 * @param {Event} evento - El evento de submit del formulario
 * @returns {boolean} - True si es válido, false si no
 */
export function validarFormularioProducto(evento) {
    const formulario = evento.target;
    const datosFormulario = new FormData(formulario);
    
    // Validación básica de campos requeridos
    const camposRequeridos = ['nombre', 'descripcion', 'precio', 'categoria', 'stock'];
    let esValido = true;
    
    camposRequeridos.forEach(campo => {
        const valor = datosFormulario.get(campo);
        if (!valor || valor.trim() === '') {
            esValido = false;
            mostrarErrorCampo(campo, 'Este campo es requerido');
        }
    });

    // Validación del precio
    const precio = parseFloat(datosFormulario.get('precio'));
    if (precio <= 0) {
        esValido = false;
        mostrarErrorCampo('precio', 'El precio debe ser mayor a 0');
    }

    // Validación del stock
    const stock = parseInt(datosFormulario.get('stock'));
    if (stock < 0) {
        esValido = false;
        mostrarErrorCampo('stock', 'El stock no puede ser negativo');
    }

    if (!esValido) {
        evento.preventDefault();
        return false;
    }

    return true;
}

/**
 * Muestra un mensaje de error para un campo específico
 * @param {string} nombreCampo - El nombre del campo con error
 * @param {string} mensaje - El mensaje de error a mostrar
 */
function mostrarErrorCampo(nombreCampo, mensaje) {
    const campo = document.getElementById(nombreCampo) || 
                  document.getElementById(`nuevo${nombreCampo.charAt(0).toUpperCase() + nombreCampo.slice(1)}`);
    
    if (campo) {
        campo.style.borderColor = 'var(--danger)';
        
        // Remover mensaje de error existente
        const errorExistente = campo.parentNode.querySelector('.campo-error');
        if (errorExistente) {
            errorExistente.remove();
        }
        
        // Agregar mensaje de error
        const divError = document.createElement('div');
        divError.className = 'campo-error';
        divError.style.color = 'var(--danger)';
        divError.style.fontSize = '0.75rem';
        divError.style.marginTop = '0.25rem';
        divError.textContent = mensaje;
        campo.parentNode.appendChild(divError);
        
        // Remover estilo de error al escribir
        campo.addEventListener('input', function() {
            campo.style.borderColor = '';
            if (divError.parentNode) {
                divError.remove();
            }
        }, { once: true });
    }
}

/**
 * Limpia todos los errores de validación de un formulario
 * @param {HTMLFormElement} formulario - El formulario a limpiar
 */
export function limpiarErroresValidacion(formulario) {
    const errores = formulario.querySelectorAll('.campo-error');
    errores.forEach(error => error.remove());
    
    const campos = formulario.querySelectorAll('input, textarea, select');
    campos.forEach(campo => {
        campo.style.borderColor = '';
    });
}