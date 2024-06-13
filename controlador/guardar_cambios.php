<?php
session_start();
if (isset($_SESSION['usuario'])) {
    $username = $_SESSION['usuario'];
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");
    // Verificar si se enviaron datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir datos del formulario
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $cedula = $_POST['cedula'];
        $telefono = $_POST['telefono'];
        // Actualizar datos en la base de datos
        $sql = "UPDATE usuarios SET nombres='$nombres', apellidos='$apellidos', email='$email', telefono='$telefono' WHERE username='$username'";
        if ($mysqli->query($sql) === TRUE) {   
         header("Location: ../Vista/perfil.php?exito=true");
        } else {
            echo "Error al actualizar los datos: " . $mysqli->error;
        }
    }
    $mysqli->close();
} else {
    echo '<p>Usuario no autenticado.</p>';
}
?>
<a href="../Vista/perfil.php" class="login-link">Volver al Perfil</a>
<style>
    .login-link {
    display: inline-block;
    padding: 12px 20px;
    background-color: #FF0000;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s, color 0.3s, transform 0.3s;
 }
 .login-link:hover {
    background-color: #00FF00;
    color: rgb(0, 0, 0);
    transform: scale(1.05);
 }
 /* Otros estilos que puedas necesitar para el enlace */
   .success-message {
    color: #008000; /* Verde oscuro */
    font-weight: bold;
    font-size: 30px; /* Tamaño de la fuente */
    margin-top: 20px; /* Espacio superior */
 }
    body {
    background-image: url('../vista/IMG/rent.png'); 
    background-size: cover; 
    background-position: center center; 
    text-align: center;
    margin-top: 50px;
    background-color: #333; /* Negro */
    color: #fff; /* Blanco */
 }
 .login-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498db; /* Azul */
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
 }
 /* Estilos para el formulario */
 form {
    background-color: #fff; /* Blanco */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 20px;
 }
 label {
    display: block;
    margin-bottom: 8px;
    color: #333; /* Negro */
 }
 input,
 select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc; /* Gris */
    border-radius: 4px;
    box-sizing: border-box;
    background-color: #fff; /* Blanco */
    color: #333; /* Negro */
 }
 select {
    appearance: none;
    -webkit-appearance: none;
 }
 /* Estilo para el mensaje de error */
 .error-message {
    color: #ff0000; /* Rojo */
    font-weight: bold;
 }
 /* Estilo para el mensaje de éxito */
 .success-message {
    color: #008000; /* Verde oscuro */
    font-weight: bold;
 }
</style>