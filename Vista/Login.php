<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet" />
    <link href="/estilos/Login.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="image"></div>
        <div class="form-container">

        <?php 
            include __DIR__."/bases/alertas.php";
        ?>
            <h1>Inicio de Sesión</h1>
            <form id="loginForm" method="POST">
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="text" id="email" name="email" placeholder="Escribe tu email" required />
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="password" name="contrasena" placeholder="Escribe tu contraseña" class="input-custom" required />
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit">Iniciar Sesión</button>
                </div>
            </form>
            <div class="additional-text">
                <p>o iniciar sesión con</p>
            </div>
            <div class="social-buttons">
                <button type="button" class="Google">Google</button>
                <button type="button" class="facebook">Facebook</button>
            </div>
            <div class="register-link">
                <p>No tienes una cuenta? <a href="/registrarse">Regístrate</a></p>
            </div>
        </div>
    </div>
    <script src="/Public/scripts/Login.js"></script>
</body>
</html>
