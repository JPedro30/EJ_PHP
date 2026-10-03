<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUSQUEDA ALUMNO</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=delete_forever" />
    <style>
        body{
            background: rgb(248, 226, 226);
            font-family: Verdana;
        }
        h1{
            text-align: center;
            margin-top: 5px;
        }
        .formulario{
            border: solid 2px black;
            border-radius: 10px;
            background: whitesmoke;
            padding: 30px;
            width: 500px;
            margin: 50px auto;
        }
        .cajaNombre{
            width: 98%;
        }
        .boton{
            height: 50px;
            width: 100px;
            background-color: rgb(232, 128, 128);
            box-shadow: 3px 3px rgba(0, 0, 0, 0.304);
            text-align: center;
        }
        .material-symbols-outlined{
            padding-left: 90%;
        }
    </style>
</head>
<body>

    <?php

    //$nombre = strip_tags($_POST['nombre']); 

    echo "<br>";
    $conexion = mysqli_connect("localhost", "root", "", "base1") or
            die ("Problemas con la conexion");

    $registros = mysqli_query($conexion, "SELECT codigo, nombre, mail, codigocurso
                                            FROM alumnos") or
                die ("Problemas en el select: ". mysqli_error($conexion));

    $nombreCurso = [1=>"PHP", "ASP", "JSP"];

    echo "<div class='formulario'>";
    echo "<h1>BAJA ALUMNO</h1>";
    echo "<form action='eliminaAlumno.php' method='post'>";
    echo "Seleccione al alumno que desea eliminar: <br><br>";
    echo "<hr><br>";

    //echo "<br>ALUMNOS DE ". $nombreCurso[$_POST['curso']] . " :<br><br>";
    $cont = 1;

    while ($reg = mysqli_fetch_array($registros)) {
        echo "Codigo: " . $reg['codigo'] . "<br>";
        echo "Nombre: " . $reg['nombre'] . "<br>";
        echo "Mail: " . $reg['mail'] . "<br>";
        echo "Curso: " . $nombreCurso[$reg['codigocurso']];
        echo "<a href='eliminarAlumno.php?alumno=".$reg['codigo']."'> <span class='material-symbols-outlined'>delete_forever</span></a> <br>";
        $cont++;
        echo "<hr><br>";
    }

    echo "</form>";
    echo "</div>";

    if (isset($_GET['alumno'])) {
        $codigo = $_GET['alumno'];
        $registros = mysqli_query($conexion, "DELETE FROM alumnos
                                            WHERE codigo = $codigo") or
                                            die ("Problemas en el select: ". mysqli_error($conexion));
        header("Refresh:0;url=" . $_SERVER['PHP_SELF']); // 0 es el tiempo en segundos
        exit();
    } else header("Refresh:10;url=" . $_SERVER['PHP_SELF']);
    
    mysqli_close($conexion);

    ?>

</body>
</html>