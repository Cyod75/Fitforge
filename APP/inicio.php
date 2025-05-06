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
  <link href="./CSS/bootstrap.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="./CSS/style.css">
  <style>
    body {
      background: linear-gradient(135deg, #1e1e2f, #12121c);
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      width: 220px;
      height: 100vh;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(8px);
      padding: 2rem 1rem;
      position: fixed;
      left: 0;
      top: 0;
      border-right: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar a {
      display: block;
      color: #fff;
      margin-bottom: 1.2rem;
      text-decoration: none;
      font-weight: 500;
    }

    .sidebar a:hover {
      color: #ff7f32;
    }

    .main-content {
      margin-left: 240px;
      padding: 2rem;
    }

    .glass-card {
      background: rgba(255,255,255,0.07);
      backdrop-filter: blur(10px);
      border-radius: 1rem;
      padding: 1.5rem;
      border: 1px solid rgba(255,255,255,0.1);
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      transition: transform 0.2s ease;
      height: 100%;
    }

    .glass-card:hover {
      transform: scale(1.02);
    }

    .glass-card i {
      font-size: 2rem;
      color: #ff7f32;
    }

    .welcome {
      font-size: 1.9rem;
      font-weight: 600;
      margin-bottom: 2rem;
    }

    .row > div {
      margin-bottom: 1.5rem;
    }

    .highlight {
      color: #ff7f32;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-white mb-4 text-center">FitForge</h4>
    <a href="inicio.html"><i class="bi bi-house-door-fill me-2"></i> Inicio</a>
    <a href="rutinas.html"><i class="bi bi-list-check me-2"></i> Rutinas</a>
    <a href="alimentacion.html"><i class="bi bi-egg-fried me-2"></i> Alimentación</a>
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
