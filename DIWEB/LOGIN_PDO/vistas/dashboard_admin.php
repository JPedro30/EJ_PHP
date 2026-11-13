<?php
session_start();
require_once("../connection/connection.php");

if (!isset($_SESSION['sesion_iniciada']) || $_SESSION['rol'] !== 'A') {
    header("Location: ../vistas/login.php");
    exit();
}

$email = $_SESSION['email'] ?? 'admin@ejemplo.com';
$nombre = $_SESSION['nombre'] ?? 'Administrador';
$imagen_usuario = $_SESSION['imagen_usuario'] ?? null;

$filtro_nombre = trim($_GET['nombre'] ?? '');
$filtro_comunidad = trim($_GET['comunidad'] ?? '');
$filtro_provincia = trim($_GET['provincia'] ?? '');
$filtro_municipio = trim($_GET['municipio'] ?? '');

$sql = "SELECT usuarios.email, usuarios.nombre, usuarios.primer_apellido, usuarios.segundo_apellido, 
               ccaa.Nombre AS ccaa_nombre, 
               provincias.Provincia AS provincia_nombre, 
               municipios.Municipio AS municipio_nombre 
        FROM usuarios 
        JOIN ccaa ON usuarios.idCCAA = ccaa.idCCAA 
        JOIN provincias ON usuarios.idProvincia = provincias.idProvincia 
        JOIN municipios ON usuarios.idMunicipio  = municipios.idMunicipio";

$params = [];
$sqlPlus = [];

if (!empty($filtro_nombre)) {
    $sqlPlus[] = "usuarios.nombre LIKE :nombre";
    $params[':nombre'] = '%' . $filtro_nombre . '%';
}

if (!empty($filtro_comunidad)) {
    $sqlPlus[] = "ccaa.Nombre LIKE :comunidad";
    $params[':comunidad'] = '%' . $filtro_comunidad . '%';
}

if (!empty($filtro_provincia)) {
    $sqlPlus[] = "provincias.Provincia LIKE :provincia";
    $params[':provincia'] = '%' . $filtro_provincia . '%';
}

if (!empty($filtro_municipio)) {
    $sqlPlus[] = "municipios.Municipio LIKE :municipio";
    $params[':municipio'] = '%' . $filtro_municipio . '%';
}

if (!empty($sqlPlus)) {
    $sql .= " WHERE " . implode(" AND ", $sqlPlus);
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Comic-Con Trebujena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../estilo/style.css">
</head>

<body class="bg-slate-200 min-h-screen text-slate-800 flex flex-col">

    <nav class="bg-slate-800 border-b border-slate-200 shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <?php if ($imagen_usuario && file_exists("../uploads/".$imagen_usuario)): ?>
                        <img src="<?= htmlspecialchars("../uploads/".$imagen_usuario) ?>" alt="PERFIL" class="w-9 h-9 rounded-full object-cover border border-slate-300">
                    <?php else: ?>
                        <img src="<?= htmlspecialchars("../uploads/default.jpg") ?>" alt="Perfil" class="w-9 h-9 rounded-full object-cover border border-slate-300">
                    <?php endif; ?>

                    <span class="text-sm font-semibold text-slate-200">
                        <?= htmlspecialchars($email) ?>
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <a href="../vistas/subirImagen.php" title="Ajustes" class="p-2 rounded-lg bg-slate-200 text-slate-500 hover:text-indigo-600 hover:bg-indigo-200 transition">
                        <img src="<?= htmlspecialchars("../uploads/ajustes.svg") ?>" alt="Configuracion" class="w-6 h-6">
                    </a>

                    <a href="../procesos/logout.php" title="Cerrar sesión" class="p-2 rounded-lg bg-slate-200 text-slate-500 hover:text-red-600 hover:bg-red-200 transition">
                        <img src="<?= htmlspecialchars("../uploads/cerrar_sesion.svg") ?>" alt="Cerrar Sesion" class="w-6 h-6">
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">

        <form action="dashboard_admin.php" method="GET" class="bg-white p-4 rounded-xl shadow-sm flex flex-wrap gap-4 items-center">
            <input type="text" name="nombre" value="<?= htmlspecialchars($filtro_nombre) ?>" placeholder="Nombre..." class="p-2 border rounded-lg text-sm">
            <input type="text" name="comunidad" value="<?= htmlspecialchars($filtro_comunidad) ?>" placeholder="Comunidad..." class="p-2 border rounded-lg text-sm">
            <input type="text" name="provincia" value="<?= htmlspecialchars($filtro_provincia) ?>" placeholder="Provincia..." class="p-2 border rounded-lg text-sm">
            <input type="text" name="municipio" value="<?= htmlspecialchars($filtro_municipio) ?>" placeholder="Municipio..." class="p-2 border rounded-lg text-sm">
            
            <button type="submit" class="ml-28 px-10 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">BUSCAR</button>
            <a href="dashboard_admin.php" class="px-10 py-2 bg-slate-400 text-white rounded-lg text-sm hover:bg-slate-500">BORRAR</a>
        </form>

        <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-800 text-slate-200">
                    <tr>
                        <th class="p-3">Email</th>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">1er Apellido</th>
                        <th class="p-3">2do Apellido</th>
                        <th class="p-3">CCAA</th>
                        <th class="p-3">Provincia</th>
                        <th class="p-3">Municipio</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr class="hover:bg-slate-50">
                                <td class="p-3"><?= htmlspecialchars($usuario['email']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($usuario['nombre']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($usuario['primer_apellido']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($usuario['segundo_apellido']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($usuario['ccaa_nombre']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($usuario['provincia_nombre']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($usuario['municipio_nombre']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-4 text-center text-slate-500">No se encontraron usuarios con esos criterios de búsqueda.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>