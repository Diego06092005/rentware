<?php
session_start();
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
//Se requiere la conexion de la base de datos. En este caso es conne.php
require_once("../modelo/conne.php");
//se crear clase usuario con diversas variables respecto a la conexion a la base de datos
class Usuario {
    private $conne;
    public function __construct() {
        $this->conne = new conne();
    }
//Se crea variable para captar la id y nombre del usuario que esta en la sesion
    public function get_id_usuario($nombre_usuario) {
        $mysqli = $this->conne->get_conne();
        //Se define instancia mediante consulta en mysql
        $get_user_id_query = "SELECT id FROM usuarios WHERE username = '$nombre_usuario'";
        $user_id_result = $mysqli->query($get_user_id_query);
        //verfica si la consulta es verdadera y si no lo es se retorna como falsa 
        if ($user_id_result && $user_id_result->num_rows > 0) {
            $user_data = $user_id_result->fetch_assoc();
            return $user_data['id'];
        } else {
            return false;
        }
    }
//se crea funcion que busca los inmuebles mediante la id del usuario que esta logeado y el codigo catastral que esta relacionado con el usuario 
    public function buscar_inmuebles($id_usuario, $codigo_catastral = '') {
        //se define la conexion ya establecida
        $mysqli = $this->conne->get_conne();
        //Se crea la variable que hace la consulta en mysql 
        if ($codigo_catastral !== '') {
            $sql = "SELECT * FROM inmueble WHERE id_usuario = $id_usuario AND Codigo_catastral = '$codigo_catastral'";
        } else {
            $sql = "SELECT * FROM inmueble WHERE id_usuario = $id_usuario";
        }
        //Retorna los resultados
        return $mysqli->query($sql);
    }
//Se crea funcion para borrar los inmuebles 
    public function borrar_inmueble($codigo_catastral, $id_usuario) {
        //se define la conexion ya establecida
        $mysqli = $this->conne->get_conne();
        //se hace el sql delete para borrar el inmueble registrado mediante el codigo catastral a eliminar 
        $sql_delete = "DELETE FROM inmueble WHERE Codigo_catastral = '$codigo_catastral' AND id_usuario = $id_usuario";
        return $mysqli->query($sql_delete);
    }
//Se crea funcion para captar los mensajes no leidos por el usuario 
       public function get_mensajes_no_leidos($id_usuario) {
        //se define la conexion ya establecida
        $mysqli = $this->conne->get_conne();
        //Se crea la variable mediante consultas a la base de datos de los mensajes no leidos    
        $sql_mensajes_no_leidos = "SELECT COUNT(*) AS no_leidos FROM messages WHERE incoming_msg_id = $id_usuario AND is_read = 0";
        $resultado_mensajes_no_leidos = $mysqli->query($sql_mensajes_no_leidos);
        //Se crea condicion si los mensajes fueron leidos y el resultado de las consultas
        if ($resultado_mensajes_no_leidos) {
            $fila = $resultado_mensajes_no_leidos->fetch_assoc();
            return $fila['no_leidos'];
        } else {
            return 0;
        }
    }  
}
// Uso de nueva instancia 
$usuario = new Usuario();
//Se capta el nombre del usuario del que esta en sesion
$nombre_usuario = $_SESSION['usuario'];
$id_usuario = $usuario->get_id_usuario($nombre_usuario);
if (isset($_SESSION['usuario'])) {
} else {
    echo "La sesión de usuario no está definida.";
}
//La siguiente condicion verifica si se cumplen diversas condicion para efectuar distintas acciones  
if ($id_usuario !== false) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Se busca el inmueble
        if (isset($_POST['buscar'])) {
            $codigo_catastral = $_POST['codigo_catastral'];
            $result = $usuario->buscar_inmuebles($id_usuario, $codigo_catastral);
            //Se elimina el inmueble seleccionado
        } elseif (isset($_POST['borrar'])) {
            $Codigo_catastral_a_borrar = $_POST['Codigo_catastral_a_borrar'];
            if ($usuario->borrar_inmueble($Codigo_catastral_a_borrar, $id_usuario)) {
                header("Location: inmueble.php");
                exit();
            } else {
                echo "Error al borrar el registro: " . $mysqli->error;
            }
        }
    } else {
        // Consulta original para obtener todos los inmuebles del usuario actual
        $result = $usuario->buscar_inmuebles($id_usuario);
    }
} else {
    echo "Error: Usuario no encontrado.";
}
//Se crea nueva clase que nos permitira conocer el total de los inmuebles
class inmueble_manager {
    private $mysqli;
//Se crea variable para la conexion 
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
//Se crea la variable para obtener el total de los inmuebles 
    public function get_total_inmuebles($id_usuario) {
        $total_inmuebles = 0;
//se verifica si el mysql esta conectado 
        if ($this->mysqli instanceof mysqli && !$this->mysqli->connect_errno) {
            // Se crea y ejecuta la consulta en mysql
            $sql_count = "SELECT COUNT(*) as total_inmuebles FROM inmueble WHERE id_usuario = ?";
            $stmt = $this->mysqli->prepare($sql_count);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            //Se crea la condicion para el resultado de la consulta mysql
            if ($result) {
                $row = $result->fetch_assoc();
                $total_inmuebles = $row['total_inmuebles'];
            }
            //Se cierra el objeto de la declaracion despues de ejecutar la consulta 
            $stmt->close();
        } else {
            //Se ejecuta mensaje si la conexion no esta establecida o esta cerrada
            echo "Error: Conexion Mysqli no establecida o esta cerrada";
        }
//retorna los resultados obtenidos 
        return $total_inmuebles;
    }
}
//Se establece  la conexion con todas los parametros 
$mysqli = new mysqli("localhost", "root", "", "rentware");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
//Se crea nueva instancia 
$inmueble_manager = new inmueble_manager($mysqli);
//Se capta la id del usuario que esta en sesion 

//Con la consulta Mysql ya creada se obtienen todos los inmuebles por la id del usuario
$total_inmuebles = $inmueble_manager->get_total_inmuebles($id_usuario);
