<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALENDARIO</title>
    <style>
        table{
            border: 1px solid black;
            text-align: center;
            border-collapse: collapse;
        }
        .semana{
            border: 2px solid red;
        }
        .dias{
            border: 2px solid green;
        }
    </style>
</head>
<body>

    <?php
    
    $contDiaSem;
    $contDiaMes;
    $dias = "LMXJVSD";
    $diasMes = range(1,31);
    $diaComenzar = 3;

    echo "<table>";

    echo "<tr>"."ENERO"."</tr>";
    
    echo "<tr>";
    for ($contDiaSem=0; $contDiaSem < 7; $contDiaSem++) { 
        echo "<td class=semana>".$dias[$contDiaSem]."</td>";
    }
    echo "</tr>";
    
    echo "<tr>";
    $contDiaSem=0;

    for ($contBlanInici=0; $contBlanInici < $diaComenzar; $contBlanInici++) { 
        echo "<td class=dias></td>";
        $contDiaSem++;
    }

    for ($contDiaMes=0; $contDiaMes < count($diasMes); $contDiaMes++) { 
        if ($contDiaSem==7) {
            echo "</tr><tr>";
            $contDiaSem=0;
        }

        echo "<td class=dias>".$diasMes[$contDiaMes]."</td>";
        $contDiaSem++;

    }

    while ($contDiaSem < 7) {
        echo "<td class=dias></td>";
        $contDiaSem++;
    }

    echo "</tr>";
    echo "</table>";


    ?>
    
</body>
</html>