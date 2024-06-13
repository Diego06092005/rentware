<?php
    session_start();
    include_once "../modelo/config.php";
    // Cambio de 'unique_id' por 'id' para coincidir con el campo de tu tabla 'usuarios'
    $outgoing_id = $_SESSION['unique_id'];
    // Cambio de "users" a "usuarios" y ajuste de campos según tu esquema
    $sql = "SELECT * FROM usuarios WHERE NOT id = {$outgoing_id} ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "<p style='color: red;'>No hay Arrendatarios para mostrar aún.</p>";
    } elseif(mysqli_num_rows($query) > 0){
    
        include_once "data.php";
    }
    echo $output;
