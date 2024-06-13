<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tu perfil</title>
  <link rel="Website Icon" type="png" href="../vista/IMG/rent2.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../modelo/assets/css/perfil.css">
</head>
<body>
<div class="container">
<?php
  session_start();
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
          //PARTE EN LA QUE SE DESGLOZA TODO ACERCA DE LA FOTO
          echo '<div class="row justify-content-center">';
          echo '<div class="col-md-7">';
          echo '<div class="profile-card text-center">';
          //flecha de volver
          echo '<h2><a href="sesiones514.php"><i class="fas fa-arrow-left"></i> Ir a sesiones</a></h2>';
          echo '<hr>';
          //texto de, "tu perfil"
          echo '<h2><i class="fa fa-user"></i> Tu perfil </h2>';
          echo '<div class="profile">';
          echo '<input type="file" id="profile-image" accept="image/*" style="display: none;">';
          echo '<img id="profile-img" src="" alt="" class="img-fluid rounded-circle custom-img mx-auto d-block">';
          //sesion para el icono y texto de cambiar foto
          echo '<button type="button" class="btn btn-danger" style="border-radius:20px;height:40px; width:40px; margin-top: -25px; position: relative;">';
          echo '<i id="change-profile-pic" class="bi bi-cloud-upload" style="color: white; font-size: 1.5em; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>'; 
          echo '<input id="../vista/uploads" type="file" style="display: none;" />';
          echo '</button>';
          //FIN FOTO
          echo '<br> <br><br>';
          echo '<h5 style="color:ligthblue;"><i class="fas fa-pencil-alt"></i> Edita tu perfil</h5>
          ';
          echo '<hr>';
          echo '<form method="POST" action="../controlador/guardar_cambios.php">';
          echo '<div style="display: flex; flex-direction: column;">'; // Contenedor principal
          echo '<div style="display: flex; align-items: center; margin-bottom: 10px;">'; // Contenedor para nombres
          echo '<p style="margin-right: 10px; width: 100px;">Nombres:</p>';
          echo '<input type="text" name="nombres" value="' . $nombres . '" placeholder="Nombres">';
          echo '</div>'; // Fin del contenedor para nombres
          echo '<div style="display: flex; align-items: center; margin-bottom: 10px;">'; // Contenedor para apellidos
          echo '<p style="margin-right: 10px; width: 100px;">Apellidos:</p>';
          echo '<input type="text" name="apellidos" value="' . $apellidos . '" placeholder="Apellidos">';
          echo '</div>'; // Fin del contenedor para apellidos
          echo '<div style="display: flex; align-items: center; margin-bottom: 10px;">'; // Contenedor para cédula
          echo '<p style="margin-right: 10px; width: 100px;">Cedula:</p>';
          echo '<input type="text" name="cedula" value="' . $cedula . '" placeholder="Cédula" readonly>';
          echo '</div>'; // Fin del contenedor para cédula
          echo '<div style="display: flex; align-items: center; margin-bottom: 10px;">'; // Contenedor para correo
          echo '<p style="margin-right: 10px; width: 100px;">Correo:</p>';
          echo '<input type="text" name="email" value="' . $email . '" placeholder="Correo Electrónico">';
          echo '</div>'; // Fin del contenedor para correo
          echo '<div style="display: flex; align-items: center; margin-bottom: 10px;">'; // Contenedor para teléfono
          echo '<p style="margin-right: 10px; width: 100px;">Telefono:</p>';
          echo '<input type="text" name="telefono" min="2999999999" maxLength="10" value="' . $telefono . '" placeholder="Teléfono">';
          echo '</div>'; // Fin del contenedor para teléfono
          echo '</div>'; // Fin del contenedor principal
          echo '<div style="margin-bottom: 10px;">';
          echo '<button type="submit">💾Guardar Cambios</button>';
          echo '</div>';
          echo '</form>';
          
          echo '</div>';
          echo '</div>';
          echo '</div>';
      } else {
          echo '<p>No se encontraron datos del usuario.</p>';
      }
      $mysqli->close();
  } else {
      echo '<p>Usuario no autenticado.</p>';
  }
  ?>
 </div>
    </div>
  </header>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<footer>
    <div class="marca-agua"></div>
</footer>
<br><br>
</body>
</html>
 <!-- script para la imagen update-->
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const exito = urlParams.get('exito');
    if (exito === 'true') {
        Swal.fire({
            icon: 'success',
            title: '¡Cambios guardados!',
            text: 'Los cambios se han guardado.',
        });
    }
    
    document.addEventListener("DOMContentLoaded", function() {
        const changeProfilePicButton = document.getElementById('change-profile-pic');
        const profileImg = document.getElementById('profile-img');
        const fileInput = document.getElementById('profile-image');

    changeProfilePicButton.addEventListener('click', function() {
        fileInput.click(); // Hacer clic en el input de tipo file oculto
    });
    fileInput.addEventListener('change', function() {
        const selectedFile = fileInput.files[0]; // Obtener el archivo 
        if (selectedFile) {
            // Crear un objeto FormData para enviar la imagen al 
            const formData = new FormData();
            formData.append('profileImage', selectedFile);
            // Enviar la imagen al servidor usando Fetch API o 
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
   // Obtener la imagen de perfil del usuario desde la base de datos
    const profileImage = document.getElementById('profile-img');

    // Obtener la imagen de perfil del usuario desde la base de datos
    function getProfileImage() {
        fetch('../controlador/obtener_imagen.php')
            .then(response => response.json())
            .then(data => {
                if (data && data.profile_image) {
                    profileImage.src = '../vista/uploads/' + data.profile_image.split('/').pop(); // Seleccionamos solo el nombre del archivo
                }
            })
            .catch(error => {
                console.error('Error al obtener la imagen:', error);
            });
    }

    // Llamar a la función para obtener la imagen al cargar la página
    getProfileImage();

    document.querySelectorAll('input[type="number"]').forEach(input =>{
  input.oninput = () =>{
    if(input.value.length > input.maxLength) input.value = input.value = input.value.slice(0, input.maxLength);
  };
}); 
</script>
