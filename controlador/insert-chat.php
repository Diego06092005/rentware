<?php 
session_start();
include_once "../modelo/config.php";

if(isset($_SESSION['unique_id'])) {
    // Verifica si el usuario está en sesión
    $outgoing_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']); // El ID del remitente
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); // El ID del receptor
    $message = mysqli_real_escape_string($conn, $_POST['message']); // El mensaje de texto
    
    // Verifica si el mensaje no está vacío
    if (!empty($message)) {
        if(isset($_FILES['image'])){
            $img_name = $_FILES['image']['name']; // Obteniendo el nombre del archivo
            $tmp_name = $_FILES['image']['tmp_name']; // Este es el nombre temporal del archivo cuando se sube al servidor
            // Podemos obtener la extensión del archivo dividiendo el nombre del archivo en partes y tomar la última parte
            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode); // Aquí obtenemos la extensión del archivo cargado por el usuario
            $extensions = ["jpeg", "PNG", "jpg", "png", ]; // Algunas extensiones de archivo para validar
            if(in_array($img_ext, $extensions) === true){
                $time = time(); // Esto es necesario para que cada imagen tenga un nombre único
                $new_img_name = $time.$img_name;
                if(move_uploaded_file($tmp_name,"../vista/img_chat/".$new_img_name)){ // Si la imagen se carga correctamente        
                    // Insertar la información de la imagen en la base de datos
                    $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, img_url) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    $emptyMsg = ""; // Mensaje vacío porque estamos enviando una imagen
                    mysqli_stmt_bind_param($stmt, "iiss", $incoming_id, $outgoing_id, $emptyMsg, $new_img_name);
                    mysqli_stmt_execute($stmt);
                }
            }
        } else {
            // Si no es una imagen, insertamos el mensaje de texto
            $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iis", $incoming_id, $outgoing_id, $message);
            mysqli_stmt_execute($stmt);
        }
    }
}

