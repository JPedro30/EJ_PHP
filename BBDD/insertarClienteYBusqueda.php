<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENTES</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=delete_forever" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=contract_edit" />
    <style>
        body{
            background: lightcyan;
            font-family: Verdana;
        }
        h1{
            text-align: center;
            margin-top: 5px;
        }
        .formularioInsertar{
            border: solid 2px black;
            border-radius: 10px;
            background: whitesmoke;
            padding: 30px;
            height: 300px;
            width: 330px;
            margin: 50px auto;
        }
        .formularioBusqueda{
            border: solid 2px black;
            border-radius: 10px;
            background: whitesmoke;
            padding: 30px;
            height: 70px;
            width: 330px;
            margin: 50px auto;
        }
        .formularioModificar{
            border: solid 2px black;
            border-radius: 10px;
            background: whitesmoke;
            padding: 30px;
            height: 230px;
            width: 330px;
            margin: 50px auto;
        }
    </style>    
</head>
<body>

    <div class="formularioInsertar">
        <form action="insertarClienteYBusqueda.php" method="get">
            Nombre:
            <input type="text" name="nombre" id=""><br>
            Primer Apellido:
            <input type="text" name="apellido_1" id=""><br>
            Segundo Apellido:
            <input type="text" name="apellido_2" id=""><br>
            Sexo:
            <input type="text" name="sexo" id=""><br>
            Direccion:
            <input type="text" name="direccion" id=""><br>
            Email:
            <input type="email" name="correo" id=""><br>
            Telefono:
            <input type="text" name="telefono" id=""><br>
            Fecha Nacimiento:
            <input type="date" name="fecha_nacimiento" id=""><br>
            Poblacion:
            <input type="text" name="poblacion" id=""><br>
            Provincia:
            <input type="text" name="provincia" id=""><br>
            Contraseña:
            <input type="password" name="contraseña" id=""><br>
            DNI:
            <input type="text" name="dni" id=""><br>
            <input type="submit" value="INSERTAR">
        </form>
    </div>

    <hr>

    <div class="formularioBusqueda">
        <form action="insertarClienteYBusqueda.php" method="get">
            Primer Apellido:
            <input type="text" name="apellido_1Bus" id=""><br>
            Segundo Apellido:
            <input type="text" name="apellido_2Bus" id=""><br>
            <input type="submit" value="BUSCAR">
        </form>
    </div>

    <?php

    if (isset($_GET['apellido_1Bus']) || isset($_GET['apellido_2Bus'])) {
        $conexion = mysqli_connect("localhost", "root", "", "registroclientes") or
            die("Problemas con la conexión");

        $registros = mysqli_query($conexion, "SELECT *
                                            FROM clientes
                                            WHERE apellido_1 LIKE '%".$_GET['apellido_1Bus']."';")
                or die("Problemas en el select" . mysqli_error($conexion));

        while ($reg = mysqli_fetch_array($registros)) {
            echo "Nombre: " . $reg['nombre'] . "<br>";
            echo "Primer Apellido: " . $reg['apellido_1'] . "<br>";
            echo "Segundo Apellido: " . $reg['apellido_2'];
            echo "<a href='insertarClienteYBusqueda.php?clienteMod=".$reg['ID_CLIENTES']."'> <span class='material-symbols-outlined'>contract_edit</span></a> <br>";
            echo "<a href='insertarClienteYBusqueda.php?clienteBor=".$reg['ID_CLIENTES']."'> <span class='material-symbols-outlined'>delete_forever</span></a> <br>";
            echo "<hr><br>";
        }

        mysqli_close($conexion);


    }

    if (isset($_GET['clienteBor'])) {
        $conexion = mysqli_connect("localhost", "root", "", "registroclientes") or
            die("Problemas con la conexión");

        mysqli_query($conexion, "DELETE FROM clientes WHERE ID_CLIENTES = ".$_GET['clienteBor'].";")
                or die("Problemas en el select" . mysqli_error($conexion));

        mysqli_close($conexion);

        //header("Refresh:0;url=" . $_SERVER['PHP_SELF']); // 0 es el tiempo en segundos
        //exit();
    }

    if (isset($_GET['clienteMod'])) {
        $conexion = mysqli_connect("localhost", "root", "", "registroclientes") or
            die("Problemas con la conexión");

        $registros = mysqli_query($conexion, "SELECT * FROM clientes WHERE ID_CLIENTES = ".$_GET['clienteBor'].";")
                or die("Problemas en el select" . mysqli_error($conexion));

        if ($reg = mysqli_fetch_array($registros)) {

        ?>

        <div class="formularioModificar">
            <form action="insertarClienteYBusqueda.php" method="get">
                Nombre:
                <input type="text" name="nombreNuevo" value="<?php echo $reg['nombre'] ?>"><br>
                Primer Apellido:
                <input type="text" name="apellido_1Nuevo" value="<?php echo $reg['apellido_1'] ?>"><br>
                Segundo Apellido:
                <input type="text" name="apellido_2Nuevo" value="<?php echo $reg['apellido_2'] ?>"><br>
                Sexo:
                <input type="text" name="sexoNuevo" value="<?php echo $reg['sexo'] ?>"><br>
                Direccion:
                <input type="text" name="direccionNuevo" value="<?php echo $reg['direccion'] ?>"><br>
                Email:
                <input type="email" name="correoNuevo" value="<?php echo $reg['email'] ?>"><br>
                Telefono:
                <input type="text" name="telefonoNuevo" value="<?php echo $reg['telefono'] ?>"><br>
                Fecha Nacimiento:
                <input type="date" name="fecha_nacimientoNuevo" value="<?php echo $reg['fecha_nacimiento'] ?>"><br>
                Poblacion:
                <input type="text" name="poblacionNuevo" value="<?php echo $reg['poblacion'] ?>"><br>
                Provincia:
                <input type="text" name="provinciaNuevo" value="<?php echo $reg['provincia'] ?>"><br>
                Contraseña:
                <input type="password" name="contraseñaNuevo" value="<?php echo $reg['contraseña'] ?>"><br>
                DNI:
                <input type="text" name="dniNuevo" value="<?php echo $reg['dni'] ?>"><br>
                <input type="submit" value="MODIFICAR">
            </form>
        </div>

        <?php
        }

        if (isset($_GET['nombreNuevo']) || 
            isset($_GET['apellido_1Nuevo']) || 
            isset($_GET['apellido_2Nuevo']) || 
            isset($_GET['sexoNuevo']) || 
            isset($_GET['direccionNuevo']) || 
            isset($_GET['correoNuevo']) || 
            isset($_GET['telefonoNuevo']) || 
            isset($_GET['fecha_nacimientoNuevo']) || 
            isset($_GET['poblacionNuevo']) || 
            isset($_GET['provinciaNuevo']) || 
            isset($_GET['contraseñaNuevo']) || 
            isset($_GET['dniNuevo'])) {

            $conexion = mysqli_connect("localhost", "root", "", "registroclientes") or
            die("Problemas con la conexión");

            mysqli_query($conexion, "UPDATE FROM clientes 
                                    SET nombre = '".$_GET['nombreNuevo']."'
                                    , apellido_1 = '".$_GET['apellido_1Nuevo']."'
                                    , apellido_2 = '".$_GET['apellido_2Nuevo']."'
                                    , sexo = '".$_GET['sexoNuevo']."'
                                    , direccion = '".$_GET['direccionNuevo']."'
                                    , correo = '".$_GET['correoNuevo']."'
                                    , telefono = '".$_GET['telefonoNuevo']."'
                                    , fecha_nacimiento = '".$_GET['fecha_nacimientoNuevo']."'
                                    , poblacion = '".$_GET['poblacionNuevo']."'
                                    , provincia = '".$_GET['provinciaNuevo']."'
                                    , contraseña = '".$_GET['contraseñaNuevo']."'
                                    , dni = '".$_GET['dniNuevo']."'
                                    WHERE ID_CLIENTES = ".$_GET['clienteBor'].";")
                    or die("Problemas en el select" . mysqli_error($conexion));

            mysqli_close($conexion);

            //header("Refresh:0;url=" . $_SERVER['PHP_SELF']); // 0 es el tiempo en segundos
            //exit();
        }
    }

    

    
    

    ?>


</body>
</html>