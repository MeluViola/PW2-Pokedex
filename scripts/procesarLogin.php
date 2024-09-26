<?php
global $conexion;
include("database.php");

if(isset($_POST["correo"]) && isset($_POST["contraseña"])){

    $correo = $_POST["correo"];
    $contraseña = $_POST["contraseña"];

    $query = "SELECT * FROM usuarios WHERE correo = ? AND contraseña = ?";


    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ss", $correo,$contraseña);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();

    if ($resultado->num_rows > 0) {
        session_start();
        $fila = $resultado->fetch_assoc();
        $_SESSION["username"] = $fila["id"];
        header("Location: ../index.php");
        exit();
    } else {
        echo("Credenciales incorrectas");
    }
}

$conexion->close();