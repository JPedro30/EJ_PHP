<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        body{
            font-size: 21px;
            font-family: verdana;
        }

        .bisiesto {
            background: lightgreen;
            text-align: center;
            border: solid 2px green;
            border-radius: 25px;
            box-sizing: border-box;
            border-collapse: collapse;
            color: green;
        }

        .secular{
            background: rgb(246, 243, 235);
            text-align: center;
            border: solid 2px rgb(75, 64, 34);
            box-sizing: border-box;
            border-collapse: collapse;
            color: rgb(75, 64, 34);
        }

    </style>
</head>
<body>
    
    <?php

    $añoLimite = 3000;
    $contador = 0;

    echo "<table>";
    for ($año=1; $año <= $añoLimite; $año++) { 
        if ($contador == 0) {
            echo "<tr>";
        }
        if ($año%4==0 && $año%100!=0 || $año%400==0) {
            echo "<td class=bisiesto>".$año;
            $contador++;
        } else {
            echo "<td class=secular>".$año;
            $contador++;
        }
        echo "</td>";
        if ($contador==25) {
            echo "</tr>";
            $contador=0;
        }
    }
    echo "</table>";

    ?>

</body>
</html>