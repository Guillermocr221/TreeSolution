<?php
namespace Controllers;
use MVC\Router;


class PaginasController{

    public static function index(Router $router){
        $router->render('index');
    }
    public static function dashboard(Router $router){
        $router->render('dashboard');
    }
    public static function dashboard2(Router $router){
        $router->render('dashboard2');
    }
    public static function Login(Router $router){
        $router->render('Login');
    }
    public static function CrearCuenta(Router $router){
        $router->render('CrearCuenta');
    }
    public static function Admin(Router $router){
        $router->render('dashboard_admin');
    }
}