<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALMANAQUE</title>
    <Style>
        body{
            font-family: verdana;
        }
        table{
            border-collapse: collapse;
            text-align: center;
            margin: 0 auto;
            margin-bottom: 20px;
        }
        h3{
            text-align: center;
        }
        .titulo{
            font-weight: bold;
            background: gray;
            color: white;
            border-collapse: collapse;
            border: solid 2px black;
            height: 30px;
            width: 30px;
        }
        .finde{
            background: rgb(249, 76, 76);
            border: solid 2px black;
            height: 30px;
            width: 30px;
        }
        .entreSemana{
            background: rgb(255, 255, 255);
            border: solid 2px black;
            height: 30px;
            width: 30px;
        }
        .diaBlanco{
            background: rgb(192, 190, 190);
            border: solid 2px black;
            height: 30px;
            width: 30px;
        }
        .añoNuevo{
            background: rgb(9, 129, 37);
            border: solid 2px black;
            color: rgb(218, 244, 88);
            height: 30px;
            width: 30px;
        }
        .cumpleMarcos{
            background: rgb(247, 64, 201);
            border: solid 2px black;
            color: rgb(109, 31, 91);
            font-family: "Times New Roman";
            height: 30px;
            width: 30px;
        }
        .cumpleArturo{
            background: rgb(231, 177, 52);
            border: solid 2px black;
            color: rgb(113, 79, 30);
            font-family: "Roboto";
            height: 30px;
            width: 30px;
        }
        .cumpleJP{
            background: rgb(122, 141, 252);
            border: solid 2px black;
            color: rgb(62, 37, 161);
            font-family: Verdana;
            height: 30px;
            width: 30px;
        }
    </Style>
</head>
<body>

    <?php

    $año = $_POST['año'];

    $nombresMeses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO','SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

    echo "<div>";
    
    for ($mes=1; $mes <= 12 ; $mes++) { 
        
        $fecha = new DateTime("$año-$mes-01");
        $diasMes = $fecha->format('t');
        $diaSemanaComienzo = $fecha->format('N');

        echo "<div class='mes'>";
        echo "<h3>· " . $nombresMeses[$mes-1] ." ".  $año." ·</h3>";
        echo "<table>";
        echo "<tr>
                <td class=titulo>L</td>
                <td class=titulo>M</td>
                <td class=titulo>X</td>
                <td class=titulo>J</td>
                <td class=titulo>V</td>
                <td class=titulo>S</td>
                <td class=titulo>D</td>
              </tr><tr>";

        for ($diasBlanco=1; $diasBlanco < $diaSemanaComienzo; $diasBlanco++) {

            echo "<td class=diaBlanco></td>";

        }

        $diaSemanaActual = $diaSemanaComienzo;

        for ($dias=1; $dias <= $diasMes; $dias++) { 
            
            if ($dias == 30 && $mes == 1) {
                echo "<td class=cumpleJP>$dias</td>";
            }else if ($dias == 19 && $mes == 3) {
                echo "<td class=cumpleArturo>$dias</td>";
            }else if ($dias == 5 && $mes == 7) {
                echo "<td class=cumpleMarcos>$dias</td>";
            }else if ($dias == 31 && $mes == 12) {
                echo "<td class=añoNuevo>$dias</td>";
            } else if ($diaSemanaActual >= 6) {
                echo "<td class=finde>$dias</td>";
            } else if ($diaSemanaActual < 6) {
                echo "<td class=entreSemana>$dias</td>";
            } 

            if ($diaSemanaActual == 7) {
                
                echo "</tr><tr>";

                $diaSemanaActual = 0;

            }

            $diaSemanaActual++;

        }

        if ($diaSemanaActual!=1) {
            
            while ($diaSemanaActual <= 7) {
                
                echo "<td class=diaBlanco></td>";

                $diaSemanaActual++;

            }


        }

        echo "</tr>";
        echo "</table>";
        echo "<hr>";
        echo "</div>";
        

    }

    ?>

</body>
</html>