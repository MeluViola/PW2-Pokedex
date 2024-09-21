<?php
// Incluye script de conexión
global $conexion;
include 'database.php';

// Prueba si la conexión fue exitosa
if ($conexion) {
    echo "Conexión exitosa a la base de datos";
} else {
    echo "Error en la conexión: " . mysqli_connect_error();
}

