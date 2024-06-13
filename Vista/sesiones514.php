<!DOCTYPE html>
<html lang="en">
<head>
<link rel="Website Icon" type="png" href=" ../vista/IMG/rent2.png">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>sesiones-user</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
  <link href="../modelo/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../modelo/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../modelo/assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../modelo/assets/css/sesiones514.css">
    <!-- Incluyendo jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluyendo SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<!--inicio de todo el cuerpo de la pagina-->
<body>
 <!--lugar para la imagen de perfil, sesion usuario -->
 <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>
 <header id="header">
  <div class="d-flex flex-column">
    <div class="profile">   
    <input type="file" id="profile-image" accept="image/*" style="display: none;">
    <img id="profile-img" src="" alt="" class="img-fluid rounded-circle">
 <!--ESPACIO DE PHP para hacer las conexiones y traer y llevar datos-->
<?php
  session_start();
  // Se verifica si el usuario ha iniciado sesión
  if (!isset($_SESSION['usuario'])) {
    // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: ../index.php");
    exit();
  }
  $username = $_SESSION['usuario'];
  $host_rentware = "localhost";
  $username_rentware = "root";
  $password_rentware = "";
  $database_rentware = "rentware";
    // Crear conexión
  $mysqli = new mysqli($host_rentware, $username_rentware, $password_rentware, $database_rentware);
  // Verificar conexión
  if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
    }
    // Consulta para obtener información del usuario
  $sql = "SELECT * FROM usuarios WHERE username = '$username'";
  $result = $mysqli->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombres = $row['nombres'];
    $apellidos = $row['apellidos'];
    $id_usuario = $row['id']; // Asumiendo que hay un campo id en la tabla usuarios
    // Mostrar nombre y apellido del usuario
    echo '<h1 class="text-light">' . htmlspecialchars($nombres) . ' ' . htmlspecialchars($apellidos) . '</h1>';
  } else {
    echo '<p>No se encontraron datos del usuario.</p>';
  }
  // Consulta para contar los mensajes no leídos para el usuario actual
  $sqlMensajesNoLeidos = "SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = $id_usuario AND is_read = 0";
  $resultadoMensajesNoLeidos = $mysqli->query($sqlMensajesNoLeidos);
  $mensajesNoLeidos = 0;
  if ($fila = $resultadoMensajesNoLeidos->fetch_assoc()) {
    $mensajesNoLeidos = $fila['no_leidos'];
  }
  // Consulta para contar los anuncios nuevos para el arrendatario actual
  $sqlAnunciosNuevos = "SELECT COUNT(*) AS nuevos FROM anuncios WHERE id_arrendador = {$id_usuario}";
  $resultadoAnunciosNuevos = $mysqli->query($sqlAnunciosNuevos);
  $anunciosNuevos = 0;
  if ($fila = $resultadoAnunciosNuevos->fetch_assoc()) {
    $anunciosNuevos = $fila['nuevos'];
  }
  $mysqli->close();
  ?>
 </div>
  <?php
  if (!isset($_SESSION['id_cargo'])) {
    header('Location: ../index.php'); // Redirigir al usuario si el id_cargo no está 
    exit();
 }
  $id_cargo = $_SESSION['id_cargo'];
  $cargo_nombre = ""; // Inicializar la variable que contendrá el nombre del cargo
  switch ($id_cargo) {
    case 1: // Arrendador
      $cargo_nombre = "A R R E N D A D O R";
      echo '<br><h1 class="animate__animated animate__pulse animate__infinite" style="margin: 0 auto; color:red; text-align:center; font-size:16px; font-family: \'Open Sans\', sans-serif;">' . $cargo_nombre . '</h1><hr style="border-color:white;">';
    ?>
        <!-- Mostrar contenido para arrendador -->
        <nav id="navbar" class="nav-menu navbar">
           <ul>
               <li><a href="perfil.php" class="nav-link scrollto active"><i class="bx bx-user"></i> <span>Mi perfil</span></a></li>
               <li class="dropdown">
                   <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="bx bx-key"></i> <span>Arrendatarios</span>
                   </a>
                   <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                       <li><a class="dropdown-item" href="tabla_tario.php">Ver tabla</a></li>
                       <li><a class="dropdown-item" href="agregar_atario.php">Agregar</a></li>
                   </ul>
               </li>
               <li><a href="inmueble.php" class="nav-link scrollto"><i class="bx bx-home"></i> <span>Inmuebles</span></a></li>

               <li><a href="vista_contratos.php" class="nav-link scrollto"><i class="bx bx-file"></i> <span>Contrato</span></a></li>
               <li> 
    <a href="users.php" class="nav-link scrollto">
        <span class="icono-mensaje"><i class="bx bx-message"></i></span>
        <span>Chat 
             <?php if ($mensajesNoLeidos > 0) { 
                 // La animación se aplica directamente al ícono de la campana
                 echo "<span class='alerta-mensajes-no-leidos mensajes-no-leidos' style='position: relative;'><i class='fas fa-bell animate__animated animate__tada animate__infinite' style='color: red;'></i><span style='position: absolute; top: 0; right: -1; color: white; font-size: smaller;'>$mensajesNoLeidos</span></span>"; 
              } ?>
        </span>
            </a>
          </li>
          <li>
            <a href="crearAnuncio.php" class="nav-link scrollto">
            <i class="bi bi-megaphone"></i><span> Anuncios</span></a>
          </li>
          <li><a href="../controlador/logout.php?logout_id=<?php echo $row['id']; ?>" class="nav-link scrollto logout">
              <i class="bx bx-power-off"></i> <span>Cerrar Sesión</span>
              </a>
          </li>
           </ul>
        </nav>
<?php
 break;
 case 2: // Arrendatario
    $cargo_nombre = "A R R E N D A T A R I O";
  echo '<br><h1 class="animate__animated animate__pulse animate__infinite" style="margin: 0 auto; color:red; text-align:center; font-size:16px">' . $cargo_nombre . '</h1><hr style="border-color:white;">';
?>
        <!-- Mostrar contenido para arrendatario -->
        <nav id="navbar" class="nav-menu navbar">
           <ul>
               <li><a href="perfil.php" class="nav-link scrollto active"><i class="bx bx-user"></i> <span>Mi perfil</span></a></li>
               <li><a href="servicios_tario.php" class="nav-link scrollto"><i class="fas fa-plug"></i><span> Mis servicios</span></a></li>
               <li><a href="arriendo_tario.php" class="nav-link scrollto"><i class="bx bx-home"></i> <span>Mi arriendo</span></a></li>
               <li><a href="contratos_tario.php" class="nav-link scrollto"><i class="bx bx-file"></i> <span>Mi Contrato</span></a></li>   
               <li> 
    <a href="users.php" class="nav-link scrollto">
        <span class="icono-mensaje"><i class="bx bx-message"></i></span>
        <span>Mi Chat 
             <?php if ($mensajesNoLeidos > 0) { 
                 // La animación se aplica directamente al ícono de la campana
                 echo "<span class='alerta-mensajes-no-leidos mensajes-no-leidos' style='position: relative;'><i class='fas fa-bell animate__animated animate__tada animate__infinite' style='color: red;'></i><span style='position: absolute; top: 0; right: 0; color: white; font-size: smaller;'>$mensajesNoLeidos</span></span>"; 
              } ?>
        </span>
    </a>
</li>
          <li>
            <a href="anuncios_tario.php" class="nav-link scrollto">
            <i class="bi bi-megaphone"></i> <span>Anuncios <?php if ($anunciosNuevos > 0) { echo "<span style='color: red;'>($anunciosNuevos nuevos)</span>"; } ?></span></a>
          </li>
               <li> 
               <li><a href="../controlador/logout.php?logout_id=<?php echo $row['id']; ?>" class="nav-link scrollto logout">
  <i class="bx bx-power-off"></i> <span>Cerrar Sesión</span>
</a>
</li>
           </ul>
        </nav> 
<?php
        break;
        case 514: // Admin
            $cargo_nombre = "A D M I N";
            echo '<br><h1 class="animate__animated animate__pulse animate__infinite" style="margin: 0 auto; color:red; text-align:center; font-size:16px">' . $cargo_nombre . '</h1><hr style="border-color:white;">';
          ?>
            <!-- Mostrar contenido para admin -->
            <nav id="navbar" class="nav-menu navbar">
               <ul>               
               <li><a href="perfil.php" class="nav-link scrollto active"><i class="bx bx-user"></i> <span>Mi perfil</span></a></li>
               <li><a href="tabla.php" class="nav-link scrollto"><i class="bx bx-home"></i> <span>usuarios</span></a></li>           
               <li><a href="../controlador/logout.php?logout_id=<?php echo $row['id']; ?>" class="nav-link scrollto logout">
  <i class="bx bx-power-off"></i> <span>Cerrar Sesión</span>
</a>
</li>
           </ul>
        </nav>
<?php
        break;
        default:
        break;
}
?>
 </div>
 </header>
 <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
  <div class="hero-container" data-aos="fade-in">
  <h1>¡Bienvenido,</h1>
  <h1 style="margin-left: 21.5px;"><?php echo $nombres; ?>!</h1>
           <br><br><br><br><br>
    <p style="margin-left: 21.5px;">Rent-Ware es  <span class="typed" data-typed-items="Ordenado., Cómodo., Flexible., Seguro."></span></p>
  </div>
 </section>
 <script src="../modelo/javascript/script_index.js"></script>
</body> 
<footer id="footer">
  <div class="container">
    <div class="copyright">
      <strong><span>Rent-Ware</span></strong>
    </div>
  </div>
</footer>
</html>
<script src="../modelo/javascript/notificaciones.js"></script>
 <script>
    const profileImage = document.getElementById('profile-img');
    // Obtener la imagen de perfil del usuario desde la base de datos
    function getProfileImage() {
        fetch('../controlador/obtener_imagen.php')
            .then(response => response.json())
            .then(data => {
                if (data && data.profile_image) {
                    profileImage.src = '../vista/uploads/' + data.profile_image.split('/').pop(); 
                }
            })
            .catch(error => {
                console.error('Error al obtener la imagen:', error);
            });
    }
    getProfileImage();
  document.addEventListener("DOMContentLoaded", function() {
    const changeProfilePicButton = document.getElementById('change-profile-pic');
    const profileImg = document.getElementById('profile-img');
    const fileInput = document.getElementById('profile-image');
    changeProfilePicButton.addEventListener('click', function() {
        fileInput.click(); // Hacer clic en el input de tipo file oculto
    });
    // Manejar el cambio en el input de tipo file
    fileInput.addEventListener('change', function() {
        const selectedFile = fileInput.files[0]; // Obtener el archivo seleccionado
        if (selectedFile) {
            const formData = new FormData();
            formData.append('profileImage', selectedFile);
            fetch('../controlador/actualizar_imagen.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Actualizar la imagen en la interfaz de usuario si la respuesta es exitosa
                if (data && data.success) {
                    profileImg.src = URL.createObjectURL(selectedFile);
                } else {
                    console.error('Error al actualizar la imagen.');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
        }
    });
  });
 </script>
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
 <script src="../modelo/assets/vendor/purecounter/purecounter_vanilla.js"></script>
 <script src="../modelo/assets/vendor/aos/aos.js"></script>
 <script src="../modelo/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="../modelo/assets/vendor/glightbox/js/glightbox.min.js"></script>
 <script src="../modelo/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
 <script src="../modelo/assets/vendor/swiper/swiper-bundle.min.js"></script>
 <script src="../modelo/assets/vendor/typed.js/typed.umd.js"></script>
 <script src="../modelo/assets/vendor/waypoints/noframework.waypoints.js"></script>
 <script src="../modelo/assets/vendor/php-email-form/validate.js"></script>
 <script src="../modelo/assets/js/main.js"></script>