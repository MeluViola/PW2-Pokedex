<?php
global $conexion;
session_start();
include_once __DIR__ . '/../scripts/database.php';
include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/search-bar.php';


// Obtener el ID del Pokémon desde la URL o una solicitud
$pokemonId = 1; // Puedes cambiar esto por la forma en que obtendrás el ID del Pokémon
//lo cambie para que tome el id del pokemon que selecciono en la pagina, sino toma solo el 1ero

// Consultar la base de datos para obtener los detalles del Pokémon
$pokemonSolicitado = $_GET["unique_id"];
$query = "SELECT * FROM pokemon WHERE unique_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $pokemonSolicitado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pokemon = $result->fetch_assoc();
} else {
    echo "No se encontró el Pokémon.";
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/PW2-Pokedex/CSS/estilosDetalles.css">
    <!--Estilos con bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Detalle de <?php echo htmlspecialchars($pokemon['nombre']); ?></title>
</head>

<body>



<div class="main-content">
    <div class="detalle-container">
        <h1><?php echo htmlspecialchars($pokemon['nombre']); ?></h1>
        <img src="<?php echo htmlspecialchars($pokemon['imagen']); ?>" alt="<?php echo htmlspecialchars($pokemon['nombre']); ?>" class="pokemon-img">
        <p>Tipo: <?php echo htmlspecialchars($pokemon['tipo_id']); ?></p>
        <p>Altura: <?php echo htmlspecialchars($pokemon["altura"]. ' mts' )?></p>
        <p>Peso: <?php echo htmlspecialchars($pokemon["peso"]. ' kg')?></p>
        <p><?php echo htmlspecialchars($pokemon['descripcion']); ?></p>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

</body>
</html>

