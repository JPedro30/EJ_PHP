<?php
session_start();
$imagen_usuario = $_SESSION['imagen_usuario'] ?? null;
$nombre = $_SESSION['nombre'] ?? 'Usuario';
$error = $_SESSION['error'] ?? null;

unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUBIR IMAGEN PERFIL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../estilo/style.css">
</head>
<body class="bg-slate-900 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="max-w-sm w-full space-y-4">
        
        <a href="../vistas/dashboard_cliente.php" class="btn-back hover:text-slate-200">VOLVER PAGINA PRINCIPAL</a>

        <div class="bg-slate-200 p-8 rounded-2xl shadow-lg border border-slate-300 flex flex-col items-center">
            
            <?php if (!file_exists("../uploads/".$imagen_usuario)) $imagen_usuario = "default.jpg"; ?>
            
            <img src="<?= htmlspecialchars("../uploads/".$imagen_usuario) ?>" alt="Perfil" class="w-28 h-28 rounded-full object-cover border-4 border-slate-100 shadow-md mb-4">

            <h3 class="text-2xl font-bold text-slate-800 text-center mb-6"><?= htmlspecialchars($nombre) ?></h3>

            <form action="../procesos/upload.php" method="post" enctype="multipart/form-data" class="w-full space-y-4">
                
                <!-- Input file 100% nativo estilizado con el modificador file: de Tailwind -->
                <div>
                    <label for="imagen" class="block text-xs font-semibold text-slate-600 mb-1">Elegir foto de perfil</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*"
                           class="block w-full text-sm text-slate-600
                                  file:mr-4 file:py-2.5 file:px-4
                                  file:rounded-xl file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-600 file:text-white
                                  hover:file:bg-indigo-700
                                  file:cursor-pointer cursor-pointer
                                  bg-slate-100 rounded-xl p-1 border border-slate-300">
                </div>

                <!-- Botón de envío -->
                <button type="submit" name="submit" class="btn-primary bg-slate-900">
                    SUBIR IMAGEN
                </button>
            </form>
        </div>
    </div>

</body>
</html>