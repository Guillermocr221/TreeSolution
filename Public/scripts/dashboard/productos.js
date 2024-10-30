
let productosList ;

async function obtenerProductos(){
    
    try {
        const url = '/api/productos' ;
        const resultado = await fetch(url);
        let productos = await resultado.json();

        return productos;
    } catch (error) {
        console.log(error);
    }
}



let contenedorProductos = document.getElementById('productList');

async function llenarProductos(){
    
    productosList.forEach(producto => {
        let productoInsertado = crearProducto(producto);
            contenedorProductos.appendChild(productoInsertado);
    });
}


async function inicio(){
    productosList = await obtenerProductos();
    
    await llenarProductos();
    funcionalidadModalProducto();
}

inicio();



function crearProducto( producto ){
    // Crear el contenedor principal
    const productDiv = document.createElement('div');
    productDiv.classList.add('product');

    // Añadir atributos 'data-id', 'data-name' y 'data-price'
    productDiv.dataset.id = producto.ID_Producto;
    productDiv.dataset.name = producto.nombre;
    productDiv.dataset.price = producto.precio;

    // Crear la imagen
    const img = document.createElement('img');
    img.src = `/imagenes/store/${producto.imagen}`;
    img.alt = producto.nombre;

    // Crear el contenedor de la información
    const infoDiv = document.createElement('div');
    infoDiv.classList.add('info');

    // Crear los elementos de información
    const h3 = document.createElement('h3');
    h3.textContent = 'GENÉRICO';

    const productName = document.createElement('p');
    productName.textContent = producto.nombre;

    const deliveryInfo = document.createElement('p');
    deliveryInfo.textContent = 'Por tienda y delivery';

    const productPrice = document.createElement('p');
    productPrice.textContent = producto.precio;

    // Añadir los elementos al contenedor de información
    infoDiv.appendChild(h3);
    infoDiv.appendChild(productName);
    infoDiv.appendChild(deliveryInfo);
    infoDiv.appendChild(productPrice);

    // Añadir la imagen y la información al contenedor principal
    productDiv.appendChild(img);
    productDiv.appendChild(infoDiv);

    // Finalmente, agregar el 'productDiv' al DOM, por ejemplo a un contenedor existente
    document.body.appendChild(productDiv);  // O puedes añadirlo a un div específico

    return productDiv;
}

function funcionalidadModalProducto(){
    //? MODAL DETALLES DE PRODUCTO
    const productModal = document.getElementById('productModal');
    let i = 1;
    // Mostrar detalles del producto en el modal al hacer clic en el card del producto
    document.querySelectorAll('.product').forEach(product => {
        
        product.addEventListener('click', function () {
            const name = product.getAttribute('data-name');
            const price = product.getAttribute('data-price');
            const id = product.getAttribute('data-id');
            const imgSrc = product.querySelector('img').getAttribute('src');

            const modalProduct = document.getElementById('productModal');
                modalProduct.setAttribute('data-id', id); 

            document.getElementById('modalImage').setAttribute('src', imgSrc);
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalPrice').textContent = `Precio: S/ ${price}`;
            productModal.style.display = 'block';
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
    });
}
