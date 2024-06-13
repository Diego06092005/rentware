<?php

class Conne {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "rentware";
    private $mysqli;

    // constructor que establece la conexión
    public function __construct() {
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->mysqli->connect_error) {
            die("Error de conexión a rentware: " . $this->mysqli->connect_error);
        }
    }

    // Método para obtener la conexión
    public function get_conne() {
        return $this->mysqli;
    }

    // Método para cerrar la conexión
    public function cerrar_conne() {
        $this->mysqli->close();
    }
}

// se creauna instancia de la clase para usar la conexión
$conne = new conne();
$mysqli = $conne->get_conne();


// Se cierra la conexion
$conne->cerrar_conne();
