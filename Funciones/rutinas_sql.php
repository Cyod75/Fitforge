<?php
// Conexión directa
$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
if ($mysql->connect_error) {
    die("Error de conexión: " . $mysql->connect_error);
}

// Determina la operación
$opcion = $_GET['opcion'] ?? '';

if ($opcion === 'insertar') {
    // Inserta una nueva rutina
    $usuario_id   = $_POST['usuario_id'];
    $dia_semana   = $_POST['dia_semana'];
    $ejercicio_id = $_POST['ejercicio_id'];
    $intensidad   = $_POST['intensidad'];

    $query = "
      INSERT INTO rutinas (usuario_id, dia_semana, ejercicio_id, intensidad)
      VALUES ($usuario_id, '$dia_semana', $ejercicio_id, '$intensidad')
    ";
    $mysql->query($query);

} elseif ($opcion === 'eliminar') {
    // Borra por ID único de rutina
    $id = $_GET['id'];
    $mysql->query("DELETE FROM rutinas WHERE id = $id");

}

// Después de la operación, vuelve a rutinas.php
header("Location: ../APP/rutinas.php");
$mysql->close();
