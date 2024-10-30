<?php
namespace Controllers;

use Model\Cliente;
use MVC\Router;
use Model\Producto;
use Model\User;
use Model\Ventas;
use Model\ImpresionVenta;

class AdminController {

    public static function index(Router $router){

        session_start();

        
        if($_SESSION){
            // En caso haya una sesion activa
            $productos = Producto::all();
            $usuarios = User::all();
            $ventas  = self::obtenerVentas();

            if($_SESSION['admin'] == true){

                $router->render('Dashboard_admin', [
                    'productos' => $productos,
                    'usuarios' => $usuarios,
                    'ventas' => $ventas
                ]);     

            }else{
                header('Location: /dashboard');
            }
        }else{
            debuguear('INICIA SESION! 👻');
        }

    }

    public static function obtenerVentas(){

        // Consultar la base de datos
        $consulta = "SELECT ventas.ID_Venta, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= "productos.nombre, detalleventa.cantidad, detalleventa.precio_Unitario, detalleventa.subtotal, ventas.total ";
        $consulta .= "FROM ventas ";
        $consulta .= "INNER JOIN clientes ON ventas.ID_Cliente = clientes.ID_Cliente ";
        $consulta .= "INNER JOIN usuarios ON clientes.ID_Usuario = usuarios.ID_Usuario ";
        $consulta .= "INNER JOIN detalleventa ON detalleventa.ID_Venta = ventas.ID_Venta ";
        $consulta .= "INNER JOIN productos ON productos.ID_Producto = detalleventa.ID_Producto ";
        
        $ventas = ImpresionVenta::SQL($consulta);
        // echo json_encode($ventas);
        return $ventas;
    }   

    public static function añadirProducto(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // debuguear($_POST);
            $datosProducto = $_POST;

            $nuevoProducto = new Producto($datosProducto);
            
            $resultado = $nuevoProducto->guardar();
            $idProductoNuevo = $resultado['id'];
            

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        
                $uploadDir = __DIR__.'/../Public/imagenes/store/';
                
                // Información del archivo subido
                $fileTmpPath = $_FILES['imagen']['tmp_name'];
                $fileName = $_FILES['imagen']['name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
        
                // Define las extensiones permitidas
                $allowedfileExtensions = array('jpg', 'png', 'jpeg','webp');
                
                // Validar la extensión del archivo
                if (in_array($fileExtension, $allowedfileExtensions)) {

                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    
                    // RenombreArchivo
                    $newFileName = uniqid('imageProduct_'). '.' . $fileExtension;
                    
                    // Ruta completa donde se guardará el archivo
                    $dest_path = $uploadDir . $newFileName;
                    
                    // Mueve el archivo a la carpeta especificada
                    move_uploaded_file($fileTmpPath, $dest_path); 

                    $query = "UPDATE productos SET imagen = '$newFileName' WHERE ID_Producto = '$idProductoNuevo' " ;      
                    Producto::SQL($query);
                } 
            } 


            if($resultado){
                header('Location: /admin?estado=regProdExitoso');
            }
        }
    }

    public static function agregarAdmin(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $usuariotmp = new User($_POST);
            $usuariotmp->usuario = 'admin';
            //Comprobamos que el correo no exista en otro usuario
            $usuario = User::where('email', $usuariotmp->email);
            

            if($usuario){
                //alerta, correo ya registrado.
                header('Location: /admin?estado=correoExistente');
            }else{
                $resultado  = $usuariotmp->guardar();
                if($resultado){
                    header('Location: /admin?estado=regAdminExitoso');
                }
            }
        }
    }

    public static function modificarProducto(){
        
        //Objeto Producto con datos nuevos/modificados
        $producto = new Producto($_POST);
        $userId = $producto->ID_Producto;

        //obtener la imagen previa
        $producto_A_modificar = Producto::where('ID_Producto', $userId);
        //ruta de imagen previa
        $imagen_previa = $producto_A_modificar->imagen;
        
        
        //Si es que enviamos imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        
            $uploadDir = __DIR__.'/../Public/imagenes/store/';

            if ($imagen_previa && file_exists($uploadDir . $imagen_previa)) {
                if($imagen_previa !== "productUndefined.png"){
                    unlink($uploadDir . $imagen_previa); // Elimina el archivo del servidor
                }
            }
            
            // Información del nuevo archivo subido
            $fileTmpPath = $_FILES['imagen']['tmp_name'];
            $fileName = $_FILES['imagen']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            // Extensiones permitidas
            $allowedfileExtensions = array('jpg', 'webp', 'png', 'jpeg');
            
            // Validación de la extensión del archivo
            if (in_array($fileExtension, $allowedfileExtensions)) {

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // RenombreArchivo
                $newFileName = uniqid('imageProduct_'). '.' . $fileExtension;
                
                // Ruta completa donde se guardará el archivo
                $dest_path = $uploadDir . $newFileName;
                
                // Mueve el archivo a la carpeta especificada
                move_uploaded_file($fileTmpPath, $dest_path); 

                $producto->imagen = $newFileName ;            
            } 

        }else{
            $producto->imagen = $imagen_previa;
        } 
           
        $result = $producto->actualizar();

        if($result){
            header('Location: /admin?estado=modProdExitoso');
        }
    }

}