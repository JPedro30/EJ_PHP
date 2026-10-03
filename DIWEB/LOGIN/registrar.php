<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALTA USUARIO</title>
    <link rel="stylesheet" href="style_ejercicio1.css">
</head>

<body>

    <?php

    $insertado = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $conexion = mysqli_connect("localhost", "root", "", "usuarioscomic");

        if (!$conexion) {

            die("Error de conexion: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO usuarios (email, password, password_cifrada, nombre, apellido1, apellido2)
                            VALUES (?, ?, ?, ?, ?, ?)";

        $statement = mysqli_prepare($conexion, $sql);

        $password_cifrada = md5($_POST['password']);

        if ($statement) {

            mysqli_stmt_bind_param(
                $statement,
                "ssssss",
                $_POST['email'],
                $_POST['password'],
                $password_cifrada,
                $_POST['nombre'],
                $_POST['apellido1'],
                $_POST['apellido2']
            );

            if (!mysqli_stmt_execute($statement)) {

                $errores[] = "Error al guardar el cliente: " . mysqli_stmt_error($statement);
            } else {

                $insertado = true;
            }

            mysqli_stmt_close($statement);
        } else {

            $errores[] = "Error al preparar la consulta: " . mysqli_error($conexion);
        }

        mysqli_close($conexion);

        if ($insertado) {
            print("<h1><span>✓</span> Usuario registrado correctamente, los datos se han guardado en la base de datos.</h1>");
            print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
        }
    } else {
        print("Accede a esta pantalla desde inicio.");
        print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
    }



    ?>



</body>

</html>