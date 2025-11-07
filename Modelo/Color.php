<?php

namespace Model;

class Color extends ActiveRecord{

    protected static $tabla = 'colores';
    protected static $columnasDB = ['id_color', 'nombre_color'];

    protected $nombreDeId = 'id_color';
    public $id_color, $nombre_color;

    public function __construct($args = []) {
        $this->id_color = $args['id_color'] ?? null;
        $this->nombre_color = $args['nombre_color'] ?? '';
    }

    // Obtener todos los colores disponibles para un producto específico
    public static function obtenerColoresPorProducto($id_producto) {
        $query = "SELECT DISTINCT c.id_color, c.nombre_color 
                  FROM colores c 
                  INNER JOIN productos_tallas_colores ptc ON c.id_color = ptc.id_color 
                  WHERE ptc.id_producto = {$id_producto} AND ptc.cantidad > 0";
        
        return self::consultarSQL($query);
    }
}