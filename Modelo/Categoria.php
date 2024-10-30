<?php

namespace Model;

class Categoria extends ActiveRecord {
    protected static $tabla ='categoria';
    protected static $columnasDB  = ['id', 'nombre'];

    public $id, $nombre;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        
    }
}