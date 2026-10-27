<?php
session_start();
require_once '../connection/connection.php';

// Configuración de la geocerca
$latitudPermitida = 36.8667762775813;
$longitudPermitida = -6.178595445589528;
$radioMaximo = 1000;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = "ERROR: ACCESO DENEGADO";
    $permitir_acceso = false;
    $ubi_correcta = false;

    // Validar que llegaron las coordenadas
    if (!isset($_POST['latitud']) || !isset($_POST['longitud']) || empty($_POST['latitud'])) {
        // Redirigir de vuelta indicando que falta la ubicación
        $mensaje = "FALTA UBICACION";
        $_SESSION['mensaje'] = $mensaje;
        header("Location: ../vistas/login.php");
        exit();
    }

    $latUsuario = $_POST['latitud'];
    $lonUsuario = $_POST['longitud'];

    $distancia = calcularDistanciaMetros($latUsuario, $lonUsuario, $latitudPermitida, $longitudPermitida);

    if ($distancia <= $radioMaximo) {
        $ubi_correcta = true;
    }

    try {

        $sql = "SELECT email, nombre, password, bloqueado, fecha_bloqueo, intentos_inicio, fecha_ultimo_intento, tipo_usuario, imagen_usuario, id 
                FROM usuarios
                WHERE email = :email";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':email' => $_POST['email'],
        ]);

        $usuario = $stmt->fetch();
        $permitir_acceso = false;
        $rol = "C";
        $imagen_usuario = "";

        if ($usuario) {

            $rol = "";
            $nombre = $usuario['nombre'];
            $tiempo_bloqueo = $usuario['fecha_bloqueo'] ? strtotime($usuario['fecha_bloqueo']) : 0;
            $tiempo_ultimo_intento = $usuario['fecha_ultimo_intento'] ? strtotime($usuario['fecha_ultimo_intento']) : 0;
            $tiempo_actual = time();
            $usuario_bloqueado = $usuario['bloqueado'];
            $intentos_inicio = $usuario['intentos_inicio'];
            $imagen_usuario = $usuario['imagen_usuario'];
            $id = $usuario['id'];

            switch ($usuario['tipo_usuario']) {
                case 0:
                    $rol = "A";
                    break;

                case 1:
                    $rol = "C";
                    break;

                case 2:
                    $rol = "T";
                    break;

                default:
                    $rol = "C";
                    break;
            }

            if ($usuario_bloqueado && $tiempo_actual > strtotime('+2 minutes', $tiempo_bloqueo)) {
                $usuario_bloqueado = 0;
                $intentos_inicio = 0;
            }

            if ($usuario_bloqueado) {
                $mensaje = "ERROR: ACCESO DENEGADO";
            } else {
                if (password_verify($_POST['password'], $usuario['password']) && $ubi_correcta) {
                    $permitir_acceso = true;

                    $sql = "UPDATE usuarios SET bloqueado = 0, intentos_inicio = 0, fecha_bloqueo = NULL, fecha_ultimo_intento = NULL
                            WHERE email = :email";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':email' => $_POST['email']
                    ]);
                } else {
                    if ($tiempo_ultimo_intento > 0 && $tiempo_actual > strtotime('+1 minutes', $tiempo_ultimo_intento)) {
                        $intentos_inicio = 1;
                    } else {
                        $intentos_inicio++;
                    }

                    if ($intentos_inicio >= 3) {
                        $sql = "UPDATE usuarios SET bloqueado = 1, intentos_inicio = 0, fecha_bloqueo = NOW(), fecha_ultimo_intento = NOW()
                                WHERE email = :email";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':email' => $_POST['email']
                        ]);
                        $mensaje = "ERROR: ACCESO DENEGADO";
                    } else {
                        $sql = "UPDATE usuarios SET intentos_inicio = :intentos, fecha_ultimo_intento = NOW()
                                WHERE email = :email";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':email' => $_POST['email'],
                            ':intentos' => $intentos_inicio,
                        ]);
                        $mensaje = "ERROR: ACCESO DENEGADO";
                    }
                }
            }
        }

        if ($permitir_acceso) {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['nombre'] = $nombre;
            $_SESSION['rol'] = $rol;
            $_SESSION['imagen_usuario'] = $imagen_usuario;
            $_SESSION['permitir_acceso'] = $permitir_acceso;
            $_SESSION['sesion_iniciada'] = true;
            $_SESSION['id'] = $id;
            $location = "";
            switch ($rol) {
                case 'A':
                    $location = "Location: ../vistas/dashboard_admin.php";
                    break;

                case 'T':
                    $location = "Location: ../vistas/dashboard_trabajador.php";
                    break;

                case 'C':
                    $location = "Location: ../vistas/dashboard_cliente.php";
                    break;
            }
            header($location);
            exit();
        } else {
            $_SESSION['mensaje'] = $mensaje;
            $_SESSION['permitir_acceso'] = $permitir_acceso;

            header('Location: ../vistas/login.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = $mensaje;
        $_SESSION['permitir_acceso'] = $permitir_acceso;

        header('Location: ../vistas/login.php');
        exit();
    }
} else {
    header('Location: ../vistas/inicio.html');
    exit();
}

function calcularDistanciaMetros($lat1, $lon1, $lat2, $lon2)
{
    $radioTierra = 6371000;
    $latFrom = deg2rad($lat1);
    $lonFrom = deg2rad($lon1);
    $latTo = deg2rad($lat2);
    $lonTo = deg2rad($lon2);
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $radioTierra;
}
?>