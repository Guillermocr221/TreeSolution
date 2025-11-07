<?php

namespace Model;
// use Model\ActiveRecord;

class User extends ActiveRecord {

    protected static $tabla = "usuarios" ;
    protected static $columnasDB = ['ID_Usuario', 'nombre','apellido','dni','telefono', 'email','contrasena', 'usuario','imagen','codigo','estado'] ;

    //Nombre de id necesario para las incerciones
    protected static $nombreDeId = 'ID_Usuario';

    //variable id provisional en caso no se requiera usar un nombre especifico de id
    public $id;

    //usuario = tipo de usuario.
    public $ID_Usuario, $nombre, $apellido, $dni, $email, $telefono, $contrasena, $usuario, $imagen, $codigo, $estado;

    public function __construct($args = []) {
        $this->ID_Usuario = $args['ID_Usuario'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->dni = $args['dni'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->contrasena = $args['contrasena'] ?? '';
        $this->usuario = $args['usuario'] ?? 'inactivo';
        $this->imagen = $args['imagen'] ?? 'user_generico.png';
        $this->codigo = $args['codigo'] ?? null;
        $this->estado = $args['estado'] ?? 'activo';
    }

    /**
     * Hashea la contraseña antes de guardar
     */
    public function hashearPassword() {
        $this->contrasena = password_hash($this->contrasena, PASSWORD_DEFAULT);
    }

    public function comprobarPassword( $passwordtmp){
        $resultado = password_verify($passwordtmp, $this->contrasena);
        return $resultado;
    }

    /**
     * Genera un código de activación de 10 dígitos
     */
    public function generarCodigoActivacion() {
        $this->codigo = str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        return $this->codigo;
    }

}