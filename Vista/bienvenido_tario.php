<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../modelo/assets/css/bienvenido_tario.css">

</head>
<body>
    <?php
    if (isset($_POST['aren_nombre'])) {
        $aren_nombre = $_POST['aren_nombre'];
        // Muestra un mensaje de bienvenida personalizado con el nombre del arrendatario
        echo "<h1 class='display-4 mt-5'>¡Bienvenido, $aren_nombre!</h1>";
    } else {
        echo "<h1 class='display-4 mt-5'>¡HECHO!</h1>";
    }
    ?>
    <a class="volver-link" href="tabla_tario.php">Mira la tabla aquí</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
