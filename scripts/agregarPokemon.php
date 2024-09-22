<?php
global $conexion;
include("database.php");

session_start();
if(!isset($_SESSION["usuario"])){
    header("location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $numero_pokemon = $_POST['numero_pokemon'];
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $descripcion = $_POST["descripcion"];

    $imagen = $_FILES['imagen'];
    $ruta_imagen = 'images/' . basename($imagen['name']);
    move_uploaded_file($imagen['tmp_name'], $ruta_imagen);

    $stmt = $conexion->prepare("INSERT INTO pokemons (numero_identificador, nombre, tipo, descripcion, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('issss', $numero_pokemon, $nombre, $tipo, $descripcion, $ruta_imagen);
    $stmt->execute();

    echo "Pokémon añadido correctamente";
}
?>
