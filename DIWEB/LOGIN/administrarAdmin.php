<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONFIGURACION</title>
    <link rel="stylesheet" href="style_ejercicio1.css">
</head>
<body>
    <?php

    session_start();
    if ($_SERVER['REQUEST_METHOD']==='GET' && isset($_SESSION['tipoUsuario'])) {
        $tipoUsuario = $_SESSION['tipoUsuario'];
        if ($tipoUsuario == "ADMIN") {
            print("<h1>BIENVENIDO ADMIN, PAGINA EN PROCESO...</h1>");
        } else {
            print("<h1>POR QUE PULSAS AQUI SI NO ERES ADMIN...TU TIPO DE USUARIO ES : ".$tipoUsuario."</h1>");
        }
        print("<a href='inicio.html' class='boton-inicio'>⬅ VOLVER AL INICIO</a>");
    }else{
        print("DEBE DE ACCEDER DE MANERA ADECUADA");
    }
    


?>  
</body>
</html>