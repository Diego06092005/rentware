<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html"); 
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="Website Icon" type="png" href="../rentware/IMG/rent2.png">
<link rel="stylesheet" href="../modelo/assets/css/registro.css">
<div class="circle-container">
    <a href="logout.php">
        <img src="../rentware/IMG/regresar.png" alt="regresar" style="width: 50px; height: auto;">
    </a>
</div>
    <title>Rent-ware - Registrarse</title>
</head>
<body>
    <h1>Rent-ware</h1>
    <div class="form-container">
        <h2>Registrarse</h2>
        <form action="register.php" method="POST">


            <label for="new_username">Nuevo Usuario:</label>
            <input type="text" id="new_username" name="new_username" required>
            
            <label for="new_password">Nueva Contraseña:</label>
            <input type="password" id="new_password" name="new_password" required>
            
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" required>
            
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required>
            
            <label for="cedula">Número de Cédula:</label>
            <input type="text" id="cedula" name="cedula" required>
            
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="telefono">Cargo: (1: Arrendaddor) - (2: Arrendatario))</label>
            <input type="tel" id="telefono" name="telefono" required>

            <input type="submit" value="Registrarse">
        </form>
        <br>
        <a class="volver-link" href="logout.php">Regresar al inicio de sesión</a>
       
       
    </div>
</body>
</html>
