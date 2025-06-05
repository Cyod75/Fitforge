<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location: ../AUTH/login.php');
    die();
}

$mysql = new mysqli("localhost", "root", "garrapata", "fitforge");
if ($mysql->connect_error) {
    die("Error de conexión: " . $mysql->connect_error);
}

$usuario_id = $_POST['usuario_id'] ?? 0;
$accion = $_POST['accion'] ?? '';

$latest_progreso = null;
if ($usuario_id) {
    $stmt_latest = $mysql->prepare("SELECT peso, altura, biceps, pecho, cintura, pierna, imc FROM progreso_fisico WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 1");
    if ($stmt_latest) {
        $stmt_latest->bind_param("i", $usuario_id);
        $stmt_latest->execute();
        $result_latest = $stmt_latest->get_result();
        if ($result_latest->num_rows > 0) {
            $latest_progreso = $result_latest->fetch_assoc();
        }
        $stmt_latest->close();
    }
}

if ($accion === 'actualizar_personales' && $usuario_id) {
    $peso = !empty($_POST['peso']) ? (float)$_POST['peso'] : ($latest_progreso['peso'] ?? null);
    $altura = !empty($_POST['altura']) ? (float)$_POST['altura'] : ($latest_progreso['altura'] ?? null);
    $imc = null;
    if ($peso && $altura > 0) {
        $imc = round($peso / ($altura * $altura), 2);
    } elseif ($latest_progreso['imc']) {
        $imc = $latest_progreso['imc'];
    }

    $biceps = $latest_progreso['biceps'] ?? null;
    $pecho = $latest_progreso['pecho'] ?? null;
    $cintura = $latest_progreso['cintura'] ?? null;
    $pierna = $latest_progreso['pierna'] ?? null;

    $query = "INSERT INTO progreso_fisico (usuario_id, fecha, peso, altura, imc, biceps, pecho, cintura, pierna) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysql->prepare($query);
    if ($stmt) {
        $stmt->bind_param("iddddddd", $usuario_id, $peso, $altura, $imc, $biceps, $pecho, $cintura, $pierna);
        $stmt->execute();
        $stmt->close();
    }

} elseif ($accion === 'registrar_mediciones' && $usuario_id) {
    $biceps = !empty($_POST['biceps']) ? (float)$_POST['biceps'] : ($latest_progreso['biceps'] ?? null);
    $pecho = !empty($_POST['pecho']) ? (float)$_POST['pecho'] : ($latest_progreso['pecho'] ?? null);
    $cintura = !empty($_POST['cintura']) ? (float)$_POST['cintura'] : ($latest_progreso['cintura'] ?? null);
    $pierna = !empty($_POST['pierna']) ? (float)$_POST['pierna'] : ($latest_progreso['pierna'] ?? null);

    $peso = $latest_progreso['peso'] ?? null;
    $altura = $latest_progreso['altura'] ?? null;
    $imc = $latest_progreso['imc'] ?? null;
    if ($peso && $altura > 0) {
        $imc = round($peso / ($altura * $altura), 2);
    }

    $query = "INSERT INTO progreso_fisico (usuario_id, fecha, peso, altura, imc, biceps, pecho, cintura, pierna) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysql->prepare($query);
    if ($stmt) {
        $stmt->bind_param("iddddddd", $usuario_id, $peso, $altura, $imc, $biceps, $pecho, $cintura, $pierna);
        $stmt->execute();
        $stmt->close();
    }
} elseif ($accion === 'actualizar_objetivos' && $usuario_id) {
    //
}

$mysql->close();
header("Location: ../APP/progreso.php");
exit();
?>