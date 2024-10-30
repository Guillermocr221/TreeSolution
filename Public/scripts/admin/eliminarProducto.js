import { obtenerProducto } from "./modificarProducto.js";

let botonesEliminarProducto = document.querySelectorAll('.symbol-borrar');

botonesEliminarProducto.forEach(boton => {
    boton.addEventListener('click', async()=>{
        let rsp = confirm('¿Seguro de eliminar el producto?');

        if(rsp == true){
            let productoAEliminar = await obtenerProducto(boton);
            productoAEliminar = productoAEliminar.ID_Producto;
            
            if( eliminarProducto(productoAEliminar)) {

            }
        }
        
    });
});

async function eliminarProducto( idProducto){
    const datos  = new FormData();

    datos.append('id_Producto', idProducto )

    try {
        // Petición hacia la api
        const url = '/api/eliminarProducto'
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        if (respuesta.redirected) {
            // Redirigir manualmente en el lado del cliente
            window.location.href = respuesta.url;  
        } 
        
    } catch (error) {
        console.log(error)
    }
}