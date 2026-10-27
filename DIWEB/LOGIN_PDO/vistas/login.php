<?php
session_start();

$mensaje = $_SESSION['mensaje'] ?? null;
$permitir_acceso = $_SESSION['permitir_acceso'] ?? null;
$sesion_iniciada = $_SESSION['sesion_iniciada'] ?? null;
$rol = $_SESSION['rol'] ?? null;

unset($_SESSION['mensaje']);
unset($_SESSION['permitir_acceso']);

// Redirección ANTES de cualquier salida de texto/HTML
if ($sesion_iniciada !== null && $rol !== null) {
    switch ($rol) {
        case 'A':
            header("Location: ../vistas/dashboard_admin.php");
            break;
        case 'T':
            header("Location: ../vistas/dashboard_trabajador.php");
            break;
        case 'C':
            header("Location: ../vistas/dashboard_cliente.php");
            break;
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../estilo/style.css">
</head>

<body class="bg-slate-900 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="max-w-sm w-full space-y-4">
        <a href="../vistas/inicio.html" class="btn-back hover:text-slate-200">Volver al inicio</a>

        <div class="bg-slate-200 p-8 rounded-2xl shadow-sm border border-slate-200">
            <h1 class="text-2xl font-bold text-slate-800 text-center mb-6">Inicio de Sesión</h1>

            <?php if ($mensaje): ?>
                <div class="bg-red-50 text-red-700 p-3 rounded-lg text-sm mb-4 border border-red-200">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <form id="formLogin" action="../procesos/procesoLogin.php" method="post" class="space-y-4">
                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-input" placeholder="tu@email.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <input type="hidden" name="latitud" id="latitud">
                <input type="hidden" name="longitud" id="longitud">

                <button type="submit" id="btnSubmit" class="btn-primary opacity-50 cursor-not-allowed" disabled>
                    Obteniendo ubicación...
                </button>
                <p id="avisoUbicacion" class="text-sm text-red-700 mt-2 hidden"></p>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btn = document.getElementById('btnSubmit');
            const lat = document.getElementById('latitud');
            const lng = document.getElementById('longitud');
            const aviso = document.getElementById('avisoUbicacion');

            const textos = {
                1: "Permiso de ubicación denegado. Actívalo desde el candado de la barra de direcciones.",
                2: "No se pudo determinar la ubicación (¿ubicación del sistema desactivada?).",
                3: "Se agotó el tiempo de espera."
            };

            function pedirUbicacion() {
                if (!window.isSecureContext) {
                    aviso.textContent = "La página debe abrirse por https o http://localhost.";
                    aviso.classList.remove('hidden');
                    return;
                }
                if (!navigator.geolocation) {
                    aviso.textContent = "Tu navegador no soporta geolocalización.";
                    aviso.classList.remove('hidden');
                    return;
                }

                aviso.classList.add('hidden');
                btn.type = 'submit';
                btn.disabled = true;
                btn.innerText = "Obteniendo ubicación...";

                navigator.geolocation.getCurrentPosition(
                    pos => {
                        lat.value = pos.coords.latitude;
                        lng.value = pos.coords.longitude;
                        btn.disabled = false;
                        btn.innerText = "ENTRAR";
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    },
                    err => {
                        console.warn("Geolocalización", err.code, err.message);
                        aviso.textContent = (textos[err.code] || "Error desconocido.") + " (" + err.message + ")";
                        aviso.classList.remove('hidden');
                        // El botón pasa a ser "Reintentar" y deja de enviar el formulario
                        btn.type = 'button';
                        btn.disabled = false;
                        btn.innerText = "Reintentar ubicación";
                        btn.onclick = pedirUbicacion;
                    }, {
                        enableHighAccuracy: false,
                        timeout: 15000,
                        maximumAge: 0
                    }
                );
            }

            pedirUbicacion();
        });
    </script>
</body>

</html>