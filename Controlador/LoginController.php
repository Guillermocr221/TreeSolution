<?php 

namespace Controllers;
use MVC\Router;
use Model\User;
use Model\Cliente;

use Controllers\MailController;

class LoginController{


    public static function login(Router $router){
        
        if( $_SERVER['REQUEST_METHOD'] === 'POST'){
            //creamos un objeto User con los datos enviados a trabes del formulario(post)
            $usuariotmp = new User($_POST);
            //buscamos un Usuario donde el email sea igual al ingresado por form
            $usuario = User::where('email', $usuariotmp->email);
            // debuguear($usuario);
            if($usuario){
                // Verificar si el usuario está activado (codigo debe ser NULL)
                if(!empty($usuario->codigo)){
                    User::setAlerta('error', 'Tu cuenta no está activada. Revisa tu correo para obtener el código de activación.');
                } else {
                    //Comprobamos el password del usuario correspondiante al Email, con la contraseña ingresada en form:
                    if($usuario->comprobarPassword($usuariotmp->contrasena)){
                        session_start();
                        $_SESSION['id'] = $usuario->ID_Usuario;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //redireccionar
                        if($usuario->usuario == "admin"){
                            $_SESSION['admin'] = true;
                            header('Location: /admin');
                        }elseif($usuario->usuario == "cliente"){
                            header('Location: /dashboard');
                        }else{
                            User::setAlerta('error', 'Tu cuenta no está activada.');
                        }

                    }else{
                        User::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }else{
                User::setAlerta('error', 'Correo no registrado');
            }

        }

        if (isset($_GET['estado'])) {
            $estado = $_GET['estado'];
            if($estado == "registroExitoso"){
                User::setAlerta('success', 'Usuario registrado exitosamente');

                // Enviar correo de bienvenida
                $mailer = new MailController();
                $mailer->enviar();
            }
            if($estado == "e1"){
                User::setAlerta('success', 'Inicio de sesion requerido');
            }
        }

        $alertas = User::getAlertas();

        $router->render('Login', [
            'alertas' => $alertas
        ]);

    }

    public static function logout(){


        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Si no está iniciada, la iniciamos
        }

        $_SESSION = [];

        session_destroy();

        header('Location: /');
    }

    public static function crearCuenta(Router $router){

        if( $_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuariotmp = new User($_POST);
            $usuariotmp->usuario = 'inactivo'; // Establecer como inactivo por defecto
            $usuariotmp->hashearPassword(); // Hashear la contraseña antes de guardar
            $usuariotmp->generarCodigoActivacion(); // Generar código de 10 dígitos
        
            //Comprobamos que el correo no exista en otro usuario
            $usuario = User::where('email', $usuariotmp->email);
            
            if($usuario){
                //alerta, correo ya registrado.
                User::setAlerta('error', 'El correo ya está registrado anteriormente');
            }else{
                $resultado = $usuariotmp->guardar();

                if($resultado['resultado']){
                    // Enviar código de activación por correo
                    $emailEnviado = MailController::enviarCodigoActivacion(
                        $usuariotmp->email, 
                        $usuariotmp->nombre, 
                        $usuariotmp->codigo
                    );

                    if($emailEnviado){
                        // Redirigir a página de confirmación con el ID del usuario
                        header('Location: /confirmar-codigo?id=' . $resultado['id']);
                    }else{
                        User::setAlerta('error', 'Error al enviar el código de activación. Intenta nuevamente.');
                    }
                }else{
                    User::setAlerta('error', 'Error al crear la cuenta. Intenta nuevamente.');
                }
            }
        }else{

            if (isset($_GET['estado'])) {
                $estado = $_GET['estado'];
                if($estado == "error")
                User::setAlerta('error', 'El Correo ya ha registrado anteriormente');
            }

            $alertas = User::getAlertas();

            $router->render('CrearCuenta',[
                'alertas'=>$alertas
            ]);

        }
    }

    public static function confirmarCodigo(Router $router) {
        $usuario = null;
        
        // Obtener el usuario por ID si se proporciona
        if(isset($_GET['id'])) {
            $usuario = User::where('ID_Usuario', $_GET['id']);
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigoIngresado = $_POST['codigo'] ?? '';
            $usuarioId = $_POST['usuario_id'] ?? '';
            
            if($usuarioId) {
                $usuario = User::where('ID_Usuario', $usuarioId);
                
                if($usuario && $usuario->codigo && $usuario->codigo === $codigoIngresado) {
                    // Código correcto - activar usuario
                    $usuario->usuario = 'cliente';
                    $usuario->codigo = null;
                    $resultadoActualizacion = $usuario->guardar();
                    
                    if($resultadoActualizacion) {
                        // Crear registro en tabla clientes
                        $datosCliente = [
                            'ID_Cliente' => '',
                            'ID_Usuario' => $usuario->ID_Usuario,
                            'direccion' => 'Por definir'
                        ];
                        $clientetmp = new Cliente($datosCliente);
                        $clientetmp->guardar();
                        
                        User::setAlerta('success', '¡Cuenta activada exitosamente! Ya puedes iniciar sesión.');
                        header('Location: /login');
                        return;
                    } else {
                        User::setAlerta('error', 'Error al activar la cuenta. Intenta nuevamente.');
                    }
                } else {
                    User::setAlerta('error', 'Código incorrecto. Verifica e intenta nuevamente.');
                }
            } else {
                User::setAlerta('error', 'Sesión inválida. Intenta registrarte nuevamente.');
            }
        }

        $alertas = User::getAlertas();
        
        $router->render('ConfirmarCodigo', [
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }
}