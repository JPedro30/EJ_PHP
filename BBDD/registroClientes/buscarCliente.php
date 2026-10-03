<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESULTADO BUSQUEDA</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
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
            margin-left: 45%;
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
            min-height: 200px;
            height: 100%;
            margin: 100px auto;
            box-sizing: border-box;
            align-items: center;
            padding-right: 30px;
            padding-left: 10px;
            padding-top: 10px;
        }
        p{
            font-size: 20px;
            text-align: center;
            padding-top: 100px;
            color: rgb(12, 36, 71);
        }
        a{
            color: rgb(12, 36, 71);
            padding-left: 50px;
            margin-left: 150px;
        }
    </style>
</head>
<body>
    <?php
        $conexion = mysqli_connect("localhost", "root", "", "registroclientes") or
            die("Problemas con la conexion");

        $resultado = mysqli_query($conexion, "SELECT id_clientes, nombre, apellido_1, apellido_2
                                                FROM clientes
                                                WHERE apellido_1 LIKE '%" . $_POST['apellido_1'] . "%'
                                                OR apellido_2 LIKE '%" . $_POST['apellido_2'] . "%'") or
            die("Problemas en el select ". mysqli_error($conexion));

        echo "<div class='resultado'>";
        echo "<h1>RESULTADO DE BUSQUEDA</h1>";
        while ($reg = mysqli_fetch_array($resultado)) {
            echo "<p>Nombre: ". $reg['nombre'] ."<br>";
            echo "Primer apellido: ". $reg['apellido_1'] ."<br>";
            echo "Segundo apellido: ". $reg['apellido_2'] ."</p><br>";
            echo "<a href='formModificarCliente.php?codigo=". $reg['id_clientes'] ."'> <span class='material-symbols-outlined'> edit_document </span></a>";
            echo "<a href='eliminarCliente.php?codigo=". $reg['id_clientes'] ."'> <span class='material-symbols-outlined'> delete_forever </span></a>";
            echo "<hr>";
        }
    
        echo "</div>";
        
        mysqli_close($conexion);

    ?>
        <form action="paginaInicio.html" method="post">
            <input type="submit" class="volver" value="VOLVER">
        </form>
    
</body>
</html>