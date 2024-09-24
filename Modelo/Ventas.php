<?php

namespace Model;

class Ventas extends ActiveRecord{

    protected static $tabla = 'ventas';

    protected static $columnasDB = ['ID_Venta', 'ID_Cliente','ID_Empleado','fechaVenta','total', 'tipoPago'] ;

    //Nombre de id Primary Key necesario para las incerciones
    protected $nombreDeId = 'ID_Venta';

    //variable id provisional en caso no se requiera usar un nombre especifico de id
    public $id;

    public $ID_Venta, $ID_Cliente, $ID_Empleado, $total, $tipoPago;
    public $fechaVenta;
    
    public function __construct($args = []) {
        $this->ID_Venta = $args['ID_Venta'] ?? null;
        $this->ID_Cliente = $args['ID_Cliente'] ?? null;
        $this->ID_Empleado = $args['ID_Empleado'] ?? 1;
        $this->fechaVenta = $args['fechaVenta'] ?? '2024-07-01 15:30:00';
        $this->total = $args['total'] ?? null;
        $this->tipoPago = $args['tipoPago'] ?? 'tarjeta';
    }
    
}    
