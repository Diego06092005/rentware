<?php
// Definición de la clase AnuncioModel
class AnuncioModel {
    private $db; // Variable para almacenar el objeto de conexión a la base de datos
    private $id_arrendador; // Variable para almacenar el ID del arrendador
    // Constructor de la clase, inicializa la conexión a la base de datos y el ID del arrendador
    public function __construct($db, $id_arrendador) { // Cambiar $id_arrendadr a $id_arrendador
        $this->db = $db; // Asigna el objeto de conexión a la base de datos
        $this->id_arrendador = $id_arrendador; // Asigna el ID del arrendador
    }
    // Método para insertar un anuncio en la base de datos
    public function insertarAnuncio($titulo, $contenido, $fecha_expiracion) {
        // Prepara la sentencia SQL para insertar el anuncio, con NOW() para registrar la fecha actual de publicación
        $stmt = $this->db->prepare("INSERT INTO anuncios (titulo, contenido, fecha_publicacion, fecha_expiracion, id_arrendador) VALUES (?, ?, NOW(), ?, ?)");
        // Vincula los parámetros a la sentencia SQL preparada
        $stmt->bind_param("sssi", $titulo, $contenido, $fecha_expiracion, $this->id_arrendador);
        // Ejecuta la sentencia preparada
        $stmt->execute();
        // Cierra el statement para liberar recursos
        $stmt->close();
    }
    // Método para obtener los anuncios de un arrendador específico
    public function getAnuncios() {
        $anuncios = []; // Inicializa un array para almacenar los anuncios
        // Prepara la consulta SQL para seleccionar anuncios del arrendador
        $sql = "SELECT titulo, contenido, fecha_publicacion, fecha_expiracion FROM anuncios WHERE id_arrendador = ?";
        $stmt = $this->db->prepare($sql);
        // Vincula el ID del arrendador al parámetro de la consulta SQL
        $stmt->bind_param("i", $this->id_arrendador);
        // Ejecuta la sentencia preparada
        $stmt->execute();
        // Obtiene el resultado de la consulta
        $result = $stmt->get_result();
        // Itera sobre cada fila del resultado
        while ($row = $result->fetch_assoc()) {
            $anuncios[] = $row; // Añade cada fila al array de anuncios
        }
        // Cierra el statement para liberar recursos
        $stmt->close();
        // Devuelve el array de anuncios
        return $anuncios;
    }
}