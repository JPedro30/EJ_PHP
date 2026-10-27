<?php
session_start();

// Control de acceso: solo permite el rol de Cliente ('C')
if (!isset($_SESSION['sesion_iniciada']) || $_SESSION['rol'] !== 'C') {
    header("Location: ../vistas/login.php");
    exit();
}

// Datos de la sesión
$email = $_SESSION['email'] ?? 'cliente@ejemplo.com';
$nombre = $_SESSION['nombre'] ?? 'Cliente';
$imagen_usuario = $_SESSION['imagen_usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente - Comic-Con Trebujena</title>
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

                    <a href="../vistas/editarUsuarios" title="Configuracion" class="p-2 rounded-lg bg-slate-200 text-slate-500 hover:text-indigo-600 hover:bg-indigo-200 transition">
                        <img src="<?= htmlspecialchars("../uploads/configuracionAdmin.svg") ?>" alt="Configuracion" class="w-6 h-6">
                    </a>

                    <a href="../vistas/subirImagen.php" title="Ajustes" class="p-2 rounded-lg bg-slate-200 text-slate-500 hover:text-indigo-600 hover:bg-indigo-200 transition">
                        <img src="<?= htmlspecialchars("../uploads/ajustes.svg") ?>" alt="Ajustes" class="w-6 h-6">
                    </a>

                    <a href="../procesos/logout.php" title="Cerrar sesión" class="p-2 rounded-lg bg-slate-200 text-slate-500 hover:text-red-600 hover:bg-red-200 transition">
                        <img src="<?= htmlspecialchars("../uploads/cerrar_sesion.svg") ?>" alt="Cerrar Sesion" class="w-6 h-6">
                    </a>

                </div>
            </div>
        </div>
    </nav>

</body>

</html>