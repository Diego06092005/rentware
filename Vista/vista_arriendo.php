<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Información de Arriendos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icono de la página web -->     
    <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <body>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Arriendo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../modelo/assets/css/vista_arriendos.css">
</head>
<?php
session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
$nombre_usuario = $_SESSION['usuario'];
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");
// Añadir estilos para el desenfoque y la tabla oscura
if (isset($_GET['aren_cedula_id'])) {
    $aren_cedula_id = $_GET['aren_cedula_id'];
    // Consultar información del arrendatario
    $arrendatario_query = "SELECT aren_nombre, aren_apellido, aren_cedula_id FROM arrendatario WHERE aren_cedula_id = '$aren_cedula_id'";
    $arrendatario_result = $mysqli->query($arrendatario_query);
    if ($arrendatario_result && $arrendatario_result->num_rows > 0) {
        $arrendatario = $arrendatario_result->fetch_assoc();
        echo "<div class='container mt-5'>";
        echo "<div class='info-arrendatario'>";
        echo "<a href='tabla_tario.php' class='btn btn-primary'><i class='bi bi-arrow-left'></i> Volver</a>";
        echo "<h2>Información del Arrendatario (Arriendo)</h2>";
        echo "<p><strong>Nombre:</strong> {$arrendatario['aren_nombre']} {$arrendatario['aren_apellido']}</p>";
        echo "<p><strong>Cédula:</strong> {$arrendatario['aren_cedula_id']}</p>";
        echo "</div>";
    } else {
        echo "<p class='text-white'>No se encontró el arrendatario.</p>";
        exit();
    }
    // Consultar los arriendos asociados a este arrendatario y mostrarlos
    $arriendos_query = "SELECT id, mes_arriendo, fecha_inicio, fecha_fin FROM arriendos WHERE aren_cedula_id = '$aren_cedula_id'";
    $arriendos_result = $mysqli->query($arriendos_query);
    if ($arriendos_result && $arriendos_result->num_rows > 0) {
        echo "<div class='table-responsive mt-4'>";
        echo "<table class='table table-dark table-hover'>";
        echo "<thead><tr><th>ID</th><th>Mes del Arriendo</th><th>Fecha de Inicio</th><th>Fecha de Fin</th><th>Estado del Arriendo</th><th>Acciones</th></tr></thead>";
        echo "<tbody>";
        while ($arriendo = $arriendos_result->fetch_assoc()) {
            $fecha_inicio = new DateTime($arriendo['fecha_inicio']);
            $fecha_fin = new DateTime($arriendo['fecha_fin']);
            $fecha_actual = new DateTime(); // Fecha y hora actual
            $fecha_actual->setTime(0, 0, 0); // Establecer la hora a medianoche para la fecha actual
            $fecha_inicio->setTime(0, 0, 0);
            $fecha_fin->setTime(0, 0, 0);    
            $dias_restantes = $fecha_actual->diff($fecha_fin)->format("%a");   
            if ($fecha_actual <= $fecha_fin) {
                $dias_restantes += 2;
            }   
            // Asignar un valor predeterminado a $icono
            $icono = ""; // Valor predeterminado vacío
            $mensaje_contador = "Días restantes: $dias_restantes "; // Mensaje predeterminado que incluirá los días restantes    
            if ($fecha_actual > $fecha_fin) {
                // Si la fecha actual es mayor que la fecha de fin, el arriendo ha finalizado
                $mensaje_contador = " ";
                $icono = "<span style='color: red;'>Arriendo finalizado. <i class='fas fa-times-circle'></i></span>";
            } else {
                // Dependiendo de los días restantes, mostrar el mensaje y el ícono correspondiente
                if ($dias_restantes <= 5) {
                    $icono = "<span style='color: orange;'><i class='fas fa-exclamation-circle'></i></span>";
                } elseif ($dias_restantes > 25) {
                    $icono = "<span style='color: green;'><i class='fas fa-check-circle'></i></span>";
                }
                // Si los días restantes están entre 6 y 25, $icono conservará su valor predeterminado (vacío), pero puedes ajustar según necesites
            }
            $mensaje_contador .= $icono; // Añadi ícono al mensaje       
            // Mostrar las fechas formateadas en la tabla
            echo "<tr><td>{$arriendo['id']}</td><td>{$arriendo['mes_arriendo']}</td><td>{$fecha_inicio->format('M-d-Y')}</td><td>{$fecha_fin->format('M-d-Y')}</td><td>$mensaje_contador</td>";
            // Añadi el ícono de borrar con un enlace (o botón) que llame a tu script de borrado, pasando el ID del arriendo como parámetro
            echo "<td><a href='#' class='btn btn-danger delete-btn' data-id='{$arriendo['id']}'><i class='fas fa-trash-alt'></i></a></td></tr>";
        }        
        echo "</tbody></table></div>";      
    } else {
        echo "<p class='text-red'>No se encontraron arriendos para este arrendatario.</p>";
    }
    echo "</div>"; // Cierre del contenedor de Bootstrap
} else {
    echo "<p class='text-white'>Error: Falta el ID del arrendatario.</p>";
}
?>
<body>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-dark-form">
                        <thead>                       
                        <th colspan="2"><h2 style="color:white; text-align:center;">Nuevo Arriendo para <?php echo "{$arrendatario['aren_nombre']} {$arrendatario['aren_apellido']}"; ?></h2></th>                    
                        </thead>
                        <tbody>
                            <form action="../controlador/insertar_arriendo.php" method="POST">
                                <tr>
                                    <td>Cédula del Arrendatario:</td>
                                    <td><input type="text" class="form-control" id="aren_cedula_id" name="aren_cedula_id" value="<?php echo htmlspecialchars($aren_cedula_id); ?>" readonly required></td>
                                </tr>
                                <tr>
                                <td>Mes del Arriendo:</td>
                                <td>
                                <select class="form-control" id="mes_arriendo" name="mes_arriendo" required>
                                    <option value="">Seleccione un mes</option>
                                    <option value="Enero">Enero</option>
                                    <option value="Febrero">Febrero</option>
                                    <option value="Marzo">Marzo</option>
                                    <option value="Abril">Abril</option>
                                    <option value="Mayo">Mayo</option>
                                    <option value="Junio">Junio</option>
                                    <option value="Julio">Julio</option>
                                    <option value="Agosto">Agosto</option>
                                    <option value="Septiembre">Septiembre</option>
                                    <option value="Octubre">Octubre</option>
                                    <option value="Noviembre">Noviembre</option>
                                    <option value="Diciembre">Diciembre</option>
                                    </select>
                                </td>
                                </tr>
                                <tr>
                                    <td>Fecha de Inicio:</td>
                                    <td><input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required></td>
                                </tr>
                                <tr>
                                    <td>Fecha de Fin:</td>
                                    <td><input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required></td>
                                </tr>
                                <tr><br>
                                    <td colspan="2"><center><button type="submit" class="btn btn-success float-center">Agregar Arriendo</button></center></td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../conexion.php");
    // Recoger los valores del formulario
    $aren_cedula_id = $_POST['aren_cedula_id'];
    $mes_arriendo = $_POST['mes_arriendo'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    // Preparar la consulta SQL para insertar los datos
    $query = "INSERT INTO arriendos (aren_cedula_id, mes_arriendo, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($query)) {
        // Vincular los parámetros para los marcadores
        $stmt->bind_param("ssss", $aren_cedula_id, $mes_arriendo, $fecha_inicio, $fecha_fin);
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro de arriendo agregado exitosamente.";
        } else {
            echo "Error: " . $stmt->error;
        }
        // Cerrar sentencia
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $mysqli->error;
    }
    // Cerrar conexión
    $mysqli->close();
}
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            var arriendoId = this.getAttribute('data-id');
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres borrar este arriendo? Serás redirigido a la página de Arrendatarios.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, bórralo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../controlador/borrar_arriendo.php?id=' + arriendoId;
                }
            });
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');

    if (success === 'true') {
        Swal.fire({
            icon: 'success',
            title: '¡Arriendo agregado!',
            text: 'El nuevo arriendo se ha agregado correctamente.',
        });
    }
});
</script>