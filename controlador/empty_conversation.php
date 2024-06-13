<?php
// empty_conversation.php
session_start();
include_once "../modelo/config.php";
if (!isset($_SESSION['unique_id']) || !isset($_POST['incoming_id'])) {
    // Redirige al usuario si no está autenticado o si falta el ID del destinatario
    echo 'error';
    exit;
}
$my_id = $_SESSION['unique_id'];
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

// Primero, obtén los nombres de archivo de las imágenes de los mensajes a borrar
$sql = "SELECT img_url FROM messages WHERE (incoming_msg_id = $my_id AND outgoing_msg_id = {$incoming_id}) OR (incoming_msg_id = {$incoming_id} AND outgoing_msg_id = $my_id)";
$query = mysqli_query($conn, $sql);

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        if (!empty($row['img_url'])) {
            // Intenta borrar cada archivo de imagen
            $file_path = 'img_chat/' . $row['img_url'];
            if (file_exists($file_path)) {
                unlink($file_path); // Borrar el archivo de imagen
            }
        }
    }
    // Ahora, borra los mensajes de la base de datos
    $sql_delete = "DELETE FROM messages WHERE (incoming_msg_id = $my_id AND outgoing_msg_id = {$incoming_id}) OR (incoming_msg_id = {$incoming_id} AND outgoing_msg_id = $my_id)";
    if (mysqli_query($conn, $sql_delete)) {
        echo 'success'; // Mensajes e imágenes asociadas borradas
    } else {
        echo 'error'; // Error al borrar mensajes
    }
} else {
    echo 'error'; // Error en la consulta inicial
}
?>
