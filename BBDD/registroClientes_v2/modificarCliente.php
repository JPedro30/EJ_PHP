<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cliente — Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<?php

$errores    = [];
$modificado = false;

require_once 'conexion.php';

// ── Determinar el código del cliente ─────────────────────────────────────
// Si viene de un POST, usamos el campo oculto; si es GET (primera carga), la URL.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = isset($_POST['codigo']) && ctype_digit($_POST['codigo'])
              ? (int)$_POST['codigo'] : null;
} else {
    $codigo = isset($_GET['codigo']) && ctype_digit($_GET['codigo'])
              ? (int)$_GET['codigo'] : null;
}

if (!$codigo) {
    die("Identificador de cliente no válido.");
}

// ── Leer siempre de la BD los campos no editables ────────────────────────
$sqlLeer = "SELECT nombre, apellido_1, apellido_2, sexo, fecha_nacimiento, dni,
                   direccion, correo, telefono, poblacion, provincia
            FROM clientes WHERE id_clientes = ?";
$stmtLeer = mysqli_prepare($conexion, $sqlLeer);
mysqli_stmt_bind_param($stmtLeer, "i", $codigo);
mysqli_stmt_execute($stmtLeer);
$resLeer = mysqli_stmt_get_result($stmtLeer);

if (!$bd = mysqli_fetch_assoc($resLeer)) {
    die("Cliente no encontrado.");
}
mysqli_stmt_close($stmtLeer);

// ── Procesar el UPDATE solo si llega un POST ──────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['direccion']))
        $errores[] = "La dirección es obligatoria.";

    if (empty($_POST['correo']) || !filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL))
        $errores[] = "El correo electrónico no es válido.";

    if (empty($_POST['telefono']) || !preg_match("/^\d{9}$/", $_POST['telefono']))
        $errores[] = "El teléfono debe tener exactamente 9 dígitos.";

    if (empty($_POST['poblacion']))
        $errores[] = "La población es obligatoria.";

    if (empty($_POST['provincia']))
        $errores[] = "La provincia es obligatoria.";

    if (empty($_POST['contraseña']))
        $errores[] = "La contraseña es obligatoria.";

    if (empty($errores)) {

        // Los campos bloqueados siempre vienen de la BD ($bd), nunca del POST
        $password_hasheada = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

        $sqlUpd = "UPDATE clientes
                   SET nombre           = ?,
                       apellido_1       = ?,
                       apellido_2       = ?,
                       sexo             = ?,
                       direccion        = ?,
                       correo           = ?,
                       telefono         = ?,
                       fecha_nacimiento = ?,
                       poblacion        = ?,
                       provincia        = ?,
                       contraseña       = ?,
                       dni              = ?
                   WHERE id_clientes    = ?";

        $stmtUpd = mysqli_prepare($conexion, $sqlUpd);
        mysqli_stmt_bind_param($stmtUpd, "ssssssssssssi",
            $bd['nombre'], $bd['apellido_1'], $bd['apellido_2'], $bd['sexo'],
            $_POST['direccion'], $_POST['correo'], $_POST['telefono'],
            $bd['fecha_nacimiento'],
            $_POST['poblacion'], $_POST['provincia'],
            $password_hasheada, $bd['dni'],
            $codigo
        );

        if (!mysqli_stmt_execute($stmtUpd))
            $errores[] = "Error al actualizar: " . mysqli_stmt_error($stmtUpd);
        else
            $modificado = true;

        mysqli_stmt_close($stmtUpd);
    }

    // Actualizar $bd con los valores recién enviados para rellenar el form
    if (!empty($errores)) {
        $bd['direccion'] = $_POST['direccion'] ?? $bd['direccion'];
        $bd['correo']    = $_POST['correo']    ?? $bd['correo'];
        $bd['telefono']  = $_POST['telefono']  ?? $bd['telefono'];
        $bd['poblacion'] = $_POST['poblacion'] ?? $bd['poblacion'];
        $bd['provincia'] = $_POST['provincia'] ?? $bd['provincia'];
    }
}

mysqli_close($conexion);

// Helper
function esc(string $val): string {
    return htmlspecialchars($val, ENT_QUOTES);
}
?>

    <div class="page-header">
        <h1>Registro de <span>Clientes</span></h1>
    </div>

    <div class="card">

        <?php if ($modificado): ?>
            <!-- ── Pantalla de éxito ──────────────────────────────── -->
            <span class="confirm-icon">✓</span>
            <p class="confirm-title">Cliente actualizado correctamente</p>
            <p class="confirm-sub">Los cambios se han guardado en la base de datos.</p>
            <div class="btn-row">
                <a href="buscarCliente.php" class="btn btn-primary">Volver a búsqueda</a>
                <a href="paginaInicio.html" class="btn btn-ghost">Inicio</a>
            </div>

        <?php else: ?>
            <!-- ── Formulario de edición ─────────────────────────── -->

            <?php if (!empty($errores)): ?>
                <div class="alert alert-error">
                    <strong>Corrige los siguientes errores:</strong>
                    <ul>
                        <?php foreach ($errores as $e): ?>
                            <li><?= esc($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="modificarCliente.php" method="post">
                <input type="hidden" name="codigo" value="<?= $codigo ?>">

                <p class="section-label">Datos no editables</p>
                <div class="form-grid">

                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" value="<?= esc($bd['nombre']) ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Sexo</label>
                        <input type="text" value="<?= $bd['sexo'] === 'H' ? 'Hombre' : 'Mujer' ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Primer apellido</label>
                        <input type="text" value="<?= esc($bd['apellido_1']) ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Segundo apellido</label>
                        <input type="text" value="<?= esc($bd['apellido_2']) ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" value="<?= esc($bd['dni']) ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Fecha de nacimiento</label>
                        <input type="date" value="<?= esc($bd['fecha_nacimiento']) ?>" disabled>
                    </div>

                </div>

                <p class="section-label">Datos editables</p>
                <div class="form-grid">

                    <div class="form-group full">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion"
                               value="<?= esc($bd['direccion']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="poblacion">Población</label>
                        <input type="text" id="poblacion" name="poblacion"
                               value="<?= esc($bd['poblacion']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="provincia">Provincia</label>
                        <input type="text" id="provincia" name="provincia"
                               value="<?= esc($bd['provincia']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo electrónico</label>
                        <input type="email" id="correo" name="correo"
                               value="<?= esc($bd['correo']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono"
                               pattern="\d{9}"
                               value="<?= esc($bd['telefono']) ?>" required>
                    </div>

                </div>

                <p class="section-label">Nueva contraseña</p>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" id="contraseña" name="contraseña"
                               placeholder="Introduce la nueva contraseña" required>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <a href="buscarCliente.php" class="btn btn-ghost">Cancelar</a>
                </div>

            </form>
        <?php endif; ?>

    </div>

</body>
</html>
