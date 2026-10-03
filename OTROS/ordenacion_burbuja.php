<html>

<head>
  <title>Jose Pedro - Ordenacion Burbuja</title>
  <Style>
    body{
      margin: 10px;
      padding: 10px;
    }
  </Style>
</head>

<body>
  
<?php
$numeros = [3, 5, 1, 4, 2];
$n = count($numeros);
echo " [ ".implode(" , ", $numeros)." ] <br>";

for ($i = 0; $i < $n - 1; $i++) {
    $huboIntercambio = false; // Reiniciamos la bandera

    for ($j = 0; $j < $n - $i - 1; $j++) { // ponemos - $i por que ya consideramos que el ultimo esta ordenado
        if ($numeros[$j] > $numeros[$j + 1]) {
            // Intercambio
            $aux = $numeros[$j];
            $numeros[$j] = $numeros[$j + 1];
            $numeros[$j + 1] = $aux;
            
            $huboIntercambio = true; // ¡Marcamos que hubo cambio!
            
            // Visualizar el cambio
            echo " [ ".implode(" , ", $numeros)." ] <br>";
        }
    }

    // Si terminamos una vuelta completa y no hubo cambios,
    // significa que ya está ordenado. Rompemos el bucle.
    if (!$huboIntercambio) {
        break;
    }

}
?>
  
  
</body>

</html>