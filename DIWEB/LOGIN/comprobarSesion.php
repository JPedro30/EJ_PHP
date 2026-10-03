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
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
        } else {
            $email = "";
        }
        print("El email del usuario en esta sesion es ".$email);
        print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
        print("<a href='cerrarSession.php' style='position: absolute; bottom: 25px; right: 30px;'>Cerrar Session</a>");
    ?>
</body>
</html>