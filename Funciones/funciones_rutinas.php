<?php
function conectarDB() {
    $mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
    if ($mysql->connect_error) {
        die("Error de conexión: " . $mysql->connect_error);
    }
    return $mysql;
}

function obtenerUsuarioId($mysql, $usuarioNombre) {
    $stmt = $mysql->prepare("SELECT id FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $usuarioNombre);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuarioData = $result->fetch_assoc();
    $stmt->close();
    return $usuarioData['id'] ?? null;
}

function insertarRutina($mysql, $usuarioId, $diaSemana, $ejercicioId, $intensidad) {
    $stmt = $mysql->prepare("
        INSERT INTO rutinas (usuario_id, dia_semana, ejercicio_id, intensidad)
        VALUES (?, ?, ?, ?)
    ");
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $mysql->error);
    }
    // usuario_id (i), dia_semana (s), ejercicio_id (i), intensidad (s)
    $stmt->bind_param("isis", $usuarioId, $diaSemana, $ejercicioId, $intensidad);
    if (!$stmt->execute()) {
        die("Error al insertar rutina: " . $stmt->error);
    }
    $stmt->close();
}

function eliminarRutina($mysql, $usuarioId, $diaSemana, $ejercicioId) {
    $stmt = $mysql->prepare("
        DELETE FROM rutinas
         WHERE usuario_id = ? 
           AND dia_semana = ? 
           AND ejercicio_id = ?
    ");
    $stmt->bind_param("isi", $usuarioId, $diaSemana, $ejercicioId);
    $stmt->execute();
    $stmt->close();
}

function cargarEjercicios($mysql) {
    $ejercicios = [];
    $res = $mysql->query("SELECT id, nombre FROM ejercicios");
    while ($row = $res->fetch_assoc()) {
        $ejercicios[] = $row;
    }
    return $ejercicios;
}

function cargarRutinasPorDia($mysql, $usuarioId) {
    $rutinasPorDia = [];
    $ejerciciosUnicos = [];
    $totalRutinas = 0;

    $sql = "
        SELECT r.dia_semana, e.nombre AS ejercicio, r.intensidad, r.ejercicio_id
          FROM rutinas r
          JOIN ejercicios e ON r.ejercicio_id = e.id
         WHERE r.usuario_id = $usuarioId
    ";
    $res = $mysql->query($sql);
    while ($row = $res->fetch_assoc()) {
        $rutinasPorDia[$row['dia_semana']][] = [
            'ejercicio'    => $row['ejercicio'],
            'intensidad'   => $row['intensidad'],
            'ejercicio_id' => $row['ejercicio_id']
        ];
        $totalRutinas++;
        $ejerciciosUnicos[$row['ejercicio_id']] = true;
    }

    return [$rutinasPorDia, $ejerciciosUnicos, $totalRutinas];
}
