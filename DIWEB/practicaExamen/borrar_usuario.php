<?php
require_once("connection.php");

$id_usuario = $_GET['id_usuario'] ?? '';

$sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id_usuario' => $id_usuario
]);

header("Location: consultas.php");
exit();

?>