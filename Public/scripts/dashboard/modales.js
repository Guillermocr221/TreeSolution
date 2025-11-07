document.addEventListener("DOMContentLoaded", function() {
    
  //? MODAL VER PERFIL/EDITAR PERFIL
    let queryString = window.location.search;
    if(queryString){
      let params = new URLSearchParams(queryString);
      let pa =  params.get('pa');
      if(pa == "1"){
        Swal.fire({
          icon: 'success',
          title: 'Perfil Actualizado',
          text: 'Los datos han sido registrados correctamente'
        }).then( () => {
          setTimeout(() => {
            window.history.replaceState({}, '', window.location.pathname);
          }, 1);
        })
      }
    }
  
    // Obtener los elementos de los modales y los botones de cierre
    const verPerfilModal = document.getElementById('verPerfilModal');
    const closeVerPerfilModal = document.getElementById('closeVerPerfilModal');
    const botonModificarPerfil = document.getElementById('modificarPerfilBtn');
    const botonActualizarDatos = document.querySelector('.botonActualizarPerfil');
    
    const overlay = document.getElementById('overlay');
    // Obtener los enlaces para abrir los modales
    const verPerfilLink = document.getElementById('verPerfil');
  
    // Función para abrir el modal de ver perfil
    verPerfilLink.addEventListener('click', function() {
        verPerfilModal.style.display = 'block';
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Evitar el desplazamiento del cuerpo mientras el modal está abierto
    });
  
    botonModificarPerfil.addEventListener('click',()=>{
      
      botonModificarPerfil.style.display = 'none';
      botonActualizarDatos.style.display = 'block';
  
      document.querySelector('.titulo__editarPerfil').classList.add('tituloVisible');
      document.querySelector('.titulo__verPerfil').classList.add('tituloInvisible');
      document.querySelector('.perfil--picture').classList.add('active');
      const formulario = document.getElementById('verPerfilForm');
  
      // Seleccionar todos los inputs dentro del formulario
      const inputs = formulario.querySelectorAll('input');
  
      // 
      inputs.forEach(input => {
          if(input.name !== 'email') {
            input.removeAttribute('readonly');
          };
  
      });
    })

    // Funciones para cerrar los modales al hacer clic en el botón de cierre
    closeVerPerfilModal.addEventListener('click', function() {
        verPerfilModal.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = ''; // Restablecer el desplazamiento del cuerpo al cerrar el modal
  
        document.querySelector('.titulo__editarPerfil').classList.remove('tituloVisible');
        document.querySelector('.titulo__verPerfil').classList.remove('tituloInvisible');
        document.querySelector('.perfil--picture').classList.remove('active');
        botonModificarPerfil.style.display = 'block';
        botonActualizarDatos.style.display = 'none';
  
        // Seleccionar todos los inputs dentro del formulario
        const formulario = document.getElementById('verPerfilForm');
        const inputs = formulario.querySelectorAll('input');
        inputs.forEach(input => {
            if(input.name !== 'email') {
              input.setAttribute('readonly',true);
            };
  
        });
    });
  
    // Funciones para cerrar los modales al hacer clic fuera de ellos
    window.addEventListener('click', function(event) {
        if (event.target === overlay) {
            verPerfilModal.style.display = 'none';
            overlay.style.display = 'none';
            document.body.style.overflow = ''; // Restablecer el desplazamiento del cuerpo al cerrar el modal
            productModal.style.display = 'none';
          }
    });
  
    // Función para cerrar los modales al presionar la tecla Escape
    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            verPerfilModal.style.display = 'none';
            overlay.style.display = 'none';
            document.body.style.overflow = ''; // Restablecer el desplazamiento del cuerpo al cerrar el modal
        }
    });
  
    // Seleccionamos los elementos
    const inputFile = document.getElementById('profile_image');
    const imagenVistaPrevia = document.getElementById('imagenVistaPrevia');
  
    // Al hacer clic en la imagen, abre el input de archivo
    imagenVistaPrevia.addEventListener('click', () => {
        if( botonActualizarDatos.style.display == 'block' ){
          inputFile.click();
        }
    });
  
    // Al seleccionar un archivo, mostramos la vista previa
    inputFile.addEventListener('change', (event) => {
        const archivo = event.target.files[0]; // Tomamos el primer archivo seleccionado
  
        if (archivo) {
            // Creamos un URL temporal de la imagen seleccionada para mostrarla
            const reader = new FileReader();
            reader.onload = function(e) {
                imagenVistaPrevia.src = e.target.result; // Cambiamos el src de la imagen para vista previa
            };
            reader.readAsDataURL(archivo); // Leer el archivo como Data URL
        }
    });

    //? MODAL DE PRODUCTO DETALLADO
    const productModal = document.getElementById('productModal');
    const closeProductModal = productModal.querySelector('.close');
    const quantityDisplay = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseQuantity');
    const increaseBtn = document.getElementById('increaseQuantity');
    const addToCartBtn = document.getElementById('addToCart');
    const colorSelect = document.getElementById('modalColorSelect');
    const sizeSelect = document.getElementById('modalSizeSelect');
    const addToCartText = document.getElementById('addToCartText');
    const modalPrice = document.getElementById('modalPrice');

    let currentQuantity = 1;
    let currentProductData = null;

    // Funciones para controlar la cantidad
    decreaseBtn.addEventListener('click', function() {
        if (currentQuantity > 1) {
            currentQuantity--;
            updateQuantityDisplay();
        }
    });

    increaseBtn.addEventListener('click', function() {
        currentQuantity++;
        updateQuantityDisplay();
    });

    function updateQuantityDisplay() {
        quantityDisplay.textContent = currentQuantity;
        updateAddToCartButton();
    }

    function updateAddToCartButton() {
        if (currentProductData) {
            const totalPrice = (parseFloat(currentProductData.price) * currentQuantity).toFixed(2);
            addToCartText.innerHTML = `Agregar al carrito - S/ <span id="precioProdcuto">${totalPrice}<span>`;
        }
    }

    // Función para validar si se puede agregar al carrito
    function canAddToCart() {
        const hasColor = colorSelect.value !== '';
        const hasSize = sizeSelect.value !== '';
        
        // Si hay opciones disponibles, deben estar seleccionadas
        const colorOptions = colorSelect.querySelectorAll('option:not([value=""])');
        const sizeOptions = sizeSelect.querySelectorAll('option:not([value=""])');
        
        const needsColor = colorOptions.length > 0;
        const needsSize = sizeOptions.length > 0;
        
        return (!needsColor || hasColor) && (!needsSize || hasSize);
    }

    // Event listeners para las selecciones
    colorSelect.addEventListener('change', function() {
        addToCartBtn.disabled = !canAddToCart();
        // Opcional: Verificar disponibilidad específica cuando cambie la selección
        verificarDisponibilidadEspecifica();
    });

    sizeSelect.addEventListener('change', function() {
        addToCartBtn.disabled = !canAddToCart();
        // Opcional: Verificar disponibilidad específica cuando cambie la selección
        verificarDisponibilidadEspecifica();
    });

    // Función para configurar el modal cuando se abre
    async function setupProductModal(productData) {
        currentProductData = productData;
        currentQuantity = 1;
        
        // Resetear selecciones
        colorSelect.value = '';
        sizeSelect.value = '';
        
        // Limpiar opciones existentes
        colorSelect.innerHTML = '<option value="">Seleccionar color</option>';
        sizeSelect.innerHTML = '<option value="">Seleccionar talla</option>';
        
        // Cargar colores y tallas disponibles
        await cargarColoresYTallas(productData.id);
        
        // Actualizar displays
        updateQuantityDisplay();
        
        // Validar estado inicial del botón
        addToCartBtn.disabled = !canAddToCart();
        
        // Actualizar precio en el modal
        modalPrice.textContent = `S/ ${parseFloat(productData.price).toFixed(2)}`;
    }

    // Función para cargar colores y tallas desde la API
    async function cargarColoresYTallas(idProducto) {
        try {
            // Cargar colores
            const coloresResponse = await fetch('/api/obtenerColoresProducto', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_producto=${idProducto}`
            });
            
            if (coloresResponse.ok) {
                const colores = await coloresResponse.json();
                
                // Llenar select de colores
                colores.forEach(color => {
                    const option = document.createElement('option');
                    option.value = color.id_color;
                    option.textContent = color.nombre_color;
                    colorSelect.appendChild(option);
                });
            }

            // Cargar tallas
            const tallasResponse = await fetch('/api/obtenerTallasProducto', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_producto=${idProducto}`
            });
            
            if (tallasResponse.ok) {
                const tallas = await tallasResponse.json();
                
                // Llenar select de tallas
                tallas.forEach(talla => {
                    const option = document.createElement('option');
                    option.value = talla.id_talla;
                    option.textContent = talla.nombre_talla;
                    sizeSelect.appendChild(option);
                });
            }

        } catch (error) {
            console.error('Error al cargar colores y tallas:', error);
        }
    }

    // Función para verificar disponibilidad específica con talla y color
    async function verificarDisponibilidadEspecifica() {
        if (!currentProductData || !colorSelect.value || !sizeSelect.value) {
            return;
        }

        try {
            const response = await fetch('/api/verificarDisponibilidadEspecifica', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_producto=${currentProductData.id}&cantidad_solicitada=${currentQuantity}&id_talla=${sizeSelect.value}&id_color=${colorSelect.value}`
            });

            if (response.ok) {
                const resultado = await response.json();
                
                // Mostrar mensaje si no hay disponibilidad
                if (!resultado.disponible) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stock limitado',
                        text: 'Esta combinación de color y talla tiene stock limitado',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    addToCartBtn.disabled = true;
                } else {
                    addToCartBtn.disabled = !canAddToCart();
                }
            }
        } catch (error) {
            console.error('Error al verificar disponibilidad específica:', error);
        }
    }

    // Función para cerrar el modal de producto
    closeProductModal.addEventListener('click', function() {
        productModal.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = '';
        
        // Resetear estado del modal
        currentProductData = null;
        currentQuantity = 1;
        colorSelect.value = '';
        sizeSelect.value = '';
    });

    // Exponer la función para que pueda ser usada desde productos.js
    window.setupProductModal = setupProductModal;
});


