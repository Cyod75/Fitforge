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
  <title>Progreso - FitForge</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/app.css">
  <link rel="stylesheet" href="../CSS/bootstrap.css">
  <script src="../JS/progreso.js"></script>
</head>

<body>

  <div class="sidebar">
    <h4 class="text-center">FitForge</h4>
    <a href="inicio.php"><i class="bi bi-house-door-fill"></i> Inicio</a>
    <a href="rutinas.php"><i class="bi bi-list-check"></i> Rutinas</a>
    <a href="alimentacion.php"><i class="bi bi-egg-fried"></i> Alimentación</a>
    <a href="progreso.php" class="active"><i class="bi bi-bar-chart-fill"></i> Progreso</a>
    <a href="logros.php"><i class="bi bi-trophy-fill"></i> Logros</a>
    <a href="../AUTH/logout.php"><i class="bi bi-door-closed"></i> Salir</a>
  </div>

  <div class="main-content">
    <div class="welcomeRutina">
      <span>¡Monitorea tu <span class="highlight">Progreso Corporal</span>!</span>
    </div>

    <div class="row">
      <!-- Información Personal -->
      <div class="col-md-6 mb-4">
        <div class="glass-card">
          <h5><i class="bi bi-person-fill"></i> Información Personal</h5>
          <p><strong>Edad:</strong> 25 años</p>
          <p><strong>Peso actual:</strong> 75 kg</p>
          <p><strong>Altura:</strong> 1.75 m</p>
          <p><strong>IMC:</strong> 24.5</p>
          <button class="btn btn-glass rounded-pill d-flex align-items-center mt-3">
            <i class="bi bi-pencil-square me-2"></i> Actualizar Datos
          </button>
        </div>
      </div>

      <!-- Mediciones Corporales -->
      <div class="col-md-6 mb-4">
        <div class="glass-card">
          <h5><i class="bi bi-rulers"></i> Mediciones Corporales</h5>
          <p><strong>Bíceps:</strong> 35 cm</p>
          <p><strong>Pecho:</strong> 100 cm</p>
          <p><strong>Cintura:</strong> 80 cm</p>
          <p><strong>Pierna:</strong> 55 cm</p>
          <button class="btn btn-glass rounded-pill d-flex align-items-center mt-3">
            <i class="bi bi-plus-circle me-2"></i> Añadir Medición
          </button>
        </div>
      </div>

      <!-- Objetivos de Progreso -->
      <div class="col-md-6 mb-4">
        <div class="glass-card">
          <h5><i class="bi bi-target"></i> Objetivos de Progreso</h5>
          <p><strong>Objetivo principal:</strong> Reducir grasa corporal al 15%</p>
          <p><strong>Meta secundaria:</strong> Aumentar masa muscular en 5 kg</p>
          <button class="btn btn-glass rounded-pill d-flex align-items-center mt-3">
            <i class="bi bi-pencil-square me-2"></i> Actualizar Objetivos
          </button>
        </div>
      </div>

      <!-- Historial de Mediciones -->
      <div class="col-md-6 mb-4">
        <div class="glass-card">
          <h5><i class="bi bi-clock-history"></i> Historial de Mediciones</h5>
          <p><strong>Bíceps (Marzo):</strong> 34 cm</p>
          <p><strong>Bíceps (Abril):</strong> 35 cm</p>
          <p><strong>Cintura (Marzo):</strong> 81 cm</p>
          <p><strong>Cintura (Abril):</strong> 80 cm</p>
          <button class="btn btn-glass rounded-pill d-flex align-items-center mt-3">
            <i class="bi bi-file-earmark-text me-2"></i> Ver Historial Completo
          </button>
        </div>
      </div>


    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
