<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="img/pokebola.png" alt="Logo Pokébola" />
    </div>
    <title>Pokedex</title>
    <h1 class="page-title">Pokedex</h1>
    <nav>
        <?php
        if (isset($_SESSION['username'])) {
            echo "<ul><li><span>ADMIN</span></li></ul>";      // Si el usuario está conectado, muestra "ADMIN"
        } else {                                              // Si no está conectado, muestra el formulario de login
            echo '<form method="POST" action="/Pokedex/scripts/procesarLogin.php">  
                    <ul>
                        <li>
                            <input type="text" name="correo" placeholder="Usuario" class="input-field" required />
                        </li>
                        <li>
                            <input type="password" name="contraseña" placeholder="Contraseña" class="input-field" required />
                        </li>
                        <li>
                            <button type="submit" class="login-button"> Ingresar </button>
                        </li>
                    </ul>
                  </form>';
        }
        ?>
    </nav>
</header>
</body>
</html>