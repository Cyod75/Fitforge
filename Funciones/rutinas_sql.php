<?php
$mysql = new mysqli("localhost:3307", "root", "majada", "fitforge");

$opcion = $_GET["opcion"] ?? null;

if ($opcion == "eliminar") {
    $usuarioId = $_GET["usuario_id"];
    $diaSemana = $_GET["dia_semana"];
    $ejercicioId = $_GET["ejercicio_id"];

    $mysql->query("DELETE FROM rutinas WHERE usuario_id=$usuarioId AND dia_semana='$diaSemana' AND ejercicio_id=$ejercicioId");

} else if ($opcion == "insertar") {
    $usuarioId = $_POST["usuario_id"];
    $diaSemana = $_POST["dia_semana"];
    $ejercicioId = $_POST["ejercicio_id"];
    $intensidad = $_POST["intensidad"];

    $mysql->query("INSERT INTO rutinas (usuario_id, dia_semana, ejercicio_id, intensidad) VALUES ($usuarioId, '$diaSemana', $ejercicioId, '$intensidad')");

} else if ($opcion == "obtener_usuario_id") {
    $usuarioNombre = $_GET["usuario_nombre"];
    $resultado = $mysql->query("SELECT id FROM usuarios WHERE nombre = '$usuarioNombre'");
    $usuario = $resultado->fetch_assoc();
    echo $usuario['id'] ?? 0;
}

$mysql->close();
?>
