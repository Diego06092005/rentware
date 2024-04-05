<?php

$host_rentware = "rentwaresv.database.windows.net";
$username_rentware = "diegoaguilar";
$password_rentware = "@Dso2617514";
$database_rentware = "rentware";

$mysqli = new mysqli($host_rentware, $username_rentware, $password_rentware, $database_rentware);

if ($mysqli->connect_error) {
    die("Error de conexión a rentware: " . $mysqli->connect_error);
}
?>
