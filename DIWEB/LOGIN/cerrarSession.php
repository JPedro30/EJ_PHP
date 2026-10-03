<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SESSION CERRADA</title>
    <link rel="stylesheet" href="style_ejercicio1.css">
</head>

<body>
    <?php
    session_start();
    session_unset();
    session_destroy();
    print("SESSION cerrada correctamente...");
    print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
    print("<a href='comprobarSesion.php' style='position: absolute; bottom: 25px; right: 30px;'>Comprobar Session</a>");
    ?>

</body>

</html>