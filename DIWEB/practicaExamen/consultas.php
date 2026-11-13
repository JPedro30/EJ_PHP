<?php
require_once("connection.php");

$ciudades = [];
$usuarios = [];

$filtro_usuario = trim($_GET['filtro_usuario'] ?? '');
$filtro_ciudad = trim($_GET['filtro_ciudad'] ?? '');
$filtro_sexo = trim($_GET['filtro_sexo'] ?? '');

$sqlCiudades = "SELECT DISTINCT ciudad FROM usuarios";
$stmtCiudades = $pdo->prepare($sqlCiudades);
$stmtCiudades->execute();
$resultadoCiudades = $stmtCiudades->fetchAll();

foreach ($resultadoCiudades as $dato) {
    $ciudades[] = $dato['ciudad'];
}

$sqlConsulta = "SELECT id_usuario, usuario, sexo, ciudad, dni, email, twitter FROM usuarios";
$sqlPlus = [];
$parametros = [];

if (!empty($filtro_usuario)) {
    $sqlPlus[] = " usuario LIKE :usuario";
    $parametros[':usuario'] = "%" . $filtro_usuario . "%";
}

if (!empty($filtro_ciudad)) {
    $sqlPlus[] = " ciudad = :ciudad";
    $parametros[':ciudad'] = $filtro_ciudad;
}

if (!empty($filtro_sexo)) {
    $sqlPlus[] = " sexo = :sexo";
    $parametros[':sexo'] = $filtro_sexo;
}

if (!empty($sqlPlus)) {
    $sqlConsulta .= " WHERE " . implode(" AND", $sqlPlus);
}

$stmtConsulta = $pdo->prepare($sqlConsulta);
$stmtConsulta->execute($parametros);
$usuarios = $stmtConsulta->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTADO</title>
</head>
<style>
    td {
        padding: 20px;
    }
</style>

<body>
    <hr>
    <div class="contenedor" align="center">
        <form action="consultas.php" method="get">
            <input type="text" name="filtro_usuario" placeholder="Usuario">
            <select name="filtro_ciudad">
                <option value="">Seleccione una ciudad</option>
                <?php foreach ($ciudades as $ciudad): ?>
                    <option><?php echo ($ciudad) ?></option>
                <?php endforeach ?>
            </select>
            <input type="radio" value="H" name="filtro_sexo">Hombre</input>
            <input type="radio" value="M" name="filtro_sexo">Mujer</input>
            <input type="submit" value="BUSCAR">
        </form>
    </div>
    <hr>
    <div class="listado">
        <table style="width: 800px; margin: 50px auto; border: 2px solid black; border-collapse:collapse;">
            <tr>
                <th>USUARIO</th>
                <th>SEXO</th>
                <th>CIUDAD</th>
                <th>DNI</th>
                <th>EMAIL</th>
                <th>TWITTER</th>
                <th>ACCIONES</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo ($usuario['usuario']) ?></td>
                    <td><?php echo ($usuario['sexo']) ?></td>
                    <td><?php echo ($usuario['ciudad']) ?></td>
                    <td><?php echo ($usuario['dni']) ?></td>
                    <td><?php echo ($usuario['email']) ?></td>
                    <td><?php echo ($usuario['twitter']) ?></td>
                    <td><a href="borrar_usuario.php?id_usuario=<?php echo ($usuario['id_usuario']) ?>"><button>BORRAR</button></a></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <hr>
    <a href="index.php"><button>INICIO</button></a>
    <hr>
</body>

</html>