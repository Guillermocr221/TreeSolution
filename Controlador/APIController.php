<?php
namespace Controllers;

use Model\Producto;
use Model\Ventas;
use Model\Cliente;
use Model\Detalleventa;
use Model\User;
use Model\Categoria;
use Model\Color;
use Model\Talla;
use Model\ProductoTallaColor;

class APIController{

    public static function index(){
        header('Access-Control-Allow-Origin: *');
        $productos = Producto::all();
        echo json_encode($productos);
    }

    public static function categorias(){
        $categorias = Categoria::all();
        echo json_encode($categorias);
    }   

    public static function crearPedido(){
        session_start();
        // Para usar postman:
        // $json = file_get_contents('php://input');
        // $data = json_decode($json, true);
        // $productosVenta = $data['productos'];
        //$productosVenta = json_decode($data, true);

        $venta = new Ventas($_POST);

        if ( isset($_SESSION['id'])) {
            $idUsuario = $_SESSION['id'];
        } else {
            return;
        }
        $cliente = new Cliente();      
        $cliente = Cliente::where('ID_Usuario', (int) $idUsuario);

        // Verificar que el cliente exista
        if (!$cliente) {
            return;
        }
        $venta->ID_Cliente = (int) $cliente->ID_Cliente;
        
        // Establecer tipo de pago como Efectivo por defecto
        $venta->tipoPago = 'Efectivo';

        $resultado = $venta->guardar();

        // *Guardar detalles del pedido
        $productosVenta = json_decode($_POST['productos'], true);

        foreach( $productosVenta as $producto){
            $ID_Venta = $resultado['id'];
            $ID_Producto = $producto['idproducto'];
            $cantidad = $producto['cantidad'];
            $precio_Unitario = $producto['precioUnitario'];
            $subtotal = $cantidad * $precio_Unitario;
            
            // Obtener talla y color si están disponibles
            $id_talla = isset($producto['tallaId']) && $producto['tallaId'] !== '' ? $producto['tallaId'] : null;
            $id_color = isset($producto['colorId']) && $producto['colorId'] !== '' ? $producto['colorId'] : null;

            $args = [
                'ID_Venta'=> $ID_Venta, 
                'ID_Producto' => $ID_Producto, 
                'cantidad'=> $cantidad, 
                'precio_Unitario'=> $precio_Unitario, 
                'subtotal'=>$subtotal,
                'id_talla' => $id_talla,
                'id_color' => $id_color
            ];

            // Reducir stock específico o general
            if ($id_talla && $id_color) {
                // Reducir stock específico de la combinación talla/color
                $queryReducirStock = "UPDATE productos_tallas_colores 
                                    SET cantidad = cantidad - {$cantidad} 
                                    WHERE id_producto = {$ID_Producto} 
                                    AND id_talla = {$id_talla} 
                                    AND id_color = {$id_color}";
                ProductoTallaColor::SQL($queryReducirStock);
            } else {
                // Reducir stock general del producto
                Producto::reducirStock($ID_Producto, $cantidad);
            }
            
            $productoAventa = new Detalleventa($args);
            $productoAventa->guardar();
        }
        echo json_encode(['resultado' =>  $resultado]);

    }
    
    public static function eliminarUsuario(){
        $idUsuario = $_POST['id_usuario'];

        $query = "UPDATE usuarios SET estado = 'inactivo' WHERE ID_Usuario = '$idUsuario' ";

        $usuario = User::SQL($query);

        header('Location: /admin');
    }

    public static function activarUsuario(){
        $idUsuario = $_POST['id_usuario'];

        $query = "UPDATE usuarios SET estado = 'activo' WHERE ID_Usuario = '$idUsuario' ";

        $usuario = User::SQL($query);

        header('Location: /admin');
    }

    public static function agregarProducto(){
        $datosProducto = $_POST;

        $nuevoProducto = new Producto($_POST);

        debuguear($nuevoProducto);
    }

    public static function obtenerProducto(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_Producto = $_POST['id_Producto'];
            $producto = Producto::where('ID_Producto', $id_Producto);
            echo json_encode($producto);

        }
    }
    
    public static function eliminarProducto(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_Producto = $_POST['id_Producto'];

            $query = "UPDATE productos SET estado = 'deshabilitado' WHERE ID_Producto = '$id_Producto' " ;

            $resultado = Producto::SQL($query);

            if($resultado){
                header('Location: /admin?estado=eliminacionExitosa');
                
            }
            
            
        }
    }
    public static function comprobarDisponibilidad(){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_Producto = $_POST['idProducto'];
            $cantidadSolicitada = (int) $_POST['cantidadSolicitada'];

            $producto = Producto::where('ID_Producto', $id_Producto);
            $cantidadDisponible = (int) $producto->stock;


            // Verificar la cantidad disponible
            if($cantidadSolicitada > $cantidadDisponible){
                echo json_encode(['disponible' => false]);
            } else {
                echo json_encode(['disponible' => true]);
            }
        }
    }

    // Obtener colores disponibles para un producto
    public static function obtenerColoresProducto(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_producto = $_POST['id_producto'];
            $colores = Color::obtenerColoresPorProducto($id_producto);
            echo json_encode($colores);
        }
    }

    // Obtener tallas disponibles para un producto
    public static function obtenerTallasProducto(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_producto = $_POST['id_producto'];
            $tallas = Talla::obtenerTallasPorProducto($id_producto);
            echo json_encode($tallas);
        }
    }

    // Obtener todas las combinaciones disponibles para un producto
    public static function obtenerCombinacionesProducto(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_producto = $_POST['id_producto'];
            $combinaciones = ProductoTallaColor::obtenerCombinacionesPorProducto($id_producto);
            echo json_encode($combinaciones);
        }
    }

    // Verificar disponibilidad específica con talla y color
    public static function verificarDisponibilidadEspecifica(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_producto = $_POST['id_producto'];
            $cantidad_solicitada = (int) $_POST['cantidad_solicitada'];
            $id_talla = $_POST['id_talla'] ?? null;
            $id_color = $_POST['id_color'] ?? null;

            $disponible = ProductoTallaColor::verificarDisponibilidad(
                $id_producto, 
                $cantidad_solicitada, 
                $id_talla, 
                $id_color
            );

            echo json_encode(['disponible' => $disponible]);
        }
    }

    // Guardar combinaciones de producto (tallas, colores, cantidades)
    public static function guardarCombinacionesProducto(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_producto = $_POST['id_producto'];
            $combinaciones = json_decode($_POST['combinaciones'], true);

            // Primero eliminar combinaciones existentes del producto
            $queryEliminar = "DELETE FROM productos_tallas_colores WHERE id_producto = {$id_producto}";
            ProductoTallaColor::SQL($queryEliminar);

            $resultados = [];
            
            // Insertar nuevas combinaciones
            foreach($combinaciones as $combinacion){
                $nuevaCombinacion = new ProductoTallaColor([
                    'id_producto' => $id_producto,
                    'id_talla' => $combinacion['id_talla'],
                    'id_color' => $combinacion['id_color'],
                    'cantidad' => $combinacion['cantidad']
                ]);

                $resultado = $nuevaCombinacion->guardar();
                $resultados[] = $resultado;
            }

            echo json_encode(['success' => true, 'resultados' => $resultados]);
        }
    }

}