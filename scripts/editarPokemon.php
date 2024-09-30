<?php
global $conexion;
session_start();

include("database.php");
include_once __DIR__ . '/../includes/header.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["username"])) {
    header("Location: procesarLogin.php");
    exit;
}

// Obtener el unique_id del Pokémon a editar
if (!isset($_GET['unique_id'])) {
    echo "Error: No se ha especificado un Pokémon para editar.";
    exit;
}

// Asigna el unique_id a la variable correspondiente desde la URL.
$unique_id = $_GET['unique_id'];

// Cargar los datos del Pokémon actual desde la base de datos
$query = "SELECT * FROM pokemon WHERE unique_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $unique_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el Pokémon
if ($result->num_rows === 0) {
    echo "Error: No se encontró el Pokémon.";
    exit;
}

// Cargar los datos del Pokémon
$pokemon = $result->fetch_assoc();

// Tipos del Pokémon
$tipos = [
    "agua" => 1, "fuego" => 2, "planta" => 3, "acero" => 4, "volador" => 5,
    "hielo" => 6, "bicho" => 7, "electrico" => 8, "normal" => 9,
    "roca" => 10, "tierra" => 11, "lucha" => 12, "hada" => 13,
    "psiquico" => 14, "veneno" => 15, "dragon" => 16, "fantasma" => 17,
    "siniestro" => 18
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que todos los campos necesarios estén presentes en el formulario
    if (isset($_POST['unique_id']) && isset($_POST['nombre']) && isset($_POST['tipo']) &&
        isset($_POST['descripcion']) && isset($_POST['altura']) && isset($_POST['peso'])) {

        $unique_id = $_POST['unique_id'];
        $id = $_POST['identificador'];
        $nombre = $_POST["nombre"];
        $tipo_id = isset($tipos[$_POST["tipo"]]) ? $tipos[$_POST["tipo"]] : null;
        $descripcion = $_POST["descripcion"];
        $altura = $_POST["altura"];
        $peso = $_POST["peso"];

        // Verificar si se ha subido una nueva imagen
        if (!empty($_FILES["img"]["tmp_name"])) {
            $imagen_data = file_get_contents($_FILES["img"]["tmp_name"]);
            $stmt = $conexion->prepare("UPDATE pokemon SET nombre=?, id=?, descripcion=?, imagen=?, altura=?, peso=?, tipo_id=? WHERE unique_id=?");

            if ($stmt === false) {
                die("Error en la consulta: " . $conexion->error);
            }

            // Vincula los parámetros para la consulta
            $stmt->bind_param('sissdiii', $nombre, $id, $descripcion, $imagen_data, $altura, $peso, $tipo_id, $unique_id);
        } else {
            // Si no se ha subido una imagen, prepara la consulta sin la columna de imagen.
            $stmt = $conexion->prepare("UPDATE pokemon SET nombre=?, id=?, descripcion=?, altura=?, peso=?, tipo_id=? WHERE unique_id=?");

            if ($stmt === false) {
                die("Error en la consulta: " . $conexion->error);
            }
            // Vincula los parámetros para la consulta sin la imagen.
            $stmt->bind_param('sisdiii', $nombre, $id, $descripcion, $altura, $peso, $tipo_id, $unique_id);
        }

        if ($stmt->execute()) {
            echo "Pokémon actualizado correctamente.";
            // Redirigir a la página de inicio después de editar
            header("Location: ../index.php?editado");
             exit();
        } else {
            echo "Error al actualizar Pokémon: " . $stmt->error;
        }
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pokémon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-pokemon">
<div class="bg-blur">
    <div class="container pt-5">
        <form class="form-container" action="editarPokemon.php?unique_id=<?= $unique_id ?>" method="post" enctype="multipart/form-data">
            <h3 class="text-center">Editar Pokémon</h3>
            <div class="row">
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" required class="form-control" id="nombre" name="nombre" value="<?= $pokemon['nombre'] ?>">
                </div>
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" name="tipo" required>
                        <option value="">Selecciona el tipo</option>
                        <?php foreach ($tipos as $tipo => $id): ?>
                            <option value="<?= $tipo ?>" <?= ($id == $pokemon['tipo_id']) ? 'selected' : '' ?>><?= ucfirst($tipo) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="identificador" class="form-label">Identificador</label>
                    <input type="number" required class="form-control" id="identificador" name="identificador" value="<?= $pokemon['id'] ?>">
                </div>
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="altura" class="form-label">Altura</label>
                    <input type="text" required class="form-control" id="altura" name="altura" value="<?= $pokemon['altura'] ?>">
                </div>
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="peso" class="form-label">Peso</label>
                    <input type="text" required class="form-control" id="peso" name="peso" value="<?= $pokemon['peso'] ?>">
                </div>
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label for="formFile" class="form-label">Foto de Pokémon (opcional)</label>
                    <input class="form-control" type="file" id="img" name="img">
                </div>
                <div class="mb-3 col-sm-6 col-lg-6">
                    <label class="form-label" for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" style="height: 100px" name="descripcion" required><?= $pokemon['descripcion'] ?></textarea>
                </div>
                <input type="hidden"  id="unique_id" name="unique_id" value="<?= $pokemon['unique_id'] ?>">

                <div class="d-flex justify-content-between">
                    <img src="../assets/pikachu2.gif" alt="" width="200" class="pokemonGif">
                    <div class="mb-3 col-12 col-sm-4 col-lg-4 pt-3">
                        <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
                        <a href="../index.php" class="btn btn-danger w-100 mt-3">Cancelar</a>
                    </div>
                    <img src="../assets/pikachu2.gif" alt="" width="200" class="pokemonGif">
                </div>
            </div>
        </form>
    </div>
</div>
<?php
require_once __DIR__ . '/../includes/footer.php';
?>
</body>
</html>
