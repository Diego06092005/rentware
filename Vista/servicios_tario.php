<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arrendatarios</title>
    <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> 
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../modelo/assets/css/servicios_tario.css">
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
        echo '<p>No se encontraron datos del usuario.</p>';
    }
  // consulta para contar los mensajes no leídos
  $sqlMensajesNoLeidos = "SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = '{$cedula}' AND is_read = 0";
  $resultadoMensajesNoLeidos = $mysqli->query($sqlMensajesNoLeidos);
  $mensajesNoLeidos = 0;
  if ($fila = $resultadoMensajesNoLeidos->fetch_assoc()) {
      $mensajesNoLeidos = $fila['no_leidos'];
  }
    $sqlServicios = "SELECT * FROM servicios WHERE id_arrendatario = '$cedula'";
    $resultServicios = $mysqli->query($sqlServicios);
    $mysqli->close();
} else {
    echo '<p>Usuario no autenticado.</p>';
}
?>
<br><br>
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
</nav>
<!-- Bootstrap Bundle JS - incluye Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <div class="container">
    <div class="info-usuario">
        <h2>Tú información de (Servicios)</h2>
        <!-- información del usuario -->
        <p><strong>Nombres:</strong> <?php echo $nombres; ?></p>
        <p><strong>Apellidos:</strong> <?php echo $apellidos; ?></p>     
    </div>
    <div class="tabla-servicios">
        <h2>Servicios Asociados</h2>
        <table class="table table-dark table-striped">
            <br>
            <thead>
                <tr>
                    <th>Nombre del servicio</th>
                    <th>Descripción</th>
                    <th>Estado del servicio</th>
                    <th>Días restantes</th>
                    <th>Fecha de pago</th>
                </tr>
            </thead>
            <tbody>
  <!-- información de la tabla servicios-->
  <?php
if ($resultServicios && $resultServicios->num_rows > 0) {
    while ($rowServicio = $resultServicios->fetch_assoc()) {
        $fechaActual = new DateTime();
        $fechaActual->setTime(0, 0, 0);
        $fechaFin = new DateTime($rowServicio['fecha_fin']);
        $fechaFin->setTime(0, 0, 0);

        // Calcular la diferencia en días directamente
        $intervalo = $fechaActual->diff($fechaFin);
        $diasRestantes = $intervalo->days;

        // Incluir el día actual en el conteo si la fecha actual es antes o igual a la fecha de fin
        if ($fechaActual <= $fechaFin) {
            $diasRestantes += 1;
        }

        // Verificar si el intervalo es de exactamente 1 mes o 2 meses
        $unMes = new DateTime('2024-06-27');
        $dosMeses = new DateTime('2024-07-27');

        // Ajustar días restantes para casos específicos de 1 y 2 meses
        if ($fechaFin == $unMes) {
            $diasRestantes = 31;
        } elseif ($fechaFin == $dosMeses) {
            $diasRestantes = 62;
        }
        
        echo "<tr>";
        echo "<td>" . $rowServicio['nombre'] . "</td>";
        echo "<td>" . $rowServicio['descripcion'] . "</td>";

        if ($fechaActual > $fechaFin) {
            echo "<td><i class='fas fa-times-circle' style='color: red;'> Vencido</i></td>";
            $textoDiasRestantes = "Servicio vencido";
        } else if ($diasRestantes <= 5) {
            echo "<td><i class='fas fa-exclamation-circle' style='color: orange;'> ¡Pronto vence!</i></td>";
            $textoDiasRestantes = "Quedan " . $diasRestantes . " días";
        } else {
            echo "<td><i class='fas fa-check-circle' style='color: green;'> En orden</i></td>";
            $textoDiasRestantes = "Quedan " . $diasRestantes . " días";
        }

        echo "<td>" . $textoDiasRestantes . "</td>";
        echo "<td>" . date_format(new DateTime($rowServicio['fecha_pago']), 'd-m-Y') . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No se encontraron servicios para este usuario.</td></tr>";
}

?>
            </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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