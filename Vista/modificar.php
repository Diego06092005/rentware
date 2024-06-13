<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
require_once("../modelo/conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aren_cedula_id = $_POST['aren_cedula_id'];
    $new_aren_cedula_id = $_POST['new_aren_cedula_id']; 
    $aren_telefono = $_POST['aren_telefono'];
    $aren_nombre = $_POST['aren_nombre'];
    $aren_apellido = $_POST['aren_apellido'];
    $sql = "UPDATE arrendatario SET aren_cedula_id = '$new_aren_cedula_id', aren_telefono = '$aren_telefono', aren_nombre = '$aren_nombre', aren_apellido = '$aren_apellido' WHERE aren_cedula_id = '$aren_cedula_id'";

    if ($mysqli->query($sql) === TRUE) {
        header("Location: tabla_tario.php");
        exit();
    } else {
        echo "Error al actualizar el registro: " . $mysqli->error;
    }
}

$aren_cedula_id = $_GET['aren_cedula_id'];
$sql = "SELECT * FROM arrendatario WHERE aren_cedula_id = '$aren_cedula_id'";
$result = $mysqli->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Registro no encontrado.";
}

$mysqli->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Registro</title>
    <link rel="Website Icon" type="png" href="../rentware/IMG/rent2.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Enlace al CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../modelo/assets/css/modificar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body>

              <!-- tabla de contenido-->
        <div class="container mt-5" style="background-color: black; color: white; padding: 20px; margin-top: 10px; margin-bottom: 0; border-radius:10px;">
        <h2 class="mb-2" ><a class="navbar-brand" href="tabla_tario.php">
            <i class="ri-arrow-left-s-line ri-3x"></i>
            
        </a>🛠️Editar Registro👤</h2>

        <hr style="border-top: 1px solid gray;">
    <form method="POST" action="modificar.php">
        <input type="hidden" name="aren_cedula_id" value="<?php echo $row['aren_cedula_id']; ?>">
        <div class="form-group">
    <label for="new_aren_cedula_id">Cédula (no modificable):</label>
    <input type="text" class="form-control" name="new_aren_cedula_id" value="<?php echo $row['aren_cedula_id']; ?>" readonly style="background-color: #333; color: white; border: 1px solid #555;">
</div>

        <div class="form-group">
            <label for="aren_telefono">Teléfono:</label>
            <input type="number" class="form-control" name="aren_telefono" maxlength="10" value="<?php echo $row['aren_telefono']; ?>" required style="background-color: #333; color: white; border: 1px solid #555;">
        </div>
        <div class="form-group">
            <label for="aren_nombre">Nombres:</label>
            <input type="text" class="form-control" name="aren_nombre" value="<?php echo $row['aren_nombre']; ?>" required style="background-color: #333; color: white; border: 1px solid #555;">
        </div>
        <div class="form-group">
            <label for="aren_apellido">Apellidos:</label>
            <input type="text" class="form-control" name="aren_apellido" value="<?php echo $row['aren_apellido']; ?>" required style="background-color: #333; color: white; border: 1px solid #555;">
        </div>
        <div class="text-center">
    <input type="submit" class="btn btn-primary" value="💾Guardar">
</div>

    </form>
</div>

    <!-- Scripts de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!--  derecho de la imagen todas de arrendatario: alina_lada -->
<script>   
 document.querySelectorAll('input[type="number"]').forEach(input =>{
  input.oninput = () =>{
    if(input.value.length > input.maxLength) input.value = input.value = input.value.slice(0, input.maxLength);
  };
}); 

</script>
