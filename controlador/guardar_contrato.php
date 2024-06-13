<?php
//cambiar la ruta segun sea necesario (modificado por jesus)
require_once("../modelo/conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_arrendatario = $_POST["arrendatario"];

    // Procesar archivo subido.
    $archivo_nombre = $_FILES["archivo"]["name"];
    $archivo_tmp = $_FILES["archivo"]["tmp_name"];
    $archivo_destino = "../modelo/Descargas/" . $archivo_nombre;

    // Mover archivo a carpeta destino.
    move_uploaded_file($archivo_tmp, $archivo_destino);

    // Insertar información en la tabla contratos.
    $query = "INSERT INTO contratos (archivo, id_arrendatario) VALUES ('$archivo_nombre', $id_arrendatario)";
    mysqli_query($mysqli, $query);

    header("Location: ../Vista/vista_contratos.php?exito=true");
    exit();
}
?>