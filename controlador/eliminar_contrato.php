<?php
// Asegúrate de haber iniciado la sesión en algún punto antes de este código
session_start();
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el usuario ha iniciado sesión y obtener su nombre de usuario
    if (isset($_SESSION['usuario'])) {
        // Obtener el ID del contrato a eliminar desde el formulario
        $contrato_id = $_POST['contrato_id'];
        // Consulta para eliminar el contrato de la base de datos
        $query_eliminar = "DELETE FROM contratos WHERE id = $contrato_id";
        if (mysqli_query($mysqli, $query_eliminar)) {
            // Mostrar una alerta de JavaScript
            echo "<script>
                    if(confirm('¿Estás seguro de que deseas eliminar este contrato?')) {
                        // Si el usuario confirma, enviar el formulario nuevamente con la confirmación
                        document.getElementById('eliminar_form').submit();
                    }
                  </script>";
            // Redirigir de vuelta a la página de contratos
            header("Location: ../Vista/vista_contratos.php?eliminado=true");
            exit();
        } else {
            echo "Error al intentar eliminar el contrato: " . mysqli_error($mysqli);
        }
    } else {
        echo "Usuario no ha iniciado sesión.";
    }
}
?>
