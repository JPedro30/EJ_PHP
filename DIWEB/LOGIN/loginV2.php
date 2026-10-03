<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style_ejercicio1.css">
</head>

<body>
    <?php
    session_start();

    $usuarioCorrecto = false;
    $todoCorrecto = false;
    $mensajeError = "Email o contraseña incorrectos.";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $conexion = mysqli_connect("localhost", "root", "", "usuarioscomic");

        if (!$conexion) {
            die("Error de conexion: " . mysqli_connect_error());
        }

        $sql = "SELECT email, password_cifrada, bloqueado, fecha_bloqueo, intentos_inicio, fecha_ultimo_intento FROM usuarios WHERE email = ?";
        $statement = mysqli_prepare($conexion, $sql);

        $password = md5($_POST['password']); 
        $email = trim($_POST['email']);

        if ($statement) {
            mysqli_stmt_bind_param($statement, "s", $email);

            if (mysqli_stmt_execute($statement)) {
                $resultado = mysqli_stmt_get_result($statement);
                
                if ($fila = mysqli_fetch_assoc($resultado)) {
                    $usuarioCorrecto = true;
                    
                    $passBD = $fila['password_cifrada'];
                    $cuentaBloqueada = $fila['bloqueado'];
                    $intentos = $fila['intentos_inicio'];
                    
                    $tiempoActual = time(); // saco fecha actual
                    $tiempoBloqueo = $fila['fecha_bloqueo'] ? strtotime($fila['fecha_bloqueo']) : 0; // comprueba si existe fecha de bloqueo si existe la convierto a segundos si no pongo la variable a 0
                    $tiempoUltimoIntento = $fila['fecha_ultimo_intento'] ? strtotime($fila['fecha_ultimo_intento']) : 0;

                    // 1. VALIDACION DE CUENTA BLOQUEADA Y TIEMPO DE BLOQUEO
                    if ($cuentaBloqueada && $tiempoActual > strtotime('+2 minutes', $tiempoBloqueo)) {
                        $cuentaBloqueada = 0; // reseteamos la variables para sobreescribir en la base de datos
                        $intentos = 0;
                    }

                    // 2. VALIDACIONES LOGIN
                    if ($cuentaBloqueada) { // si cuenta bloqueada se acaba todo
                        $mensajeError = "La cuenta está bloqueada. Por favor, espera 3 minutos.";
                    } else { // si no esta bloqueada compruebo la contraseña
                        if ($passBD === $password) { // === significa identico, tanto valor como tipo de dato
                            $todoCorrecto = true; // SI ES CORRECTA TODO OK Y ACTUALIZO BLOQUEOS, FECHAS E INTENTOS
                            $sqlUpdate = "UPDATE usuarios SET bloqueado = 0, intentos_inicio = 0, fecha_bloqueo = NULL, fecha_ultimo_intento = NULL WHERE email = ?";
                            $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
                            mysqli_stmt_bind_param($stmtUpdate, "s", $email);
                            mysqli_stmt_execute($stmtUpdate);
                            
                        } else {
                            // SI CONTRASEÑA INCORRECTA
                            // COMPROBAR SI PASARON MAS DE 1 min DESDE ULTIMO INTENTO PARA RESETEAR O SUMAR UN INTENTO MAS
                            if ($tiempoUltimoIntento > 0 && $tiempoActual > strtotime('+1 minutes', $tiempoUltimoIntento)) {
                                $intentos = 1;
                            } else {
                                $intentos++;
                            }

                            if ($intentos >= 3) {
                                // SI LLEGA A LOS INTENTOS LIMITE, RESETEO INTENTOS PERO BLOQUEO LA CUENTA Y LA FECHA DE BLOQUEO
                                $sqlUpdate = "UPDATE usuarios SET bloqueado = 1, intentos_inicio = 0, fecha_bloqueo = NOW(), fecha_ultimo_intento = NOW() WHERE email = ?";
                                $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
                                mysqli_stmt_bind_param($stmtUpdate, "s", $email);
                                mysqli_stmt_execute($stmtUpdate);
                                $mensajeError = "Cuenta bloqueada por demasiados intentos fallidos. Espera 3 minutos.";
                            } else {
                                // SI NO HA LLEGADO AL LIMITE ACTUALIZO LOS INTENTOS Y LA FECHA DE ULTIMO INTENTO
                                $sqlUpdate = "UPDATE usuarios SET intentos_inicio = ?, fecha_ultimo_intento = NOW() WHERE email = ?";
                                $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);
                                mysqli_stmt_bind_param($stmtUpdate, "is", $intentos, $email);
                                mysqli_stmt_execute($stmtUpdate);
                                $mensajeError = "Contraseña incorrecta. Intento $intentos de 3.";
                            }
                        }
                    }
                }
            }
        }

        // SALIDA DE DATOS
        if ($todoCorrecto) {
            $_SESSION['email'] = $email;
            print("<h1><span>✓</span> Email y contraseña válido, accediendo a la web.</h1>");
            print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
            print("<a href='comprobarSesion.php' style='position: absolute; bottom: 25px; right: 30px;'>Comprobar Session</a>");
        } else {
            print("<h1><span>X</span> $mensajeError</h1>");
            print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
        }

        mysqli_close($conexion);

    } else {
        print("Accede a esta pantalla desde el formulario POST.");
        print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
    }

    ?>
</body>

</html> 