<html>

<head>
  <title>Jose Pedro - Ordenacion Cesar</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

<?php

$texto = $_POST['frase'];
$textoDES = "";
$textoALE = "";
strtolower($texto);

$cifradoDES =  [['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ',',','.'],
                [],
                [],
                []];

if ($_POST['desplazamiento'] == null) {
    $desplazamiento = 0;
}else {
$desplazamiento = $_POST['desplazamiento'];
}
$longitudABC = count($cifradoDES[0]);

for ($contadorABC = 0; $contadorABC < $longitudABC; $contadorABC++) { 
  $nuevoIndice = ($contadorABC + $desplazamiento) % $longitudABC;
  $cifradoDES[1][$contadorABC] = $cifradoDES[0][$nuevoIndice];
}

for ($contadorVAC=0; $contadorVAC < $longitudABC; $contadorVAC++) { 
  $nuevoIndice = ($contadorVAC + $desplazamiento) % $longitudABC;
  $cifradoDES[2][$contadorVAC] = $contadorVAC;
  $cifradoDES[3][$contadorVAC] = $nuevoIndice;
}

for ($contadorTEX = 0; $contadorTEX < strlen($texto); $contadorTEX++) { 
    $letraBuscar = $texto[$contadorTEX];
    for ($contadorLetras = 0; $contadorLetras < $longitudABC; $contadorLetras++) { 
        if ($letraBuscar == $cifradoDES[0][$contadorLetras]) {
            $textoDES[$contadorTEX] = $cifradoDES[1][$contadorLetras];
            break; 
        }
    }
}

echo "<strong>--- ORDENACION CESAR ---</strong><br><br>";
echo "<strong>Texto original: </strong>" . $texto . "<br><br>";
echo "<br><strong> ORDENACION POR DESPLAZAMIENTO</strong><br><br>";
echo "<table class='tabla-cifrado'>";

// 1. Fila de Índices (0, 1, 2...)
echo "<tr>";
echo "<th class='titulo-fila'>Índice</th>";
for ($i = 0; $i < $longitudABC; $i++) {
    echo "<th>$i</th>";
}
echo "</tr>";

// 2. Fila Alfabeto Original
echo "<tr>";
echo "<td class='titulo-fila'>Letra Original</td>";
foreach ($cifradoDES[0] as $letra) {
    echo "<td>$letra</td>";
}
echo "</tr>";

// 3. Fila Nueva Posición (A dónde va la letra)
echo "<tr>";
echo "<td class='titulo-fila'>Indice nueva letra ( ".$desplazamiento." pos )</td>";
foreach ($cifradoDES[3] as $pos) {
    echo "<td><strong>$pos</strong></td>";
}
echo "</tr>";

// 4. Fila Alfabeto Cifrado (Resultado)
echo "<tr>";
echo "<td class='titulo-fila'>Letra Cifrada</td>";
foreach ($cifradoDES[1] as $letraCifrada) {
    echo "<td>$letraCifrada</td>";
}
echo "</tr>";

echo "</table>";

// 5. MUESTRO EL TEXTO
echo "<br><strong>Texto cifrado por desplazamiento fijo : </strong>".$textoDES."<br><br>";

$cifradoALE =  [['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ',',','.'],
                [],
                []];

// aqui relleno de 0 a 28
for ($contadorALE=0; $contadorALE < $longitudABC; $contadorALE++) { 
  $cifradoALE[1][$contadorALE] = $contadorALE;
}
// lo barajo
shuffle($cifradoALE[1]);

// muevo la letra segun el nuevo indice y las ordeno
for ($contadorPOS=0; $contadorPOS < $longitudABC; $contadorPOS++) { 
  $cifradoALE[2][$cifradoALE[1][$contadorPOS]] = $cifradoALE[0][$contadorPOS];
}              

// y aqui busco la letra en el texto y la sustituyo por la letra ya cifrada
for ($contadorTEX = 0; $contadorTEX < strlen($texto); $contadorTEX++) { 
    $letraBuscar = $texto[$contadorTEX];
    for ($contadorLetras = 0; $contadorLetras < $longitudABC; $contadorLetras++) { 
        if ($letraBuscar == $cifradoALE[0][$contadorLetras]) {
            $textoALE[$contadorTEX] = $cifradoALE[2][$contadorLetras];
            break; 
        }
    }
}

// aqui es para que se vean ordenadas ese array, por que como arriba se van enviando de a b c, llegan igual aunque su indice sea distinto
ksort($cifradoALE[2]);

echo "<br><br><strong> ORDENACION POR POSICION ALEATORIA</strong><br><br>";
echo "<table class='tabla-cifrado'>";

// 1. Fila de Índices (0, 1, 2...)
echo "<tr>";
echo "<th class='titulo-fila'>Índice</th>";
for ($i = 0; $i < $longitudABC; $i++) {
    echo "<th>$i</th>";
}
echo "</tr>";

// 2. Fila Alfabeto Original
echo "<tr>";
echo "<td class='titulo-fila'>Letra Original</td>";
foreach ($cifradoALE[0] as $letra) {
    echo "<td>$letra</td>";
}
echo "</tr>";

// 3. Fila Nueva Posición (A dónde va la letra)
echo "<tr>";
echo "<td class='titulo-fila'>Nueva Posición</td>";
foreach ($cifradoALE[1] as $pos) {
    echo "<td><strong>$pos</strong></td>";
}
echo "</tr>";

// 4. Fila Alfabeto Cifrado (Resultado)
echo "<tr>";
echo "<td class='titulo-fila'>Letra Cifrada</td>";
foreach ($cifradoALE[2] as $letraCifrada) {
    echo "<td>$letraCifrada</td>";
}
echo "</tr>";

echo "</table>";

// 5. MUESTRO EL TEXTO
echo "<br><strong>Texto cifrado por posicion aleatorio : </strong>".$textoALE;

?>  
  
</body>

</html>