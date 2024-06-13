<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arrendatarios</title>
    <!-- Icono de la página web -->
    <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
    <!-- Bootstrap Icons para iconos adicionales -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> 
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../modelo/assets/css/anuncios_tario.css">
       <!-- Incluyendo jQuery -->
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluyendo SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<?php
  session_start(); // Inicia una nueva sesión o reanuda la existente
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
?>
<body>
<!-- Barra Nav con Menú de Usuario -->
<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a href="sesiones514.php">
            <img src="../vista/IMG/logo2.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!--para el espacio entre imagen y arrendatarios -->
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
                        <li>
                            <a href="../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>" class="dropdown-item">
                                <i class="fas fa-sign-out-alt" style="color:red;"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<?php
require_once '../modelo/AnuncioModel.php';
require_once("../modelo/conexion.php");
if (!isset($_SESSION['id_usuario'])) {
    echo "<p class='text-center mt-5'>Necesitas iniciar sesión para ver los anuncios de tu arrendador.</p>";
} else {
    $id_usuario = $_SESSION['id_usuario'];
    // Consultar el id_arrendador para el usuario actual
    $query = "SELECT id_arrendador FROM usuarios WHERE id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $id_arrendador = $row['id_arrendador'];
            $queryAnuncios = "SELECT titulo, contenido, fecha_publicacion, fecha_expiracion FROM anuncios WHERE id_arrendador = ? AND fecha_expiracion >= CURDATE() ORDER BY fecha_publicacion DESC";
            if ($stmtAnuncios = $mysqli->prepare($queryAnuncios)) {
                $stmtAnuncios->bind_param("i", $id_arrendador);
                $stmtAnuncios->execute();
                $resultAnuncios = $stmtAnuncios->get_result();
                if ($resultAnuncios->num_rows > 0) {
                    echo "<div class='container mt-5'>";
                    echo "<h2 class='text-center'>Anuncios de tu Arrendador</h2>";
                    echo "<br>";
                    echo "<div class='row'>";
                    while ($anuncio = $resultAnuncios->fetch_assoc()) {
                        echo "<div class='col-md-6 anuncio-card'>";
                        echo "<div class='card' style='background-color: #000;'>";
                        echo "<div class='card-body'>";
                        echo "<div style='background-color:#007bff; color: white; text-align: left; padding: 5px; border-radius:5px;'>";
                        echo "<h5 class='card-title'>Titulo: " . htmlspecialchars($anuncio['titulo']) . "</h5>";
                        echo "</div>";  
                        echo "<br>";                
                        echo "<p class='card-text'><strong>Mensaje:</strong> " . nl2br(htmlspecialchars($anuncio['contenido'])) . "</p>";
                        echo "<hr>";                
                        echo "<div class='d-flex justify-content-between align-items-center'>";
                        echo "<hr>";
                        echo "<small class='text-muted2' style='display: block;'>Publicado el: " . strftime('%d/%B/%Y', strtotime($anuncio['fecha_publicacion'])) . ' a las ' . date('h:i A', strtotime($anuncio['fecha_publicacion'])) . "</small>";
                        if (new DateTime($anuncio['fecha_expiracion']) > new DateTime()) {
                            $fechaExpiracion = new DateTime($anuncio['fecha_expiracion']);
                            $fechaActual = new DateTime();             
                            // Calcula la diferencia entre las fechas
                            $diferencia = $fechaActual->diff($fechaExpiracion);                 
                            // Construye la cadena de texto para mostrar la diferencia
                            $textoExpiracion = "Expira en ";             
                            if ($diferencia->d > 0) {
                                $textoExpiracion .= $diferencia->d . " días ";
                            } elseif ($diferencia->h > 0) {
                                $textoExpiracion .= $diferencia->h . " horas";
                            } elseif ($diferencia->i > 0) {
                                $textoExpiracion .= $diferencia->i . " minutos ";
                            }                     
                            echo "<small class='text-muted2' style='display: block;'>$textoExpiracion</small>";
                        } else {
                            echo "<small class='text-muted1' style='display: block;'></small>";
                        }
                                
                        echo "</div>"; // Cierre de .d-flex
                        echo "</div>"; // Cierre de .card-body
                        echo "</div>"; // Cierre de .card
                        echo "</div>"; // Cierre de .col-md-6
                    }
                    echo "</div>"; // Cierre de .row
                    echo "</div>"; // Cierre de .container
                } else {
                    echo "<p class='text-center mt-5'style='font-size: 30px;' >Tu arrendador no tiene anuncios activos en este momento.</p>";
                }
                $stmtAnuncios->close();
            } else {
                echo "<p class='text-center mt-5'>Error preparando la consulta de anuncios.</p>";
            }
        } else {
            echo "<p class='text-center mt-5'>No se encontró el arrendador para este usuario.</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='text-center mt-5'>Error preparando la consulta de arrendador.</p>";
    }
}
$mysqli->close();
?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script src="../modelo/javascript/alert_tario.js"></script>

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










