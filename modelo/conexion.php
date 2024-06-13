<?php

$host_rentware = "localhost";
$username_rentware = "root";
$password_rentware = "";
$database_rentware = "rentware";

$mysqli = new mysqli($host_rentware, $username_rentware, $password_rentware, $database_rentware);

if ($mysqli->connect_error) {
    die("Error de conexión a rentware: " . $mysqli->connect_error);
}
?>
