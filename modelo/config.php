<?php

$host_rentware = "localhost";
$username_rentware = "root";
$password_rentware = "";
$database_rentware = "rentware";

$conn = new mysqli($host_rentware, $username_rentware, $password_rentware, $database_rentware);

if ($conn->connect_error) {
    die("Error de conexión a rentware: " . $conn->connect_error);
}
?>
