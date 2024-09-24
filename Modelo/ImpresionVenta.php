<?php 

namespace Model;


class ImpresionVenta extends ActiveRecord{
    protected static $tabla = 'ventas';

    protected static $columnasDB = ['ID_Venta', 'cliente','nombre','cantidad','precio_Unitario', 'subtotal', 'total'] ;

    //Nombre de id Primary Key necesario para las incerciones
    protected $nombreDeId = 'ID_Venta';

    //variable id provisional en caso no se requiera usar un nombre especifico de id
    public $id;

    public $ID_Venta, $cliente,$nombre, $cantidad, $precio_Unitario, $subtotal, $total;
    
    public function __construct($args = []) {
        $this->ID_Venta = $args['ID_Venta'] ?? null;
        $this->cliente = $args['cliente'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->precio_Unitario = $args['precio_Unitario'] ?? null;
        $this->subtotal = $args['subtotal'] ?? null;
        $this->total = $args['total'] ?? null;
    }
}