<?php
namespace Controllers;

use Model\User;
use MVC\Router;


class PaginasController{

    public static function index(Router $router){
        $router->render('index');
    }
    public static function dashboard(Router $router){
            $router->render('dashboard');
    }

    public static function dashboard2(Router $router){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // debuguear($_POST);

            $nombreNuevo = $_POST['nombre'];
            $apellidoNuevo = $_POST['apellido'];
            $dniNuevo = $_POST['dni'];
            $telefonoNuevo = $_POST['telefono'];

            session_start();
            $userId = $_SESSION['id'];

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        
                //Primero eliminar la imagen antigua
                $sql = "SELECT imagen FROM usuarios WHERE ID_Usuario = '$userId' ";
                $resultado = User::SQL($sql);
                $imagenAntigua = $resultado[0]->imagen;
                $uploadDir = __DIR__.'/../Public/imagenes/uploads/';


                if ($imagenAntigua && file_exists($uploadDir . $imagenAntigua)) {
                    unlink($uploadDir . $imagenAntigua); // Elimina el archivo del servidor
                }
                
                // Información del archivo subido
                $fileTmpPath = $_FILES['imagen']['tmp_name'];
                $fileName = $_FILES['imagen']['name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
        
                // Define las extensiones permitidas
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
                
                // Validar la extensión del archivo
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    

                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    // RenombreArchivo
                    $newFileName = 'fotoperfil_' . $userId. '.' . $fileExtension;
                    
                    // Ruta completa donde se guardará el archivo
                    $dest_path = $uploadDir . $newFileName;
                    
                    // Mueve el archivo a la carpeta especificada
                    move_uploaded_file($fileTmpPath, $dest_path); 

                    $query = "UPDATE usuarios SET imagen = '$newFileName' WHERE ID_Usuario = '$userId' " ;      
                    User::SQL($query);
                } 
            } 
            
            $query = "UPDATE usuarios SET nombre='$nombreNuevo',apellido='$apellidoNuevo',dni='$dniNuevo',telefono='$telefonoNuevo' 
                      WHERE ID_Usuario = '$userId' " ;
            User::SQL($query);

            header('Location: /dashboard?pa=1');

        }else{
            session_start();
            if($_SESSION['id']){
                $userId = $_SESSION['id'];
                $usuarioLogeado = User::where('ID_Usuario', $userId);
            }else{
                $usuarioLogeado = new User;
            }
            

            $router->render('Dashboard2',[
                'usuario' => $usuarioLogeado
            ]
            ); 
        }
    }
    public static function Login(Router $router){
        $router->render('Login');
    }
    public static function CrearCuenta(Router $router){
        $router->render('CrearCuenta');
    }
    public static function Admin(Router $router){
        $router->render('Dashboard_admin');
    }
}