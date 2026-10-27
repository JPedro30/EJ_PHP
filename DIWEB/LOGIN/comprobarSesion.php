<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SESSION</title>
    <link rel="stylesheet" href="style_ejercicio1.css">
</head>
<body>
    <?php
        session_start();
        if (isset($_SESSION['email']) && isset($_SESSION['tipoUsuario'])) {
            $email = $_SESSION['email'];
            $tipoUsuario = $_SESSION['tipoUsuario'];
        } else {
            $email = "";
            $tipoUsuario = "";
        }
        print("<h1>El email del usuario en esta sesion es ".$email." el usuario es de tipo: ".$tipoUsuario."</h1>");
        print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
        print("<a href='cerrarSession.php' style='position: absolute; bottom: 25px; right: 30px;'>Cerrar Session</a>");
    ?>
</body>
</html>