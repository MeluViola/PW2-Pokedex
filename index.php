<?php
global $conexion;
session_start();
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : null;

?>


<!-- Formulario de login -->
<form method="POST" action="scripts/procesarLogin.php">
    <label for="correo">Correo:</label>
    <input type="text" name="correo" required>

    <label for="contraseña">Contraseña:</label>
    <input type="password" name="contraseña" required>

    <button type="submit">Iniciar sesión</button>
</form>


<?php
$tipos = [
    1 => "Agua", 2 => "Fuego", 3 => "Planta", 4 => "Acero", 5 => "Volador",
    6 => "Hielo", 7 => "Bicho", 8 => "Electrico", 9 => "Normal", 10 => "Roca",
    11 => "Tierra", 12 => "Lucha", 13 => "Hada", 14 => "Psiquico", 15 => "Veneno",
    16 => "Dragon", 17 => "Fantasma", 18 => "Siniestro"
];
?>


<?php
//Prueba para ver si la logica funciona, despues se borra
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipoSeleccionado = $_POST['tipo'] ?? '';
    $nombrePokemon = $_POST['nombre'] ?? '';

    // Imprimir los valores recibidos para depuración
    echo "Tipo seleccionado: " . htmlspecialchars($tipoSeleccionado) . "<br>";
    echo "Nombre Pokémon: " . htmlspecialchars($nombrePokemon) . "<br>";
}

?>

<div class="container">
    <!--PRUEBA PARA BUSCAR-->
    <br>
    <?php
    if(isset($usuario)) {
        echo "<h2 style='font-size: 40px'>¡Bienvenido, $usuario!</h2>";
    } else {
        echo "<h2 style='font-size: 40px'>¡Bienvenido!</h2>";
    }
    ?>
    <br>

    <form class="form-inline mb-3" method="post" action="">
        <h5 style="font-weight: bolder">Busqueda de Pokemones:</h5>
        <div class="d-flex align-items-center">
            <div class="form-group mb-2">
                <select class="form-control" name="tipo" id="tipo">
                    <option value="" selected>Todos</option>
                    <?php
                    foreach ($tipos as $numeroReferencia => $tipo) {
                        echo '<option value="' . $numeroReferencia . '">' . ucfirst($tipo) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mx-sm-3 mb-2"> <!-- Cambiado a mx-sm-3 para más espacio horizontal -->
                <input type="text" class="busqueda" name="nombre" id="nombre" placeholder="Ingrese ID o nombre del Pokemon">
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary ml-2" style="margin-left: 10px">Filtrar</button>
            </div>

            <div class="form-group mb-2"> <!-- Añadido un contenedor form-group para el botón Nuevo Pokémon -->
                <?php
                if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                    echo '<button class="btn btn-danger pokemon-nuevo-btn" type="button" data-bs-toggle="modal" data-bs-target="#nuevoPokemonModal">Nuevo Pokemon<i class="bi bi-plus" style="margin-left: 5px"></i></button>';
                }
                ?>
            </div>

        </div>

    </form>
