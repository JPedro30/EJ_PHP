<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ER REGISTRO</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="contenedor">
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="mensaje">
                <h4><?= htmlspecialchars($_SESSION['msg']) ?></h4>
            </div>
        <?php unset($_SESSION['msg']) ?>
        <?php endif ?>
        <div class="formulario">
            <form action="valida_registro.php" method="post">
                <label>Usuario:</label>
                <input type="text" name="usuario" pattern="[a-zA-ZáéíóúÁÉÚÍÓçñÑ][a-zA-ZáéíóúÁÉÚÍÓçñÑªº\s]{4,19}" required><br>
                <label>Sexo:</label>
                <input type="radio" name="sexo" value="H" required>Hombre</input>
                <input type="radio" name="sexo" value="M" required>Mujer</input><br>
                <label>Ciudad:</label>
                <input type="text" name="ciudad" pattern="[a-zA-ZáéíóúÁÉÚÍÓçñÑ][a-zA-ZáéíóúÁÉÚÍÓçñÑªº\s]{4,19}" required><br>
                <label>Email:</label>
                <input type="email" name="email" pattern="[a-zA-ZáéíóúÁÉÚÍÓñÑ]*@cdpjosecabrera.es" required><br>
                <label>DNI:</label>
                <input type="text" name="dni" pattern="\d{8}[AEIOUaeiuo]" required><br>
                <label>Twitter:</label>
                <input type="text" name="twitter" pattern="@[a-zA-ZáéíóúÁÉÚÍÓñÑ]{4,19}" required><br>
                <label>Contraseña:</label>
                <input type="password" name="password" required><br>
                <label>Repite contraseña:</label>
                <input type="password" name="password_repetida" required><br>
                <input type="submit" value="REGISTRAR">
            </form>
        </div>
    </div>
    <a href="index.php"><button>INICIO</button></a>
</body>

</html>