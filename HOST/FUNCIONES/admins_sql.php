<?php

function getAllUsers($mysql) {
    $usuarios = [];
    $query = "SELECT id, nombre, correo, rol FROM usuarios ORDER BY nombre ASC";
    $result = $mysql->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }
    return $usuarios;
}

function deleteUserById($mysql, $userId) {
    $stmt = $mysql->prepare("DELETE FROM usuarios WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Error al preparar la eliminación del usuario: " . $mysql->error);
    }
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $error_message = $stmt->error;
        $stmt->close();
        throw new Exception("Error al eliminar el usuario: " . $error_message);
    }
}

?>