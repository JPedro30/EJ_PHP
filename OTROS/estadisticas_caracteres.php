<html>

<head>
  <title>Jose Pedro - Estadisticas de Caracteres</title>
  <Style>
    body{
      margin: 10px;
      padding: 10px;
    }
  </Style>
</head>

<body>
  
  <?php
  $texto = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non
  urna neque. Ut euismod aliquet orci, sed finibus nisi. Integer
  sollicitudin, mauris sit amet lacinia dictum, tortor sem ornare est, ac
  facilisis velit purus eu sapien. Nullam accumsan aliquet felis, at porta
  purus aliquam ut. Etiam vitae ante augue. Donec a orci nunc. Vestibulum
  est metus, maximus eget dolor non, pulvinar hendrerit enim. In semper,
  ligula in egestas finibus, lacus mauris elementum justo, nec commodo
  ante mi quis eros. Nunc ultrices neque vitae nisi finibus, nec semper
  massa dignissim. Duis augue dolor, pretium molestie ex non, convallis
  viverra felis. Sed tincidunt magna nulla, ut tristique lorem dapibus
  vitae. Praesent eu leo lobortis, rutrum lorem in, dictum erat. Phasellus
  semper eros ut ipsum vulputate, vel pulvinar velit ornare.

  Sed euismod libero ac nibh finibus, vel sagittis tortor molestie.
  Integer tempor, purus eu finibus semper, ipsum augue tincidunt quam, in
  congue elit arcu non diam. Vestibulum sed quam aliquam, egestas tellus
  quis, molestie augue. Phasellus nec consequat metus. Aliquam sodales
  eget tortor eget suscipit. Nulla vitae vestibulum tortor. Ut auctor ex
  quis urna ultrices ultricies. Mauris facilisis velit vitae rhoncus
  volutpat. Aliquam cursus fringilla pretium.
  
  Mauris aliquet, justo eget imperdiet viverra, arcu ipsum pellentesque
  risus, eu tincidunt tellus neque vel magna. In pulvinar tortor ex, in
  mattis dui vulputate id. Pellentesque in egestas nibh. Nullam et semper
  enim. Quisque pulvinar elit eget ultricies euismod. Proin eleifend
  finibus tincidunt. Curabitur nibh turpis, tempor et faucibus eget,
  ornare sit amet diam. Vestibulum ante ipsum primis in faucibus orci
  luctus et ultrices posuere cubilia curae; Sed ac porta risus."; //texto
  
  $letras = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ.,"; //abecedario

  for ($cont=0; $cont < strlen($letras); $cont++) { 
    $contadorletras[$cont] = 0; //inicio contador de cada letra a 0
  }

  for ($cont1=0; $cont1 < strlen($texto); $cont1++) { //recorro todo el texto
    $letra = $texto[$cont1]; //saco cada caracter del texto en minuscula
    for ($cont2=0; $cont2 < strlen($letras); $cont2++) { //recorro todo el abecedario
      if ($letra == $letras[$cont2]) { //comparo la letra que he sacado antes, con la letra del abecedario
        $contadorletras[$cont2]++; // si coincide al contador de la letra encontrada le sumo 1
      }
    }
  }

  $contadorletrasordenado = $contadorletras;

  echo $texto;
  echo "<br><br>";

  for ($cont4=0; $cont4 < strlen($letras); $cont4++) { 

    $valormax = -1;
    $nummax = -1;

    for ($cont3=0; $cont3 < strlen($letras); $cont3++) { 
      if ($contadorletrasordenado[$cont3]>$nummax) {
        $valormax = $cont3;
        $nummax=$contadorletrasordenado[$cont3];
      }
    }

    // DESCOMENTAR ESTE SI QUIERO QUE APAREZCAN LOS CARACTERES CON 0 (NO APARECEN)
    /* echo "- Letra ".$letras[$valormax]." : ".$contadorletras[$valormax]." caracteres.<br>";
    $contadorletras[$valormax] = -1; */

    if ($contadorletras[$valormax]>0) { // DEJAR ESTE SI QUIERO QUE SOLO APAREZCAN LOS CARACTERES QUE EXISTEN EN EL TEXTO
      echo "- Letra ".$letras[$valormax]." : ".$contadorletrasordenado[$valormax]." caracteres.<br>";
      $contadorletrasordenado[$valormax] = -1;
    }
    
  }

  /* echo $texto; //muestro el texto
  echo "<br><br>";
  echo "Hay un total de ".strlen($texto)." letras en el texto (repartidas de la siguiente forma) :<br><br>";
  for ($cont3=0; $cont3 < strlen($letras); $cont3++) { //vuelvo a recorrer el abecedario
    echo "- Letra ".$letras[$cont3]." : ".$contadorletras[$cont3]." caracteres.<br>"; //muestro cada letra con el contador propio
  } */

  ?>
  
  
</body>

</html>