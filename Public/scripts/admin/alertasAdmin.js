import { activateMenuItem } from './adminNavegation.js';
const usersButton = document.getElementById('usersButton');

export function activarPanelUsuario(){
    activateMenuItem(usersButton);
    usersSection.style.display = 'block';
    productsSection.style.display = 'none';
    employeesSection.style.display = 'none';
}
export function activarPanelProductos(){
    activateMenuItem(productsButton);
    usersSection.style.display = 'none';
    productsSection.style.display = 'block';
    employeesSection.style.display = 'none';
}
export function activarPanelVentas(){
    activateMenuItem(employeesButton);
    usersSection.style.display = 'none';
    productsSection.style.display = 'none';
    employeesSection.style.display = 'block';
}

function alerta( tipo, titulo, mensaje){
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje
    }).then( () => {
        window.history.replaceState({}, '', window.location.pathname);
    })
}

let queryString = window.location.search;

document.addEventListener('DOMContentLoaded', function () {
    let mensaje, titulo;
    if(queryString){
        let params = new URLSearchParams(queryString);
        let estado =  params.get('estado');
        if(estado == "regProdExitoso"){
            activarPanelProductos();
            titulo = 'Producto Creado';
            mensaje = 'Los datos del producto han sido registrados correctamente';
            alerta('success', titulo, mensaje);
        }else if(estado == "regAdminExitoso" ){
            activarPanelUsuario();
            titulo = 'Administrador Registrado';
            mensaje = 'Los datos del nuevo administrador han sido registrados correctamente';
            alerta('success', titulo, mensaje);
        }else if(estado == "eliminacionExitosa"){
            activarPanelProductos();
            titulo = 'Eliminacion Registrada';
            mensaje = 'El producto ha sido eliminado';
            alerta('success', titulo, mensaje );
        }else if(estado == "correoExistente"){
            titulo = 'Correo Registrado Anteriormente';
            mensaje = 'El correo ya ha sido registrado en otro usuario, intente con uno distinto';
            alerta('error', titulo, mensaje);
        }else if(estado == "modProdExitoso"){
            activarPanelProductos();
            titulo = 'Modificación exitosa del Producto.';
            mensaje = 'Los datos se guardaron correctamente.';
            alerta('success', titulo, mensaje );
        }else if(estado){
            titulo = 'Estado Desconocido';
            mensaje= 'Algo no está bien 🤔';
            alerta('error', titulo, mensaje);
        }
    }
});
