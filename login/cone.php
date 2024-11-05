<?php
$host = "localhost";
$usuario = "root";
$password = "1344"; 
$database = "login";
$conexion = new mysqli($host, $usuario, $password, $database);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
