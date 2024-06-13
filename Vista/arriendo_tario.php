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
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../modelo/assets/css/arriendo_tario.css">
     <!-- Incluyendo jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluyendo SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<?php
session_start();
include_once "../modelo/config.php"; // Incluye el archivo de configuración de la base de datos
  if (!isset($_SESSION['unique_id'])) { // Verifica si la sesión con 'unique_id' no está establecida
    header("location: ../index.php"); // Redirecciona al index.php si no hay sesión
    exit; // Termina la ejecución del script
    }
  $id_usuario = $_SESSION['id_usuario']; // Asigna el ID de usuario desde la sesión a una variable
  $stmt = $conn->prepare("SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = ? AND is_read = 0"); // Prepara la consulta SQL
  $stmt->bind_param("i", $id_usuario); // Vincula la variable al parámetro de la consulta
  if ($stmt->execute()) { // Ejecuta la consulta
    $resultado = $stmt->get_result(); // Obtiene el resultado de la consulta
    
  }
  $stmt->close(); // Cierre de la sentencia preparada
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
if (isset($_SESSION['usuario'])) {
    $username = $_SESSION['usuario'];
    $host_rentware = "localhost";
    $username_rentware = "root";
    $password_rentware = "";
    $database_rentware = "rentware";
    $mysqli = new mysqli($host_rentware, $username_rentware, $password_rentware, $database_rentware);
    if ($mysqli->connect_error) {
        die("Error de conexión a rentware: " . $mysqli->connect_error);
    }
    $sql = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombres = $row['nombres'];
        $apellidos = $row['apellidos'];
        $email = $row['email'];
        $cedula = $row['cedula'];
        $telefono = $row['telefono'];    
        
    } else {
        echo "<p>No se encontraron datos del usuario.</p>";
    }
    $mysqli->close();
} else {
    echo "<p>Usuario no autenticado.</p>";
}
if (isset($_SESSION['usuario'])) {
    $username = $_SESSION['usuario'];
    $host_rentware = "localhost";
    $username_rentware = "root";
    $password_rentware = "";
    $database_rentware = "rentware";
    $mysqli = new mysqli($host_rentware, $username_rentware, $password_rentware, $database_rentware);
    if ($mysqli->connect_error) {
        die("Error de conexión a rentware: " . $mysqli->connect_error);
    }
    $sql = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombres = $row['nombres'];
        $apellidos = $row['apellidos'];
        $email = $row['email'];
        $cedula = $row['cedula'];
        $telefono = $row['telefono'];
    } else {
        echo '<p>No se encontraron datos del usuario.</p>';
    }
    // Consulta para servicios
    $sqlServicios = "SELECT * FROM servicios WHERE id_arrendatario = '$cedula'";
    $resultServicios = $mysqli->query($sqlServicios);
    // Consulta para arriendos
    $sqlArriendos = "SELECT * FROM arriendos WHERE aren_cedula_id = '$cedula'";
    $resultArriendos = $mysqli->query($sqlArriendos);
  // la consulta para contar los mensajes no leídos
  $sqlMensajesNoLeidos = "SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = '{$cedula}' AND is_read = 0";
  $resultadoMensajesNoLeidos = $mysqli->query($sqlMensajesNoLeidos);
  $mensajesNoLeidos = 0;
  if ($fila = $resultadoMensajesNoLeidos->fetch_assoc()) {
      $mensajesNoLeidos = $fila['no_leidos'];
  }
    $mysqli->close();
} else {
    echo '<p>Usuario no autenticado.</p>';
}
?>
<body>
<!-- Barra de Navegación Responsive con Menú de Usuario -->
<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a href="sesiones514.php">
            <img src="../vista/IMG/logo2.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
         <!-- espacio entre imagen y arrendatarios -->
         <li style="margin-bottom: 20px; color:black;"></li>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'contratos_tario.php' ? 'active' : ''; ?>" href="contratos_tario.php"><i class="bx bx-file"></i> Contrato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'servicios_tario.php' ? 'active' : ''; ?>" href="servicios_tario.php"><i class="fas fa-plug"></i> Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'arriendo_tario.php' ? 'active' : ''; ?>" href="arriendo_tario.php"><i class="fas fa-home"></i> Tu Arriendo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>" href="users.php"><i class="fas fa-comments" style="color:#08d847;"></i> Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'anuncios_tario.php' ? 'active' : ''; ?>" href="anuncios_tario.php"><i class="bi bi-megaphone"></i> Anuncios</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="perfil.php"><i class="fa fa-user-circle" style="color:lightblue;"></i> Ir al perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>" class="nav-link scrollto logout">
            <span style="color: white;"><i class="fas fa-sign-out-alt" style="color:red;"></i> Cerrar Sesión</span>
          </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav><!-- Bootstrap Bundle JS - incluye Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
                    <!---->
                    <br>
                    <div class="container">
    <div class="info-usuario">
        <h2>Tú información de (Arriendo)</h2>
        <!-- información del usuario -->
        <p><strong>Nombres:</strong> <?php echo $nombres; ?></p>
   <br>
        <p><strong>Apellidos:</strong> <?php echo $apellidos; ?></p>     
    </div>
    <div class="tabla-servicios">
        <h2>Tus Arriendos Asociados</h2>
        <table class="table table-dark table-striped">
            <br>
            <thead>
            <tr>
                            <th>Mes de Arriendo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Estado del Arriendo</th>
                        </tr>
            </thead>
            <tbody></tbody>
            <?php
setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');
function formatearFechaCorta($fecha) {
    $fechaDateTime = new DateTime($fecha);
    $fechaFormateada = strftime('%d %b %Y', $fechaDateTime->getTimestamp());
    $fechaFormateada = ucwords($fechaFormateada);
    return $fechaFormateada;
}
if ($resultArriendos && $resultArriendos->num_rows > 0) {
    while ($arriendo = $resultArriendos->fetch_assoc()) {
        $fecha_inicio_formateada = formatearFechaCorta($arriendo['fecha_inicio']);
        $fecha_fin_formateada = formatearFechaCorta($arriendo['fecha_fin']);
        $fecha_inicio = new DateTime($arriendo['fecha_inicio']);
        $fecha_fin = new DateTime($arriendo['fecha_fin']);
        $fecha_actual = new DateTime(); // Fecha actual
        $fecha_actual->setTime(0, 0, 0); // Establecer la hora a medianoche
        $fecha_inicio->setTime(0, 0, 0);
        $fecha_fin->setTime(0, 0, 0);

        // Si la fecha de inicio es en mayo y la fecha de fin es en junio, establecer los días restantes como 31
        if ($fecha_inicio->format('m') == '05' && $fecha_fin->format('m') == '06') {
            $dias_restantes = 31;
        } else {
            // Calcular los días restantes normalmente
            $dias_restantes = $fecha_actual->diff($fecha_fin)->format("%a");
            if ($fecha_actual <= $fecha_fin) {
                $dias_restantes += 1; // día de hoy.
            }
        }
        // Resto del código para determinar el mensaje y el ícono
        if ($fecha_actual > $fecha_fin) {
            $mensaje_contador = "Arriendo finalizado. ";
            $icono = "<span style='color: red;'><i class='fas fa-times-circle'></i></span>";
        } else {
            if ($dias_restantes <= 5) {
                $icono = "<span style='color: orange;'><i class='fas fa-exclamation-circle'></i></span>";
                $mensaje_contador = "Días restantes: $dias_restantes ";
            } elseif ($dias_restantes >= 25) {
                $icono = "<span style='color: green;'><i class='fas fa-check-circle'></i></span>";
                $mensaje_contador = "Días restantes: $dias_restantes ";
            } else {
                $mensaje_contador = "Días restantes: $dias_restantes ";
            }
                }
                    $mensaje_contador .= $icono;

            // Imprimir la fila de la tabla
            echo "<tr><td>{$arriendo['mes_arriendo']}</td><td>{$fecha_inicio_formateada}</td><td>{$fecha_fin_formateada}</td><td>$mensaje_contador</td></tr>";
                }
            } else {
            echo "<tr><td colspan='4'>No se encontraron arriendos.</td></tr>";
        }
    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="../modelo/javascript/alert_tario.js"></script>
</body>
</html>
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
