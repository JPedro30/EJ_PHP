<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pokeGACHA</title>
    <style>
        body{
            border: 5px solid rgb(0, 27, 62);
            background: rgb(233, 29, 45);
            box-sizing: border-box;
            margin: 0;
        }
        .contenedor{
            border: 5px solid rgb(0, 27, 62);
            border-radius: 500px;
            margin: -240px auto;
            width: 400px;
            height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            padding: 15px;
            background: rgb(255, 255, 255);
            box-sizing: border-box;
        }
        .azul{
            border: 5px solid rgb(0, 27, 62);
            width: 100%;
            height: 100px;
            background: rgb(0, 27, 62);
            margin: 300px auto;
            box-sizing: border-box;
        }
        .blanco{
            border: 5px solid rgb(0, 27, 62);
            width: 1536px;
            height: 342px;
            background: rgb(255, 255, 255);
            margin: 90px auto;
            margin-left: -10px;
            box-sizing: border-box;
        }
        #poke-img{
            width: 60%;
            box-sizing: border-box;
        }
        #buscar{
            border: 3px solid rgb(0, 27, 62);
            font-family: verdana;
            font-size: 15px;
            border-radius: 15px;
            width: 90px;
            height: 50px;
            background: rgb(255, 212, 4);
            box-sizing: border-box;
        }
        h1{
            font-family: verdana;
            font-size: 15px;
            text-transform: capitalize;
        }
    </style>
</head>
<body>

    <div class="azul">

    <div class="blanco">

    <div class="contenedor">

    <?php

    if (isset($_GET['pokemon_id'])) {
        $shiny = false;

        $idBuscado = $_GET['pokemon_id'];

        if (rand(1,10) == 1) {
            $shiny = true;
        }
        
        $apiUrl = "https://pokeapi.co/api/v2/pokemon/" . $idBuscado;

        $respuesta = @file_get_contents($apiUrl);

        $datosPokemon = json_decode($respuesta, true);

        $nombre = $datosPokemon['name'];

        if ($shiny == true) {
            $pokeImg = $datosPokemon['sprites']['other']['official-artwork']['front_shiny'];
            $nombre = $nombre." ⭐";
        } else {
            $pokeImg = $datosPokemon['sprites']['other']['official-artwork']['front_default'];
        }

        echo "<h1>ID: ".$idBuscado."</h1>";
        echo "<h1>Pokemon: ".$nombre."</h1>";
        echo "<img id='poke-img' src=". $pokeImg ." alt=". $nombre .">";
        
    }


    ?>

    <form action="pokeGacha.php" method="get">
        <input hidden type="number" name="pokemon_id" value="<?php echo rand(1, 151); ?>">
        <input type="submit" id="buscar" value="BUSCAR">
    </form>

    </div>
    </div>
    </div>

</body>
</html>