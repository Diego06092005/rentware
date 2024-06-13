<?php
session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
$nombre_usuario = $_SESSION['usuario'];
require_once("../modelo/conexion.php");

if (isset($_GET['aren_cedula_id'])) {
    $aren_cedula_id = $_GET['aren_cedula_id'];
    // Consultar información del arrendatario
    $arrendatario_query = "SELECT aren_nombre, aren_apellido, aren_cedula_id FROM arrendatario WHERE aren_cedula_id = '$aren_cedula_id'";
    $arrendatario_result = $mysqli->query($arrendatario_query);
    if ($arrendatario_result && $arrendatario_result->num_rows > 0) {
        $arrendatario = $arrendatario_result->fetch_assoc();
        echo "<div class='container mt-3'>";
        echo "<div class='info-arrendatario'>";
        echo "<h2><a href='tabla_tario.php' class='btn btn-primary'><i class='bi bi-arrow-left'></i> Volver</a>";
        echo "<center>Información del Arrendatario (Servicios)</h2></center><br>";
        echo "<p><strong>Nombre:</strong> {$arrendatario['aren_nombre']} {$arrendatario['aren_apellido']}</p>";
        echo "<p><strong>Cédula:</strong> {$arrendatario['aren_cedula_id']}</p>";
        echo "</div>";
    } else {
        echo "<p class='text-white'>No se encontró el arrendatario.</p>";
        exit();
    }
    // Consulta de servicios asociados al arrendatario y mostrarlos
    $servicios_query = "SELECT id, nombre, descripcion, fecha_pago, fecha_fin FROM servicios WHERE id_arrendatario = '$aren_cedula_id'";
    $servicios_result = $mysqli->query($servicios_query);
    if ($servicios_result && $servicios_result->num_rows > 0) {
        echo "<div class='table-responsive mt-4'>";
        echo "<table class='table table-dark table-hover'>";
        echo "<thead><tr><th>Nombre</th><th>Descripción</th><th>Estado del servicio</th><th>Días Restantes</th><th>Fecha de Pago</th><th>Borrar</th></tr></thead>";
        echo "<tbody>";    
        while ($servicio = $servicios_result->fetch_assoc()) {
            $fechaPago = new DateTime($servicio['fecha_pago']);
            $fechaFin = new DateTime($servicio['fecha_fin']);
            $fechaActual = new DateTime();
            $fechaActual->setTime(0, 0, 0); // hora a medianoche             
            $fechaFin->setTime(0, 0, 0);    // la fecha de fin esta en medianoche
            
            // Calcular los días restantes de manera directa
            $diasRestantes = $fechaActual->diff($fechaFin)->days;

            // Incluir el día actual en el conteo
            if ($fechaActual <= $fechaFin) {
                $diasRestantes += 1;
            }

            // Ajustar específicamente para el caso de dos meses
            $intervaloMeses = $fechaActual->diff($fechaFin)->m;
            $intervaloDias = $fechaActual->diff($fechaFin)->d;
            if ($intervaloMeses == 2 && $intervaloDias == 0) {
                $diasRestantes = 62;
            }

            // Ajuste en la asignación de $textoDiasRestantes para cada caso
            if ($fechaActual > $fechaFin) {
                $estadoPagoIcono = "<i class='fas fa-times-circle' style='color: red;'> Vencido</i>";
                $textoDiasRestantes = "Servicio vencido";
            } else if ($diasRestantes <= 5) {
                $estadoPagoIcono = "<i class='fas fa-exclamation-circle' style='color: orange;'> ¡Pronto vence!</i>";
                $textoDiasRestantes = "Quedan " . $diasRestantes . " días";
            } else {
                $estadoPagoIcono = "<i class='fas fa-check-circle' style='color: green;'> En orden</i>";
                $textoDiasRestantes = "Quedan " . $diasRestantes . " días";
            }    

            $fechaPagoMostrar = $fechaPago->format('d-m-Y');
            $botonBorrar = "<button class='btn btn-danger' onclick='borrarServicio({$servicio['id']})'><i class='fas fa-trash'></i></button>";       
            // Mostrar fila de tabla
            echo "<tr>
                    <td>{$servicio['nombre']}</td>
                    <td>{$servicio['descripcion']}</td>
                    <td>{$estadoPagoIcono}</td>
                    <td>{$textoDiasRestantes}</td>
                    <td>{$fechaPagoMostrar}</td>
                    <td>{$botonBorrar}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";   
    } else {
        echo "<p class='text-red'>No se encontraron servicios para este arrendatario.</p>";
    }
    echo "</div>"; // Cierre del contenedor de Bootstrap
} else {
    echo "<p class='text-white'>Error: Falta el ID del arrendatario.</p>";
}

if (isset($_GET['borrarServicio'])) {
    $idServicio = $_GET['borrarServicio'];
    // Aquí colocas tu código para conectar a la base de datos si aún no lo has hecho
    // Preparar y ejecutar la consulta de borrado
    $stmt = $mysqli->prepare("DELETE FROM servicios WHERE id = ?");
    $stmt->bind_param("i", $idServicio);
    if ($stmt->execute()) {
        // Borrado exitoso, redirigir para limpiar la URL
        $urlSinParametro = preg_replace('/(&|\?)?borrarServicio=\d+/', '', $_SERVER['REQUEST_URI']);
        header("Location: $urlSinParametro");
        exit();
    } else {
        echo "Error al borrar el servicio.";
    }
}
?>

<br><br><br><br><br>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Meta tags requeridas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Agregar Servicio</title>
    <!-- Bootstrap CSS -->
     <!-- Icono de la página web -->     
    <link rel="icon" type="image/png" href="../vista/IMG/rent2.png"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
       

    <!-- Opcional: añade jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../modelo/assets/css/detalles_servicios.css">
</head>
<body>
    <br><br><br><br><br><br><br><br>
    <div class="container p-1 info-arrendatario">
        <br>
    <h3 class="mb-3" style="color: white; text-align:center;"><b>Agrega Servicios</b></h3>
    <hr>
    <form method="POST" action="../controlador/agregar_servicio.php" class="row g-3 mx-auto" style="max-width: 800px;">
        <input type="hidden" name="aren_cedula_id" value="<?php echo isset($_GET['aren_cedula_id']) ? $_GET['aren_cedula_id'] : ''; ?>">
        <div class="col-md-4 mx-auto">
            <label for="nombre_servicio" class="form-label" style="color: white;">Nombre del Servicio:</label>
            <input type="text" id="nombre_servicio" name="nombre_servicio" class="form-control" required>
        </div>
        <div class="col-md-4 mx-auto">
            <label for="descripcion_servicio" class="form-label" style="color: white;">Tipo</label>
            <select id="descripcion_servicio" name="descripcion_servicio" class="form-control" required>
                <option value="Compartido">Compartido</option>
                <option value="Individual">Individual</option>
            </select>
        </div>
        <div class="col-md-4 mx-auto">
            <label for="fecha_fin" class="form-label" style="color: white;">Fecha Inicio:</label>
            <input type="date" id="fecha_pago" name="fecha_pago" class="form-control" required>
        </div>
        <div class="col-md-4 mx-auto">
            <label for="fecha_fin" class="form-label" style="color: white;">Fecha Fin del servicio:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
        </div>
        <!-- se ajusta el espaciado superior utilizando mt-* (Bootstrap spacing classes) -->
        <div class="col-12 d-flex justify-content-center mt-4" >
            <button type="submit" class="btn btn-success" name="agregar_servicio">Agregar Servicio</button>
        </div>
       
    </form>
    <br>
</div>

    </form>
    </div>
    <br>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        if (success === 'true') {
            Swal.fire({
                icon: 'success',
                title: '¡Servicio agregado!',
                text: 'El nuevo servicio se ha agregado correctamente.',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Obtener el ID del arrendatario de la URL
                    const aren_cedula_id = urlParams.get('aren_cedula_id');
                    // Redirigir a la misma página con el ID del arrendatario
                    window.location.href = updateURLParameter(window.location.href, 'success', null);
                }
            });
        }
    });
    // Función para actualizar un parámetro de la URL
    function updateURLParameter(url, param, value) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set(param, value);
        return window.location.pathname + '?' + urlParams.toString();
    }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function borrarServicio(idServicio) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrarlo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = window.location.href + '&borrarServicio=' + idServicio;
        }
    });
}
</script>
 <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
</style>
