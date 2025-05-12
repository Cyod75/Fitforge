<?php
session_start();
$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
if (isset($_SESSION['usuario'])) {
  header('Location:../APP/inicio.php');
  exit;
}
//Comprobar Conexion MYSQL
if ($mysql->connect_error) {
  die("Conexión fallida: " . $mysql->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión - FitForge</title>
  <link href="../CSS/bootstrap.css" rel="stylesheet">
  <link href="../CSS/style.css" rel="stylesheet">
</head>
<body>

  <div class="glass-card">
    <img src="../IMG/logo.png" alt="FitForge Logo" class="logo">
    <h2 class="text-center mb-4">Crea tu Cuenta de FitForge</h2>

    <form action="checkLogin.php" method="POST">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
        <label for="usuario">Usuario</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo" required>
        <label for="correo">Correo</label>
      </div>

      <div class="form-floating mb-4">
        <input type="password" class="form-control" id="contraseña1" name="contraseña" placeholder="Contraseña" required>
        <label for="contraseña">Contraseña</label>
      </div>

      <div class="form-floating mb-4">
        <input type="password" class="form-control" id="contraseña2" name="contraseña2" placeholder="Contraseña" required>
        <label for="contraseña2">Confirmar Contraseña</label>
      </div>

      <button type="submit" class="btn btn-custom text-white  ">Crear Cuenta</button>
    </form>
    
    <p class="text-center mb-0">
      ¿Ya tienes una cuenta?
      <a href="../AUTH/login.php" class="text-link" style="color: #ff7f32;">Iniciar Sesión</a>
    </p>
  </div>

</body>
</html>
