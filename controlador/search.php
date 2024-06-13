<?php
    session_start();
    include_once "../modelo/config.php";
    $outgoing_id = $_SESSION['id_usuario'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $sql = "SELECT * FROM usuarios WHERE NOT id = {$outgoing_id} AND (nombres LIKE '%{$searchTerm}%' OR apellidos LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        $_SESSION['searchTerm'] = $searchTerm; // Guarda el término de búsqueda en la sesión.

        include_once "../controlador/data.php";
    }else{
        $output .= '<span style="color: white;">No hay usuarios relacionados con el nombre</span>';

    }
    echo $output;
?>