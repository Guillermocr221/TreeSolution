<?php

include __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Model\Producto;

use MVC\Router;
use Controllers\PaginasController;
use Controllers\LoginController;
use Controllers\AdminController;

//Metodo para obtener todos los productos de la db
// $productos = Producto::all();
// debuguear($productos) ; 

$router = new Router();

// RUTAS DEL CLIENTE 
$router->get('/',[PaginasController::class, 'index']);
$router->get('/dashboard',[PaginasController::class, 'Dashboard2']);

$router->get('/login',[LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->get('/admin', [AdminController::class, 'index']);
$router->get('/registrarse',[LoginController::class, 'CrearCuenta']);
$router->post('/registrarse',[LoginController::class, 'CrearCuenta']);


// API 
$router->get('/api/productos',[APIController::class, 'index']);
$router->post('/api/pedido', [APIController::class, 'crearPedido']);
$router->post('/api/borrarUsuario', [APIController::class, 'eliminarUsuario']);
$router->post('/api/activarUsuario', [APIController::class, 'activarUsuario']);

// $router->get('/api/imprimirProducto',[AdminController::class, 'obtenerVentas']);

$router->comprobarRutas();