
const overlay = document.getElementById('overlay');
let botonesModificar = document.querySelectorAll('.symbol--editar');
const modalEditarProducto = document.getElementById('modificarProductModal');

let productoObtenido ;

botonesModificar.forEach( boton =>{
    boton.addEventListener('click', async ()=>{
        productoObtenido = await obtenerProducto(boton);
        llenarModalProducto(productoObtenido);
        overlay.style.display = 'block';
        
    });
})



export async function obtenerProducto(boton){
    let id_producto = boton.parentNode.parentNode.querySelector('.id_producto').innerHTML;
        id_producto = Number(id_producto);
    
    const datos  = new FormData();

    datos.append('id_Producto', id_producto )

    try {
        const url = '/api/obtenerProducto'
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        if (respuesta.ok) {
            let producto = await respuesta.json()
            return producto;
        } 
    } catch (error) {
        console.log(error)
    }
}


let formImagen = modalEditarProducto.querySelector('#imagenPVistaPrevia');
let formNombre = modalEditarProducto.querySelector('#nombreNuevo');
let formDescr = modalEditarProducto.querySelector('#nuevaDescripcion');
let formPrecio = modalEditarProducto.querySelector('#nuevoPrecio')
let formCateg = modalEditarProducto.querySelector('#nuevaCategoria');
let formStock = modalEditarProducto.querySelector('#nuevoStock');
let formId = modalEditarProducto.querySelector('#inputIdProducto');


function llenarModalProducto( producto ){
    let {nombre,descripcion,precio,stock,imagen,categoria,ID_Producto} = producto;

        formImagen.setAttribute('src',`/imagenes/store/${imagen}`);  
        formNombre.value = nombre;
        formDescr.value = descripcion;
        formPrecio.value = precio ;
        formCateg.value = categoria;
        formStock.value = stock;
        modalEditarProducto.dataset.idproducto = ID_Producto;
        formId.value = ID_Producto;

    modalEditarProducto.style.display = 'block';
}

overlay.addEventListener('click', function (event) {
    if (true) {
        modalEditarProducto.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }
});

document.querySelectorAll('.close').forEach(closeBtn => {
    closeBtn.addEventListener('click', function () {
        modalEditarProducto.style.display = 'none';
        overlay.style.display = 'none';
    });
});

// Seleccionamos los elementos
const inputFile = document.getElementById('producto_imagen');
const imagenVistaPrevia = document.getElementById('imagenPVistaPrevia');

// Al hacer clic en la imagen, abre el input de archivo
imagenVistaPrevia.addEventListener('click', () => {
    inputFile.click();
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



//* RELLENAR EL SELECT DE CATEGORIAS CON DATOS DE LA DB

let selectCategorias = document.getElementById('categoria-select');
let selectCategoriasMod = document.getElementById('nuevaCategoria');

async function consultarAPI(){
    try {
        const url = '/api/categorias';
        const resultado = await fetch(url);
        const categorias = await resultado.json();
        return categorias;

    } catch (error) {
        console.log(error);
    }  
}
async function obtenerCategorias() {
    let listaCats = await consultarAPI();

    listaCats.forEach( categoria =>{
        selectCategorias.append( crearOptionCategoria(categoria.id, categoria.nombre) );
        selectCategoriasMod.append( crearOptionCategoria(categoria.id, categoria.nombre) );
    });
}

obtenerCategorias();

function crearOptionCategoria(id, nombre){
    let option = document.createElement('OPTION');
        option.textContent = nombre;
        option.value = id;

    return option;
}