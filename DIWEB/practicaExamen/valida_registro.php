<?php
session_start();
require_once("connection.php");

if (isset($rol)) {
    header("Location: dashboard.php");
    exit();
}

$usuario = trim($_POST['usuario'] ?? '');
$pass1 = $_POST['password'] ?? '';
$pass2 = $_POST['password_repetida'] ?? '';
$sexo = $_POST['sexo'] ?? '';
$ciudad = trim($_POST['ciudad'] ?? '');
$email = trim($_POST['email'] ?? '');
$dni = trim($_POST['dni'] ?? '');
$twitter = trim($_POST['twitter'] ?? '');

$patron_texto = '/^[a-zA-ZáéíóúÁÉÚÍÓçñÑ][a-zA-ZáéíóúÁÉÚÍÓçñÑªº\s]{4,19}$/';
$patron_dni = '/^\d{8}[AEIOUaeiuo]$/';
$patron_twitter = '/^@[a-zA-ZáéíóúÁÉÚÍÓñÑ]{4,19}$/';

$errores = [];

if ($pass1 !== $pass2 && !empty($pass1)) {
    $errores[] = "Las contraseñas no coinciden";
}

if (!preg_match($patron_texto, $usuario)) {
    $errores[] = "Usuario no coincide el patron";
}

if (empty($sexo)) {
    $errores[] = "Seleccione un sexo";
}

if (!preg_match($patron_texto, $ciudad)) {
    $errores[] = "Apellido no coincide el patron";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Email no coincide el patron";
}

if (!preg_match($patron_dni, $dni)) {
    $errores[] = "DNI no coincide el patron";
}

if (!preg_match($patron_twitter, $twitter)) {
    $errores[] = "Twitter no coincide el patron";
}

if (empty($errores)) {
    $password = password_hash($pass1, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (usuario, password, sexo, ciudad, dni, email, twitter) VALUES (:usuario, :password, :sexo, :ciudad, :dni, :email, :twitter)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario' => $usuario,
        ':password' => $password,
        ':sexo' => $sexo,
        ':ciudad' => $ciudad,
        ':dni' => $dni,
        ':email' => $email,
        ':twitter' => $twitter,
    ]);
    $_SESSION['msg'] = "Usuario registrado correctamente";
} else {
    $_SESSION['msg'] = implode(", ", $errores);
}

header("Location: registro.php");
exit();
