<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Treesolution</title>
    <link rel="stylesheet" href="/estilos/CrearCuenta.css">
    
</head>
<body>
    <div class="container">
        <h1>¿Eres nuevo en TreeSolution?</h1>
        <p>Regístrate y disfruta de nuestros beneficios y una experiencia de compra más rápida y sencilla</p>
        <form id="registrationForm" method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="contrasena" required>

            <label for="confirmarContrasena">Confirmar Contraseña</label>
            <input type="password" id="confirmarContrasena" name="confirmarContrasena" required>

            <div class="checkbox-container">
                <input type="checkbox" id="terminos" name="terminos" required>
                <label for="terminos">He leído y acepto los términos y condiciones y políticas de privacidad</label>
            </div>

            <button type="submit">Crear Cuenta</button>
            <button type="button" id="volverLogin">Volver al Login</button>
        </form>
    </div>
    <script src="/scripts/CrearCuenta.js"></script>
</body>
</html>
