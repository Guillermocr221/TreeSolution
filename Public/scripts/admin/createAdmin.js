const overlay = document.getElementById('overlay');
let addAdminModal = document.getElementById('addAdminModal');
let button__agregarAdmin = document.getElementById('button__agregarAdmin');

overlay.addEventListener('click', function (event) {
    if (true) {
        addAdminModal.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }
});

document.querySelectorAll('.close').forEach(closeBtn => {
    closeBtn.addEventListener('click', function () {

        addAdminModal.style.display = 'none';
        overlay.style.display = 'none';
    });
});

button__agregarAdmin.addEventListener('click',()=>{
    addAdminModal.style.display = 'block';
    overlay.style.display = 'block';
})

// Seleccionamos los elementos
const inputFile = document.getElementById('admin_imagen');
const imagenAdminVistaPrevia = document.getElementById('imagenAdminVistaPrevia');

// Al hacer clic en la imagen, abre el input de archivo
imagenAdminVistaPrevia.addEventListener('click', () => {
    inputFile.click();
});

// Al seleccionar un archivo, mostramos la vista previa
inputFile.addEventListener('change', (event) => {
    const archivo = event.target.files[0]; // Tomamos el primer archivo seleccionado

    if (archivo) {
        // Creamos un URL temporal de la imagen seleccionada para mostrarla
        const reader = new FileReader();
        reader.onload = function(e) {
            imagenAdminVistaPrevia.src = e.target.result; // Cambiamos el src de la imagen para vista previa
        };
        reader.readAsDataURL(archivo); // Leer el archivo como Data URL
    }
});