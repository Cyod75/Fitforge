<?php
session_start();
$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");

if ($mysql->connect_error) {
    die("Conexión fallida: " . $mysql->connect_error);
}

$usuario = trim($_POST['usuario'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$contraseña = $_POST['contraseña'] ?? '';
$contraseña2 = $_POST['contraseña2'] ?? '';

$error = '';

// Verificar si las contraseñas coinciden
if ($contraseña !== $contraseña2) {
    $_SESSION['error'] = "Las contraseñas no coinciden.";
    header('Location: registro.php');
    exit;
} else {
    // Comprobar si el usuario ya existe
    $res = $mysql->query("SELECT id FROM usuarios WHERE nombre = '$usuario'");
    if ($res->num_rows > 0) {
        $_SESSION['error'] = "El usuario ya existe.";
        header('Location: registro.php');
        exit;
    } else {
        // Encriptar la contraseña
        $contraseña_segura = password_hash($contraseña, PASSWORD_DEFAULT);
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, correo, clave) VALUES ('$usuario', '$correo', '$contraseña_segura')";
        
        if ($mysql->query($sql)) {
            $_SESSION['usuario'] = $usuario;
            header('Location: ../APP/inicio.php');
            exit;
        } else {
            $_SESSION['error'] = "Error al registrar: " . $mysql->error;
            header('Location: registro.php');
            exit;
        }
    }
}
