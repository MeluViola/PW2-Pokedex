<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TP N° 2 - Pokedex/CSS/estilos.css">
</head>
<body>
<?php
$tipos = [
    1 => "Agua", 2 => "Fuego", 3 => "Planta", 4 => "Acero", 5 => "Volador",
    6 => "Hielo", 7 => "Bicho", 8 => "Electrico", 9 => "Normal", 10 => "Roca",
    11 => "Tierra", 12 => "Lucha", 13 => "Hada", 14 => "Psiquico", 15 => "Veneno",
    16 => "Dragon", 17 => "Fantasma", 18 => "Siniestro"
];
?>
<div class="search-bar">
<!--FILTRO-->
<form class="form-inline mb-3" method="post" action="">
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
            <input type="text" class="busqueda" name="nombre" id="nombre" placeholder="Ingrese nombre, tipo o número de Pokémon">
        </div>
        <div class="form-group mb-2">
            <button type="submit" class="btn btn-primary ml-2" style="margin-left: 10px"> ¿Quién es ese pokemon?</button>
        </div>
        <div class="form-group mb-2"> <!-- Añadido un contenedor form-group para el botón Nuevo Pokémon -->
            <?php
            if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                echo '<a href="scripts/agregarPokemon.php" class="btn btn-success">Nuevo Pokemon</a>';
            }
            ?>
        </div>


        </div>
</form>

</div>
</body>
</html>