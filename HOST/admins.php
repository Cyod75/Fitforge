<?php
session_start();
$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Admin') {
    header('Location: ../AUTH/login.php');
    exit;
}

if ($mysql->connect_error) {
    die("Conexión fallida: " . $mysql->connect_error);
}

require_once './FUNCIONES/admins_sql.php';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

$delete_message = isset($_SESSION['delete_message']) ? $_SESSION['delete_message'] : '';
unset($_SESSION['delete_message']);

// Lógica para manejar la solicitud de eliminación
$user_id_to_delete = $_GET['delete_id'] ?? null;
$current_user_id = $_SESSION['usuario_id'];

if ($user_id_to_delete !== null) {
    $user_id_to_delete = (int)$user_id_to_delete;

    if ($user_id_to_delete == $current_user_id) {
        $_SESSION['delete_message'] = "No puedes eliminar tu propia cuenta de administrador.";
    } else {
        try {
            if (deleteUserById($mysql, $user_id_to_delete)) {
                $_SESSION['delete_message'] = "Usuario eliminado exitosamente.";
            } else {
                $_SESSION['delete_message'] = "Error desconocido al eliminar el usuario.";
            }
        } catch (Exception $e) {
            $_SESSION['delete_message'] = "Error al eliminar el usuario: " . $e->getMessage() . ". Asegúrate de que el usuario no tenga datos relacionados en otras tablas (rutinas, alimentos favoritos, progreso físico) o considera actualizar tu esquema de base de datos con ON DELETE CASCADE.";
        }
    }
    // Redirigir para limpiar el parámetro GET después de procesar
    header('Location: admins.php');
    exit;
}

$nombre_usuario = isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : '';
$correo_usuario = isset($_SESSION['form_data']['correo']) ? $_SESSION['form_data']['correo'] : '';
$rol_seleccionado = isset($_SESSION['form_data']['rol']) ? $_SESSION['form_data']['rol'] : 'Usuario';
unset($_SESSION['form_data']);

$usuarios = getAllUsers($mysql);

$mysql->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administración - FitForge</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../CSS/bootstrap.css" rel="stylesheet">
  <link href="../CSS/app.css" rel="stylesheet">
  <link href="../CSS/style.css" rel="stylesheet">
  <style>
    .admin-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    @media (min-width: 992px) {
        .admin-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    .alert-success-custom {
        background-color: #28a745;
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        text-align: center;
        opacity: 0.9;
    }
    .alert-danger-custom {
        background-color: #dc3545;
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        text-align: center;
        opacity: 0.9;
    }
    .btn-eliminar {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: #fff !important;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    .btn-eliminar:hover,
    .btn-eliminar:focus {
        background-color: #c82333 !important;
        border-color: #bd2130 !important;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h4 class="text-center">FitForge</h4>
    <a href="inicio.php"><i class="bi bi-house-door-fill"></i> Inicio</a>
    <a href="ejercicios.php"><i class="bi bi-list-check"></i> Ejercicios</a>
    <a href="#"><i class="bi bi-egg-fried"></i> Alimentos</a>
    <a href="admins.php" class="active"><i class="bi bi-bar-chart-fill"></i> Administradores</a>
    <a href='../AUTH/logout.php'><i class="bi bi-door-closed"></i> Salir</a>
  </div>

  <div class="main-content">
    <div class="welcome">
      Panel de <span class="highlight">Administración</span>
    </div>

    <?php if (!empty($success_message)): ?>
      <div class="alert-success-custom"><?= $success_message ?></div>
    <?php endif; ?>
    <?php if (!empty($delete_message)): ?>
      <div class="alert-danger-custom"><?= $delete_message ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <div class="admin-grid">
      <div class="glass-card">
        <img src="../IMG/logo.png" alt="FitForge Logo" class="logo-small mx-auto d-block mb-3" style="max-width: 100px;">
        <h2 class="text-center mb-4">Crear Nuevo Usuario</h2>

        <form action="./FUNCIONES/checkRegistroHost.php" method="POST">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de Usuario" required value="<?= $nombre_usuario ?>">
            <label for="nombre">Nombre de Usuario</label>
          </div>

          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" required value="<?= $correo_usuario ?>">
            <label for="correo">Correo Electrónico</label>
          </div>

          <div class="form-floating mb-4">
            <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña" required>
            <label for="contraseña">Contraseña</label>
          </div>

          <div class="form-floating mb-4">
            <input type="password" class="form-control" id="contraseña2" name="contraseña2" placeholder="Confirmar Contraseña" required>
            <label for="contraseña2">Confirmar Contraseña</label>
          </div>

          <div class="mb-4">
            <label for="rol" class="form-label" style="color:white;">Rol del Usuario</label>
            <select class="form-select" id="rol" name="rol" required>
              <option value="Usuario" <?= ($rol_seleccionado === 'Usuario') ? 'selected' : '' ?>>Usuario</option>
              <option value="Admin" <?= ($rol_seleccionado === 'Admin') ? 'selected' : '' ?>>Admin</option>
            </select>
          </div>

          <button type="submit" class="btn btn-custom text-white w-100">Crear Usuario</button>
        </form>
      </div>

      <div class="glass-card">
        <h2 class="mb-4 text-center">Lista de Usuarios</h2>

        <?php if (empty($usuarios)): ?>
          <p class="text-center">No hay usuarios registrados.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-dark table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Correo</th>
                  <th scope="col">Rol</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                  <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= $usuario['nombre'] ?></td>
                    <td><?= $usuario['correo'] ?></td>
                    <td><?= $usuario['rol'] ?></td>
                    <td>
                      <?php if ($usuario['id'] != $current_user_id): ?>
                        <button type="button" class="btn btn-eliminar btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-user-id="<?= $usuario['id'] ?>" data-user-name="<?= $usuario['nombre'] ?>">
                          Eliminar
                        </button>
                      <?php else: ?>
                        <span class="text-muted">No eliminar</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content glass-card">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="confirmDeleteModalLabel" style="color:white">Confirmar Eliminación</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="color:white">
          ¿Estás seguro de que quieres eliminar al usuario <strong id="userNameToDelete"></strong>? Esta acción no se puede deshacer.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a href="#" id="confirmDeleteButton" class="btn btn-eliminar">Eliminar Usuario</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const confirmDeleteModal = document.getElementById('confirmDeleteModal');
    if (confirmDeleteModal) {
      confirmDeleteModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');

        const userNameToDelete = confirmDeleteModal.querySelector('#userNameToDelete');
        const confirmDeleteButton = confirmDeleteModal.querySelector('#confirmDeleteButton');

        userNameToDelete.textContent = userName;
        confirmDeleteButton.href = `admins.php?delete_id=${userId}`;
      });
    }
  </script>
</body>
</html>