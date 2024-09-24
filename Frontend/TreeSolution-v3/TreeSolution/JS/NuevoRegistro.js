document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const telefono = document.getElementById('telefono').value;
    const correo = document.getElementById('correo').value;
    const contrasena = document.getElementById('contrasena').value;
    const confirmarContrasena = document.getElementById('confirmarContrasena').value;
    const terminos = document.getElementById('terminos').checked;

    if (contrasena !== confirmarContrasena) {
        alert('Las contraseñas no coinciden.');
        return;
    }

    if (!terminos) {
        alert('Debe aceptar los términos y condiciones y políticas de privacidad.');
        return;
    }

    // Aquí puedes añadir la lógica para enviar los datos del formulario al servidor

    alert('Cuenta creada con éxito.');
});

document.getElementById('volverLogin').addEventListener('click', function() {
    window.location.href = 'Login.html'; // Reemplaza con la URL de tu página de login
});
