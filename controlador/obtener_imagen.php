<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    exit(json_encode(['error' => 'Usuario no autenticado']));
}
$username = $_SESSION['usuario'];
$host_rentware = "localhost";
$username_rentware = "root";
$password_rentware = "";
$database_rentware = "rentware";
$mysqli = new mysqli($host_rentware, $username_rentware, $password_rentware, $database_rentware);
if ($mysqli->connect_error) {
    exit(json_encode(['error' => 'Error de conexión a rentware: ' . $mysqli->connect_error]));
}
$sql = "SELECT profile_image FROM usuarios WHERE username = '$username'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profileImage = $row['profile_image'];
    // Añadir el prefijo de la ruta:
    $profileImage = '../vista/uploads/' . $profileImage;
    exit(json_encode(['profile_image' => $profileImage]));
} else {
    exit(json_encode(['error' => 'No se encontraron datos del usuario']));
}

$mysqli->close();
?>
