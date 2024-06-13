<!--==========================================================================================================
||||||||||<<<<<<<< Sección HTML5 y links de Bootstrap, Font Awesome, y más estilos >>>>>>>||||||||||||||||||||
============================================================================================================-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arrendatarios</title>
    <!-- Icono de la página web -->
    <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    <link rel="stylesheet" href="../modelo/assets/css/crearAnuncio.css">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <!-- Incluyendo jQuery -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluyendo SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!--==========================================================================================================
||||||||||<<<<<<<< Sección lógica de inicio de sesión y conexión a la base de datos >>>>>>>|||||||||||||||||||
============================================================================================================-->
<?php
    session_start(); // Inicia una nueva sesión o reanuda la existente
    require_once '../modelo/anuncioModel.php'; // Incluye el modelo de anuncios para la lógica de negocio
    require_once '../modelo/db.php'; // Incluye la clase Database para manejar la conexión
    $db = new Database(); // Crea una nueva instancia de Database
    $conn = $db->getConnection(); // Obtiene la conexión a la base de datos
    if ($conn === null) {
        die("Error al conectar a la base de datos"); // Finaliza el script si la conexión falla
    }
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: ../index.php"); // Redirecciona si el usuario no está logueado
        exit();
    }
    $id_usuario = $_SESSION['id_usuario']; // Almacena el ID del usuario de la sesión
    $modelo = new AnuncioModel($conn, $id_usuario); // Crea un nuevo modelo de anuncios para el usuario
    $anuncios = $modelo->getAnuncios($id_usuario); // Obtiene los anuncios del usuario
    $sqlMensajesNoLeidos = "SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = ? AND is_read = 0"; // Consulta SQL para contar mensajes no leídos
    $stmt = $conn->prepare($sqlMensajesNoLeidos); // Prepara la consulta para ejecución
    $stmt->bind_param("i", $id_usuario); // Vincula el ID del usuario a la consulta
    $stmt->execute(); // Ejecuta la consulta preparada
    $resultadoMensajesNoLeidos = $stmt->get_result(); // Obtiene el resultado de la consulta
    $mensajesNoLeidos = 0;
    if ($fila = $resultadoMensajesNoLeidos->fetch_assoc()) {
        $mensajesNoLeidos = $fila['no_leidos']; // Almacena la cantidad de mensajes no leídos
    }
    $stmt->close(); // Cierra el statement
?>
  <!-- ==============================================================================================
// Sección: Barra de Navegación Responsive con Menú de Usuario
=============================================================================================== -->
<!-- Comienzo del documento HTML -->
<body>
    <!-- Inicio de la barra de navegación -->
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top" style="background-color: black;">
        <!-- Contenedor fluido para una mejor adaptabilidad -->
        <div class="container-fluid">
            <!-- Enlace al logo que redirige a la página inicial -->
            <a href="sesiones514.php">
                <img src="../vista/IMG/logo2.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            </a>
            <!-- Botón hamburguesa para el menú en versiones móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Espacio visual entre el logo y el menú -->
            <a style="margin-bottom: 10px;"></a>
            <!-- Contenido colapsable del menú -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!-- Lista de enlaces de navegación, lado izquierdo -->
                <ul class="navbar-nav me-auto">
                    <!-- Elemento individual del menú: Arrendatarios -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'tabla_tario.php' ? 'active' : ''; ?>" href="tabla_tario.php"><i class="fa fa-users" style="color:red;"></i> Arrendatarios</a>
                    </li>
                    <!-- Elemento individual del menú: Inmuebles -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'inmueble.php' ? 'active' : ''; ?>" href="inmueble.php"><i class="fas fa-city" style="color:orange;"></i> Inmuebles</a>
                    </li>
                    <!-- Elemento individual del menú: Contratos -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'vista_contratos.php' ? 'active' : ''; ?>" href="vista_contratos.php"><i class="bx bx-file" style="color:lightblue;"></i> Contratos</a>
                    </li>
                    <!-- Elemento individual del menú: Chat -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>" href="users.php">
                            <span style="display: inline-block; margin-right: 5px;"><i class="fas fa-comments" style="color:#08d847;"></i></span> Chat
                        </a>
                    </li>
                    <!-- Elemento individual del menú: Anuncios -->
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
                        <!-- Contenido del menú desplegable -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <!-- Opción para ir al perfil del usuario -->
                            <li><a class="dropdown-item" href="perfil.php"><i class="fa fa-user-circle" style="color:lightblue;"></i> Ir al perfil</a></li>
                            <!-- Opción para gestionar anuncios -->
                            <li>
                                <a class="dropdown-item" href="gestion_anuncios.php">
                                    <i class="fa fa-folder" style="color:yellow;"></i> Gestionar anuncios</a>
                            </li>
                            <!-- Separador visual -->
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
    <!-- Scripts de Bootstrap para la funcionalidad de componentes como el menú desplegable -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Contenedor principal -->
    <br>
    <div class="container mt-5" style="background-color: black; color: white; border-radius:50px;">
        <br>
        <!-- Título de la sección -->
        <h1 class="mb-4" style="text-align:center;">Crear Anuncios a tus arrendatarios.</h1>
        <!-- Formulario para la creación de anuncios -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="../controlador/AnuncioController.php" method="post" class="mb-5">
                    <!-- Campo para el título del anuncio -->
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" class="form-control form-control-sm" name="titulo" id="titulo" required>
                    </div>
                    <br>
                    <!-- Campo para el contenido del anuncio -->
                    <div class="form-group">
                        <label for="contenido">Contenido:</label>
                        <textarea class="form-control form-control-sm" name="contenido" id="contenido" rows="3" required></textarea>
                    </div>
                    <br>
                    <!-- Campo oculto para la fecha de publicación, gestionado automáticamente -->
                    <div class="invisible">
                        <div class="col">
                            <label for="fecha_publicacion">Fecha de Publicación:</label>
                            <input type="text" class="form-control form-control-sm" name="fecha_publicacion" id="fecha_publicacion" readonly>
                        </div>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <div class="col">
                        <center><button type="submit" class="btn btn-success" style="background-color:#08d847; color:black;">Crear Anuncio</button></center>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <!-- Contenedor principal para la sección de anuncios publicados -->
<div class="container mt-5" style="background-color: black; border-radius:50px;">
    <br>
    <!-- Título de la sección de anuncios publicados -->
    <h2 style="text-align:center; color: white;">Mis Anuncios Publicados</h2>
    <!-- Línea horizontal para separar visualmente el título del contenido -->
    <hr>
    <!-- Contenedor de tarjetas para cada anuncio -->
    <div class="row" id="cardsContainer">
        <!-- Iteración sobre la variable $anuncios para mostrar cada anuncio -->
        <?php foreach ($anuncios as $anuncio): ?>
        <!-- Columna para cada tarjeta de anuncio -->
        <div class="col-md-4 mb-4 card-item">
            <!-- Tarjeta para mostrar los detalles del anuncio -->
            <div class="card">
                <!-- Cuerpo de la tarjeta -->
                <div class="card-body">
    <!-- Título del anuncio -->
    <h5 class="card-title">Titulo: <?php echo htmlspecialchars($anuncio['titulo']); ?></h5>
    <!-- Separador visual dentro de la tarjeta -->
    <hr>
    <!-- Mensaje o contenido del anuncio -->
    <p class="card-text">Mensaje: <?php echo htmlspecialchars($anuncio['contenido']); ?></p>
    <!-- Separador visual dentro de la tarjeta -->
    <hr>
    <!-- Información de la fecha de publicación del anuncio -->
    <?php 
    $fechaHora = htmlspecialchars($anuncio['fecha_publicacion']);
    $partes = explode(' ', $fechaHora);
    $fecha = $partes[0];
    $hora = $partes[1];
    $ampm = (date('H', strtotime($hora)) < 12) ? 'AM' : 'PM';
    ?>
    <p class="card-text">Fecha de publicación: <?php echo $fecha; ?> Hora: <?php echo date('h:i:s', strtotime($hora)) . ' ' . $ampm; ?></p>
</div>


            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- Controles de paginación -->
    <div id="pagination">
        <!-- Botón para ir a la página anterior -->
        <button onclick="changePage(-1)" class="pagination-btn" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
        <!-- Indicador de página actual -->
        <span id="currentPage"></span>
        <!-- Botón para ir a la página siguiente -->
        <button onclick="changePage(1)" class="pagination-btn" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>
<br>
<!-- Scripts adicionales para jQuery, Popper.js y Bootstrap para soportar interacciones y estilos -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="../modelo/javascript/crearAnuncio.js"></script>
<script src="../modelo/javascript/notificaciones.js"></script>
</body>
</html>
  <!-- Script personalizado para la funcionalidad de usuarios -->
  <script src="../modelo/javascript/users.js"></script>
<!--Script para el contador de inactividad -->
<script>
    // Tiempo de inactividad en milisegundos (1 minuto)
    var inactivityTime = 30 * 60 * 1000; // 1 minuto en milisegundos
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


