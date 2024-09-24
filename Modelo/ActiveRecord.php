<?php
namespace Model;

class ActiveRecord{

    //Base de datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];


    //Definir conexion a la DB
    public static function setDB($database){
        self::$db = $database;
    }
    
    // alertas
    protected static $alertas = [];

    public static function setAlerta($tipo, $mensaje){
        static::$alertas[$tipo][] = $mensaje;
    }
    public static function getAlertas(){
        return static::$alertas;
    }


    public static function consultarSQL($query){
        //Consultar la base de datos
        $resultado = self::$db->query($query);
        
        //Iterar los resultados
        $array = [];

        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjeto($registro); 
        }
        

        //liberar memoria
        $resultado->free();

        //retornar los resultados
        return $array;
    }

    public static function ejecutarSQL($query) {
        // Ejecutar la consulta
        $resultado = self::$db->query($query);

        // Retornar true si la consulta fue exitosa
        return true;
    }
    
    // Funcion para convertir un arreglo asociativo en Objeto
    protected static function crearObjeto($registro){
        $objeto = new static; // crea nuevos objetos de la clase actual

        foreach($registro as $key => $value){
            // if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            // }
        }
        // debuguear($objeto);
        return $objeto;
    }


    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public function obtenerNombreId(){
        if( !isset($this->nombreDeId)){
            $this->id = 'id';
            return $this->id ;
        }else{
            return $this->nombreDeId;
        }
    }
    //!BUSCAR REGISTROS
    // Busca un registro por su id
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        
        return array_shift( $resultado ) ;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            $columnName = $this->obtenerNombreId();

            if($columna === $columnName ) continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Listar todos los resultados de la tabla
    public static function all(){
        $query = "SELECT * FROM ". static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

     // crea un nuevo registro
     public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // // Insertar en la base de datos
        // $query = " INSERT INTO " . static::$tabla . " ( ";
        // $query .= join(', ', array_keys($atributos));
        // $query .= " ) VALUES (' "; 
        // $query .= join("', '", array_values($atributos));
        // $query .= " ') ";
        
        //? Construir la consulta
        $columnas = join(', ', array_keys($atributos));
        $valores = [];
        foreach ($atributos as $key => $value) {
            // Si el valor es null, agregar NULL a la consulta
            if (is_null($value)) {
                $valores[] = "NULL";
            } else {
                $valores[] = "'{$value}'";
            }
        }
        $valores = join(', ', $valores);

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ({$columnas}) VALUES ({$valores})";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
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
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }


    // Consulta Plana de SQL 
    // public static function SQL($query) {
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }

    public static function SQL($query) {
        if (strpos(strtoupper($query), 'SELECT') !== false) {
            return self::consultarSQL($query);
        } else {
            return self::ejecutarSQL($query);
        }
    }
}    

