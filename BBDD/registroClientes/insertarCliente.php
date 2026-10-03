<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENTE INSERTADO</title>
    <style>
        h1{
            font-size: 30px;
            text-align: center;
            margin-top: 30px;
            margin-bottom: -80px;
            color: rgb(12, 36, 71);
            letter-spacing: 3px;
        }
        .volver{
            border-radius: 15px;
            border: 2px solid rgb(12, 36, 71);
            background: rgb(216, 226, 241);
            height: 20px;
            width: 100px;
            box-sizing: border-box;
            font-size: 12px;
            color: rgb(12, 36, 71);
            margin: 200px;
            margin-left: 280px;
        }
        body{
            background: rgb(225, 228, 231);
            font-family: verdana;
            font-size: 12px;
        }
        .resultado{
            border-radius: 15px;
            border: 2px solid rgb(12, 36, 71);
            background: rgb(116, 142, 182);
            width: 700px;
            height: 300px;
            margin: 100px auto;
            box-sizing: border-box;
            align-items: center;
            padding-right: 30px;
            padding-left: 10px;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <?php
        
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]{1,50}$/", $_POST['nombre'])) {
            echo "error nombre";
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "error email";
        }

        if (!preg_match("/^@[a-zA-Z]{1}[a-zA-Z0-9_]{3,14}$/", $_POST['twitter'])) {
            echo "error twitter";
        }

        

            $conexion = mysqli_connect("localhost", "root", "", "registroclientes") or die("Problemas con la conexion");

            $password_hasheada = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO clientes (nombre, apellido_1, apellido_2, sexo, direccion, correo, telefono, fecha_nacimiento, poblacion, provincia, contraseña, dni, twitter) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conexion, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssssssssss", 
                    $_POST['nombre'], 
                    $_POST['apellido_1'], 
                    $_POST['apellido_2'], 
                    $_POST['sexo'], 
                    $_POST['direccion'], 
                    $_POST['email'], 
                    $_POST['telefono'], 
                    $_POST['fecha_nacimiento'], 
                    $_POST['poblacion'], 
                    $_POST['provincia'], 
                    $password_hasheada,
                    $_POST['dni'],
                    $_POST['twitter'], 
                );

                mysqli_stmt_execute($stmt) or die("Problemas en el insert: " . mysqli_stmt_error($stmt));
                
                mysqli_stmt_close($stmt);

            } else {
                die("Error al preparar la consulta: " . mysqli_error($conexion));
            }

            mysqli_close($conexion);


        ?>



    <div class="resultado">
    <h1>CLIENTE INSERTADO CORRECTAMENTE</h1>
    <form action="paginaInicio.html" method="post">
    <input type="submit" class="volver" value="VOLVER">
    </form>
    </div>

</body>
</html>