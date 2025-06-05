<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:login.php');
    die();
}

$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
if ($mysql->connect_error) {
    die("Error de conexión: " . $mysql->connect_error);
}

$nombre_usuario_session = $mysql->real_escape_string($_SESSION['usuario']);
$res_usuario = $mysql->query("SELECT id FROM usuarios WHERE nombre = '$nombre_usuario_session'");
if ($res_usuario && $res_usuario->num_rows > 0) {
    $row_usuario = $res_usuario->fetch_assoc();
    $id_usuario = $row_usuario['id'];
} else {
    die("Error: Usuario no encontrado en la base de datos.");
}

$progreso_actual = null;
$progreso_anterior = null;

$stmt_progreso = $mysql->prepare("SELECT peso, altura, biceps, pecho, cintura, pierna, imc, DATE_FORMAT(fecha, '%M %Y') as mes_medicion FROM progreso_fisico WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 2");
if ($stmt_progreso) {
    $stmt_progreso->bind_param("i", $id_usuario);
    $stmt_progreso->execute();
    $result_progreso = $stmt_progreso->get_result();
    if ($result_progreso->num_rows > 0) {
        $progreso_actual = $result_progreso->fetch_assoc();
    }
    if ($result_progreso->num_rows > 1) {
        $progreso_anterior = $result_progreso->fetch_assoc();
    }
    $stmt_progreso->close();
}

// Simplified display variables without htmlspecialchars
$display_peso = $progreso_actual && $progreso_actual['peso'] !== null ? $progreso_actual['peso'] . " kg" : "No registrado";
$display_altura = $progreso_actual && $progreso_actual['altura'] !== null ? $progreso_actual['altura'] . " m" : "No registrado";
$display_imc = $progreso_actual && $progreso_actual['imc'] !== null ? $progreso_actual['imc'] : "No calculado";

$display_biceps = $progreso_actual && $progreso_actual['biceps'] !== null ? $progreso_actual['biceps'] . " cm" : "No registrado";
$display_pecho = $progreso_actual && $progreso_actual['pecho'] !== null ? $progreso_actual['pecho'] . " cm" : "No registrado";
$display_cintura = $progreso_actual && $progreso_actual['cintura'] !== null ? $progreso_actual['cintura'] . " cm" : "No registrado";
$display_pierna = $progreso_actual && $progreso_actual['pierna'] !== null ? $progreso_actual['pierna'] . " cm" : "No registrado";

$hist_biceps_actual_val = $progreso_actual && $progreso_actual['biceps'] !== null ? $progreso_actual['biceps'] . " cm" : "N/A";
$hist_biceps_actual_mes = $progreso_actual ? " (" . ($progreso_actual['mes_medicion'] ?? 'Fecha Reciente') . ")" : "";

$hist_biceps_anterior_val = $progreso_anterior && $progreso_anterior['biceps'] !== null ? $progreso_anterior['biceps'] . " cm" : "N/A";
$hist_biceps_anterior_mes = $progreso_anterior ? " (" . ($progreso_anterior['mes_medicion'] ?? 'Fecha Anterior') . ")" : "";

$hist_cintura_actual_val = $progreso_actual && $progreso_actual['cintura'] !== null ? $progreso_actual['cintura'] . " cm" : "N/A";
$hist_cintura_actual_mes = $progreso_actual ? " (" . ($progreso_actual['mes_medicion'] ?? 'Fecha Reciente') . ")" : "";

$hist_cintura_anterior_val = $progreso_anterior && $progreso_anterior['cintura'] !== null ? $progreso_anterior['cintura'] . " cm" : "N/A";
$hist_cintura_anterior_mes = $progreso_anterior ? " (" . ($progreso_anterior['mes_medicion'] ?? 'Fecha Anterior') . ")" : "";

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
      <div class="col-md-6 mb-4">
        <div class="glass-card">
          <h5><i class="bi bi-person-fill"></i> Información Personal</h5>
          <p><strong>Peso actual:</strong> <?= $display_peso ?></p>
          <p><strong>Altura:</strong> <?= $display_altura ?></p>
          <p><strong>IMC:</strong> <?= $display_imc ?></p>
          <button class="btn btn-glass rounded-pill d-flex align-items-center mt-3" data-bs-toggle="modal" data-bs-target="#modalActualizarDatos">
            <i class="bi bi-pencil-square me-2"></i> Actualizar Datos
          </button>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="glass-card">
          <h5><i class="bi bi-rulers"></i> Mediciones Corporales</h5>
          <p><strong>Bíceps:</strong> <?= $display_biceps ?></p>
          <p><strong>Pecho:</strong> <?= $display_pecho ?></p>
          <p><strong>Cintura:</strong> <?= $display_cintura ?></p>
          <p><strong>Pierna:</strong> <?= $display_pierna ?></p>
          <button class="btn btn-glass rounded-pill d-flex align-items-center mt-3" data-bs-toggle="modal" data-bs-target="#modalAnadirMedicion">
            <i class="bi bi-plus-circle me-2"></i> Añadir Medición
          </button>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="glass-card">
          <h5><i class="bi bi-target"></i> Objetivos de Progreso</h5>
          <p><strong>Objetivo principal:</strong> <span id="displayObjetivoPrincipal">No definido</span></p>
          <p><strong>Meta secundaria:</strong> <span id="displayMetaSecundaria">No definida</span></p>
          <button class="btn btn-glass rounded-pill d-flex align-items-center mt-3" data-bs-toggle="modal" data-bs-target="#modalActualizarObjetivos">
            <i class="bi bi-pencil-square me-2"></i> Actualizar Objetivos
          </button>
        </div>
      </div>

        <div class="col-md-6 mb-4">
            <div class="glass-card">
                <h5><i class="bi bi-clock-history"></i> Historial de Mediciones Recientes</h5>
                <?php if ($progreso_actual && $progreso_anterior): ?>
                    <p><strong>Bíceps (Anterior<?= $hist_biceps_anterior_mes ?>):</strong> <?= $hist_biceps_anterior_val ?></p>
                    <p><strong>Bíceps (Reciente<?= $hist_biceps_actual_mes ?>):</strong> <?= $hist_biceps_actual_val ?></p>
                    <p><strong>Cintura (Anterior<?= $hist_cintura_anterior_mes ?>):</strong> <?= $hist_cintura_anterior_val ?></p>
                    <p><strong>Cintura (Reciente<?= $hist_cintura_actual_mes ?>):</strong> <?= $hist_cintura_actual_val ?></p>
                <?php elseif ($progreso_actual): ?>
                     <p><strong>Bíceps (Reciente<?= $hist_biceps_actual_mes ?>):</strong> <?= $hist_biceps_actual_val ?></p>
                     <p><strong>Cintura (Reciente<?= $hist_cintura_actual_mes ?>):</strong> <?= $hist_cintura_actual_val ?></p>
                     <p>No hay datos anteriores para comparar.</p>
                <?php else: ?>
                    <p>No hay historial de mediciones disponible.</p>
                <?php endif; ?>
                <button class="btn btn-glass rounded-pill d-flex align-items-center mt-3" data-bs-toggle="modal" data-bs-target="#modalHistorialCompleto">
                    <i class="bi bi-file-earmark-text me-2"></i> Ver Historial Completo
                </button>
            </div>
        </div>
    </div>
  </div>

  <div class="modal fade" id="modalActualizarDatos" tabindex="-1" aria-labelledby="modalActualizarDatosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content glass-card">
        <form method="POST" action="../FUNCIONES/progreso_sql.php">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalActualizarDatosLabel" style="color:white">Actualizar Datos Personales</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="color:white">
            <input type="hidden" name="usuario_id" value="<?= $id_usuario ?>">
            <input type="hidden" name="accion" value="actualizar_personales">
            <div class="mb-3">
              <label for="peso" class="form-label">Peso (kg)</label>
              <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="<?= $progreso_actual['peso'] ?? '' ?>">
            </div>
            <div class="mb-3">
              <label for="altura" class="form-label">Altura (m)</label>
              <input type="number" step="0.01" class="form-control" id="altura" name="altura" value="<?= $progreso_actual['altura'] ?? '' ?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-guardar">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalAnadirMedicion" tabindex="-1" aria-labelledby="modalAnadirMedicionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content glass-card">
        <form method="POST" action="../FUNCIONES/progreso_sql.php">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalAnadirMedicionLabel" style="color:white">Añadir/Actualizar Mediciones Corporales</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="color:white">
            <input type="hidden" name="usuario_id" value="<?= $id_usuario ?>">
            <input type="hidden" name="accion" value="registrar_mediciones">
            <div class="mb-3">
              <label for="biceps" class="form-label">Bíceps (cm)</label>
              <input type="number" step="0.1" class="form-control" id="biceps" name="biceps" value="<?= $progreso_actual['biceps'] ?? '' ?>">
            </div>
            <div class="mb-3">
              <label for="pecho" class="form-label">Pecho (cm)</label>
              <input type="number" step="0.1" class="form-control" id="pecho" name="pecho" value="<?= $progreso_actual['pecho'] ?? '' ?>">
            </div>
            <div class="mb-3">
              <label for="cintura" class="form-label">Cintura (cm)</label>
              <input type="number" step="0.1" class="form-control" id="cintura" name="cintura" value="<?= $progreso_actual['cintura'] ?? '' ?>">
            </div>
            <div class="mb-3">
              <label for="pierna" class="form-label">Pierna (cm)</label>
              <input type="number" step="0.1" class="form-control" id="pierna" name="pierna" value="<?= $progreso_actual['pierna'] ?? '' ?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-guardar">Guardar Mediciones</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalActualizarObjetivos" tabindex="-1" aria-labelledby="modalActualizarObjetivosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content glass-card">
        <form method="POST" action="../FUNCIONES/progreso_sql.php">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalActualizarObjetivosLabel" style="color:white">Actualizar Objetivos de Progreso</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="color:white">
            <input type="hidden" name="usuario_id" value="<?= $id_usuario ?>">
            <input type="hidden" name="accion" value="actualizar_objetivos">
            <div class="mb-3">
              <label for="objetivo_principal" class="form-label">Objetivo Principal</label>
              <input type="text" class="form-control" id="objetivo_principal" name="objetivo_principal" placeholder="Ej: Reducir grasa corporal al 15%">
            </div>
            <div class="mb-3">
              <label for="meta_secundaria" class="form-label">Meta Secundaria</label>
              <input type="text" class="form-control" id="meta_secundaria" name="meta_secundaria" placeholder="Ej: Aumentar masa muscular en 5 kg">
            </div>
            <p class="small">Nota: La funcionalidad de guardar objetivos en la base de datos está pendiente.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-guardar">Guardar Objetivos</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalHistorialCompleto" tabindex="-1" aria-labelledby="modalHistorialCompletoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content glass-card">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalHistorialCompletoLabel" style="color:white">Historial Completo</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="color:white">
          <p>La funcionalidad para mostrar el historial completo de mediciones estará disponible próximamente.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const modalObjetivos = document.getElementById('modalActualizarObjetivos');
    if (modalObjetivos) {
        modalObjetivos.addEventListener('hidden.bs.modal', function () {
            const objPrincipalInput = document.getElementById('objetivo_principal');
            const metaSecundariaInput = document.getElementById('meta_secundaria');
            if (objPrincipalInput && objPrincipalInput.value) {
                document.getElementById('displayObjetivoPrincipal').textContent = objPrincipalInput.value;
            }
            if (metaSecundariaInput && metaSecundariaInput.value) {
                document.getElementById('displayMetaSecundaria').textContent = metaSecundariaInput.value;
            }
        });
    }
  </script>
</body>
</html>
<?php
$mysql->close();
?>