
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
  });


  