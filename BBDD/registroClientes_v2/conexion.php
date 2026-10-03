<?php
// Conexión centralizada — incluir con require_once 'conexion.php'
$conexion = mysqli_connect("localhost", "root", "", "registroclientes");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
