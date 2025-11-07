<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Código - TreeSolution</title>
    <link rel="stylesheet" href="/estilos/CrearCuenta.css">
    <style>
        .codigo-container {
            text-align: center;
            margin: 20px 0;
        }
        
        .codigo-input {
            font-size: 24px;
            text-align: center;
            letter-spacing: 10px;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            max-width: 300px;
            margin: 0 auto;
            display: block;
        }
        
        .codigo-input:focus {
            border-color: #4CAF50;
            outline: none;
        }
        
        .user-info {
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        
        .resend-code {
            color: #666;
            font-size: 14px;
            margin-top: 15px;
        }
        
        .resend-code a {
            color: #4CAF50;
            text-decoration: none;
        }
        
        .resend-code a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirma tu código de activación</h1>
        <p>Hemos enviado un código de 10 dígitos a tu correo electrónico</p>
        
        <?php if($usuario): ?>
            <div class="user-info">
                <p><strong>Cuenta:</strong> <?php echo htmlspecialchars($usuario->nombre . ' ' . $usuario->apellido); ?></p>
                <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuario->email); ?></p>
            </div>
        <?php endif; ?>
        
        <?php 
            include __DIR__."/bases/alertas.php";
        ?>
        
        <form id="confirmCodeForm" method="POST">
            <?php if($usuario): ?>
                <input type="hidden" name="usuario_id" value="<?php echo $usuario->ID_Usuario; ?>">
            <?php endif; ?>
            
            <div class="codigo-container">
                <label for="codigo">Código de Activación</label>
                <input 
                    type="text" 
                    id="codigo" 
                    name="codigo" 
                    class="codigo-input"
                    placeholder="0000000000"
                    maxlength="10"
                    pattern="[0-9]{10}"
                    required
                >
            </div>

            <button type="submit">Activar Cuenta</button>
            
            <div class="resend-code">
                <p>¿No recibiste el código? <a href="/registrarse">Registrarse nuevamente</a></p>
            </div>
            
            <button type="button" onclick="window.location.href='/login'">Volver al Login</button>
        </form>
    </div>
    
    <script>
        // Formatear input para solo números
        document.getElementById('codigo').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
        
        // Auto-submit cuando se complete el código
        document.getElementById('codigo').addEventListener('input', function(e) {
            if(e.target.value.length === 10) {
                document.getElementById('confirmCodeForm').submit();
            }
        });
    </script>
</body>
</html>