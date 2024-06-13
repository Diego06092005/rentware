<?php
// Verificar si se accedió al script mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");
    // Recoger los datos del formulario
    $aren_cedula_id = $_POST['aren_cedula_id'];
    $mes_arriendo = $_POST['mes_arriendo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    // Preparar la consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO arriendos (aren_cedula_id, mes_arriendo, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)";
    // Preparar la declaración para evitar inyecciones SQL
    if ($stmt = $mysqli->prepare($sql)) {
        // Vincular los parámetros a la declaración preparada como strings
        $stmt->bind_param("ssss", $aren_cedula_id, $mes_arriendo, $fecha_inicio, $fecha_fin);
        // Ejecutar la declaración preparada
        if ($stmt->execute()) {
            // Si todo fue exitoso, redirigir a vista_arriendo.php con mensaje de éxito
            $stmt->close();
            $mysqli->close();
            header("Location: ../Vista/vista_arriendo.php?aren_cedula_id=$aren_cedula_id&success=true");
            exit();
        } else {
            // Si hubo un problema al insertar, informar al usuario
            echo "Error al agregar el arriendo: " . $stmt->error;
        }
        // Cerrar la declaración preparada
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $mysqli->error;
    }
    // Cerrar la conexión a la base de datos
    $mysqli->close();
} else {
    // Si no se accedió al script mediante POST, informar al usuario
    echo "Método de solicitud no permitido";
}
?>