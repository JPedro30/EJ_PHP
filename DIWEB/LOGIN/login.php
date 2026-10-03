<!DOCTYPE html>
<html lang="en">

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $conexion = mysqli_connect("localhost", "root", "", "usuarioscomic");

        if (!$conexion) {
            die("Error de conexion: " . mysqli_connect_error());
        }

        $sql = "SELECT email, password_cifrada FROM usuarios WHERE email = ? AND password_cifrada = ?";

        $statement = mysqli_prepare($conexion, $sql);

        $password = md5($_POST['password']);

        if ($statement) {
            mysqli_stmt_bind_param(
                $statement,
                "ss",
                $_POST['email'],
                $password
            );

            if (mysqli_stmt_execute($statement)) {
                $resultado = mysqli_stmt_get_result($statement);
                if ($fila = mysqli_fetch_assoc($resultado)) {
                    $usuarioCorrecto = true;
                    $_SESSION['email'] = $_POST['email'];
                }
            }
        }

        mysqli_close($conexion);

        if ($usuarioCorrecto) {
            print("<h1><span>✓</span> Email y contraseña valido, accediendo a la web.</h1>");
            print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
            print("<a href='comprobarSesion.php' style='position: absolute; bottom: 25px; right: 30px;'>Comprobar Session</a>");
        } else {
            print("<h1><span>X</span> Email o contraseña incorrectos, intentelo de nuevo.</h1>");
            print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
        }
    } else {
        print("Accede a esta pantalla desde selector");
        print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
    }

    ?>
</body>

</html>