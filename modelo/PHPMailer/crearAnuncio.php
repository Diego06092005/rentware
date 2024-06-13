
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
</head>
<?php
    session_start();
    require_once '../modelo/anuncioModel.php';
    require_once '../modelo/db.php';
    $db = new Database();
    $conn = $db->getConnection(); // Obtiene la conexión a la base de datos
    if ($conn === null) {
    die("Error al conectar a la base de datos");// mensaje de error en caso de fallar la conexion.
    }
    if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.php"); // Asegurar redirección si no hay sesión
    exit();
    }
    $id_usuario = $_SESSION['id_usuario']; // Obtener el id del usuario desde la sesión
    $modelo = new AnuncioModel($conn, $id_usuario);
    // Inicializamos $anuncios como un array vacío
    $anuncios = [];
    // Intentamos obtener los anuncios si hay conexión
    $anuncios = $modelo->getAnuncios($id_usuario);
    // Consulta para contar los mensajes no leídos dirigidos al usuario
    $sqlMensajesNoLeidos = "SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = ? AND is_read = 0";
    $stmt = $conn->prepare($sqlMensajesNoLeidos); // Preparar la consulta para mayor seguridad
    $stmt->bind_param("i", $id_usuario); // Protección contra inyección SQL
    $stmt->execute();
    $resultadoMensajesNoLeidos = $stmt->get_result();
    $mensajesNoLeidos = 0;
    if ($fila = $resultadoMensajesNoLeidos->fetch_assoc()) {
    $mensajesNoLeidos = $fila['no_leidos'];
    }
    $stmt->close();
?>
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
           <!--para el espacio entre imagen y arrendatarios -->
           <a style="margin-bottom: 10px;"></a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'tabla_tario.php' ? 'active' : ''; ?>" href="tabla_tario.php"><i class="fa fa-users"></i> Arrendatarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'inmueble.php' ? 'active' : ''; ?>" href="inmueble.php"><i class="fas fa-city"></i> Inmuebles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'vista_contratos.php' ? 'active' : ''; ?>" href="vista_contratos.php"><i class="bx bx-file"></i> Contratos</a>
                </li>
                <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'active' : ''; ?>" href="users.php">
                    <span style="display: inline-block; margin-right: 5px;"><i class="fas fa-comments" style="color:#08d847;"></i></span> Chat
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'crearAnuncio.php' ? 'active' : ''; ?>" href="crear_anuncio.php"><i class="bi bi-megaphone"></i> Anuncios</a>
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
    <div class="container mt-5" style="background-color: black; color: white; border-radius:50px;">
    <br>
    <h1 class="mb-4" style="text-align:center;">Crear Anuncios a tus arrendatarios.</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="../controlador/AnuncioController.php" method="post" class="mb-5">
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" class="form-control form-control-sm" name="titulo" id="titulo" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="contenido">Contenido:</label>
                    <textarea class="form-control form-control-sm" name="contenido" id="contenido" rows="3" required></textarea>
                </div>
                <br>
                <div class="form-row">
                    <div class="col">
                        <label for="fecha_publicacion">Fecha de Publicación:</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_publicacion" id="fecha_publicacion" required>
                    </div>
                    <br>
                    <div class="col">
                        <label for="fecha_expiracion">Fecha de Expiración:</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_expiracion" id="fecha_expiracion" required>
                    </div>
                </div>
                 <br>
                <center><button type="submit" class="btn btn-primary">Crear Anuncio</button></center>
            </form>
        </div>
    </div>
</div>
<div class="container mt-5" style="background-color: black; border-radius:50px;">
<br>
    <h2 style="text-align:center; color: white;">Mis Anuncios Publicados</h2>
    <hr>
    <div class="row">
        <?php foreach ($anuncios as $anuncio): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Titulo: <?php echo htmlspecialchars($anuncio['titulo']); ?></h5>
                    <hr>
                    <p class="card-text">Contenido: <?php echo htmlspecialchars($anuncio['contenido']); ?></p>
                    <hr>
                    <p class="card-text"><small class="text-muted"> Publicado: <?php
                      $fechaPublicacion = new DateTime($anuncio['fecha_publicacion']);
                      echo $fechaPublicacion->format('d-m-Y H:i');
                    ?></small></p>
                    <p class="card-text"><small class="text-muted">Expira: <?php echo htmlspecialchars($anuncio['fecha_expiracion']); ?></small></p>
            <!-- Botón de borrado -->
            <form action="" method="post">
    <input type="hidden" name="id_anuncio_a_borrar" value="">
    <input type="submit" name="borrar" value="Eliminar Anuncio">
</form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<br>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<style>
    body {
            background-image: url('../vista/IMG/fondos10.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-color: #f8f9fa;
            padding-top: 50px;
            min-height: 100vh;
            padding-top: 20px;
        }
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
          }
        .nav-link.active {
            color: red; /* Color de texto para el enlace activo */
          }
        .nav-link:hover {
            color: red; /* Color de texto al pasar el mouse */
          }
        .nav-item{
            margin-left: 10px; margin-right: 10px;
          }
    /* Estilos específicos para el menú desplegable del perfil de usuario */
    .navbar-nav .dropdown-menu {
        background-color: black; /* Fondo negro */
        color: white; /* Texto blanco */
    }
    .navbar-nav .dropdown-menu a {
        color: white; /* Texto de los enlaces blanco */
    }
    .navbar-nav .dropdown-menu a:hover {
        background-color: #555; /* Fondo de los enlaces al hacer hover */
        color: #ddd; /* Color del texto al hacer hover */
        }
    .table-responsive{
        border-radius: 10px;
    }
</style>
<script>
    // funcion para que los mjs no leidos llegue en 500 mlsegundos (medio segundo)
    function updateUnreadMessagesCount() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../controlador/get-unread-count.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                let unreadCount = xhr.responseText;
                const unreadSpan = document.querySelector(".alerta-mensajes-no-leidos span");
                if(unreadSpan) {
                    unreadSpan.textContent = unreadCount;
                } else if (unreadCount > 0) {
                    const chatLink = document.querySelector("a[href='users.php']");
                    const newUnreadSpan = document.createElement("span");
                    newUnreadSpan.className = "alerta-mensajes-no-leidos";
                    newUnreadSpan.innerHTML = `<i class='fas fa-bell animate__animated animate__tada animate__infinite' style='color: red;'></i><span>${unreadCount}</span>`;
                    chatLink.appendChild(newUnreadSpan);
                }
            }
        }
    };
    xhr.send();
    }
    setInterval(updateUnreadMessagesCount, 500);
