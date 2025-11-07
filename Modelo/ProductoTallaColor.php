<?php

namespace Model;

class ProductoTallaColor extends ActiveRecord{

    protected static $tabla = 'productos_tallas_colores';
    protected static $columnasDB = ['id_producto', 'id_talla', 'id_color', 'cantidad'];

    protected $nombreDeId = 'id_producto';
    public $id_producto, $id_talla, $id_color, $cantidad;

    public function __construct($args = []) {
        // $this->id = $args['id'] ?? null;
        $this->id_producto = $args['id_producto'] ?? null;
        $this->id_talla = $args['id_talla'] ?? null;
        $this->id_color = $args['id_color'] ?? null;
        $this->cantidad = $args['cantidad'] ?? 0;
    }

    // Obtener la cantidad disponible para una combinación específica
    public static function obtenerCantidadDisponible($id_producto, $id_talla = null, $id_color = null) {
        $query = "SELECT cantidad FROM " . static::$tabla . " WHERE id_producto = {$id_producto}";
        
        if ($id_talla) {
            $query .= " AND id_talla = {$id_talla}";
        }
        
        if ($id_color) {
            $query .= " AND id_color = {$id_color}";
        }
        
        $resultado = self::consultarSQL($query);
        return $resultado ? $resultado[0]->cantidad : 0;
    }

    // Obtener todas las combinaciones disponibles para un producto
    public static function obtenerCombinacionesPorProducto($id_producto) {
        $query = "SELECT ptc.*, t.nombre_talla, c.nombre_color 
                  FROM " . static::$tabla . " ptc
                  LEFT JOIN tallas t ON ptc.id_talla = t.id_talla
                  LEFT JOIN colores c ON ptc.id_color = c.id_color
                  WHERE ptc.id_producto = {$id_producto} AND ptc.cantidad > 0";
        
        return self::consultarSQL($query);
    }

    // Verificar disponibilidad para una combinación específica
    public static function verificarDisponibilidad($id_producto, $cantidad_solicitada, $id_talla = null, $id_color = null) {
        $cantidad_disponible = self::obtenerCantidadDisponible($id_producto, $id_talla, $id_color);
        return $cantidad_disponible >= $cantidad_solicitada;
    }
}