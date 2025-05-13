<?php
session_start();

$usuario  = $_POST['usuario'] ?? '';
$password = $_POST['contraseña'] ?? '';

$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
if ($mysql->connect_error) {
    die("Conexión fallida: " . $mysql->connect_error);
}

// Buscar usuario por nombre
$query = "SELECT id, nombre, clave FROM usuarios WHERE nombre = '$usuario'";
$res = $mysql->query($query);

if ($res && $res->num_rows === 1) {
    $row = $res->fetch_assoc();

    // Verificar contraseña encriptada
    if (password_verify($password, $row['clave'])) {
        $_SESSION['usuario']    = $row['nombre'];
        $_SESSION['usuario_id'] = $row['id'];
        header('Location: ../APP/inicio.php');
        exit;
    }
}

// Redirigir con el error genérico
header('Location: login.php?error=1');
exit;
?>
