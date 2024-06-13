<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "../modelo/config.php";
    // En logout.php-.
$logout_id = mysqli_real_escape_string($conn, $_POST['logout_id']);
// get
$logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){
            $status = "Desconectado"; // este valor es adecuado para columna de estado
            // Actualizando la columna 'status'
            $sql = mysqli_query($conn, "UPDATE usuarios SET status = '{$status}' WHERE id = {$logout_id}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../index.php");
            }
        }else{
            header("location: ../index.php");
        }
    }else{  
        header("location: ../index.php");
    }
?>
