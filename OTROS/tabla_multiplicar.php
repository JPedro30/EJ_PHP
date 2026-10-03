<html>

<head>
  <title>Jose Pedro</title>
  <Style>
    body{
      margin: 0;
      padding: 0;
    }
    .enunciado{
      background: rgb(177, 193, 197);
      font-size: 25;
      color: rgb(98, 127, 142);
      text-align: center;
      padding: 0.1rem;
      margin-bottom: 40px;
      font-family: impact;
      letter-spacing: 4px;
    }
    th{
      font-size: 50px;
      color: white;
      font-family: verdana;
    }
    td{
      padding: 5px;
      margin: 5px;
      text-align: center;

    }
    .contenido{
      position: block;
      width: 800px;
      margin: 0 auto;
      inset: 0;
      
    }
    .tabla{
      float: left;
      margin: 10px;
    }
    .tabla1{
      border: solid 3px rgb(161, 150, 0);
      background-color: rgb(251, 245, 131);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(161, 150, 0);
    }
    .tabla2{
      border: solid 3px rgb(155, 103, 4);
      background-color: rgb(252, 199, 119);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(155, 103, 4);
    }
    .tabla3{
      border: solid 3px rgb(143, 5, 5);
      background-color: rgb(245, 121, 109);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(143, 5, 5);
    }
    .tabla4{
      border: solid 3px rgb(105, 2, 91);
      background-color: rgb(189, 124, 180);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(105, 2, 91);
    }
    .tabla5{
      border: solid 3px rgb(56, 8, 92);
      background-color: rgb(126, 106, 175);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(56, 8, 92);
    }
    .tabla6{
      border: solid 3px rgb(8, 28, 99);
      background-color: rgb(86, 100, 173);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(8, 28, 99);
    }
    .tabla7{
      border: solid 3px rgb(1, 61, 115);
      background-color: rgb(92, 136, 197);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(1, 61, 115);
    }
    .tabla8{
      border: solid 3px rgb(0, 110, 111);
      background-color: rgb(79, 200, 192);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(0, 110, 111);
    }
    .tabla9{
      border: solid 3px rgb(0, 108, 59);
      background-color: rgb(100, 193, 149);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(0, 108, 59);
    }
    .tabla10{
      border: solid 3px rgb(61, 121, 41);
      background-color: rgb(173, 214, 138);
      width: 140px;
      border-radius: 5px;
      box-sizing: border-box;
      font-family: Arial;
      font-size: 22px;
      color: rgb(61, 121, 41);
    }
  </Style>
</head>

<body>
  
  <?php
  
  echo "<div class=enunciado >";
  echo "<h1>";
  echo "TABLA DE MULTIPLICAR";
  echo "</h1>";
  echo "</div>";
  echo "<div class=contenido>";
  for ($factorIzq = 1; $factorIzq <= 10; $factorIzq++) {
  $operador = "x";
  $igual = "=";
  echo "<div class=tabla>";
  if ($factorIzq==1){
    echo "<table class=tabla1>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==2){
    echo "<table class=tabla2>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==3){
    echo "<table class=tabla3>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==4){
    echo "<table class=tabla4>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==5){
    echo "<table class=tabla5>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==6){
    echo "<table class=tabla6>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==7){
    echo "<table class=tabla7>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==8){
    echo "<table class=tabla8>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==9){
    echo "<table class=tabla9>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  if ($factorIzq==10){
    echo "<table class=tabla10>";
    echo "<th>";
    echo $factorIzq;
    echo "</th>";
  }
  for ($factorDer = 1; $factorDer <= 10; $factorDer++) {
    echo "<tr>";
    $resultadoOperacion = $factorIzq*$factorDer;
    echo "<td>";
    echo $factorIzq, $operador, $factorDer, $igual, $resultadoOperacion;
    echo "</td>";
    echo "</tr>";
  }
  echo "</table>";
  echo "</div>";
  }
  echo "</div>";
  ?>
  
  
</body>

</html>