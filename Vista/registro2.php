<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Registro</title>
    <link rel="Website Icon" type="png" href="../rentware/IMG/rent2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
</head>
<body>
    <div class="container">
        <!-- Formulario de Registro -->
        <form action="../controlador/register2.php" method="post" class="animate__animated animate__backInRight form-container" enctype="multipart/form-data">
    <h1>Nuevo Registro</h1>
    <p><input type="text" placeholder="Nombre" name="nombres"></p>
    <p><input type="text" placeholder="Usuario" name="new_username"></p>
    <p><input type="password" placeholder="Contraseña" name="new_password"></p>
    <p><input type="text" placeholder="Correo Electrónico" name="email"></p>
    <p><input type="text" placeholder="Apellidos" name="apellidos"></p>
    <p><input type="text" placeholder="Cédula" name="cedula"></p>
    <p><input type="text" placeholder="Teléfono" name="telefono"></p>
    <p>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="dd/mm/yyyy" required>
    </p>
    <p>
        <label for="id_cargo">Selecciona cargo:</label>
        <select name="id_cargo" id="id_cargo" required>
            <option value="1">Arrendador</option>
            <option value="2">Arrendatario</option>
            <option value="514">Solo ADMIN</option>
        </select>
    </p>
    <p>
        <label for="imagen">Tu imagen de perfil</label>
        <input type="file" id="imagen" name="imagen">
    </p>
    <input type="submit" value="Registrarse">
    <input type="button" value="Volver" class="volver-button" onclick="window.location.href='tabla.php';">
</form>

        
    </div>
</body>
</html>
