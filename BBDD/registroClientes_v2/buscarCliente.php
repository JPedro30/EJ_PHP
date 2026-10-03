<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar cliente — Registro</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<body>
<?php
$buscado    = false;
$resultados = [];
$errores    = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validación
    $ap1 = trim($_POST['apellido_1'] ?? '');
    $ap2 = trim($_POST['apellido_2'] ?? '');

    if (empty($ap1) && empty($ap2)) {
        $errores[] = "Introduce al menos un apellido para buscar.";
    } else {
        require_once 'conexion.php';

        // Consulta preparada — sin inyección SQL
        $t1  = "%" . $ap1 . "%";
        $t2  = "%" . $ap2 . "%";
        $sql = "SELECT id_clientes, nombre, apellido_1, apellido_2
                FROM clientes
                WHERE apellido_1 LIKE ? OR apellido_2 LIKE ?";

        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $t1, $t2);
        mysqli_stmt_execute($stmt);
        $res  = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($res)) {
            $resultados[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
        $buscado = true;
    }
}

function val(string $campo): string {
    return htmlspecialchars($_POST[$campo] ?? '', ENT_QUOTES);
}
?>

    <div class="page-header">
        <h1>Registro de <span>Clientes</span></h1>
    </div>

    <div class="card">

        <?php if (!empty($errores)): ?>
            <div class="alert alert-error">
                <?php foreach ($errores as $e): ?>
                    <p><?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- ── Formulario de búsqueda (siempre visible) ────────── -->
        <form action="buscarCliente.php" method="post">

            <p class="section-label">Buscar por apellido</p>
            <div class="form-grid">
                <div class="form-group">
                    <label for="apellido_1">Primer apellido</label>
                    <input type="text" id="apellido_1" name="apellido_1"
                           placeholder="Ej: García"
                           value="<?= val('apellido_1') ?>">
                </div>
                <div class="form-group">
                    <label for="apellido_2">Segundo apellido</label>
                    <input type="text" id="apellido_2" name="apellido_2"
                           placeholder="Ej: López"
                           value="<?= val('apellido_2') ?>">
                </div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="paginaInicio.html" class="btn btn-ghost">Inicio</a>
            </div>

        </form>

        <!-- ── Resultados ───────────────────────────────────────── -->
        <?php if ($buscado): ?>
            <p class="section-label">
                <?= count($resultados) ?> resultado<?= count($resultados) !== 1 ? 's' : '' ?> encontrado<?= count($resultados) !== 1 ? 's' : '' ?>
            </p>

            <?php if (empty($resultados)): ?>
                <div class="alert alert-error">
                    No se encontró ningún cliente con esos apellidos.
                </div>
            <?php else: ?>
                <div class="result-list">
                    <?php foreach ($resultados as $reg): ?>
                        <div class="result-item">
                            <div>
                                <div class="result-name">
                                    <?= htmlspecialchars($reg['nombre']) ?>
                                    <?= htmlspecialchars($reg['apellido_1']) ?>
                                    <?= htmlspecialchars($reg['apellido_2']) ?>
                                </div>
                                <div class="result-sub">ID #<?= (int)$reg['id_clientes'] ?></div>
                            </div>
                            <div class="result-actions">
                                <a href="modificarCliente.php?codigo=<?= (int)$reg['id_clientes'] ?>"
                                   class="btn-icon" title="Editar">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem">edit</span>
                                </a>
                                <a href="eliminarCliente.php?codigo=<?= (int)$reg['id_clientes'] ?>"
                                   class="btn-icon danger" title="Eliminar"
                                   onclick="return confirm('¿Seguro que quieres eliminar este cliente?')">
                                    <span class="material-symbols-outlined" style="font-size:1.1rem">delete</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

</body>
</html>
