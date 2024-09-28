<?php
global $conexion;
include("database.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dataPokemon = $_POST["buscar"];

    $stmt = $conexion->prepare("SELECT * FROM pokemons WHERE id=? OR nombre = ? OR tipo = ?");
    $stmt->bind_param("sss", $dataPokemon,$dataPokemon,$dataPokemon);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            echo 'Pokemon n°'.$row["id"].", nombre :".$row["nombre"].", tipo:".$row["tipo"].".<br>";
        }
    } else {
        echo("No se encontró ningun Pokemon.");
    }
    $conexion->close();
}
