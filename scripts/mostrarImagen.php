<?php
global $conexion;
session_start();

include("database.php");

// Obtener el ID del Pokémon desde la URL
if (isset($_GET['id'])) {
    $pokemonId = intval($_GET['id']);

    // Consulta para obtener la imagen como BLOB
    $query = "SELECT imagen FROM pokemon WHERE unique_id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $pokemonId);
    $stmt->execute();
    $stmt->bind_result($imagenBinaria);
    $stmt->fetch();
    $stmt->close();

    if ($imagenBinaria) {
        header("Content-Type: image/png");
        echo $imagenBinaria;
    } else {
        echo "No se encontró la imagen.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
