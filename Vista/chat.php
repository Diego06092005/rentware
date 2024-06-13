<!--=======================================================================================================
||||||||||<<<<<<<<      Inicio de la sesión y configuración    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<?php
  // Inicia una nueva sesión o reanuda una existente para mantener el estado del usuario
  session_start();
  // Incluye el archivo de configuración de la base de datos para establecer conexión
  include_once "../modelo/config.php";
?>

<!--=======================================================================================================
||||||||||<<<<<<<<      Verificación de sesión de usuario    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<?php
  // Si no existe un 'unique_id' en la sesión, redirige al usuario a la página de inicio de sesión
  if (!isset($_SESSION['unique_id'])) {
    header("location: ../index.php");
  }
?>

<!--=======================================================================================================
||||||||||<<<<<<<<      Asignación de variables de sesión    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<?php
  // Asigna a variables el ID de cargo y el ID único del usuario desde la sesión
  $id_cargo = $_SESSION['id_cargo'] ?? 0;  // Si no está definido, asigna 0
  $my_id = $_SESSION['unique_id'];         // ID único del usuario logueado
?>

<!--=======================================================================================================
||||||||||<<<<<<<<      Obtención y limpieza de parámetros GET    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<?php
  // Limpia el parámetro 'user_id' recibido vía GET para prevenir inyecciones SQL
  $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
?>

<!--=======================================================================================================
||||||||||<<<<<<<<      Manejo de eliminación de chats y usuarios    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<?php
  // Acciones a realizar si se solicitó eliminar un chat (y usuario asociado)
  if (isset($_POST['eliminar_chat'])) {
    // Elimina mensajes entre dos usuarios
    $delete_messages_query = "DELETE FROM messages WHERE (incoming_msg_id = $my_id AND outgoing_msg_id = $user_id) OR (incoming_msg_id = $user_id AND outgoing_msg_id = $my_id)";
    $result_messages = mysqli_query($conn, $delete_messages_query);
    // Elimina al usuario por su ID
    $delete_user_query = "DELETE FROM usuarios WHERE id = $user_id";
    $result_user = mysqli_query($conn, $delete_user_query);
    // Redirige a la página de chat si las eliminaciones fueron exitosas, o muestra un error
    if ($result_messages && $result_user) {
      header("Location: chat.php?user_id=$user_id");
      exit();
    } else {
      echo "Error al eliminar el chat.";
    }
  }
?>

<!--=======================================================================================================
||||||||||<<<<<<<<      Manejo de vaciado de chats    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<?php
  // Acciones a realizar si se solicitó vaciar el chat
  if (isset($_POST['vaciar_chat'])) {
    // Elimina todos los mensajes entre dos usuarios
    $delete_messages_query = "DELETE FROM messages WHERE (incoming_msg_id = $my_id AND outgoing_msg_id = $user_id) OR (incoming_msg_id = $user_id AND outgoing_msg_id = $my_id)";
    $result_delete = mysqli_query($conn, $delete_messages_query);

    // Redirige a la página de chat si la eliminación fue exitosa, o muestra un error
    if ($result_delete) {
      header("Location: chat.php?user_id=$user_id");
      exit();
    } else {
      echo "Error al vaciar el chat.";
    }
  }
?>
<?php include_once "header.php"; ?>
<!--=======================================================================================================
||||||||||<<<<<<<<      Declaración de DOCTYPE y configuración básica del documento    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="Website Icon" type="png" href="../vista/IMG/rent2.png">
  <link rel="stylesheet" type="text/css" href="../modelo/assets/css/style_chat.css">
</head>

<!--=======================================================================================================
||||||||||<<<<<<<<      Área principal de chat y manejo de estado de mensajes    >>>>>>>|||||||||||||||||||||||
============================================================================================================-->
<body>
  <div class="wrapper">
    <section class="chat-area">
      <?php
        // Actualiza el estado de los mensajes a 'leído' donde el remitente es el usuario logueado y el destinatario es el usuario en sesión
        $update_message_status = mysqli_query($conn, "UPDATE messages SET is_read = 1 WHERE incoming_msg_id = $my_id AND outgoing_msg_id = {$user_id}");
      ?>

      <!--=======================================================================================================
      ||||||||||<<<<<<<<      Cabecera del área de chat, incluyendo imagen y detalles del usuario    >>>>>>>|||||||||||||||||||||||
      ============================================================================================================-->
      <header>
        <?php
          // Obtiene los detalles del usuario al que se está enviando el mensaje
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
          $sql = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = {$user_id}");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          } else {
            header("location: users.php");
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="../vista/uploads/<?php echo $row['profile_image']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['nombres'] . " " . $row['apellidos'] ?></span>
          <p style="color:#08d847;"><?php echo $row['status']; ?></p>
        </div>

        <!--=======================================================================================================
        ||||||||||<<<<<<<<      Opciones de administrador para vaciar o eliminar chats    >>>>>>>|||||||||||||||||||||||
        ============================================================================================================-->
        <div class="vaciar-chat">
          <?php if ($id_cargo == 1): ?>
            <div class="menu-icon" onclick="toggleMenu()">
              <i class="fas fa-ellipsis-h"></i>
            </div>
            <div class="menu-content" style="display: none;">
              <form id="action-form" method="post">
                <button type="button" id="vaciar-chat-btn" class="menu-item">Vaciar chat</button>
                <button type="button" id="eliminar-chat-btn" class="menu-item">Eliminar Usuario</button>
              </form>
            </div>
          <?php endif; ?>
        </div>
      </header>
      <!--=======================================================================================================
      ||||||||||<<<<<<<<      Caja de chat donde se mostrarán los mensajes    >>>>>>>|||||||||||||||||||||||
      ============================================================================================================-->
      <div class="chat-box">
      </div>
      <!--=======================================================================================================
      ||||||||||<<<<<<<<      Área para escribir y enviar nuevos mensajes    >>>>>>>|||||||||||||||||||||||
      ============================================================================================================-->
      <form action="#" class="typing-area" enctype="multipart/form-data">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Escribe tu mensaje aquí..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
        <button type="button" id="upload-btn" style="font-size:24px; color: white;">
          <i class="fas fa-camera"></i>
        </button>
        <input type="file" id="file-upload" class="file-upload-input" accept="image/*"/>
      </form>
    </section>
  </div>
  <!--=======================================================================================================
  ||||||||||<<<<<<<<      Scripts para funcionalidades de chat y alertas    >>>>>>>|||||||||||||||||||||||
  ============================================================================================================-->
  <script src="../modelo/javascript/chat.js"></script>
  <script src="../modelo/javascript/alert.js"></script>
  <script src="../modelo/javascript/alert_chat.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>