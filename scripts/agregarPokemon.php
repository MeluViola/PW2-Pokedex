<?php
global $conexion;
include("database.php");

session_start();
if(!isset($_SESSION["username"])){
    header("Location: procesarLogin.php");
    exit;
}


$tipos = [
    "agua"=>1 , "fuego" => 2, "planta"=>3, "acero" =>4, "volador"=>5,
    "hielo"=>6, "bicho"=>7, "electrico"=>8, "normal"=>9,
    "roca" =>10, "tierra"=>11, "lucha" =>12, "hada" =>13,
    "psiquico"=>14, "veneno"=>15, "dragon"=>16, "fantasma"=>17,
    "siniestro" =>18
];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = $_POST['identificador'];
    $nombre = $_POST["nombre"];
    $tipo_id = $tipos[$_POST["tipo"]];
    $descripcion = $_POST["descripcion"];
    $altura = $_POST["altura"];
    $peso = $_POST["peso"];

    $imagen_data = file_get_contents($_FILES["img"]["tmp_name"]);

    $stmt = $conexion->prepare("INSERT INTO pokemon (id, nombre, descripcion, imagen, altura, peso, tipo_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssdii', $id, $nombre, $descripcion, $imagen_data, $altura, $peso, $tipo_id);
    if ($stmt->execute()) {
        // Redirigir a la página de búsqueda después de agregar
        header("Location: ../index.php?agregado");
        exit();
    } else {
        echo "Error al agregar Pokémon: " . $stmt->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pokémon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-pokemon">
<div class="bg-blur">
    <div class="container pt-5">
        <form class="form-container" action="agregarPokemon.php" method="post" enctype="multipart/form-data">
            <h3 class="text-center">Crear Pokémon</h3>
            <div class="row">
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" required class="form-control" id="nombre"
                           placeholder="Ingrese el nombre de su pokemon" name="nombre">
                </div>
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" aria-label="Default select example" name="tipo" required>
                        <option value="">Selecciona el tipo</option>
                        <option value="fuego">Fuego</option>
                        <option value="agua">Agua</option>
                        <option value="planta">Planta</option>
                        <option value="acero">Acero</option>
                        <option value="volador">Volador</option>
                        <option value="hielo">Hielo</option>
                        <option value="bicho">Bicho</option>
                        <option value="electrico">Electrico</option>
                        <option value="normal">Normal</option>
                        <option value="roca">Roca</option>
                        <option value="tierra">Tierra</option>
                        <option value="lucha">Lucha</option>
                        <option value="hada">Hada</option>
                        <option value="psiquico">Psiquico</option>
                        <option value="veneno">Veneno</option>
                        <option value="dragon">Dragon</option>
                        <option value="fantasma">Fantasma</option>
                        <option value="siniestro">Siniestro</option>
                    </select>
                </div>
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="identificador" class="form-label">Identificador</label>
                    <input type="number" required class="form-control" id="identificador"
                           placeholder="Ingrese el identificador de su pokemon" name="identificador">
                </div>

                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="altura" class="form-label">Altura</label>
                    <input type="text" required class="form-control" id="altura"
                           placeholder="Ingrese la altura de su pokemon" name="altura">
                </div>

                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="peso" class="form-label">Peso</label>
                    <input type="text" required class="form-control" id="peso"
                           placeholder="Ingrese el peso de su pokemon" name="peso">
                </div>

                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="formFile" class="form-label">Foto de Pokemon</label>
                    <input class="form-control" type="file" id="img" name="img" required>
                </div>

                <div class="mb-3 col-sm-6 col-lg-6">
                    <label class="form-label" for="descripcion">Descripción</label>
                    <textarea class="form-control" placeholder="Ingrese una descripcion de su pokemon"
                              id="descripcion" style="height: 100px" name="descripcion" required></textarea>
                </div>

                <div class="d-flex justify-content-between space-between">
                    <img src="../assets/pikachu.gif" alt="" width="200" class="pokemonGif">

                    <div class="mb-3 col-12 col-sm-4 col-lg-4 pt-3">
                        <button type="submit" class="btn btn-primary w-100">Crear</button>
                        <a href="../index.php" class="btn btn-danger w-100 mt-3">Cancelar</a>
                    </div>
                    <img src="../assets/pikachu.gif" alt="" width="200" class="pokemonGif">
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>