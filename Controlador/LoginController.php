<?php 

namespace Controllers;
use MVC\Router;
use Model\User;
use Model\Cliente;

class LoginController{


    public static function login(Router $router){
        
        if( $_SERVER['REQUEST_METHOD'] === 'POST'){
            //creamos un objeto User con los datos enviados a trabes del formulario(post)
            $usuariotmp = new User($_POST);
            //buscamos un Usuario donde el email sea igaul al ingresado por form
            $usuario = User::where('email', $usuariotmp->email);

            if($usuario){
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
                        debuguear('ClienteBloqueado');
                    }

                }else{
                    User::setAlerta('error', 'Password Incorrecto');
                }
            }else{
                User::setAlerta('error', 'Correo no registrado');
            }

        }

        if (isset($_GET['estado'])) {
            $estado = $_GET['estado'];
            if($estado == "registroExitoso"){
                User::setAlerta('success', 'Usuario registrado exitosamente');
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
        
            //Comprobamos que el correo no exista en otro usuario
            $usuario = User::where('email', $usuariotmp->email);
            
            if($usuario){
                //alerta, correo ya registrado.
                header('Location: /registrarse?estado=error');
            }else{
                $resultado  = $usuariotmp->guardar();

                if($usuariotmp->usuario == 'cliente'){
                    $datosCliente = [
                        'ID_Cliente' => '',
                        'ID_Usuario' => $resultado['id'],
                        'direccion'=> 'casa'
                    ];
                    $clientetmp = new Cliente($datosCliente);
                    $resultado2 = $clientetmp->guardar();    
                    
                }


                if($resultado){
                    header('Location: /login?estado=registroExitoso');
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
}