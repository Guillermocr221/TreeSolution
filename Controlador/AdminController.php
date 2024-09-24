<?php
namespace Controllers;
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
            debuguear('NO HAY LOGIN DETECTADO');
        }
        // debuguear($_SESSION);

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



}