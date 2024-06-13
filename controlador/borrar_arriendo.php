<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");
// Verificar si el ID del arriendo está establecido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $arriendo_id = $_GET['id'];
    // Preparar la consulta SQL para eliminar el arriendo
    $query = "DELETE FROM arriendos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    // Vincular parámetros y ejecutar
    $stmt->bind_param("i", $arriendo_id);
    if ($stmt->execute()) {
        // Redirigir de vuelta a la página de información con un mensaje de éxito
        $_SESSION['mensaje'] = "Arriendo eliminado con éxito.";
        header("Location: ../Vista/tabla_tario.php"); // Asegúrate de cambiar esto a la página real desde donde se hacen las eliminaciones
        exit();
    } else {
        // Manejar el error, posiblemente redirigir con un mensaje de error
        $_SESSION['error'] = "Error al eliminar el arriendo.";
        header("Location: ../Vista/tabla_tario.php"); // Usa la página real de tu proyecto
        exit();
    }
} else {
    // Redirigir si el ID del arriendo no está presente o es inválido
    $_SESSION['error'] = "Solicitud inválida.";
    header("Location: ../Vista/tabla_tario.php"); // Cambia a la página real
    exit();
}
?>
