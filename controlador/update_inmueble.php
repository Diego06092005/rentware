<?php
session_start();
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
//Se requiere la conexion de la base de datos. En este caso es conne.php
include_once("../modelo/conne.php");
//se crear clase usuario con diversas variables respecto a la edicion de los inmuebles 
class inmueble_manager {
    //Se crean variables para conectar las base de datos 
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
//La siguiente funcion nos ayudara a captar los arrendatarios que estan relacionados el usuario que esta en sesion(arrendador)
    public function get_arrendatarios($id_usuario) {
        $id_usuario = $this->mysqli->real_escape_string($id_usuario);
        //Se crea la instancia para la consulta Mysql
        $arrendatarios_query = "SELECT aren_cedula_id, aren_nombre, aren_apellido FROM arrendatario WHERE id_usuario = $id_usuario";
        $arrendatarios_result = $this->mysqli->query($arrendatarios_query);
        $arrendatarios = [];
//Verifica si hay resultados en la consulta y los devuelve dentro de una funcion
        if ($arrendatarios_result && $arrendatarios_result->num_rows > 0) {
            while ($row = $arrendatarios_result->fetch_assoc()) {
                $arrendatarios[] = $row;
            }
        }
//Devuelve los resultados a la funcion creada
        return $arrendatarios;
    }
//Se crea funcion para captar todos los inmuebles 
    public function get_inmueble($codigo_catastral) {
        //Se crean las instancias 
        $codigo_catastral = $this->mysqli->real_escape_string($codigo_catastral);
        //Se crea instancia para consulta mysql conde se captaran todos los inmuebles
        $sql = "SELECT * FROM inmueble WHERE Codigo_catastral = '$codigo_catastral'";
        $result = $this->mysqli->query($sql);

        if ($result && $result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
//Esta funcion nos permitira actualizar el inmueble 
    public function update_inmueble($codigo_catastral, $direccion, $nviviendas, $arrendatario, $precio, $estrato) {
        $codigo_catastral = $this->mysqli->real_escape_string($codigo_catastral);
        $direccion = $this->mysqli->real_escape_string($direccion);
        $arrendatario = $this->mysqli->real_escape_string($arrendatario);
//Se definen variables que se cambiaran en la consulta Mysql
        $sql = "UPDATE inmueble SET Direccion = '$direccion', Nviviendas = $nviviendas, Arrendatarios = '$arrendatario', Precio = $precio, Estrato = '$estrato' WHERE Codigo_catastral = '$codigo_catastral'";

        if ($this->mysqli->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}

// Crear instancia de la conexión a la base de datos
$conne = new conne();
$mysqli = $conne->get_conne();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Redirigir a la página de inicio de sesión
    header("Location: ../index.php");
    exit();
}

// Se crea la clase para btener ID de usuario
class user_manager {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
//La siguiente funcion nos permitira captar la id del usuario en sesion
    public function get_user_id($username) {
        $get_user_id_query = "SELECT id FROM usuarios WHERE username = ?";
        $user_id_statement = $this->mysqli->prepare($get_user_id_query);
        $user_id_statement->bind_param("s", $username);
        $user_id_statement->execute();
        $user_id_result = $user_id_statement->get_result();

        $id_usuario = null;
        if ($user_id_result && $user_id_result->num_rows > 0) {
            $user_data = $user_id_result->fetch_assoc();
            $id_usuario = $user_data['id'];
        }

        return $id_usuario;
    }
}

// Crear instancia de UserManager
$user_manager = new user_manager($mysqli);

// Obtener ID de usuario
$nombre_usuario = $_SESSION['usuario'];
$id_usuario = $user_manager->get_user_id($nombre_usuario);
// Obtener arrendatarios asociados al usuario
$arrendatarios = [];
if ($id_usuario !== null) {
    $inmueble_manager = new inmueble_manager($mysqli);
    $arrendatarios = $inmueble_manager->get_arrendatarios($id_usuario);
}

// Manejar la solicitud POST para actualizar el inmueble
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Codigo_catastral = $_POST['Codigo_catastral'];
    $Direccion = $_POST['Direccion']; 
    $Nviviendas = (int)$_POST['Nviviendas'];
    $arrendatario = $_POST['arrendatario'];
    $Precio = (float)$_POST['Precio'];
    $Estrato = $_POST['Estrato'];

    $inmueble_manager = new inmueble_manager($mysqli);
    if ($inmueble_manager->update_inmueble($Codigo_catastral, $Direccion, $Nviviendas, $arrendatario, $Precio, $Estrato)) {
        header("Location: inmueble.php");
        exit();
    } else {
        echo "Error al actualizar el registro.";
    }
}

// Obtener información del inmueble para mostrar en el formulario
$Codigo_catastral = $_GET['Codigo_catastral'];
$Codigo_catastral = $mysqli->real_escape_string($Codigo_catastral);
$inmueble_manager = new inmueble_manager($mysqli);
$row = $inmueble_manager->get_inmueble($Codigo_catastral);

if (!$row) {
    echo "Registro no encontrado.";
    exit();
}
