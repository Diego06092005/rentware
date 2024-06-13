<?php
include_once "../modelo/config.php";
//  $id_usuario
$id_usuario = $_SESSION['id_usuario']; // asegura de haber iniciado la sesión correctamente
//  id_cargo del usuario
$id_cargo_usuario = $_SESSION['id_cargo']; // 1 para arrendador, 2 para arrendatario
//  inicializar $output y establecer conexión a la base de datos.
$output = "";
// Verificar si existe un término de búsqueda y leerlo de la sesión.
$searchTerm = isset($_SESSION['searchTerm']) ? $_SESSION['searchTerm'] : '';
// Limpiar la variable de sesión de búsqueda después de leerla para evitar afectar futuras cargas sin búsqueda específica.
unset($_SESSION['searchTerm']);
if ($id_cargo_usuario == 1) {
    // Si el usuario es un arrendador, obtén todos sus arrendatarios
    $sql = "SELECT * FROM usuarios WHERE id_arrendador = $id_usuario AND id_cargo = 2";
    if (!empty($searchTerm)) {
        $sql .= " AND (nombres LIKE '%$searchTerm%' OR apellidos LIKE '%$searchTerm%')";
    }
} else if ($id_cargo_usuario == 2) {
    // Este caso es más complicado porque asumimos que un arrendatario solo tiene un arrendador,
    // por lo que el término de búsqueda no aplicaría aquí como en el caso anterior.
    $sql = "SELECT * FROM usuarios WHERE id = (SELECT id_arrendador FROM usuarios WHERE id = $id_usuario)";
    // No se aplica filtro de búsqueda aquí porque la lógica supone un único arrendador.
} else {
    $sql = ""; // No se define una consulta si no se cumple ninguna de las condiciones anteriores.
}
if (!empty($sql)) {
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['id']}
                    OR outgoing_msg_id = {$row['id']}) AND (outgoing_msg_id = {$id_usuario} 
                    OR incoming_msg_id = {$id_usuario}) ORDER BY msg_id DESC LIMIT 1";
            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result = "Aún no hay mensajes.";
            (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;         
            // Indicador de mensaje nuevo
            $is_read = (isset($row2['is_read']) && $row2['is_read'] == 0 && $row2['incoming_msg_id'] == $id_usuario) ? false : true;
            if (!$is_read) {
       // Si el mensaje no ha sido leído, añade un indicador con animación al lado derecho
$msg = $msg . " <i class='fas fa-bell animate__animated animate__tada animate__infinite' style='color: red; font-size: 20px;'></i>";
            }      
            if (isset($row2['outgoing_msg_id'])) {
                ($id_usuario == $row2['outgoing_msg_id']) ? $you = "Tú: " : $you = "";
            } else {
                $you = "";
            }
            ($row['status'] == "Fuera de Línea") ? $offline = "offline" : $offline = "";
            $output .= '<a href="chat.php?user_id=' . $row['id'] . '">
                            <div class="content">
                            <img src="../vista/uploads/' . $row['profile_image'] . '" alt="">
                            <div class="details">
                                <span style="color:white;">' . $row['nombres'] . " " . $row['apellidos'] . '</span>
                                <p>' . $you . $msg . '</p>
                            </div>
                            </div>
                            <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                        </a>';
        }
    } else {
        $output = "<p style='color: red;'>No hay usuarios para mostrar aún.</p>";
    }
} else {
    $output = "No hay usuarios para mostrar.";
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


