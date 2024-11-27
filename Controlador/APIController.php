<?php
namespace Controllers;

use Model\Producto;
use Model\Ventas;
use Model\Cliente;
use Model\Detalleventa;
use Model\User;
use Model\Categoria;


class APIController{

    public static function index(){
        header('Access-Control-Allow-Origin: *');
        $productos = Producto::all();
        echo json_encode($productos);
    }
    public static function card(){
        header('Access-Control-Allow-Origin: *');
        $codigoTarjeta = 1234956;
        echo json_encode($codigoTarjeta);
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

        $resultado = $venta->guardar();

        // *Guardar detalles del pedido
        $productosVenta = json_decode($_POST['productos'], true);

        foreach( $productosVenta as $producto){
            $ID_Venta = $resultado['id'];
            $ID_Producto = $producto['idproducto'];
            $cantidad = $producto['cantidad'];
            $precio_Unitario = $producto['precioUnitario'];
            $subtotal = $cantidad * $precio_Unitario;

            $args = [
                'ID_Venta'=> $ID_Venta, 
                'ID_Producto' => $ID_Producto, 
                'cantidad'=> $cantidad, 
                'precio_Unitario'=> $precio_Unitario, 
                'subtotal'=>$subtotal
            ];

            Producto::reducirStock($ID_Producto, $cantidad);
            $productoAventa = new Detalleventa($args);
            $productoAventa->guardar();
        }
        echo json_encode(['resultado' =>  $resultado]);

    }
    
    public static function eliminarUsuario(){
        $idUsuario = $_POST['id_usuario'];

        $query = "UPDATE usuarios SET usuario = 'inactivo' WHERE ID_Usuario = '$idUsuario' ";

        $usuario = User::SQL($query);

        header('Location: /admin');
    }

    public static function activarUsuario(){
        $idUsuario = $_POST['id_usuario'];

        $query = "UPDATE usuarios SET usuario = 'cliente' WHERE ID_Usuario = '$idUsuario' ";

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

}