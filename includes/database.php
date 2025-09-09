<?php

function conectarDb(): mysqli
{
    $db = new mysqli(
        "mysql-treesolutions.alwaysdata.net","377640","treesolutionsunmsm","treesolutions_db"
    );

    // "mysql-treesolutions.alwaysdata.net","377640","treesolutionsunmsm","treesolutions_db"
    // "localhost","root","root","treesolutiondb"
    $db->set_charset('utf8');

    if (!$db) {
        echo "Error: No se pudo conectar a MySQL.";
        echo "errno de depuración: " . mysqli_connect_errno();
        echo "error de depuración: " . mysqli_connect_error();
        exit;
    }

    return $db; 
}
