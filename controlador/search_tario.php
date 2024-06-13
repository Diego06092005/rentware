<?php
// Conectarse a la base de datos
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");
session_start(); // Inicia la sesión
// Asegúrate de que $id_usuario esté definida, por ejemplo, obteniéndola de la sesión del usuario
if(isset($_SESSION['id_usuario'])){
    $id_usuario = $_SESSION['id_usuario'];
} else {
    // Manejar el caso en que $id_usuario no esté definida, como redirigir al usuario a iniciar sesión
    header('Location: login.php'); // Redirecciona al usuario a la página de login
    exit; // Detiene la ejecución del script
}

// Obtener el valor de búsqueda
$searchValue = isset($_GET['q']) ? $_GET['q'] : '';

// Preparar la consulta SQL para buscar arrendatarios según la entrada del usuario
$stmt = $mysqli->prepare("SELECT arrendatario.*, 
(SELECT fecha_fin FROM arriendos WHERE arriendos.aren_cedula_id = arrendatario.aren_cedula_id ORDER BY fecha_fin DESC LIMIT 1) AS fecha_fin_arriendo, 
(SELECT fecha_fin FROM servicios WHERE servicios.id_arrendatario = arrendatario.aren_cedula_id ORDER BY fecha_fin DESC LIMIT 1) AS fecha_fin_servicio 
FROM arrendatario WHERE id_usuario = ? AND (aren_nombre LIKE ? OR aren_apellido LIKE ?)");

// % se añade al valor de búsqueda para buscar coincidencias parciales
$searchTerm = '%' . $searchValue . '%';

// Vincular parámetros
$stmt->bind_param("iss", $id_usuario, $searchTerm, $searchTerm);

// Ejecutar
$stmt->execute();

// Obtener los resultados
$result = $stmt->get_result();



?>

 <!-- div para la tabla arrendatarios -->
 <div class="table-responsive">
    <table class="table table-striped table-dark">
        <thead class="table-dark">
      
        </thead>
        <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {

    $icono = '';

    // Verifica si existe fecha de fin del arriendo
    if (!empty($row['fecha_fin_arriendo'])) {
        // Si hay fecha de fin, procede con la lógica de los íconos
        $fecha_fin = new DateTime($row['fecha_fin_arriendo']);
        $fecha_actual = new DateTime();
        $dias_restantes = $fecha_actual->diff($fecha_fin)->days;

        if ($fecha_actual > $fecha_fin) {
            // Arriendo finalizado
            $icono = "<i class='fas fa-times-circle' style='color: red;'></i>";
        } elseif ($dias_restantes <= 5) {
            // Menos de 5 días restantes
            $icono = "<i class='fas fa-exclamation-circle' style='color: orange;'></i>";
        } else {
            // Más de 5 días restantes
            $icono = "<i class='fas fa-check-circle' style='color: green;'></i>";
        }
    }
    $fecha_actual = new DateTime();
    $fecha_actual->setTime(0, 0); // Ajustar la hora a medianoche para contar el día completo
    
    $icono_servicio = '';
    // Verifica si existe fecha de fin del servicio
    if (!empty($row['fecha_fin_servicio'])) {
        $fecha_fin_servicio = new DateTime($row['fecha_fin_servicio']);
        $fecha_fin_servicio->setTime(23, 59, 59); // Asegurar que el día de fin se cuenta completo
    
        $intervalo = $fecha_actual->diff($fecha_fin_servicio);
        $dias_restantes_servicio = $intervalo->days;
    
        // Si la fecha actual es anterior a la fecha de fin, ajustar el conteo para incluir el día actual
        if($fecha_actual < $fecha_fin_servicio) {
            $dias_restantes_servicio += 1;
        }
    
        if ($fecha_actual > $fecha_fin_servicio) {
            // Servicio finalizado
            $icono_servicio = "<i class='fas fa-times-circle' style='color: red;'></i>";
        } elseif ($dias_restantes_servicio <= 6) {
            // Menos de 6 días restantes para el servicio
            $icono_servicio = "<i class='fas fa-exclamation-circle' style='color: orange;'></i>";
        } else {
            // Más de 5 días restantes para el servicio
            $icono_servicio = "<i class='fas fa-check-circle' style='color: green;'></i>";
        }
    }
    
                echo "<tr>";
                echo "<td>" . $row['aren_nombre'] . "</td>";
                echo "<td>" . $row['aren_apellido'] . "</td>";
                echo "<td>" . $row['aren_cedula_id'] . "</td>";
                echo "<td>" . $row['aren_telefono'] . "</td>";
                // Botón de redirección
                echo "<td>
                <a href='vista_arriendo.php?aren_cedula_id=" . $row['aren_cedula_id'] . "&aren_nombre=" . $row['aren_nombre'] . "&aren_apellido=" . $row['aren_apellido'] . "' class='btn btn-info'>$icono Arriendo</a>
                
                <a href='detalles_servicios.php?aren_cedula_id=" . $row['aren_cedula_id'] . "' class='btn btn-primary'>$icono_servicio Servicios</a>
                </td>";
        
              // Columna de acciones
                echo "<td>";
                echo "<a href='modificar.php?aren_cedula_id=" . $row['aren_cedula_id'] . "' class='btn btn-primary' style='margin-right: 5px;'><i class='fas fa-edit'></i></a>";
                echo "<form method='POST' action='tabla_tario.php' onsubmit='return confirmDelete()' style='display: inline-block;'>";
                echo "<input type='hidden' name='aren_cedula_id_borrar' value='" . $row['aren_cedula_id'] . "'>";
                echo "<button class='btn btn-danger' type='submit' name='borrar'><i class='fas fa-trash-alt'></i></button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";

            }
        } else {
            echo "<tr><td colspan='6'>No se encontraron arrendatarios asociados a este usuario con la búsqueda actual.</td></tr>";
        }
        ?>
    </tbody>
</table>
