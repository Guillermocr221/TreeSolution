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
document.getElementById('addToCart').addEventListener('click', async function () {

    if(id_session == false){
        window.location.href = '/login?estado=e1' ;

    }else{
        const nombre = document.getElementById('modalName').textContent;
        const precio = parseFloat(document.getElementById('modalPrice').textContent.replace('Precio: S/ ', ''));
        const cantidad = parseInt(document.getElementById('quantity').value);
        const idproducto= document.getElementById('productModal').getAttribute('data-id');
        
        let cantidad_disponible = await comprobarStock(idproducto, cantidad);

        if(cantidad_disponible == true){
            // Hay cantidad suficiente en stock, se agrega al carrito
            const existingProductIndex = cart.findIndex(product => product.nombre === nombre);
            if (existingProductIndex > -1) {
                cart[existingProductIndex].cantidad += cantidad;
            } else {
                cart.push({ nombre, precio, cantidad, idproducto });
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
});

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
    // nombre:'',
    // direccion: '',
    // celular: '',
    productos: [],
    total: ''
}

var totalPedido = document.querySelector("#totalPrice");
// let functionEnviarPedido = async() =>{ 
// };


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


//? CARRITO
const cartItemsContainer = document.getElementById('cartItems');

// Actualizar carrito
function updateCart() {
    cartItemsContainer.innerHTML = '';
    let totalItems = 0;
    let total = 0;
    cart.forEach(product => {
        const item = document.createElement('li');
        item.dataset.id = product.idproducto;
        item.classList.add('cart__item');
        item.dataset.idproducto = product.idproducto;

        item.innerHTML = `<h5 class="cart__item-titulo">${product.nombre}</h5> - S/ ${product.precio.toFixed(2)} x ${product.cantidad}
        <button class="remove-item" data-name="${product.nombre}">Quitar</button>`;

        cartItemsContainer.appendChild(item);

        total += product.precio * product.cantidad;
        totalItems += product.cantidad;
    });
 
    totalPriceElement.textContent = `Total: S/ ${total.toFixed(2)}`;
    cartCount.textContent = totalItems;
    totalPedido = document.getElementById("totalPrice");

    botonEliminarDeCarrito();
}


// Función para eliminar un ítem del carrito
function removeItemFromCart(productName) {
    const itemIndex = cart.findIndex(product => product.nombre == productName);

    if (itemIndex > -1) {
        cart.splice(itemIndex, 1);
    }
    updateCart();
}


function botonEliminarDeCarrito(productName){
    document.querySelectorAll('.remove-item').forEach( e=>{
        e.addEventListener('click',()=>{
            const productName = e.getAttribute('data-name');
            removeItemFromCart(productName);
        })
    })
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