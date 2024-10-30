const overlay = document.getElementById('overlay');
let addProductModal = document.getElementById('addProductModal');
let button_agregarProducto = document.getElementById('button_agregarProducto');

overlay.addEventListener('click', function (event) {
    if (true) {
        addProductModal.style.display = 'none';
        document.body.style.overflow = '';
    }
});

document.querySelectorAll('.close').forEach(closeBtn => {
    closeBtn.addEventListener('click', function () {

        addProductModal.style.display = 'none';
        overlay.style.display = 'none';
    });
});

button_agregarProducto.addEventListener('click',()=>{
    addProductModal.style.display = 'block';
    overlay.style.display = 'block';
})



// Seleccionamos los elementos
const inputFile = document.getElementById('product_imagen');
const imagenVistaPrevia = document.getElementById('imagenVistaPrevia');

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