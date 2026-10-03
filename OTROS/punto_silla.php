<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUNTO DE SILLA</title>
</head>
<body>
    <?php

    // PUNTO DE SILLA ES EL NUMERO MAS ALTO DE UNA FILA Y A LA VEZ EL MAS BAJO DE LA COLUMNA POR EJEMPLO EL 5 DE LA 0,1

    $matriz =  [[4,5,3,2,1,4],
                [3,7,2,5,8,4],
                [2,8,6,3,5,6],
                [3,9,5,2,4,3],
                [2,6,4,7,3,2],
                [3,7,5,6,8,1]];

    

    for ($fila=0; $fila < count($matriz); $fila++) { 
        for ($columna=0; $columna < sizeof($matriz[$fila]) ; $columna++) { 
            $valorMaxFila = -199;
            $posMaxFila = 0;
            $posMaxCol = 0;
            for ($filaComprobar=$fila; $filaComprobar < $matriz[$fila]; $filaComprobar++) { 
                if ($matriz[$filaComprobar][$columna]>$valorMaxFila) {
                    $valorMaxFila = $matriz[$fila][$columna];
                    $posMaxFila = $filaComprobar;
                    $posMaxCol = $columna;
                }
            }
            
        }
    }

    function esMinColu($matriz,$fila,$columna,$valorMaxFila,$posMaxFila,$posMaxCol){
        for ($ColuComprobar=$columna; $ColuComprobar < $matriz[$fila]; $ColuComprobar++) { 
            if ($matriz[$posMaxFila][$ColuComprobar]<$valorMaxFila) {
                return false;
            } else { 
                return true;
            }
        }
    }

    ?>
</body>
</html>