<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENTE BORRADO</title>
    <style>
        h1{
            font-size: 30px;
            text-align: center;
            margin-top: 30px;
            margin-bottom: -80px;
            color: rgb(12, 36, 71);
            letter-spacing: 3px;
        }
        .volver{
            border-radius: 15px;
            border: 2px solid rgb(12, 36, 71);
            background: rgb(216, 226, 241);
            height: 20px;
            width: 100px;
            box-sizing: border-box;
            font-size: 12px;
            color: rgb(12, 36, 71);
            margin: 200px;
            margin-left: 280px;
        }
        body{
            background: rgb(225, 228, 231);
            font-family: verdana;
            font-size: 12px;
        }
        .resultado{
            border-radius: 15px;
            border: 2px solid rgb(12, 36, 71);
            background: rgb(116, 142, 182);
            width: 700px;
            height: 300px;
            margin: 100px auto;
            box-sizing: border-box;
            align-items: center;
            padding-right: 30px;
            padding-left: 10px;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <?php

    $conexion = mysqli_connect("localhost", "root", "", "registroclientes") or
        die("Problemas con la conexion");

    mysqli_query($conexion, "DELETE FROM clientes WHERE id_clientes = ".$_GET['codigo']) or
        die("Problemas en el select ". mysqli_error($conexion));
        
    mysqli_close($conexion);
    ?>
    <div class="resultado">
        <h1>CLIENTE BORRADO CORRECTAMENTE</h1>
        <form action="paginaInicio.html" method="post">
            <input type="submit" class="volver" value="VOLVER">
        </form>
    </div>
</body>
</html>