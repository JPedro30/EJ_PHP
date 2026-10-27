<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de Distancia</title>
</head>

<body>

    <?php

    // Coordenadas iniciales (centro)
    $latActual = 36.866329;
    $lonActual = -6.178427;

    // Coordenadas de destino (casa)
    $latCasa = 36.92487250408473;
    $lonCasa = -6.083891507937564;

    // Ejecución de la función
    $distancia = calcularDistancia($latActual, $lonActual, $latCasa, $lonCasa);

    function calcularDistancia(float $latActual, float $lonActual, float $latCasa, float $lonCasa)
    {
        $R = 6371; // Radio de la Tierra en km

        // Diferencias convertidas a radianes
        $diffLat = deg2rad($latCasa - $latActual);
        $diffLon = deg2rad($lonCasa - $lonActual);

        $latActualRad = deg2rad($latActual);
        $latCasaRad = deg2rad($latCasa);

        // Fórmula Haversine
        $a = sin($diffLat / 2) * sin($diffLat / 2) +
            sin($diffLon / 2) * sin($diffLon / 2) *
            cos($latActualRad) * cos($latCasaRad);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }


    ?>

    <div id="resultado">
        <h3>La distancia que hay hasta mi casa es: <?= number_format($distancia, 2) ?> km</h3>
    </div>

</body>

</html>