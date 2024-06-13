<?php
// Incluir el archivo de conexión a la base de datos
include '../modelo/conexion.php';
// Verificar si se ha enviado el formulario
if(isset($_POST['submit'])) {
    // Recuperar los datos del formulario
    $cedula = $_POST['cedula'];
    $contrasena = $_POST['contrasena'];
    // Hash de la contraseña
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
    // Verificar si la cédula existe en la base de datos
    $query = "SELECT * FROM usuarios WHERE cedula = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1) {
        // La cédula existe en la base de datos, actualizar la contraseña
        $update_query = "UPDATE usuarios SET password = ? WHERE cedula = ?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param("si", $hashed_password, $cedula);
        $update_stmt->execute();
        if($update_stmt->affected_rows > 0) {
            // Contraseña actualizada correctamente
            // Redireccionar a nueva_contraseña.php
            header("Location: ../vista/nueva_contraseña.php?mensaje=contraseña_cambiada");
            exit();
        } else {
            echo "Hubo un error al actualizar la contraseña.";
        }
    } else {
        // Cédula no existe en la base de datos
        // Redireccionar a nueva_contraseña.php y mostrar alerta
        header("Location: ../vista/nueva_contraseña.php?mensaje=cedula_invalida");
        exit();
    }

    // Cerrar las consultas preparadas y la conexión
    $stmt->close();
    $update_stmt->close();
    $mysqli->close();
} else {
    // Si se accede directamente a este archivo sin enviar el formulario, redireccionar al formulario
    header("Location index.php");
    exit();
}
?>