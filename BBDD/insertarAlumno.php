<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSERTAR ALUMNO</title>
</head>
<body>
    <?php
        $conexion = mysqli_connect("localhost", "root", "", "base1") or
            die("Problemas con la conexión");

        mysqli_query($conexion, "insert into alumnos(nombre,mail,codigocurso) values 
                                ('".$_POST['nombre']."','".$_POST['mail']."',".$_POST['codigocurso'].")")
            or die("Problemas en el select" . mysqli_error($conexion));

        mysqli_close($conexion);

        echo "El alumno fue dado de alta.";
    ?>
</body>
</html>