<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/PW2-Pokedex/CSS/estilosGenerales.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="/PW2-Pokedex/assets/logo.png" alt="Logo Pokebola" />
    </div>
    <title>Pokedex</title>
    <a href="/PW2-Pokedex/index.php"><h1 class="page-title">Pokedex</h1></a>
    <nav>

        <div id="form-user">
        <!-- Formulario de login -->
        <?php
        if (isset($_SESSION['username'])) {
            echo "<ul>
                <li><span>ADMIN</span></li>
                <li><a href='scripts/procesarLogout.php' class='btn btn-danger'>Cerrar Sesión</a></li>
              </ul>"; // Muestra el menú para el usuario logueado
        } else {
            // Si no está conectado, muestra el formulario de login

            echo '<form method="POST" action="/PW2-Pokedex/scripts/procesarLogin.php">  
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
        </div>
    </nav>
</header>
</body>
</html>
