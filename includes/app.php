<?php 


use Model\Producto;
require __DIR__ . '/../vendor/autoload.php';

require 'funciones.php';
require 'database.php';

$db = conectarDb();

use Model\ActiveRecord;
ActiveRecord::setDB($db);

$producto = new Producto;

Producto::setDB($db);