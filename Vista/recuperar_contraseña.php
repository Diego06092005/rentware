<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Contraseña</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../modelo/assets/css/recuperar_contraseña.css">
</head>
<body><div class="table-responsive table-dark centered-content">
  <!-- formulario para ingresar contraseña nueva. -->
  <form action="../controlador/recuperacion.php" method="post">
    <h2 style="text-align: center;">Recuperar Contraseña</h2>
    <p>Ingresa tu dirección de email electrónico para recuperar tu contraseña:</p>
    <input type="email" name="email" placeholder="email Electrónico" required>
    <input type="submit" value="Recuperar Contraseña">
  </form>
  <div class="center-link">
    <a href="../index.php#about" class="custom-btn">Ir al login</a>
  </div>
</div>

</body>
</html>