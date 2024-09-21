<?php
$configFilePath = __DIR__ . '/../config.ini';
$config = parse_ini_file($configFilePath);

$servername = $config['servername'];
$db = $config['db'];
$user = $config['user'];
$pass = $config['pass'];

$conexion= mysqli_connect($servername, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}