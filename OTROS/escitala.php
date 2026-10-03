<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESCITALA</title>
<Style>
    body{
        font-family : verdana;
    }
    .tabla{
        overflow : hidden;
        margin-top : 10px;
        box-sizing : border-box;
    }
    .columnaPar{
        float : left;
        background : rgb(94, 85, 85);
        color : rgb(245, 245, 241);
        box-sizing : border-box;
    }
    .columnaImpar{
        float : left;
        background : rgb(206, 197, 208);
        color : rgb(60, 60, 55);
        box-sizing : border-box;
    }
    .letra {
        border : solid 2px rgb(152, 142, 151);
        width : 30px;
        height : 30px;
        text-align : center;
        line-height : 30px;
        font-weight : bold;
        box-sizing : border-box;
    }
</Style>
</head>
<body>

    <?php

    $texto= $_POST['frase'] ;
    echo "<br>Texto a cifrar: ". $texto;

    $numFil = $_POST['desplazamiento'];

    $numCol = ceil(strlen($texto)/$numFil);

    $escitala;

    $contadorCarc=0;        
    for ($columna=0; $columna < $numCol; $columna++) { 
        for ($fila=0; $fila < $numFil ; $fila++) { 
            $escitala[$fila][$columna] = $texto[$contadorCarc] ?? " "; 
            $contadorCarc++;  
        }
    }

    echo "<br><br>Escitala: ";
    echo "<div class=tabla>";
    for ($fila=0; $fila < $numCol; $fila++) { 
        if (($fila+1)%2!=0) {
            echo "<div class=columnaImpar>";
        } else echo "<div class=columnaPar>";
        for ($columna=0; $columna < $numFil ; $columna++) { 
            echo "<div class=letra>";
            echo $escitala[$columna][$fila];  
            echo "</div>";
        }
        echo "</div>";
    }
    echo "</div>";

    echo "<br>Escitala cifrado: <br>";
    echo "<div class=tabla>";
    for ($fila=0; $fila < $numFil; $fila++) { 
        if (($fila+1)%2!=0) {
            echo "<div class=columnaImpar>";
        } else echo "<div class=columnaPar>";
        for ($columna=0; $columna < $numCol ; $columna++) { 
            echo "<div class=letra>";
            echo $escitala[$fila][$columna]; 
            echo "</div>"; 
        }
        echo "</div>";
    }   
    echo "</div>";



    ?>
    
</body>
</html>