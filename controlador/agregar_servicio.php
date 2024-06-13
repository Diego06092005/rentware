<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Verificar si se envió el formulario de inserción de servicio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_servicio'])) {
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");

    // Validación inicial del ID del arrendatario
    if (empty($_POST['aren_cedula_id'])) {
        echo "<div style='padding: 20px; background-color: #f44336; color: white; margin-bottom: 15px;'>Error: Falta el ID del arrendatario.</div>";
        exit();
    } else {
        $aren_cedula_id = $_POST['aren_cedula_id'];
    }

    // Obtener los datos del formulario y validar
    $nombre_servicio = $mysqli->real_escape_string($_POST['nombre_servicio']);
    $descripcion_servicio = $mysqli->real_escape_string($_POST['descripcion_servicio']);

    // Asegurarse de que la descripción es válida
    if ($descripcion_servicio !== 'Compartido' && $descripcion_servicio !== 'Individual') {
        echo "<div style='padding: 20px; background-color: #f44336; color: white; margin-bottom: 15px;'>Error: Descripción de servicio inválida.</div>";
        exit();
    }

  // Manejar las fechas solo si están presentes
$fecha_pago = isset($_POST['fecha_pago']) ? $_POST['fecha_pago'] : null;
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;

// Construir la consulta SQL según si se incluyen las fechas o no
$insert_query = "INSERT INTO servicios (id_arrendatario, nombre, descripcion" . 
                ($fecha_pago && $fecha_fin ? ", fecha_pago, fecha_fin" : "") . 
                ") VALUES ('$aren_cedula_id', '$nombre_servicio', '$descripcion_servicio'" . 
                ($fecha_pago && $fecha_fin ? ", '$fecha_pago', '$fecha_fin'" : "") . ")";

    // Insertar el nuevo servicio en la base de datos, incluyendo las fechas
// Esta línea sobrescribe la consulta anterior y debe eliminarse.
$insert_query = "INSERT INTO servicios (id_arrendatario, nombre, descripcion, fecha_pago, fecha_fin) VALUES ('$aren_cedula_id', '$nombre_servicio', '$descripcion_servicio', '$fecha_pago', '$fecha_fin')";


        if ($mysqli->query($insert_query)) {
            header("Location: ../Vista/detalles_servicios.php?aren_cedula_id=$aren_cedula_id&success=true");
            exit();
        }
     
    } else {
        echo "<div style='padding: 20px; background-color: #f44336; color: white; margin-bottom: 15px;'>Error al agregar el servicio: " . $mysqli->error . "</div>";
    }

?>
