<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:login.php');
    die();
}

// Conexión directa
$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
if ($mysql->connect_error) {
    die("Error de conexión: " . $mysql->connect_error);
}

// Obtener ID de usuario
$usuario = $mysql->real_escape_string($_SESSION['usuario']);
$res = $mysql->query("SELECT id FROM usuarios WHERE nombre = '$usuario'");
$row  = $res->fetch_assoc();
$id_usuario = $row['id'] ?? die("Error: Usuario no encontrado.");

// Cargar lista de ejercicios
$lista_ejercicios = [];
$res = $mysql->query("SELECT id, nombre FROM ejercicios");
while ($r = $res->fetch_assoc()) {
    $lista_ejercicios[] = $r;
}

// Cargar rutinas por día
$rutinas_por_dia = [];
$ejercicios_unicos = [];
$sql = "
  SELECT r.id AS rutina_id, r.dia_semana, e.nombre AS ejercicio, r.intensidad
    FROM rutinas r
    JOIN ejercicios e ON r.ejercicio_id = e.id
   WHERE r.usuario_id = $id_usuario
";
$res = $mysql->query($sql);
while ($r = $res->fetch_assoc()) {
    $rutinas_por_dia[$r['dia_semana']][] = $r;
    $ejercicios_unicos[$r['rutina_id']]  = true;
}

$dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

// Calcular cuántos días tienen al menos un ejercicio
$dias_con_ejercicios = 0;
foreach ($dias as $d) {
    if (!empty($rutinas_por_dia[$d])) {
        $dias_con_ejercicios++;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rutinas - FitForge</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/app.css">
  <link rel="stylesheet" href="../CSS/bootstrap.css">
</head>
<body>
  <div class="sidebar">
    <h4 class="text-center">FitForge</h4>
    <a href="inicio.php"><i class="bi bi-house-door-fill"></i> Inicio</a>
    <a href="rutinas.php" class="active"><i class="bi bi-list-check"></i> Rutinas</a>
    <a href="alimentacion.php"><i class="bi bi-egg-fried"></i> Alimentación</a>
    <a href="progreso.php"><i class="bi bi-bar-chart-fill"></i> Progreso</a>
    <a href="logros.php"><i class="bi bi-trophy-fill"></i> Logros</a>
    <a href="../AUTH/logout.php"><i class="bi bi-door-closed"></i> Salir</a>
  </div>

  <div class="main-content">
    <div class="welcomeRutina mb-4">
      <span>¡Organiza tu <span class="highlight">Rutina Semanal</span>!</span>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($dias as $dia_semana): ?>
      <div class="col">
        <div class="glass-card position-relative h-100">
          <button
            type="button"
            class="bi bi-plus-circle icono-derecha position-absolute top-0 end-0 m-2"
            data-bs-toggle="modal"
            data-bs-target="#modalRutina"
            data-dia="<?= $dia_semana ?>">
          </button>
          <h5><i class="bi bi-calendar2-check"></i> <?= $dia_semana ?></h5>

          <?php if (!empty($rutinas_por_dia[$dia_semana])): ?>
            <ul>
              <?php foreach ($rutinas_por_dia[$dia_semana] as $rutina): ?>
              <li>
                <?= $rutina['ejercicio'] ?> 
                <strong><?= $rutina['intensidad'] ?></strong>
                <a
                  href="../FUNCIONES/rutinas_sql.php?opcion=eliminar&id=<?= $rutina['rutina_id'] ?>"
                  class="btn btn-link p-0 text-danger"
                >
                  <i class="bi bi-x"></i>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p>No hay ejercicios asignados.</p>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>

      <?php
      $resto = count($dias) % 3;
      if ($resto !== 0):
        for ($i = 0, $faltan = 3 - $resto; $i < $faltan; $i++):
          echo '<div class="col"></div>';
        endfor;
      endif;
      ?>
    </div>

    <div class="glass-card mt-5">
      <h4><i class="bi bi-graph-up"></i> Resumen de la Semana</h4>
      <p>Días con Ejercicios: <strong><?= $dias_con_ejercicios ?></strong></p>
      <p>Ejercicios en Rutina: <strong><?= count($ejercicios_unicos) ?></strong></p>
    </div>
  </div>

  <!-- Modal Rutina -->
  <div class="modal fade" id="modalRutina" tabindex="-1" aria-labelledby="modalRutinaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content glass-card">

        <form method="POST" action="../FUNCIONES/rutinas_sql.php?opcion=insertar">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalRutinaLabel" style="color:white">
              Agregar Rutina
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" style="color:white">
            <input type="hidden" name="usuario_id" value="<?= $id_usuario ?>">
            <input type="hidden" name="dia_semana" id="diaSemanaInput">
            <div class="mb-3">
              <label for="ejercicio" class="form-label">Ejercicio</label>
              <select name="ejercicio_id" id="ejercicio" class="form-select" required>
                <?php foreach ($lista_ejercicios as $ej): ?>
                <option value="<?= $ej['id'] ?>">
                  <?= $ej['nombre'] ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="intensidad" class="form-label">Intensidad</label>
              <select name="intensidad" id="intensidad" class="form-select" required>
                <option value="3x12">3x12</option>
                <option value="3x8">3x8</option>
                <option value="4x10">4x10</option>
                <option value="4x12">4x12</option>
                <option value="5x5">5x5</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Cancelar
            </button>
            <button type="submit" class="btn btn-guardar">
              Guardar
            </button>
          </div>
        </form>
        
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('modalRutina')
      .addEventListener('show.bs.modal', e => {
        const dia = e.relatedTarget.getAttribute('data-dia');
        document.getElementById('diaSemanaInput').value = dia;
        document.getElementById('modalRutinaLabel')
          .textContent = 'Agregar Rutina – ' + dia;
      });
  </script>
</body>
</html>
