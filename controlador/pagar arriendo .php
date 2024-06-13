<?php
require_once("conexion.php"); // Asume que este archivo contiene la conexión a tu BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aren_cedula_id = $_POST['aren_cedula_id'];
    $mes = $_POST['mes'];
    $fecha_inicio = date('Y-m-d'); // Fecha de hoy
    $fecha_fin = date('Y-m-d', strtotime('+30 days', strtotime($fecha_inicio))); // 30 días después

    // Asegúrate de validar y sanitizar tus inputs aquí

    // consulta sql para insentar un registro en la tabla "arriendos"   
    $query = "INSERT INTO arriendos (mes_arriendo, fecha_inicio, fecha_fin, aren_cedula_id) VALUES (?, ?, ?, ?)";

    // Verificar si la solicitud es un metodo post
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("sssi", $mes, $fecha_inicio, $fecha_fin, $aren_cedula_id);
       //preparar la consulta sql 
        if ($stmt->execute()) {
            echo "Pago registrado con éxito.";
        } else {
            echo "Error al registrar el pago: " . $stmt->error;
        }
        //cerrar la consulta preparada 
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $mysqli->error;
    }
    //cerrar la conexion a la base de datos
    $mysqli->close();
} else {
    // si el metodo de  solicitud no es un post, mostrar un mensaje de error
    echo "Método no permitido";
}
?>