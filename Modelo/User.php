<?php

namespace Model;
// use Model\ActiveRecord;

class User extends ActiveRecord {

    protected static $tabla = "usuarios" ;
    protected static $columnasDB = ['ID_Usuario', 'nombre','apellido','dni','telefono', 'email','contrasena', 'usuario','imagen'] ;

    //Nombre de id necesario para las incerciones
    protected $nombreDeId = 'ID_Usuario';

    //variable id provisional en caso no se requiera usar un nombre especifico de id
    public $id;

    //usuario = tipo de usuario.
    public $ID_Usuario, $nombre, $apellido, $dni, $email, $telefono, $contrasena, $usuario, $imagen;

    public function __construct($args = []) {
        $this->ID_Usuario = $args['ID_Usuario'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->dni = $args['dni'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->contrasena = $args['contrasena'] ?? '';
        $this->usuario = $args['usuario'] ?? 'cliente';
        $this->imagen = $args['imagen'] ?? 'user_generico.png';
    }

    public function comprobarPassword( $passwordtmp){
        // $resultado  = password_verify( $passwordtmp, $this->password);

        if($this->contrasena == $passwordtmp){
            
            return true;
        }else{
            return false;
        }
    }

    

}