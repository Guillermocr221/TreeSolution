<?php
namespace Controllers;

use Model\Producto;
use Model\Ventas;
use Model\Cliente;
use Model\Detalleventa;
use Model\User;

class APIController{

    public static function index(){
        $productos = Producto::all();
        echo json_encode($productos);
    }

    public static function crearPedido(){
        session_start();

        //? $_POST = [ 'productos'=> [ {"nombre "=> ropa, "cantidad" => 2, "precioUnitario" => 22.5 }, ... ] , 
        //?            'total' = PrecioTotal
        //?          ];
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

        //*Guardar detalles del pedido
        $productosVenta = json_decode($_POST['productos'], true);
        // ? $productosVenta  = [ 
        // ?                     [ "nombre" => 'ropa' , "cantidad" => 3, "precioUnitario" => 22.5, "idproducto" = 1 ],
        // ?                     [ "nombre" => 'zapatos' , "cantidad" => 2, "precioUnitario" => 30, "idproducto" = 2 ] , ...]
        
        foreach( $productosVenta as $producto){
            $nombreProducto = $producto['nombre'];
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
            
            $productoAventa = new Detalleventa($args);
            $productoAventa->guardar();
        }


        echo json_encode(['resultado' => $resultado]);
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
}