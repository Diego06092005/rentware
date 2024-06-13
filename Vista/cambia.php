<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html"); 
    exit();
}

require_once("../modelo/conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // datos del formulario
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $id_cargo = $_POST['id_cargo'];
    
    $sql = "UPDATE usuarios SET username = '$username', password = '$password', email = '$email', nombres = '$nombres', apellidos = '$apellidos', cedula = '$cedula', fecha_nacimiento = '$fecha_nacimiento', telefono = '$telefono', id_cargo = '$id_cargo' WHERE id = $id";


    if ($mysqli->query($sql) === TRUE) {
        header("Location: tabla.php");
        exit();
    } else {
        echo "Error al actualizar el registro: " . $mysqli->error;
    }
}
$id = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE id = $id";
$result = $mysqli->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Registro no encontrado.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Agrega tu archivo de estilos personalizados aquí -->
    <link rel="stylesheet" href="../modelo/assets/css/cambia.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="animate__animated animate__bounceIn">Editar Registro</h1>
            <form method="POST" action="cambia.php">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <!-- Campos de entrada para los datos del usuario -->
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
            
            </div>
            
            <div class="form-group">
                <label for="password" class="text-light">Password:</label>
                <input type="text" class="form-control" name="password" value="<?php echo $row['password']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email" class="text-light">Correo Electrónico:</label>
                <input type="text" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="nombres" class="text-light">Nombres:</label>
                <input type="text" class="form-control" name="nombres" value="<?php echo $row['nombres']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="apellidos" class="text-light">Apellidos:</label>
                <input type="text" class="form-control" name="apellidos" value="<?php echo $row['apellidos']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="cedula" class="text-light">Número de Cédula:</label>
                <input type="text" class="form-control" name="cedula" value="<?php echo $row['cedula']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="fecha_nacimiento" class="text-light">Fecha de Nacimiento:</label>
                <input type="text" class="form-control" name="fecha_nacimiento" value="<?php echo $row['fecha_nacimiento']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="telefono" class="text-light">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" value="<?php echo $row['telefono']; ?>" required>
            </div>

            <div class="form-group">
    <label for="id_cargo" class="text-light">ID Cargo:</label>
    <input type="text" class="form-control" name="id_cargo" value="<?php echo $row['id_cargo']; ?>" required>
</div>

            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <br><br>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='tabla.php';">Volver</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
