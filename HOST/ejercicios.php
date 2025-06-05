<?php

session_start();
if (!isset($_SESSION['usuario'])) {
  header('location:login.php');
  die();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio - FitForge</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/app.css">
  <link rel="stylesheet" href="../CSS/bootstrap.css">
</head>

<body>

  <div class="sidebar">
    <h4 class="text-center">FitForge</h4>
    <a href="inicio.php"><i class="bi bi-house-door-fill"></i> Inicio</a>
    <a href="ejercicios.php" class="active"><i class="bi bi-list-check"></i> Ejercicios</a>
    <a href="#"><i class="bi bi-egg-fried"></i> Alimentos</a>
    <a href="admins.php"><i class="bi bi-bar-chart-fill"></i> Administradores</a>
    <a href='../AUTH/logout.php'><i class="bi bi-door-closed"></i> Salir</a>
  </div>


  <div class="main-content">
    <div class="welcomeRutina">
      <span>Administración de <span class="highlight">Alimentos</span>!</span>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>