<?php
global $conexion;
session_start();
include("database.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Obtenemos la URL para ver si se agrego un pokemon
    $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $partes = parse_url($url);

    if(isset($partes['query'])) {
        parse_str($partes['query'], $query);

        // Si la URL dice "id", entonces tomamos la id del pokemon a borrar
        if(isset($query['unique_id'])) {
            echo "La unique_id del pokemon es: " . $query['unique_id'];
            $stmt = $conexion->prepare("DELETE FROM pokemon WHERE unique_id = ?");
            $stmt->bind_param("i", $query['unique_id']);
            $stmt->execute();

            header("Location: ../index.php");
        }
    }
}

echo "No se ha podido borrar el pokemon";

?>