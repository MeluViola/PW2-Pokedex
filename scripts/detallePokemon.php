<?php
require_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../scripts/database.php';

// Obtener el ID del Pokémon desde la URL o una solicitud
$pokemonId = 1; // Puedes cambiar esto por la forma en que obtendrás el ID del Pokémon

// Consultar la base de datos para obtener los detalles del Pokémon
$query = "SELECT nombre, tipo, descripcion, imagen FROM pokemons WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $pokemonId);
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
    <link rel="stylesheet" href="/../CSS/estilos.css">
    <title>Detalle de <?php echo htmlspecialchars($pokemon['nombre']); ?></title>
</head>
<?php include __DIR__ . '/../includes/search-bar.php'; ?>
<body>

<div class="main-content">
    <div class="detalle-container">
        <h1><?php echo htmlspecialchars($pokemon['nombre']); ?></h1>
        <img src="img/<?php echo htmlspecialchars($pokemon['imagen']); ?>" alt="<?php echo htmlspecialchars($pokemon['nombre']); ?>" class="pokemon-img">
        <p><strong>Tipo:</strong> <?php echo htmlspecialchars($pokemon['tipo']); ?></p>
        <p><?php echo htmlspecialchars($pokemon['descripcion']); ?></p>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

</body>
</html>

