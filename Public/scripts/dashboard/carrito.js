import {id_session} from '../Dashboard2.js';

//? CARRITO
const cartIcon = document.getElementById('cartIcon');
const cartModal = document.getElementById('cartModal');
const totalPriceElement = document.getElementById('totalPrice');
const cartCount = document.getElementById('cartCount');

let cart = [];

// Mostrar/Ocultar el modal del carrito
cartIcon.addEventListener('click', function () {
    cartModal.style.display = 'block';
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden';
});

// Ocultar el modal al hacer clic fuera de él
overlay.addEventListener('click', function (event) {
    if (true) {
        cartModal.style.display = 'none';
        productModal.style.display = 'none';
        payModal.style.display = 'none';
        event.target.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }
});

// Añadir al carrito
document.getElementById('addToCart').addEventListener('click', () => {

    const nombre = document.getElementById('modalName').textContent;
    const precio = parseFloat(document.getElementById('precioProdcuto').textContent);
    const cantidad = parseInt(document.getElementById('quantity').textContent);
    const idproducto= document.getElementById('productModal').getAttribute('data-id');
    const imagenProducto = document.getElementById('modalImage').getAttribute('src');
    
    const productToAdd = {
        idproducto: idproducto,
        nombre: nombre,
        precio: parseFloat(precio),
        imagenProducto: imagenProducto,
        cantidad: cantidad
    };

    addToCart(productToAdd);
});

export async function addToCart ( { nombre, precio, cantidad, idproducto, imagenProducto } ) {

    if(id_session == false){
        window.location.href = '/login?estado=e1' ;

    }else{        
        let cantidad_disponible = await comprobarStock(idproducto, cantidad);

        if(cantidad_disponible == true){
            // Hay cantidad suficiente en stock, se agrega al carrito
            const existingProductIndex = cart.findIndex(product => product.nombre === nombre);
            if (existingProductIndex > -1) {
                cart[existingProductIndex].cantidad += cantidad;
            } else {
                cart.push({ nombre, precio, cantidad, idproducto, imagenProducto });
                console.log(cart);
            }
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Producto Agregado",
                showConfirmButton: false,
                timer: 800
              });
            updateCart();
            productModal.style.display = 'none';
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }else{
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No tenemos stock suficiente 😥",
              });
        }
        
    }
}

async function comprobarStock(id_producto, cantidad_a_pedir){

    const datos = new FormData;
          datos.append('idProducto',id_producto);
          datos.append('cantidadSolicitada',cantidad_a_pedir);

    try {
        let url = '/api/comprobarDisponibilidad' ;
        let respuesta = await fetch(url,{
            method: 'POST',
            body: datos
        })

        if(respuesta.ok){
            let resultado = await respuesta.json();
            return resultado.disponible;
        }
    } catch (error) {
        console.log(error)
    }

}

const venta ={
    productos: [],
    total: ''
}

var totalPedido = document.querySelector("#totalPrice");

export function precioTotalProductos(){
    let total = 0;
    cart.forEach( producto => {
        total += producto.precio * producto.cantidad ;
    })
    return total;
}

export let functionEnviarPedido = async ()=>{
    
    let contenedorDatos = document.getElementById('payModal');
    var inputs = document.querySelectorAll("#payModal input");

    var arrayProductos = cart.map(function(e){
        let producto = {
            nombre: e.nombre,
            cantidad: e.cantidad,
            precioUnitario : e.precio,
            idproducto : e.idproducto
        }
        return producto;
    });

    var precioTotal;
        precioTotal = precioTotalProductos();
    
    venta.productos = arrayProductos;
    venta.total = precioTotal ;

    const datos  = new FormData();

    datos.append('productos',  JSON.stringify(venta.productos))
    datos.append('total', venta.total)
    console.log([...datos]);
    
    try {
        // Petición hacia la api
        const url = '/api/pedido'
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        
        if(resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Pedido Registrado',
                text: 'Los detalles seran enviados al whatsapp del número registrado',
            }).then( () => {
                // setTimeout(() => {
                //     window.location.reload();
                // }, 3000);
            })
        }
    } catch (error) {
        console.log(error)
    }
        
        cart = [];
        updateCart();
        payModal.style.display ='none';
        cartModal.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = '';
   
}


//? CARRITO - Nueva implementación con diseño mejorado
const cartItemsContainer = document.getElementById('cartItemsContainer');
const emptyCartMessage = document.getElementById('emptyCartMessage');
const orderSummary = document.getElementById('orderSummary');
const cartActions = document.getElementById('cartActions');
const subtotalAmount = document.getElementById('subtotalAmount');
const shippingAmount = document.getElementById('shippingAmount');
const freeShippingNote = document.getElementById('freeShippingNote');

// Actualizar carrito con nuevo diseño
function updateCart() {
    cartItemsContainer.innerHTML = '';
    let totalItems = 0;
    let total = 0;
    
    if (cart.length === 0) {
        // Mostrar mensaje de carrito vacío
        emptyCartMessage.style.display = 'block';
        orderSummary.style.display = 'none';
        cartActions.style.display = 'none';
    } else {
        // Ocultar mensaje de carrito vacío
        emptyCartMessage.style.display = 'none';
        orderSummary.style.display = 'block';
        cartActions.style.display = 'flex';
        
        cart.forEach(product => {
            // Crear card del producto
            const itemCard = document.createElement('div');
            itemCard.classList.add('cart-item-card');
            itemCard.dataset.id = product.idproducto;
            
            itemCard.innerHTML = `
                <div class="cart-item-content">
                    <div class="cart-item-image">
                        <img src="${product.imagenProducto}" 
                             alt="${product.nombre}" 
                             >
                    </div>
                    <div class="cart-item-details">
                        <div class="cart-item-header">
                            <div class="cart-item-info">
                                <h4>${product.nombre}</h4>
                                <div class="cart-item-badges">
                                    <span class="cart-item-badge">Talla M</span>
                                    <span class="cart-item-badge">Color Azul</span>
                                </div>
                            </div>
                            <button class="cart-item-remove" data-name="${product.nombre}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3,6 5,6 21,6"></polyline>
                                    <path d="m19,6v14a2,2 0 0,1 -2,2H7a2,2 0 0,1 -2,-2V6m3,0V4a2,2 0 0,1 2,-2h4a2,2 0 0,1 2,2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="cart-item-footer">
                            <div class="cart-item-quantity">
                                <button class="quantity-btn decrease-btn" data-id="${product.idproducto}">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                                <span class="quantity-display">${product.cantidad}</span>
                                <button class="quantity-btn increase-btn" data-id="${product.idproducto}">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                            </div>
                            <p class="cart-item-price">S/ ${(product.precio * product.cantidad).toFixed(2)}</p>
                        </div>
                    </div>
                </div>
            `;

            cartItemsContainer.appendChild(itemCard);
            total += product.precio * product.cantidad;
            totalItems += product.cantidad;
        });
    }
    
    // Actualizar totales
    const subtotal = total;
    const shipping = subtotal >= 100 ? 0 : 10; // Envío gratis si compra es mayor a S/ 100
    const finalTotal = subtotal + shipping;
    
    subtotalAmount.textContent = `S/ ${subtotal.toFixed(2)}`;
    shippingAmount.textContent = shipping === 0 ? 'Gratis' : `S/ ${shipping.toFixed(2)}`;
    totalPriceElement.textContent = `S/ ${finalTotal.toFixed(2)}`;
    cartCount.textContent = totalItems;
    
    // Mostrar/ocultar nota de envío gratis
    if (shipping === 0 && cart.length > 0) {
        freeShippingNote.style.display = 'block';
    } else {
        freeShippingNote.style.display = 'none';
    }
    
    // Actualizar event listeners
    setupCartEventListeners();
}

// Configurar event listeners para los nuevos elementos
function setupCartEventListeners() {
    // Botones de eliminar
    document.querySelectorAll('.cart-item-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            const productName = this.getAttribute('data-name');
            removeItemFromCart(productName);
        });
    });
    
    // Botones de aumentar cantidad
    document.querySelectorAll('.increase-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            updateQuantity(productId, 1);
        });
    });
    
    // Botones de disminuir cantidad
    document.querySelectorAll('.decrease-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            updateQuantity(productId, -1);
        });
    });
}

// Función para actualizar cantidad
function updateQuantity(productId, change) {
    const productIndex = cart.findIndex(product => product.idproducto == productId);
    
    if (productIndex > -1) {
        cart[productIndex].cantidad += change;
        
        // Si la cantidad llega a 0, eliminar el producto
        if (cart[productIndex].cantidad <= 0) {
            cart.splice(productIndex, 1);
        }
        
        updateCart();
    }
}

// Función para eliminar un ítem del carrito
function removeItemFromCart(productName) {
    const itemIndex = cart.findIndex(product => product.nombre == productName);

    if (itemIndex > -1) {
        cart.splice(itemIndex, 1);
    }
    updateCart();
}

// Ocultar el modal del carrito y producto
document.querySelectorAll('.close').forEach(closeBtn => {
    closeBtn.addEventListener('click', function () {
        cartModal.style.display = 'none';
        productModal.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    });
});

//? PAGAR ---------------------------------------------------------
const payModal = document.getElementById('payModal');
document.getElementById('checkout').addEventListener('click', function () {
    
    if(cart.length == 0){
        console.log("Carro vacio!")
    }else{
        payModal.style.display ='block'
        cartModal.style.display = 'none';
    }
    
});

// Cancelar
document.getElementById('cancel').addEventListener('click', function () {
    cartModal.style.display = 'none';
    overlay.style.display = 'none';
    document.body.style.overflow = '';
});

// Agregar event listener para el botón "Finalizar Compra"
document.getElementById('finalizeOrder').addEventListener('click', function() {
    if(cart.length == 0){
        console.log("Carro vacio!")
    }else{
        // Aquí puedes agregar la lógica para finalizar la compra sin PayPal
        console.log("Finalizar compra");
        functionEnviarPedido();
    }
});