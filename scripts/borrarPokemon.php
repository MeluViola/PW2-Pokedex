<?php
global $conexion;
session_start();
include("database.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];

    $stmt = $conexion->prepare("DELETE FROM pokemon WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ../index.php");
}
?>