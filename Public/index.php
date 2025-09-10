<?php

include __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Model\Producto;

use MVC\Router;
use Controllers\PaginasController;
use Controllers\LoginController;
use Controllers\AdminController;


$router = new Router();

// RUTAS DEL CLIENTE 
$router->get('/',[PaginasController::class, 'index']);
$router->get('/dashboard',[PaginasController::class, 'Dashboard2']);
$router->post('/dashboard',[PaginasController::class, 'Dashboard2']);

$router->get('/login',[LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->get('/registrarse',[LoginController::class, 'CrearCuenta']);
$router->post('/registrarse',[LoginController::class, 'CrearCuenta']);

$router->get('/admin', [AdminController::class, 'index']);
$router->post('/admin/registrarProducto',[AdminController::class, 'añadirProducto']);
$router->post('/admin/registrarAdmin',[AdminController::class, 'agregarAdmin']);
$router->post('/admin/modificarProducto',[AdminController::class, 'modificarProducto']);
$router->post('/admin/eliminarProducto',[AdminController::class, 'eliminarProducto']);
$router->post('/admin/habilitarProducto',[AdminController::class, 'habilitarProducto']);

// API 
$router->get('/api/productos',[APIController::class, 'index']);
$router->get('/api/categorias',[APIController::class, 'categorias']);

$router->post('/api/pedido', [APIController::class, 'crearPedido']);
$router->post('/api/borrarUsuario', [APIController::class, 'eliminarUsuario']);
$router->post('/api/activarUsuario', [APIController::class, 'activarUsuario']);

$router->post('/api/obtenerProducto', [APIController::class, 'obtenerProducto']);
$router->post('/api/eliminarProducto', [APIController::class, 'eliminarProducto']);
$router->post('/api/comprobarDisponibilidad', [APIController::class, 'comprobarDisponibilidad']);

// $router->get('/api/imprimirProducto',[AdminController::class, 'obtenerVentas']);

$router->comprobarRutas();