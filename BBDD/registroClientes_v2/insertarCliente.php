<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo cliente — Registro</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<?php

$errores  = [];
$insertado = false;

// ── Solo procesamos si se ha enviado el formulario ────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validaciones server-side
    if (empty($_POST['nombre']) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{1,50}$/", $_POST['nombre']))
        $errores[] = "El nombre no es válido.";

    if (empty($_POST['apellido_1']) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{1,50}$/", $_POST['apellido_1']))
        $errores[] = "El primer apellido no es válido.";

    if (empty($_POST['apellido_2']) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{1,50}$/", $_POST['apellido_2']))
        $errores[] = "El segundo apellido no es válido.";

    if (!in_array($_POST['sexo'] ?? '', ['H', 'M']))
        $errores[] = "El sexo seleccionado no es válido.";

    if (!filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL))
        $errores[] = "El correo electrónico no es válido.";

    if (empty($_POST['telefono']) || !preg_match("/^\d{9}$/", $_POST['telefono']))
        $errores[] = "El teléfono debe tener exactamente 9 dígitos.";

    if (empty($_POST['fecha_nacimiento']))
        $errores[] = "La fecha de nacimiento es obligatoria.";

    if (empty($_POST['dni']) || !preg_match("/^\d{8}[TRWAGMYFPDXBNJZSQVHLCKEtrwagmyfpdxbnjzsqvhlcke]$/", $_POST['dni']))
        $errores[] = "El DNI no tiene el formato correcto (ej: 12345678A).";

    if (empty($_POST['twitter']) || !preg_match("/^@[a-zA-Z]{1}[a-zA-Z0-9_]{3,14}$/", $_POST['twitter']))
        $errores[] = "La cuenta de Twitter no es válida (ej: @usuario).";

    if (empty($_POST['contraseña']))
        $errores[] = "La contraseña es obligatoria.";

    // Si no hay errores, insertamos
    if (empty($errores)) {
        require_once 'conexion.php';

        $password_hasheada = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

        $sql  = "INSERT INTO clientes
                    (nombre, apellido_1, apellido_2, sexo, direccion, correo, telefono,
                     fecha_nacimiento, poblacion, provincia, contraseña, dni, twitter)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssssssss",
                $_POST['nombre'], $_POST['apellido_1'], $_POST['apellido_2'],
                $_POST['sexo'], $_POST['direccion'], $_POST['email'],
                $_POST['telefono'], $_POST['fecha_nacimiento'],
                $_POST['poblacion'], $_POST['provincia'],
                $password_hasheada, $_POST['dni'], $_POST['twitter']
            );
            if (!mysqli_stmt_execute($stmt))
                $errores[] = "Error al guardar el cliente: " . mysqli_stmt_error($stmt);
            else
                $insertado = true;

            mysqli_stmt_close($stmt);
        } else {
            $errores[] = "Error al preparar la consulta: " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
    }
}

// Función auxiliar: devuelve el valor POST previo (para rellenar el form si hay error)
function val(string $campo): string {
    return htmlspecialchars($_POST[$campo] ?? '', ENT_QUOTES);
}
?>

    <div class="page-header">
        <h1>Registro de <span>Clientes</span></h1>
    </div>

    <div class="card">

        <?php if ($insertado): ?>
            <!-- ── Pantalla de éxito ──────────────────────────────── -->
            <span class="confirm-icon">✓</span>
            <p class="confirm-title">Cliente registrado correctamente</p>
            <p class="confirm-sub">Los datos se han guardado en la base de datos.</p>
            <div class="btn-row">
                <a href="insertarCliente.php" class="btn btn-primary">Añadir otro</a>
                <a href="paginaInicio.html"   class="btn btn-ghost">Inicio</a>
            </div>

        <?php else: ?>
            <!-- ── Formulario (vacío o con errores) ─────────────── -->

            <?php if (!empty($errores)): ?>
                <div class="alert alert-error">
                    <strong>Corrige los siguientes errores:</strong>
                    <ul>
                        <?php foreach ($errores as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="insertarCliente.php" method="post" novalidate>

                <p class="section-label">Datos personales</p>
                <div class="form-grid">

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre"
                               placeholder="Ej: María"
                               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]+"
                               value="<?= val('nombre') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="sexo">Sexo</label>
                        <select id="sexo" name="sexo" required>
                            <option value="H" <?= (val('sexo')==='H')?'selected':'' ?>>Hombre</option>
                            <option value="M" <?= (val('sexo')==='M')?'selected':'' ?>>Mujer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="apellido_1">Primer apellido</label>
                        <input type="text" id="apellido_1" name="apellido_1"
                               placeholder="Primer apellido"
                               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]+"
                               value="<?= val('apellido_1') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="apellido_2">Segundo apellido</label>
                        <input type="text" id="apellido_2" name="apellido_2"
                               placeholder="Segundo apellido"
                               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]+"
                               value="<?= val('apellido_2') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" id="dni" name="dni"
                               placeholder="12345678A"
                               pattern="\d{8}[TRWAGMYFPDXBNJZSQVHLCKEtrwagmyfpdxbnjzsqvhlcke]"
                               value="<?= val('dni') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                               value="<?= val('fecha_nacimiento') ?>" required>
                    </div>

                </div>

                <p class="section-label">Contacto</p>
                <div class="form-grid">

                    <div class="form-group full">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion"
                               placeholder="Calle, número..."
                               value="<?= val('direccion') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="poblacion">Población</label>
                        <input type="text" id="poblacion" name="poblacion"
                               placeholder="Población"
                               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]+"
                               value="<?= val('poblacion') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="provincia">Provincia</label>
                        <input type="text" id="provincia" name="provincia"
                               placeholder="Provincia"
                               pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ \-]+"
                               value="<?= val('provincia') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" name="email"
                               placeholder="ejemplo@correo.com"
                               value="<?= val('email') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono"
                               placeholder="600000000"
                               pattern="\d{9}"
                               value="<?= val('telefono') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input type="text" id="twitter" name="twitter"
                               placeholder="@usuario"
                               pattern="@[a-zA-Z]{1}[a-zA-Z0-9_]{3,14}"
                               value="<?= val('twitter') ?>" required>
                    </div>

                </div>

                <p class="section-label">Acceso</p>
                <div class="form-grid">
                    <div class="form-group full">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" id="contraseña" name="contraseña"
                               placeholder="Contraseña" required>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn btn-primary">Guardar cliente</button>
                    <a href="paginaInicio.html" class="btn btn-ghost">Cancelar</a>
                </div>

            </form>
        <?php endif; ?>

    </div>

</body>
</html>
