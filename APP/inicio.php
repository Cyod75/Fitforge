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
    <a href="inicio.php" class="active"><i class="bi bi-house-door-fill"></i> Inicio</a>
    <a href="rutinas.php"><i class="bi bi-list-check"></i> Rutinas</a>
    <a href="alimentacion.php"><i class="bi bi-egg-fried"></i> Alimentación</a>
    <a href="progreso.php"><i class="bi bi-bar-chart-fill"></i> Progreso</a>
    <a href="logros.php"><i class="bi bi-trophy-fill"></i> Logros</a>
    <a href='../AUTH/logout.php'><i class="bi bi-door-closed"></i> Salir</a>
  </div>


  <div class="main-content">
    <div class="welcome">Hola, <span class="highlight"><?php echo $_SESSION['usuario']; ?></span> 👋<br>¡Bienvenido de nuevo a <span class="highlight">FitForge</span>!</div>

    <div class="row row-cols-1 row-cols-md-2 g-4">

      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-lightbulb-fill me-2"></i> Tip del día</h5>
          <p>"El progreso no es siempre visible, pero cada repetición cuenta. 💪"</p>
        </div>
      </div>

      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-megaphone-fill me-2"></i> Nueva función</h5>
          <p>¡Ya puedes registrar tu progreso con gráficas semanales! Revisa la sección de <strong>Progreso</strong>.</p>
        </div>
      </div>

      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-alarm-fill me-2"></i> Entrenamiento pendiente</h5>
          <p>No olvides completar tu rutina de hoy. Tienes programado <strong>Espalda y bíceps</strong>.</p>
        </div>
      </div>

      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-egg-fried me-2"></i> Nutrición rápida</h5>
          <p>Un desayuno con proteínas y carbohidratos puede mejorar tu energía en el gimnasio.</p>
        </div>
      </div>

      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-chat-left-text-fill me-2"></i> Consejo motivacional</h5>
          <p>"Recuerda que el progreso lleva tiempo. No se trata de ser perfecto, sino de ser constante. ¡Sigue adelante! 🌟"</p>
        </div>
      </div>



      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-arrow-repeat me-2"></i> Acción del día</h5>
          <p>"El éxito no es un accidente, es una decisión. ¡Haz que hoy cuente con un entrenamiento efectivo! 🚀"</p>
        </div>
      </div>




      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-trophy-fill me-2"></i> Meta del mes</h5>
          <p>Este mes, trabaja en tu resistencia. ¡Pon un objetivo de 5 km corriendo y supéralo! 🏅</p>
        </div>
      </div>



      <div class="col">
        <div class="glass-card">
          <h5><i class="bi bi-lightning-fill me-2"></i> Tip rápido</h5>
          <p>"No te rindas. Las grandes cosas toman tiempo, pero los pequeños logros cuentan cada día. 💪"</p>
        </div>
      </div>




    </div>
  </div>
</body>

</html>