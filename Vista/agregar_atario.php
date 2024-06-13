<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
require_once("../modelo/conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_SESSION['usuario'];

    // Obtener otros datos del formulario
    $aren_cedula_id = $_POST['aren_cedula_id'];
    $aren_telefono = $_POST['aren_telefono'];
    $aren_nombre = $_POST['aren_nombre'];
    $aren_apellido = $_POST['aren_apellido'];

    // Consultar si la cédula ya existe en la base de datos
    $check_duplicate_query = "SELECT * FROM arrendatario WHERE aren_cedula_id = '$aren_cedula_id'";
    $duplicate_result = $mysqli->query($check_duplicate_query);

    if ($duplicate_result->num_rows > 0) {
        echo '<script>
                alert("La cédula ya está registrada. Por favor, verifica la información.");
                window.history.back();
              </script>';
        exit();
    }
     else {
        // Consultar el ID del usuario a partir del nombre de usuario
        $get_user_id_query = "SELECT id FROM usuarios WHERE username = '$nombre_usuario'";
        $user_id_result = $mysqli->query($get_user_id_query);
        if ($user_id_result->num_rows > 0) {
            $user_data = $user_id_result->fetch_assoc();
            $id_usuario = $user_data['id'];
            // Insertar el arrendatario con el ID del usuario correspondiente
            $insert_sql = "INSERT INTO arrendatario (aren_cedula_id, aren_telefono, aren_nombre, aren_apellido, id_usuario) 
                           VALUES ('$aren_cedula_id', '$aren_telefono', '$aren_nombre', '$aren_apellido', '$id_usuario')";
            
            if ($mysqli->query($insert_sql) === TRUE) {
                header("Location: bienvenido_tario.php");
                exit();
            } else {
                echo "Error al agregar arrendatario: " . $mysqli->error;
                exit();
            }
        } else {
            echo "El usuario asociado no existe";
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Arrendatario</title>
    <link rel="Website Icon" type="png" href="../rentware/IMG/rent2.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../modelo/assets/css/agregar_tario.css">
    <script src="../modelo/javascript/contador.js"></script>
   
</head>
<body> 
    <!-- Formulario agregar arrendatario. -->
    <div class="container">
        <br>  
        <form method="POST" action="agregar_atario.php">
<h1 class="mb-4" style="display: flex; align-items: center; justify-content: center;">
    <a class="navbar-brand" href="tabla_tario.php">
        <i class="ri-arrow-left-s-line ri-3x"></i>
    </a>
    <span>➕Agregar arrendatario</span>
</h1>
    <br>
<div class="mb-3">
    <label for="aren_nombre" class="form-label">Nombres:</label>
    <input type="text" class="form-control" name="aren_nombre" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+">
</div>
<div class="mb-3">
    <label for="aren_apellido" class="form-label">Apellidos:</label>
    <input type="text" class="form-control" name="aren_apellido" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+">
</div>
<div class="mb-3">
    <label for="aren_cedula_id" class="form-label">Cedula:</label>
    <input type="number" class="form-control" name="aren_cedula_id" min="299999"  maxlength="10"   required>
</div>
<div class="mb-3">  
    <label for="aren_telefono" class="form-label">Telefono:</label>
    <input type="number" class="form-control" name="aren_telefono" min="2999999999" maxlength="10"  required>
</div>
    <button type="submit" class="btn btn-primary btn-custom">💾Guardar</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <script>
document.querySelectorAll('input[type="number"]').forEach(input =>{
  input.oninput = () =>{
    if(input.value.length > input.maxLength) input.value = input.value = input.value.slice(0, input.maxLength);
  };
}); 
</script>
</body>
</html>
