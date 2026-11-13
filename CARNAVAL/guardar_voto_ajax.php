<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$id_usuario   = $_SESSION['id_usuario'];
$id_actuacion = $_POST['id_actuacion'] ?? null;
$voto         = $_POST['voto'] ?? null;

if ($id_actuacion && in_array($voto, ['verde', 'amarillo', 'rojo'])) {
    $sql = "
        INSERT INTO valoraciones (id_usuario, id_actuacion, voto)
        VALUES (:id_usuario, :id_actuacion, :voto)
        ON DUPLICATE KEY UPDATE voto = VALUES(voto)
    ";
    
    $stmt = $pdo->prepare($sql);
    $ok = $stmt->execute([
        'id_usuario'   => $id_usuario,
        'id_actuacion' => $id_actuacion,
        'voto'         => $voto
    ]);

    echo json_encode(['success' => $ok]);
    exit;
}

echo json_encode(['success' => false]);