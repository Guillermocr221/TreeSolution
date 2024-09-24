<?php

namespace MVC;

class Router {

    public $rutasGET=[];
    public $rutasPOST=[];

    public function get($url, $fn){ //fn = funcion asociada a esa url
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas()
    {
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';

        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo == 'GET'){
            $fn = $this->rutasGET[$urlActual] ?? null;
        }else{
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        if($fn){ 
            // si existe la url y hay una funcion asociada
            call_user_func($fn, $this);

        }else{
            echo " Pagina no encontrada";
        }
    }

    // Muestra una vista
    public function render($view, $datos = []){

        
        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }
        
        ob_start(); //Almacena en memoria

        //?MODIFICAR RUTA CUANDO ESTE EL FRONTEND
        include __DIR__. "/Vista/$view.php";
        $contenido = ob_get_clean();// Almacena el view en $contenido y limpia la memoria
        
        echo $contenido;
        //include_once __DIR__ . '';
    }
}