<?php

namespace Model;

class Cliente extends ActiveRecord{

    protected static $tabla = "clientes";
    
    protected static $columnasDB = ['ID_Cliente', 'ID_Usuario','direccion'] ;

    //Nombre de id necesario para las incerciones
    protected $nombreDeId = 'ID_Cliente';

    //variable id provisional en caso no se requiera usar un nombre especifico de id
    public $id;

    //usuario = tipo de usuario.
    public $ID_Cliente, $ID_Usuario, $direccion;

    public function __construct($args = []) {
        $this->ID_Cliente = $args['ID_Cliente'] ?? null;
        $this->ID_Usuario = $args['ID_Usuario'] ?? null;
        $this->direccion = $args['direccion'] ?? null;
    }


}