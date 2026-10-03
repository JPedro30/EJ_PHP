<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente eliminado — Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<?php

// Validar que el código sea un entero positivo
if (!isset($_GET['codigo']) || !ctype_digit($_GET['codigo'])) {
    die("Identificador de cliente no válido.");
}

$codigo = (int) $_GET['codigo'];

require_once 'conexion.php';

// Consulta preparada — sin inyección SQL
$sql  = "DELETE FROM clientes WHERE id_clientes = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $codigo);

$ok = mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

    <div class="page-header">
        <h1>Registro de <span>Clientes</span></h1>
    </div>

    <div class="card">

        <?php if ($ok): ?>
            <span class="confirm-icon">🗑</span>
            <p class="confirm-title">Cliente eliminado</p>
            <p class="confirm-sub">El registro se ha borrado de la base de datos.</p>
        <?php else: ?>
            <div class="alert alert-error">
                No se pudo eliminar el cliente. Inténtalo de nuevo.
            </div>
        <?php endif; ?>

        <div class="btn-row">
            <a href="buscarCliente.php" class="btn btn-primary">Volver a búsqueda</a>
            <a href="paginaInicio.html" class="btn btn-ghost">Inicio</a>
        </div>

    </div>

</body>
</html>
