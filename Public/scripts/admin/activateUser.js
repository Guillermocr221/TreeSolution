let botonesEliminarUsuario = document.querySelectorAll(".button__eliminarUsuario");

Array.from(botonesEliminarUsuario).forEach( botonEliminar =>{
    botonEliminar.addEventListener('click', ()=>{
        let rowUser = botonEliminar.parentElement.parentElement;
        const idUser = Number (rowUser.querySelector('.id_usuario').textContent);

        eliminarUsuario(idUser);

        console.log(idUser)
    })
});

async function eliminarUsuario(idUser){

    const datos  = new FormData();

    datos.append('id_usuario', idUser )

    try {
        // Petición hacia la api
        const url = '/api/borrarUsuario'
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

let botonesActivarUsuario = document.querySelectorAll(".button__activarUsuario");

Array.from(botonesActivarUsuario).forEach( Activar =>{
    Activar.addEventListener('click', ()=>{
        let rowUser = Activar.parentElement.parentElement;
        const idUser = Number (rowUser.querySelector('.id_usuario').textContent);

        activarUsuario(idUser);
        console.log(idUser)
    })
});

async function activarUsuario(idUser){

    const datos  = new FormData();

    datos.append('id_usuario', idUser )

    try {
        // Petición hacia la api
        const url = '/api/activarUsuario'
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