<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODIFICAR CLIENTE</title>
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
            margin: 10px;
            margin-left: 280px;
        }
        .modificar{
            border-radius: 15px;
            border: 2px solid rgb(12, 36, 71);
            background: rgb(216, 226, 241);
            height: 20px;
            width: 100px;
            box-sizing: border-box;
            font-size: 12px;
            color: rgb(12, 36, 71);
            margin: 5px;
            margin-left: 280px;
        }
        body{
            background: rgb(225, 228, 231);
            font-family: verdana;
            font-size: 12px;
        }
        .formulario{
            border-radius: 15px;
            border: 2px solid rgb(12, 36, 71);
            background: rgb(116, 142, 182);
            width: 700px;
            height: 100%;
            margin: 100px auto;
            box-sizing: border-box;
            align-items: center;
            padding-right: 30px;
            padding-left: 10px;
            padding-top: 10px;
        }
        #codigo,#nombre,#apellido_1,#apellido_2,#sexo,#direccion,#email,#telefono,#fecha_nacimiento,#poblacion,#provincia,#contraseña,#dni{
            width: 100%;
            height: 20px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <?php

    $conexion = mysqli_connect("localhost", "root", "", "registroclientes") or
        die("Problemas con la conexion");

    $resultado = mysqli_query($conexion, "SELECT id_clientes, nombre, apellido_1, apellido_2, sexo, direccion, correo, telefono, fecha_nacimiento, poblacion, provincia, contraseña, dni
                                            FROM clientes
                                            WHERE id_clientes = " . $_GET['codigo']) or
            die("Problemas en el select ". mysqli_error($conexion));
    
    if ($reg = mysqli_fetch_array($resultado)) {
        $codigo = $reg['id_clientes'];
        $nombre = $reg['nombre'];
        $apellido_1 = $reg['apellido_1'];
        $apellido_2 = $reg['apellido_2'];
        $sexo = $reg['sexo'];
        $direccion = $reg['direccion'];
        $correo = $reg['correo'];
        $telefono = $reg['telefono'];
        $fecha_nacimiento = $reg['fecha_nacimiento'];
        $poblacion = $reg['poblacion'];
        $provincia = $reg['provincia'];
        $contraseña = $reg['contraseña'];
        $dni = $reg['dni'];
    } else {
        die("Cliente no encontrado.");
    }
        
    mysqli_close($conexion);
    ?>
    <h1>INSERTAR CLIENTE</h1>
    <div class="formulario">
        <form action="modificarCliente.php" method="post">
            <input type='hidden' name='codigo' id='codigo' value= "<?php echo $codigo ?>"><br><br>
            NOMBRE:
            <input disabled type='text' name='nombre' id='nombre' value= "<?php echo $nombre ?>"><br><br>
            PRIMER APELLIDO:
            <input disabled type="text" name="apellido_1" id="apellido_1" value= "<?php echo $apellido_1 ?>"><br><br>
            SEGUNDO APELLIDO:
            <input disabled type="text" name="apellido_2" id="apellido_2" value= "<?php echo $apellido_2 ?>"><br><br>
            SEXO:
            <input disabled type="text" name="sexo" id="sexo" value= "<?php echo $sexo ?>"><br><br>
            DIRECCION:
            <input type="text" name="direccion" id="direccion" value= "<?php echo $direccion ?>"><br><br>
            CORREO:
            <input type="email" name="correo" id="email" value= "<?php echo $correo ?>"><br><br>
            TELEFONO:
            <input type="number" name="telefono" id="telefono" value= "<?php echo $telefono ?>"><br><br>
            FECHA NACIMIENTO:
            <input disabled type="date" name="fecha_nacimiento" id="fecha_nacimiento" value= "<?php echo $fecha_nacimiento ?>"><br><br>
            POBLACION:
            <input type="text" name="poblacion" id="poblacion" value= "<?php echo $poblacion ?>"><br><br>
            PROVINCIA:
            <input type="text" name="provincia" id="provincia" value= "<?php echo $provincia ?>"><br><br>
            CONTRASEÑA:
            <input required type="password" name="contraseña" id="contraseña"><br><br>
            DNI:
            <input disabled type="text" name="dni" id="dni" value= "<?php echo $dni ?>"><br><br>
            <input type="submit" class="modificar" value="MODIFICAR">
        </form>
        <form action="paginaInicio.html" method="post">
            <input type="submit" class="volver" value="VOLVER">
        </form>
    </div>
</body>
</html>