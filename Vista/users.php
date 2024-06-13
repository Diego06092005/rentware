<!--=======================================================================================================
||||||||||<<<<<<<<      Seccion HTML5 y links de boostrap, styles...    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<!DOCTYPE html>
<html lang="es"> <!--Lenguaje español -->
<head>
    <meta charset="UTF-8">
    <title>Arrendatarios</title>
    <!-- Icono de la página web -->
    <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    <!-- CSS de Bootstrap -->
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
</head>
<!--FIN LINKS -->
<!--=======================================================================================================
||||||||||<<<<<<<< Seccion logica para obtener la sesion y los mensajes no leidos >>>>>>>||||||||||||||||||
============================================================================================================-->
<?php
session_start();
include_once "../modelo/config.php";

if (!isset($_SESSION['unique_id'])) {header("Location: ../index.php");
  exit();
}
$id_usuario = $_SESSION['unique_id'];
$id_cargo = $_SESSION['id_cargo'];
$mensajesNoLeidos = 0;
$stmt = $conn->prepare("SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = ? AND is_read = 0");
$stmt->bind_param("i", $id_usuario);
if ($stmt->execute()) {
    $resultado = $stmt->get_result();
    if ($fila = $resultado->fetch_assoc()) {
        $mensajesNoLeidos = $fila['no_leidos'];
    }
}
$stmt->close();
?>
<?php include_once "header.php"; // Incluye el archivo de cabecera ?>
<!--=======================================================================================================
            ||||||||||<<<<<<<< Seccion Navbar y su Contenido >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
 <body>
  <!-- Barra de navegación -->
  <nav class="navbar navbar-dark navbar-expand-lg fixed-top">
    <!-- Contenedor fluido para la barra de navegación -->
    <div class="container-fluid">
      <!-- Enlace al inicio -->
      <a href="sesiones514.php">
        <!-- Imagen del logo -->
        <img src="../vista/IMG/logo2.png" width="30" height="30" class="d-inline-block align-top" alt="">
      </a>
      <!-- Botón para mostrar menú en dispositivos móviles -->
       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
         </button>
               <!-- espacio entre imagen y arrendatarios -->
               <li style="margin-bottom: 20px; color:black;"></li>
          <!-- Espacio entre imagen y elementos de la barra de navegación -->
          <a style="margin-bottom: 10px; color:black;"></a>
            <!-- Contenido de la barra de navegación -->
             <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
               <!-- Lista de elementos de la barra de navegación -->
                <ul class="navbar-nav">
<!--==========================================================================================================
||||||||||<<<<<<<< Seccion logica y vista para el contenido con id_cargo = 1 >>>>>>>||||||||||||||||||||||||||
============================================================================================================-->
          <?php if ($_SESSION['id_cargo'] == 1): ?>
            <!-- Elementos de la barra de navegación para el Arrendador -->
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'tabla_tario.php' ? 'active' : ''; ?>" href="tabla_tario.php"><i class="fa fa-users" style="color:red;"></i> Arrendatarios</a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'inmueble.php' ? 'active' : ''; ?>" href="inmueble.php"><i class="fas fa-city" style="color:yellow;"></i> Inmuebles</a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'vista_contratos.php' ? 'active' : ''; ?>" href="vista_contratos.php"><i class="bx bx-file" style="color:lightblue;"></i> Contratos</a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>" href="users.php">
              <span style="display: inline-block; margin-right: 5px;"><i class="fas fa-comments" style="color:#08d847;"></i></span> Chats
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'crearAnuncio.php' ? 'active' : ''; ?>" href="crearAnuncio.php"><i class="bi bi-megaphone" style="color:orange;"></i> Anuncios</a>
<!--==========================================================================================================
||||||||||<<<<<<<< Seccion logica y vista para el contenido con id_cargo = 2 >>>>>>>||||||||||||||||||||||||||
============================================================================================================-->
          <?php elseif ($_SESSION['id_cargo'] == 2): ?>
            <!-- Elementos de la barra de navegación para el Arrendatario -->
            <a class="nav-link" href="contratos_tario.php"><i class="bx bx-file"></i> Contrato</a> <!-- redireccion a contratos y vista del texto del mismo -->
            <a class="nav-link" href="servicios_tario.php"><i class="fas fa-plug"></i> Servicios</a>  <!-- redireccion a servicios y vista del texto del mismo -->
            <a class="nav-link" href="arriendo_tario.php"><i class="fas fa-home"></i> Arriendo</a>  <!-- redireccion a arriendo y vista del texto del mismo -->
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>" href="users.php">
              <span style="display: inline-block; margin-right: 5px;"><i class="fas fa-comments" style="color:#08d847;"></i></span> Chat
            </a>  <!-- vista del texto chat con su icono de campana a los mensajes no leidos -->
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'anuncios_tario.php' ? 'active' : ''; ?>" href="anuncios_tario.php"><i class="bi bi-megaphone"></i> Anuncios</a>
          <?php endif; ?>  <!-- vista del texto Anuncios en el nav. -->
        </ul>
<!--==========================================================================================================
||||||||||<<<<<< Seccion para el contenido del lado derecho del nav, Perfil, cerrar sesion... >>>>>>>|||||||||
============================================================================================================-->
        <!-- Lista de elementos de la barra de navegación (lado derecho) -->
        <ul class="navbar-nav">
          <!-- Elemento desplegable para el perfil del usuario -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-user"></i> <!-- Icono de usuario en el nav -->
            </a>
            <!-- Menú desplegable -->
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <!-- Enlace para ir al perfil del usuario -->
              <li><a class="dropdown-item" href="perfil.php"><i class="fa fa-user" style="color:lightblue;"></i> Ir al perfil</a></li>
              <!-- Separador -->
              <li><hr class="dropdown-divider"></li>
              <!-- Enlace para cerrar sesión -->
              <li>
                <!-- Se toma el id_usuario para cerrar la sesion y cambiar el estado (desconenctado del chat). Redirige a logout.php-->
                <a href="../controlador/logout.php?logout_id=<?php echo $id_usuario; ?>" class="nav-link scrollto logout"> 
                  <span style="color: white;"><i class="fas fa-sign-out-alt" style="color:red;"></i> Cerrar Sesión</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<!-- FIN NAVBAR-->
<!--==========================================================================================================
||||||||||<<<<<<<< Seccion logica Y visual para la lista de usuarios en el chat. >>>>>>>||||||||||||||||||||||
============================================================================================================-->
  <!-- Contenido principal -->
  <div class="wrapper">
    <section class="users">
      <!-- Cabecera de la sección -->
      <header>
        <!-- Contenido de la cabecera -->
        <div class="content">
          <?php
          // Consulta SQL para obtener los datos del usuario actual
          $sql = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = {$_SESSION['unique_id']}");
          // Si se encontraron resultados en la consulta
          if (mysqli_num_rows($sql) > 0) {
            // Obtener la fila de resultados
            $row = mysqli_fetch_assoc($sql);
          }
          ?>
          <!-- Imagen de perfil del usuario -->
          <img src="../vista/uploads/<?php echo $row['profile_image']; ?>?v=<?php echo time(); ?>" alt="">
          <!-- Detalles del usuario -->
          <div class="details">
            <!-- Nombre completo del usuario -->
            <span style="color:white;"><?php echo $row['nombres'] . " " . $row['apellidos'] ?></span>
            <!-- Estado del usuario -->
            <p style="color:#08d847; margin-bottom: 0;"><?php echo $row['status']; ?></p>
            <!-- Cargo del usuario -->
            <span style="color:gray;"> <?php echo $row['id_cargo'] == 1 ? 'Arrendador' : ($row['id_cargo'] == 2 ? 'Arrendatario' : 'Otro'); ?> </span>
          </div>
        </div>
        <!-- Enlace para sesiones -->
        <a href="sesiones514.php" class="sesiones"><i class="fas fa-sign-out-alt"></i> Sesiones</a>
      </header>
      <!-- FIN HEADER -->
      <br>
      <!-- Si el usuario tiene el cargo 2 (Arrendatario) -->
      <?php if ($_SESSION['id_cargo'] == 2): ?>  
        <!-- Mensaje para seleccionar Arrendador -->
        <span class="text" style="color:white">Elige tu Arrendador para iniciar el chat</span>
        <hr>
      <?php endif; ?>
      <!-- Barra de búsqueda (visible solo para Arrendatarios) -->
      <div class="search" <?php if ($_SESSION['id_cargo'] == 2) echo 'style="display: none;"'; ?>>
        <!-- Mensaje de instrucción -->
        <span class="text" style="color:white">Elige o busca un Arrendatario para iniciar el chat</span>
        <!-- Input de búsqueda -->
        <input type="text" placeholder="Ingresa su nombre para buscar...">
        <!-- Botón de búsqueda -->
        <button><i class="fas fa-search"></i></button>
      </div>
      <!-- Lista de usuarios -->
      <div class="users-list">  
      </div>
    </section>
  </div>
  <!-- FIN lista de usuarios en el chat. -->
  <!-- Scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Script personalizado para la funcionalidad de usuarios -->
  <script src="../modelo/javascript/users.js"></script>
</body>
 <!--FIN BODY -->
</html>
<!--FIN HTML5 -->
<style>
   .nav-link:hover {
            color: red; /* Color de texto al pasar el mouse */
        }
</style>
  <!-- Script personalizado para la funcionalidad de usuarios -->
  <script src="../modelo/javascript/users.js"></script>
<!--Script para el contador de inactividad -->
<script>
    // Tiempo de inactividad en milisegundos (30 minutos)
    var inactivityTime = 30 * 60 * 1000; // 30 minutos en milisegundos
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