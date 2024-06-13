<?php
session_start();
include_once "../modelo/config.php";

if (!isset($_SESSION['unique_id'])) {
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit;
}

$id_usuario = $_SESSION['unique_id'];
$id_cargo = $_SESSION['id_cargo'];

$mensajesNoLeidos = 0;

$stmt = $conn->prepare("SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = ? AND is_read = 0");
$stmt->bind_param("i", $id_usuario);

if ($stmt->execute()) {
    $resultado = $stmt->get_result();
    if ($fila = $resultado->fetch_assoc()) {
        $mensajesNoLeidos = $fila['no_leidos'];
    }
}
$stmt->close();

echo $mensajesNoLeidos;