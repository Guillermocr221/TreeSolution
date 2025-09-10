<?php

namespace Model;

class Categoria extends ActiveRecord {
    protected static $tabla = 'categoria';
    protected static $columnasDB = ['id', 'nombre'];
    
    //Nombre de id necesario para las incerciones
    protected $nombreDeId = 'id';

    public $id, $nombre;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }
}