<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TP N° 2 - Pokedex/CSS/estilos.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="/TP N° 2 - Pokedex/assets/logo.png" alt="Logo Pokebola" />
    </div>
    <title>Pokedex</title>
    <a href="/TP N° 2 - Pokedex/index.php"><h1 class="page-title"> Pokedex</h1></a>
    <nav>
        <!-- Formulario de login -->
        <form method="POST" action="scripts/procesarLogin.php">
            <label for="correo">Usuario:</label>
            <input type="text" name="usuario" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" required>

            <button type="submit">Iniciar sesión</button>
        </form>
    </nav>
</header>
</body>
</html>
