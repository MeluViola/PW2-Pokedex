<?php
global $conexion;
session_start();
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : null;

include_once("includes/header.php");
include_once("includes/search-bar.php");
?>
<?php

// Carga la configuración de conexión a la base de datos
$configFilePath = __DIR__ . '/config.ini';
if (file_exists($configFilePath)) {
    $config = parse_ini_file($configFilePath);

    $servername = $config['servername'] ?? null;
    $db = $config['db'] ?? null;
    $user = $config['user'] ?? null;
    $pass = $config['pass'] ?? null;

    // Verificar si los valores están bien cargados
    if (!$servername || !$db || !$user || !$pass) {
        die("Error: No se pudieron cargar correctamente los datos de configuración.<br>");
    }
} else {
    die("Error: No se encontró el archivo de configuración en la ruta especificada.<br>");
}

// Conectar a la base de datos
$conexion = mysqli_connect($servername, $user, $pass, $db);

$usuario = "Entrenador/a";


?>


<?php
$tipos = [
    1 => "Agua", 2 => "Fuego", 3 => "Planta", 4 => "Acero", 5 => "Volador",
    6 => "Hielo", 7 => "Bicho", 8 => "Electrico", 9 => "Normal", 10 => "Roca",
    11 => "Tierra", 12 => "Lucha", 13 => "Hada", 14 => "Psiquico", 15 => "Veneno",
    16 => "Dragon", 17 => "Fantasma", 18 => "Siniestro"
];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pokedex - Inicio</title>
    <link rel="stylesheet" type="text/css" href="/PW2-Pokedex/CSS/estilosDetalles.css">
    <link href="/PW2-Pokedex/assets/logo.png" rel="icon">

    <!--Estilos con bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <!--PRUEBA PARA BUSCAR-->
    <br>

    <?php
    // Obtenemos la URL para ver si se agrego un pokemon
    $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $partes = parse_url($url);

    if(isset($partes['query'])) {
        parse_str($partes['query'], $query);

        // Si la URL dice "agregado", entonces venimos de agregar un pokemons y mostramos un mensaje
        if(isset($query['agregado'])) {
            echo "<p style='font-size: 50px'>¡Pokémon añadido correctamente!</p>";
        }
    }


    if(isset($usuario)) {
        echo "<h2 style='font-size: 40px'>¡Bienvenido, $usuario!</h2>";
    } else {
        echo "<h2 style='font-size: 40px'>¡Bienvenido!</h2>";
    }
    ?>
    <br>
    <!------------------------------PRUEBA DE ACCESOS A BDD-->
    <?php

    // FORMULARIO ENVIADO BOTON DE FILTRAR.
    include("scripts/database.php"); // Incluye el archivo de conexión a la base de datos

    // Variable para almacenar la consulta SQL
    $sql = "SELECT * FROM pokemon ORDER BY id ASC";

    // Verifica si se ha enviado el formulario de filtrado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Procesa los datos del formulario de filtrado
        $tipo = $_POST["tipo"];
        $nombre = $_POST["nombre"];

        if ($tipo !== "" && $tipo !== "todos") {
            $sql = "SELECT * FROM pokemon WHERE tipo_id = '$tipo' OR tipo2_id = '$tipo' ORDER BY id ASC";
        } else {
            $sql = "SELECT * FROM pokemon ORDER BY id ASC"; // Mostrar todos los Pokémon
        }

        // Si se ingresó un nombre o un ID
        if (!empty($nombre)) {
            // Verifica si el valor ingresado es un número
            if (is_numeric($nombre)) {
                // Si es un número, busca por ID
                $sql = "SELECT * FROM pokemon WHERE id = '$nombre' ORDER BY id ASC"; // Asegúrate de incluir $nombre entre comillas simples
            } else {
                // Si no es un número, busca por nombre
                $sql = "SELECT * FROM pokemon WHERE nombre LIKE '%$nombre%' ORDER BY id ASC";
            }
        }

        // Si se seleccionó un tipo y se ingresó un nombre
        if (!empty($tipo) && !empty($nombre)) {
            $sql = "SELECT * FROM pokemon WHERE tipo_id = '$tipo' AND nombre LIKE '%$nombre%' ORDER BY id ASC";
        }
    }
    $result = $conexion->query($sql);
    ?>
<div class="container">
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
        function obtenerNombreTipo($tipo_id, $conexion) {
            // Consulta SQL para obtener el nombre del tipo
            $sql = "SELECT nombre FROM tipo_pokemon WHERE id = '$tipo_id'";

            // Ejecutar la consulta
            $result = mysqli_query($conexion, $sql);

            // Verificar si se obtuvieron resultados
            if ($result) {
                // Obtener el nombre del tipo desde el resultado
                $row = mysqli_fetch_assoc($result);
                return $row["nombre"];
            } else {
                // Si la consulta falla, devolver un mensaje de error
                return "Error al obtener el nombre del tipo";
            }
        }
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-3 mb-4">';
            echo '<div class="card text-center">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title" style="font-weight: bolder">' . $row["nombre"] . '</h5>';
            echo "<a href=\"scripts/detallePokemon.php?unique_id={$row['unique_id']}\"><img src=\"data:image/jpeg;base64," . base64_encode($row["imagen"]) . "\" class=\"imagen-pokemon mx-auto\" alt=\"" . $row["nombre"] . "\"></a>";
            echo '<p class="card-text">Nro: ' . $row["id"] . '</p>';

            if (!empty($row["tipo2_id"])) {
                $tipo1_imagen = 'assets/tipos/' . strtolower($row["tipo_id"]) . '.webp';
                $tipo2_imagen = 'assets/tipos/' . strtolower($row["tipo2_id"]) . '.webp';

                // Obtener el nombre del tipo 1
                $tipo1_nombre = obtenerNombreTipo($row["tipo_id"], $conexion);

                // Obtener el nombre del tipo 2
                $tipo2_nombre = obtenerNombreTipo($row["tipo2_id"], $conexion);

                echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $tipo1_nombre . '" title="' . $tipo1_nombre . '">';
                echo '<img class="m-1 imagen-tipo" src="' . $tipo2_imagen . '" alt="' . $tipo2_nombre . '" title="' . $tipo2_nombre . '">';
            } else {
                $tipo1_imagen = 'assets/tipos/' . strtolower($row["tipo_id"]) . '.webp';

                // Obtener el nombre del tipo 1
                $tipo1_nombre = obtenerNombreTipo($row["tipo_id"], $conexion);

                echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $tipo1_nombre . '" title="' . $tipo1_nombre . '">';
            }

            // Función para obtener el nombre del tipo a partir de su ID
            if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                echo '<div class="d-flex justify-content-center m-2">';
                echo '<form class="m-1" method="post" action="scripts/editarPokemon.php?unique_id=' . $row["unique_id"] . '">';
                echo '<button type="submit" class="btn btn-primary"><i class="bi bi-pencil">Editar</i></button>';
                echo '</form>';

                echo '<form class="m-1" method="post" action="scripts/borrarPokemon.php?unique_id=' . $row["unique_id"] . '">';
                echo '<button type="submit" class="btn btn-danger"><i class="bi bi-trash">Borrar</i></button>';
                echo '</form>';
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No se encontró ningun Pokémon.";
    }

    ?>

</div>
</div>
</div>
<?php require_once 'includes/footer.php';   ?>
</body>
</html>



