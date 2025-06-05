<?php
session_start();
$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");

if ($mysql->connect_error) {
    die("Conexión fallida: " . $mysql->connect_error);
}

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$contraseña = $_POST['contraseña'] ?? '';
$contraseña2 = $_POST['contraseña2'] ?? '';
$rol = $_POST['rol'] ?? 'Usuario'; // Captura el rol enviado desde el formulario

// Guardar los datos del formulario en la sesión para rellenar si hay error
$_SESSION['form_data'] = [
    'nombre' => $nombre,
    'correo' => $correo,
    'rol' => $rol
];

// Validaciones
if (empty($nombre) || empty($correo) || empty($contraseña) || empty($contraseña2)) {
    $_SESSION['error'] = "Todos los campos son obligatorios.";
    header('Location: ../admins.php'); // Redirigir a la página de admin
    exit;
}

if ($contraseña !== $contraseña2) {
    $_SESSION['error'] = "Las contraseñas no coinciden.";
    header('Location: ../admins.php'); // Redirigir a la página de admin
    exit;
}

// Comprobar si el nombre de usuario ya existe
$stmt = $mysql->prepare("SELECT id FROM usuarios WHERE nombre = ?");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $_SESSION['error'] = "El nombre de usuario ya existe.";
    header('Location: ../admins.php'); // Redirigir a la página de admin
    exit;
}
$stmt->close();

// Comprobar si el correo electrónico ya existe
$stmt = $mysql->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $_SESSION['error'] = "El correo electrónico ya está registrado.";
    header('Location: ../admins.php'); // Redirigir a la página de admin
    exit;
}
$stmt->close();

// Encriptar la contraseña
$contraseña_segura = password_hash($contraseña, PASSWORD_DEFAULT);

// Insertar el nuevo usuario en la base de datos, incluyendo el rol
$stmt = $mysql->prepare("INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $correo, $contraseña_segura, $rol);

if ($stmt->execute()) {
    // Éxito: Redirigir a la página de administradores con un mensaje de éxito
    unset($_SESSION['form_data']); // Limpiar los datos del formulario exitosos
    $_SESSION['success_message'] = "Usuario '{$nombre}' creado exitosamente con el rol de '{$rol}'.";
    header('Location: ../admins.php');
    exit;
} else {
    // Error en la inserción
    $_SESSION['error'] = "Error al crear el usuario: " . $stmt->error;
    header('Location: ../admins.php'); // Redirigir a la página de admin
    exit;
}

$stmt->close();
$mysql->close();
?>
