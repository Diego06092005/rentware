<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");

$registros_por_pagina = 10;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrar'])) {
    $nombre_usuario = $_SESSION['usuario'];
    $get_user_id_query = "SELECT id FROM usuarios WHERE username = '$nombre_usuario'";
    $user_id_result = $mysqli->query($get_user_id_query);
    if ($user_id_result && $user_id_result->num_rows > 0) {
        $user_data = $user_id_result->fetch_assoc();
        $id_usuario = $user_data['id'];
        $aren_cedula_id_borrar = $_POST['aren_cedula_id_borrar'];
        $delete_query = "DELETE FROM arrendatario WHERE aren_cedula_id = '$aren_cedula_id_borrar'";
        $delete_result = $mysqli->query($delete_query);
        if ($delete_result) {
            header("Location: tabla_tario.php");
            exit();
        } else {
            echo "Error al intentar borrar el arrendatario.";
        }
    } else {
        echo "Error: Usuario no encontrado.";
        exit();
    }
}
$nombre_usuario = $_SESSION['usuario'];
$get_user_id_query = "SELECT id FROM usuarios WHERE username = '$nombre_usuario'";
$user_id_result = $mysqli->query($get_user_id_query);
if ($user_id_result && $user_id_result->num_rows > 0) {
    $user_data = $user_id_result->fetch_assoc();
    $id_usuario = $user_data['id'];
    $result = null;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
        $busqueda = $mysqli->real_escape_string($_POST['busqueda']);
        $terminos = explode(" ", $busqueda);
        $nombre = $terminos[0];
        $apellido = isset($terminos[1]) ? $terminos[1] : '';
        $sql_arrendatarios = "SELECT * FROM arrendatario WHERE id_usuario = $id_usuario AND ((aren_nombre LIKE '%$nombre%' AND aren_apellido LIKE '%$apellido%') OR (aren_nombre LIKE '%$busqueda%' OR aren_apellido LIKE '%$busqueda%'))";
        $result = $mysqli->query($sql_arrendatarios);
    } else {
        $sql = "SELECT * FROM arrendatario WHERE id_usuario = $id_usuario";
        $result = $mysqli->query($sql);
    }
// Consulta para contar los mensajes no leídos para el usuario actual
$sqlMensajesNoLeidos = "SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = $id_usuario AND is_read = 0";
$resultadoMensajesNoLeidos = $mysqli->query($sqlMensajesNoLeidos);

$mensajesNoLeidos = 0;
if ($fila = $resultadoMensajesNoLeidos->fetch_assoc()) {
    $mensajesNoLeidos = $fila['no_leidos'];
}
} else {
    echo "Error: Usuario no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arrendatarios</title>
    <!-- Icono de la página web -->     
     <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    <!-- CSS de Bootstrap - Solo una versión -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <!-- Bootstrap Icons para iconos adicionales -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Animate.css para animaciones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> 
    <!-- Boxicons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
     <!-- Incluyendo jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluyendo SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Script de DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
   <!-- Script de Bootstrap (opcional si estás utilizando Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
   <!-- Script de DataTables Bootstrap -->
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="../modelo/assets/css/tabla_tario.css">
    <script>
$(document).ready(function() {
    $('.tabla-arrendatario').DataTable({
        "scrollY": "400px",
        "scrollCollapse": true,
        "lengthMenu": [5, 10, 15, 20 ],
        "paging": true, 
        "pageLength": 5,
        "startPage": 1,
        "searching": true, 
        "language": { 
            "lengthMenu": "Mostrar _MENU_ Registros por página",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "previous": "←",
                "next": "→"
            }
        }
    });
});
</script>
  
</head>
<body>
<!-- Barra de Navegación Responsive con Menú de Usuario -->
<nav class="navbar navbar-dark navbar-expand-lg fixed-top" style="background-color: black;">
        <div class="container-fluid">
            <a href="sesiones514.php">
                <img src="../vista/IMG/logo2.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Espacio visual entre el logo y el menú -->
            <a style="margin-bottom: 10px;"></a>
            <!-- Contenido colapsable del menú -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'tabla_tario.php' ? 'active' : ''; ?>" href="tabla_tario.php"><i class="fa fa-users" style="color:red;"></i> Arrendatarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'inmueble.php' ? 'active' : ''; ?>" href="inmueble.php"><i class="fas fa-city" style="color:orange;"></i> Inmuebles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'vista_contratos.php' ? 'active' : ''; ?>" href="vista_contratos.php"><i class="bx bx-file" style="color:lightblue;"></i> Contratos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>" href="users.php">
                            <span style="display: inline-block; margin-right: 5px;"><i class="fas fa-comments" style="color:#08d847;"></i></span> Chat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'crearAnuncio.php' ? 'active' : ''; ?>" href="crearAnuncio.php"><i class="bi bi-megaphone" style="color:orange;"></i> Anuncios</a>
                    </li>
                </ul>
                <!-- Lista de enlaces de navegación, lado derecho -->
                <ul class="navbar-nav ms-auto">
                    <!-- Menú desplegable para el usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="perfil.php"><i class="fa fa-user-circle" style="color:lightblue;"></i> Ir al perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <!-- Opción para cerrar sesión -->
                            <li><a href="../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>" class="nav-link scrollto logout">
                                <span style="color: white;"><i class="fas fa-sign-out-alt" style="color:red;"></i> Cerrar Sesión</span>
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container mt-4">
<!-- Barra de búsqueda -->
<br>
<?php
 // Consulta para obtener la cantidad de arrendatarios del usuario actual
 $sql_count = "SELECT COUNT(*) as total_arrendatarios FROM arrendatario WHERE id_usuario = $id_usuario";
 $result_count = $mysqli->query($sql_count);
 $sql = "SELECT arrendatario.*, 
 (SELECT fecha_fin FROM arriendos WHERE arriendos.aren_cedula_id = arrendatario.aren_cedula_id ORDER BY fecha_fin DESC LIMIT 1) AS fecha_fin_arriendo,
 (SELECT fecha_fin FROM servicios WHERE servicios.id_arrendatario = arrendatario.aren_cedula_id ORDER BY fecha_fin DESC LIMIT 1) AS fecha_fin_servicio
 FROM arrendatario WHERE id_usuario = $id_usuario";
$result = $mysqli->query($sql);
 if ($result_count) {
    $row_count = $result_count->fetch_assoc();
    $total_arrendatarios = $row_count['total_arrendatarios'];
 } else {
    $total_arrendatarios = 0;
 }

?>
 <!-- "Agregar Inmueble" con el ícono de casa -->
<a href="agregar_atario.php" class="btn btn-success">
    <i class="fas fa-plus"></i>
    <i class="fas fa-user"></i> 
   <span class="badge bg-secondary"><?php echo $total_arrendatarios; ?></span> <!-- Contador -->
</a>
  <br>
 <!-- div para la tabla arrendatarios -->
 <div class="table-arrendatario">
    <table class="tabla-arrendatario">
        <thead class="table-arrendatario">
            <tr>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Cédula</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Tipo de Gestión</th>
                <th scope="col">Acciones</th>
            </tr>
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
                <a href='vista_arriendo.php?aren_cedula_id=" . $row['aren_cedula_id'] . "&aren_nombre=" . $row['aren_nombre'] . "&aren_apellido=" . $row['aren_apellido'] . "' class='btn btn-info1'>$icono Arriendo</a>            
                <a href='detalles_servicios.php?aren_cedula_id=" . $row['aren_cedula_id'] . "' class='btn btn-primary1'>$icono_servicio Servicios</a>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<script src="../modelo/javascript/notificaciones.js"></script>
<script>
        function confirmDelete() {
            return confirm('¿Estás seguro de que deseas borrar este usuario? Esta acción no se puede deshacer.');
        }
</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
</style>

  <!-- Script personalizado para la funcionalidad de usuarios -->
  <script src="../modelo/javascript/users.js"></script>
<!--Script para el contador de inactividad -->
<script>
    // Tiempo de inactividad en milisegundos (1 minuto)
    var inactivityTime = 1 * 60 * 1000; // 1 minuto en milisegundos
    var timeout;
    var warningTimeout;
    function startTimer() {
        timeout = setTimeout(showLogoutWarning, inactivityTime - 10000); // Mostrar advertencia 10 segundos antes de cerrar la sesión
    }
    function resetTimer() {
        clearTimeout(timeout);
        clearTimeout(warningTimeout);
        startTimer();
    }
    function logoutUser() {
        window.location.href = "../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>"; // Redirigir a la página de cierre de sesión
    }
    function showLogoutWarning() {
        Swal.fire({
            title: 'Tu sesión está a punto de cerrarse',
            text: 'Debido a la inactividad, tu sesión se cerrará automáticamente en breve. ¿Deseas continuar en la sesión?',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Continuar en la sesión',
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 10000, // Tiempo límite para la interacción del usuario (10 segundos)
            timerProgressBar: true,
            willClose: () => {
                if (Swal.getTimerLeft() === 0) {
                    logoutUser(); // Cerrar sesión si el usuario no hace nada
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario elige continuar, reiniciar el temporizador y no cerrar la sesión
                resetTimer();
            }
        });
        // Establecer un timeout adicional para cerrar sesión si el usuario no interactúa con el diálogo
        warningTimeout = setTimeout(logoutUser, 10000);
    }
    // Iniciar el temporizador cuando se carga la página
    $(document).ready(function() {
        startTimer();
    });
    // Reiniciar el temporizador en la actividad del usuario
    $(document).mousemove(function() {
        resetTimer();
    });
    $(document).keypress(function() {
        resetTimer();
    });
</script>