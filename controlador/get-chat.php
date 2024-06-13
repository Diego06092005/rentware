<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../modelo/config.php";
    $outgoing_id = $_SESSION['unique_id']; // Usamos 'unique_id' de la sesión
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";
    $sql = "SELECT messages.*, usuarios.profile_image FROM messages
            LEFT JOIN usuarios ON usuarios.id = messages.outgoing_msg_id
            WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
            OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            // Aquí se integra la comprobación y visualización de la imagen
            $msgContent = "";
            if (!empty($row['img_url'])) {
                // Envolver la imagen en un <a> que apunta a la imagen original y abrir en nueva pestaña
                $msgContent .= '<a href="../vista/img_chat/'.$row['img_url'].'" target="_blank"><img src="../vista/img_chat/'.$row['img_url'].'" alt="Imagen enviada" style="width: 150px; height: 200px; display: block; object-fit: cover; border-radius:5px;"></a>';
            }
            // antes:  $msgContent .= '<p>'.htmlspecialchars($row['msg']).'</p>'; 
            if (!empty($row['msg'])) {
                $msgContent .= '<p>'.htmlspecialchars($row['msg']).'</p>'; // Muestra el texto del mensaje
            }
            if ($row['outgoing_msg_id'] == $outgoing_id) { // Si el usuario actual es el remitente
                $output .= '<div class="chat outgoing">
                                <div class="details">' . 
                                    $msgContent .
                                '</div>
                            </div>';
            } else { // Si el usuario actual es el receptor
                $output .= '<div class="chat incoming">
                                <img src="../vista/uploads/' . $row['profile_image'] . '" alt="">
                                <div class="details">' . 
                                    $msgContent .
                                '</div>
                            </div>';
            }
        }
    } else {
        $output .= '<div class="text" style="color:white;">No hay mensajes disponibles. Una vez que envíe el mensaje, aparecerán aquí.</div>';
    }
    echo $output;
} else {
    header("location: ../index.php");
}

