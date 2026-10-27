<?php
session_start();
require_once '../connection/connection.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        $sql = "INSERT INTO usuarios    (email, password, nombre, primer_apellido, segundo_apellido) 
                                VALUES  (:email, :password, :nombre, :primer_apellido, :segundo_apellido)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':email' => $_POST['email'],
            ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ':nombre' => $_POST['nombre'],
            ':primer_apellido' => $_POST['primer_apellido'],
            ':segundo_apellido' => $_POST['segundo_apellido'],
        ]);

        $_SESSION['mensaje'] = "Usuario registrado correctamente.";
        $_SESSION['registrado'] = true;
        header('Location: ../vistas/registro.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Ocurrió un error en la base de datos.";
        $_SESSION['registrado'] = false;
        header('Location: ../vistas/registro.php');
        exit();
    }
} else {
    header('Location: ../vistas/inicio.html');
    exit();
}
?>