<?php

$host = 'localhost';
$db = 'usuarioscomic';
$user = 'root';
$pass = '';

$opciones = [

    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Fundamental para usar Try-Catch en las consultas
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Arrays asociativos por defecto
    PDO::ATTR_EMULATE_PREPARES => false, // Seguridad máxima contra Inyección SQL

];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, $opciones);
} catch (PDOException $e) {
    // SI FALLA LA CONEXION, MATAMOS EL PROCESO Y MOSTRAMOS EL ERROR
    die("ERROR CRITICO DE CONEXION: ".$e->getMessage());
}


?>