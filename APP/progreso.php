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
    <a href="rutinas.php"><i class="bi bi-list-check"></i> Rutinas</a>
    <a href="alimentacion.php"><i class="bi bi-egg-fried"></i> Alimentación</a>
    <a href="progreso.php" class="active"><i class="bi bi-bar-chart-fill"></i> Progreso</a>
    <a href="logros.php"><i class="bi bi-trophy-fill"></i> Logros</a>
    <a href='../AUTH/logout.php'><i class="bi bi-door-closed"></i> Salir</a>
  </div>


  <div class="main-content">
    <div class="welcomeRutina">
      <span>A tope con tu <span class="highlight">Progreso</span>!</span>
    </div>


    <!-- <div class="row">
      <div>
        <div class="glass-card">
          <h5><i class="bi bi-calendar2-check"></i> Lunes</h5>
          <p>...</p>
        </div>
      </div>

      <div>
        <div class="glass-card">
          <h5><i class="bi bi-calendar2-check"></i> Martes</h5>
          <p>...</p>
        </div>
      </div>

      <div>
        <div class="glass-card">
          <h5><i class="bi bi-calendar2-check"></i> Miércoles</h5>
          <p>...</p>
        </div>
      </div>

      <div>
        <div class="glass-card">
          <h5><i class="bi bi-calendar2-check"></i> Jueves</h5>
          <p>...</p>
        </div>
      </div>

      <div>
        <div class="glass-card">
          <h5><i class="bi bi-calendar2-check"></i> Viernes</h5>
          <p>...</p>
        </div>
      </div>

      <div>
        <div class="glass-card">
          <h5><i class="bi bi-calendar2-check"></i> Sábado</h5>
          <p>...</p>
        </div>
      </div>

      <div>
        <div class="glass-card">
          <h5><i class="bi bi-calendar2-check"></i> Domingo</h5>
          <p>...</p>
        </div>
      </div>
    </div>
  </div> -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>