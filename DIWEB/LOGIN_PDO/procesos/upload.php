<?php
session_start();

require_once('../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_SESSION['id'];

    $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
    $nombre_nuevo = $id . "_" . time() . "." . $extension;
    $destino_nuevo = "../uploads/" . $nombre_nuevo;
    $nombre_temporal = $_FILES['imagen']['tmp_name'];
    $nombre_original = $_FILES['imagen']['name'];

    if (move_uploaded_file($nombre_temporal, $destino_nuevo)) {
        echo "El archivo " . htmlspecialchars($nombre_nuevo) . " se ha subido.";
        $sql =  "UPDATE usuarios SET imagen_usuario = :imagen WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':imagen' => $nombre_nuevo,
            ':email' => $_SESSION['email']
        ]);
        unlink("../uploads/".$_SESSION['imagen_usuario']);
        $_SESSION['imagen_usuario'] = $nombre_nuevo;
        header('Location: ../vistas/dashboard_cliente.php');
        exit();
    } else {
        $_SESSION['error'] = "Ha habido un error al subir la imagen...";
        header('Location: ../vistas/subirImagen.php');
        exit();
    }
}
