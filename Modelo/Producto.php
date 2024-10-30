<?php

namespace Model;

class Producto extends ActiveRecord{

    protected static $tabla = 'productos';
    protected static $columnasDB = ['ID_Producto', 'nombre','descripcion','precio','imagen', 'categoria', 'stock','estado'] ;

    //Nombre de id necesario para las incerciones
    protected $nombreDeId = 'ID_Producto';
    public $id ;

    public $ID_Producto, $nombre, $descripcion, $precio, $imagen, $categoria, $stock, $estado;

    public function __construct($args = []) {
        $this->ID_Producto = $args['ID_Producto'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'productUndefined.png';
        $this->categoria = $args['categoria'] ?? '1';
        $this->stock = $args['stock'] ?? 0;
        $this->estado = 'habilitado';
    }

    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE ID_PRODUCTO = '" . self::$db->escape_string($this->ID_Producto) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function reducirStock($id, $cantidad){
       
        $producto = self::where('ID_Producto', $id);
        $stockActual = (int) $producto->stock;

        $stockNuevo = $stockActual - $cantidad;

        $query = "UPDATE productos SET stock='$stockNuevo' WHERE ID_Producto = $id" ;

        self::SQL($query);
    }
}    
 