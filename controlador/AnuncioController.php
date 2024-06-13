<?php
// Inicia la sesión para poder usar variables de sesión
session_start();
// Incluye los archivos necesarios para el funcionamiento del controlador
require_once '../modelo/AnuncioModel.php';
require_once '../modelo/db.php'; // Asume que 'db.php' contiene la clase 'Database'
// Definición de una constante para representar el cargo de arrendador
define('CARGO_ARRENDADOR', 1);
// Definición de la clase AnuncioController
class AnuncioController {
    private $modelo; // Variable para mantener la instancia del modelo
    // Constructor de la clase
    public function __construct() {
        // Comprueba si el usuario tiene el cargo de arrendador
        if ($_SESSION['id_cargo'] != CARGO_ARRENDADOR) {
            // Si no es arrendador, finaliza la ejecución y muestra un mensaje de error
            exit('Acceso denegado');
        }
        // Instancia el modelo AnuncioModel, pasando la conexión de la base de datos y el ID del usuario
        $this->modelo = new AnuncioModel(Database::getConnection(), $_SESSION['id_usuario']);
    }
    // Método para crear un anuncio
    public function crearAnuncio($titulo, $contenido, $fecha_publicacion, $fecha_expiracion) {
        // Llama al método del modelo para insertar el anuncio en la base de datos
        $this->modelo->insertarAnuncio($titulo, $contenido, $fecha_publicacion, $fecha_expiracion);
        // Redirige al usuario a la página de anuncio creado
        header('Location: ../vista/anuncio_creado.php');
    }
}
// Verifica si la solicitud actual es un POST, lo que indica que el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Crea una nueva instancia del controlador
    $controller = new AnuncioController();
    // Llama al método para crear un anuncio con los datos enviados desde el formulario
    $controller->crearAnuncio($_POST['titulo'], $_POST['contenido'], $_POST['fecha_publicacion'], $_POST['fecha_expiracion']);
}

