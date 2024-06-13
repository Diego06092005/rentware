<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Restablece tu contraseña</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../modelo/assets/css/nueva_contraseña.css">
</head>
<body>
  <div class="container mt-5" id="formulario">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-3">Ingrese su nueva contraseña</h2>
        <!-- Verificar si hay un mensaje en la URL para mostrar la alerta -->
        <?php
        if(isset($_GET['mensaje'])) {
            if($_GET['mensaje'] == 'contraseña_cambiada') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Contraseña cambiada.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            } elseif($_GET['mensaje'] == 'cedula_invalida') {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alerta">
                        Cédula inválida.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            }
        }
        ?>
        <!-- Formulario para restablecer la contraseña -->
        <form action="../controlador/guardar_contraseña.php" method="POST">
          <div class="form-group">
            <!-- Campo para ingresar la nueva contraseña -->
            <label for="cedula">Cédula</label>
            <input type="text" class="form-control" name="cedula" id="cedula" placeholder="Ingrese su cédula" required pattern="[0-9]+" title="Solo se permiten números">
          </div>
          <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" name="contrasena" id="contrasena" placeholder="Ingrese su contraseña" required>
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">Mostrar</button>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" name="submit">Enviar</button>
          <a href="../index.php" class="btn btn-secondary">Volver al inicio</a>
        </form>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Función para alternar la visibilidad de la contraseña
    $(document).ready(function(){
      mostrarAlerta();
    });

    function mostrarAlerta() {
      // Se obtiene el mensaje de la URL
      var mensaje = "<?php echo isset($_GET['mensaje']) ? $_GET['mensaje'] : ''; ?>";
      // Si el mensaje es 'cedula_invalida', se muestra la alerta
      if(mensaje === 'cedula_invalida') {
        $('#alerta').addClass('show');
        setTimeout(function(){
          $('#alerta').removeClass('show');
        }, 5000); 
      }
    }
    // Función para alternar la visibilidad de la contraseña
    $(document).ready(function(){
      $('#togglePassword').click(function(){
        var tipo = $('#contrasena').attr('type');
        if(tipo === 'password'){
          $('#contrasena').attr('type', 'text');
          $('#togglePassword').text('Ocultar');
        } else {
          $('#contrasena').attr('type', 'password');
          $('#togglePassword').text('Mostrar');
        }
      });
    });
  </script>
</body>
</html>