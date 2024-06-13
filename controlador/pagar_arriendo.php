<?php
require_once("conexion.php"); // Asume que este archivo contiene la conexión a tu BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aren_cedula_id = $_POST['aren_cedula_id'];
    $mes = $_POST['mes'];
    $fecha_inicio = date('Y-m-d'); // Fecha de hoy
    $fecha_fin = date('Y-m-d', strtotime('+30 days', strtotime($fecha_inicio))); // 30 días después

    // Asegúrate de validar y sanitizar tus inputs aquí

    $query = "INSERT INTO arriendos (mes_arriendo, fecha_inicio, fecha_fin, aren_cedula_id) VALUES (?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sssi", $mes, $fecha_inicio, $fecha_fin, $aren_cedula_id);
        if ($stmt->execute()) {
            echo "Pago registrado con éxito.";
        } else {
            echo "Error al registrar el pago: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $mysqli->error;
    }
    $mysqli->close();
} else {
    echo "Método no permitido";
}
?>
