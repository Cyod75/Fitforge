<?php
session_start();

// Recogemos los datos del formulario
$usuario  = $_POST['usuario'];
$password = $_POST['contraseña'];

// Conexión a la base de datos
$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
if ($mysql->connect_error) {
    die("Conexión fallida: " . $mysql->connect_error);
}

// Usamos consulta preparada para mayor seguridad
$stmt = $mysql->prepare("SELECT id, nombre FROM usuarios WHERE nombre = ? AND clave = ?");
$stmt->bind_param("ss", $usuario, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    // Guardamos en sesión el nombre y el id del usuario
    $_SESSION['usuario']    = $row['nombre'];
    $_SESSION['usuario_id'] = $row['id'];
    header('Location: ../APP/inicio.php');
    exit;
} else {
    // Login fallido
    header('Location: login.php?error=1');
    exit;
}
?>
