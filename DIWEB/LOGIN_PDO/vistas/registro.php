<?php
session_start();
$mensaje = $_SESSION['mensaje'] ?? null;
$registrado = $_SESSION['registrado'] ?? null;
unset($_SESSION['mensaje']);
unset($_SESSION['registrado']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO USUARIO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../estilo/style.css">
</head>
        
<body class="bg-slate-900 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="max-w-3xl w-full space-y-4">
        <a href="../vistas/inicio.html" class="btn-back hover:text-slate-200">Volver al inicio</a>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden grid grid-cols-1 md:grid-cols-5">
            
            <!-- Columna Izquierda: Banner/Info -->
            <div class="md:col-span-2 bg-slate-800 p-8 text-white flex flex-col justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-indigo-200">Edición 2026</span>
                    <h1 class="text-2xl font-bold mt-2">Comic-Con Trebujena</h1>
                    <p class="text-indigo-100 text-sm mt-4 leading-relaxed">
                        ¡Únete al evento más esperado del año! Completa tu registro para reservar tus pases y participar.
                    </p>
                </div>
                <p class="text-xs text-indigo-300 mt-6">© 2026 Comic-Con Trebujena</p>
            </div>

            <!-- Columna Derecha: Formulario -->
            <div class="md:col-span-3 p-8 bg-slate-200">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Crear Cuenta</h2>

<?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && $registrado !== null): ?>
    <div class="p-3 rounded-lg text-sm mb-4 border <?= $registrado ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' ?>">
        <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>

                <form action="../procesos/procesoRegistro.php" method="post" class="space-y-4">
                    <div class="form-group">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-input" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group mb-0">
                            <label class="form-label">1º Apellido</label>
                            <input type="text" name="primer_apellido" class="form-input" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">2º Apellido</label>
                            <input type="text" name="segundo_apellido" class="form-input" required>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="condiciones" id="condiciones" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4" required>
                        <label for="condiciones" class="text-xs text-slate-600 select-none">
                            Acepto los <a href="#" class="text-indigo-600 hover:underline">términos y condiciones</a>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary mt-4">REGISTRAR</button>
                </form>
            </div>

        </div>
    </div>

</body>