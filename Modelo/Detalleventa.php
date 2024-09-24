<?php

namespace Model;

class Detalleventa extends ActiveRecord{

    protected static $tabla = 'detalleventa';

    protected static $columnasDB = ['ID_DetalleVenta', 'ID_Venta','ID_Producto','cantidad','precio_Unitario', 'subtotal'] ;

    //Nombre de id Primary Key necesario para las incerciones
    protected $nombreDeId = 'ID_DetalleVenta';

    //variable id provisional en caso no se requiera usar un nombre especifico de id
    public $id;

    public $ID_DetalleVenta, $ID_Venta, $ID_Producto, $cantidad, $precio_Unitario, $subtotal;
    
    public function __construct($args = []) {
        $this->ID_DetalleVenta = $args['ID_DetalleVenta'] ?? null;
        $this->ID_Venta = $args['ID_Venta'] ?? null;
        $this->ID_Producto = $args['ID_Producto'] ?? 1;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->precio_Unitario = $args['precio_Unitario'] ?? null;
        $this->subtotal = $args['subtotal'] ?? null;
    }
    
}    
