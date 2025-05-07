<?php 

session_start();
if(!isset($_SESSION['usuario'])){
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
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-white mb-4 text-center">FitForge</h4>
    <a href="inicio.php" class="active"><i class="bi bi-house-door-fill me-2"></i> Inicio</a>
    <a href="rutinas.php"><i class="bi bi-list-check me-2"></i> Rutinas</a>
    <a href="#"><i class="bi bi-egg-fried me-2"></i> Alimentación</a>
    <a href="#"><i class="bi bi-bar-chart-fill me-2"></i> Progreso</a>
    <a href="#"><i class="bi bi-trophy-fill me-2"></i> Logros</a>
    <a href = '../AUTH/logout.php'><i class="bi bi-door-closed me-2"></i> Salir</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="welcome">Hola, <span class="highlight"><?php echo $_SESSION['usuario']; ?></span> 👋<br>¡Bienvenido de nuevo a <span class="highlight">FitForge</span>!</div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
      <!-- Tip motivacional -->
      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-lightbulb-fill me-2"></i> Tip del día</h5>
          <p>"El progreso no es siempre visible, pero cada repetición cuenta. 💪"</p>
        </div>
      </div>

      <!-- Anuncio -->
      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-megaphone-fill me-2"></i> Nueva función</h5>
          <p>¡Ya puedes registrar tu progreso con gráficas semanales! Revisa la sección de <strong>Progreso</strong>.</p>
        </div>
      </div>

      <!-- Recordatorio -->
      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-alarm-fill me-2"></i> Entrenamiento pendiente</h5>
          <p>No olvides completar tu rutina de hoy. Tienes programado <strong>Espalda y bíceps</strong>.</p>
        </div>
      </div>

      <!-- Consejo de alimentación -->
      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-egg-fried me-2"></i> Nutrición rápida</h5>
          <p>Un desayuno con proteínas y carbohidratos puede mejorar tu energía en el gimnasio.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
