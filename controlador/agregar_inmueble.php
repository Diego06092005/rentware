<?php
session_start();
require_once("../modelo/conexion.php");
class Inmueble
{
    private $mysqli;
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }
    public function agregar_inmueble($Codigo_catastral, $Direccion, $Nviviendas, $Arrendatarios, $Precio, $Estrato, $nombre_usuario, $id_usuario)
    {
        // Verificar duplicados
        $check_duplicate_query = "SELECT Codigo_catastral FROM inmueble WHERE Codigo_catastral = ?";
        $check_stmt = $this->mysqli->prepare($check_duplicate_query);
        $check_stmt->bind_param("s", $Codigo_catastral);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            return "El código catastral ya está registrado. Por favor, verifica la información.";
        }
        // Obtener ID de usuario
        $get_user_id_query = "SELECT id FROM usuarios WHERE username = ?";
        $user_id_stmt = $this->mysqli->prepare($get_user_id_query);
        $user_id_stmt->bind_param("s", $nombre_usuario);
        $user_id_stmt->execute();
        $user_id_stmt->store_result();
        if ($user_id_stmt->num_rows > 0) {
            $user_id_stmt->bind_result($id_usuario);
            $user_id_stmt->fetch();
            $user_id_stmt->close();
            // Insertar inmueble
            $sql = "INSERT INTO inmueble (Codigo_catastral, Direccion, Nviviendas, Arrendatarios, Precio, Estrato, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssisiii", $Codigo_catastral, $Direccion, $Nviviendas, $Arrendatarios, $Precio, $Estrato, $id_usuario);

                if ($stmt->execute()) {
                    return "Éxito al registrar el inmueble.";
                } else {
                    return "Error al insertar el registro: " . $stmt->error;
                }
                $stmt->close();
            } else {
                return "Error en la preparación de la consulta: " . $this->mysqli->error;
            }
        } else {
            return "El usuario asociado no existe";
        }
    }
}
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inmueble = new Inmueble($mysqli);

    // Obtener datos del formulario
    $Codigo_catastral = $_POST['Codigo_catastral'];
    $Direccion = $_POST['Direccion'];
    $Nviviendas = $_POST['Nviviendas'];
    $Arrendatarios = $_POST['Arrendatarios'];
    $Precio = $_POST['Precio'];
    $Estrato = $_POST['Estrato'];
    $nombre_usuario = $_SESSION['usuario'];
    // Agregar inmueble
    $mensaje = $inmueble->agregar_inmueble($Codigo_catastral, $Direccion, $Nviviendas, $Arrendatarios, $Precio, $Estrato, $nombre_usuario, $id_usuario);
   
    header("Location: ../Vista/agregar.php?exito=true");
}
