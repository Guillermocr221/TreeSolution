<?php

namespace Model;

class Talla extends ActiveRecord{

    protected static $tabla = 'tallas';
    protected static $columnasDB = ['id_talla', 'nombre_talla'];

    protected $nombreDeId = 'id_talla';
    public $id_talla, $nombre_talla;

    public function __construct($args = []) {
        $this->id_talla = $args['id_talla'] ?? null;
        $this->nombre_talla = $args['nombre_talla'] ?? '';
    }

    // Obtener todas las tallas disponibles para un producto específico
    public static function obtenerTallasPorProducto($id_producto) {
        $query = "SELECT DISTINCT t.id_talla, t.nombre_talla 
                  FROM tallas t 
                  INNER JOIN productos_tallas_colores ptc ON t.id_talla = ptc.id_talla 
                  WHERE ptc.id_producto = {$id_producto} AND ptc.cantidad > 0";
        
        return self::consultarSQL($query);
    }
}