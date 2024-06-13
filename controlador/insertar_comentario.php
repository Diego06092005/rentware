<?php
session_start(); // Asegurarse de haber iniciado la sesión en algún punto antes de este código

include 'conexion.php'; // Asegurarse de incluir el archivo de conexión a la base de datos

// Verificar si el usuario ha iniciado sesión y obtener su nombre de usuario
if (isset($_SESSION['usuario'])) {
    $nombre_usuario = $_SESSION['usuario'];
    // Preparar consulta para obtener el id del usuario basado en su nombre de usuario
    // Usar sentencias preparadas para prevenir inyecciones SQL
    $query_usuario = $mysqli->prepare("SELECT id FROM usuarios WHERE username = ?");
    $query_usuario->bind_param("s", $nombre_usuario);
    $query_usuario->execute();
    $result_usuario = $query_usuario->get_result();

    if ($result_usuario) {
        $fila_usuario = $result_usuario->fetch_assoc();
        $id_usuario = $fila_usuario['id'];
    } else {
        // Manejar el error en caso de que la consulta falle
        echo "Error: No se pudo obtener el ID del usuario.";
        exit; // Detener la ejecución del script
    }
} else {
    // Redirigir al usuario a la página de inicio de sesión o mostrar un mensaje
    echo "Usuario no ha iniciado sesión.";
    exit; // Detener la ejecución del script si no hay sesión
}

// Verificar si el mensaje de éxito está establecido
if (isset($_SESSION['mensaje_exito'])) {
    echo "<p>{$_SESSION['mensaje_exito']}</p>"; // Mostrar mensaje de éxito
    unset($_SESSION['mensaje_exito']); // Limpiar mensaje de éxito de la sesión
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Comentario</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Opcional: Bootstrap JS con Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    
<div class="container mt-5">
    <h2>Subir Comentario</h2>

    <form action="guardar_comentario.php" method="post">
        <div class="mb-3">
            <label for="comentario" class="form-label">Comentario</label>
            <textarea class="form-control" id="comentario" name="comentario" required></textarea>
        </div>

        <div class="mb-3">
            <label for="arrendatario" class="form-label">Seleccionar Arrendatario</label>
            <select class="form-select" id="arrendatario" name="aren_cedula_id" required>
                <option value="">Seleccionar Arrendatario</option>
                <?php
                $query = $mysqli->prepare("SELECT aren_cedula_id, aren_nombre, aren_apellido FROM arrendatario WHERE id_usuario = ?");
                $query->bind_param("i", $id_usuario);
                $query->execute();
                $result = $query->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['aren_cedula_id'] . "'>" . $row['aren_nombre'] . " " . $row['aren_apellido'] . "</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enviar Comentario</button>
    </form>
</div>

</body>
</html>

<?php
// Primero, obtener todos los arrendatarios del usuario
$query_arrendatarios = $mysqli->prepare("SELECT aren_cedula_id, aren_nombre, aren_apellido FROM arrendatario WHERE id_usuario = ?");
$query_arrendatarios->bind_param("i", $id_usuario);
$query_arrendatarios->execute();
$result_arrendatarios = $query_arrendatarios->get_result();

while ($arrendatario = $result_arrendatarios->fetch_assoc()) {
    echo "<div class='container mt-5'>";
    echo "<h3>Comentarios de " . htmlspecialchars($arrendatario['aren_nombre'] . " " . $arrendatario['aren_apellido']) . "</h3>";
    echo "<table class='table'>";
    echo "<thead><tr><th>Comentario</th><th>Fecha del Comentario</th></tr></thead>";
    echo "<tbody>";

    // Ahora, obtener y mostrar los comentarios para el arrendatario actual
    $query_comentarios = $mysqli->prepare("
        SELECT comentario, fecha_comentario
        FROM comentarios
        WHERE aren_cedula_id = ?
    ");
    $query_comentarios->bind_param("s", $arrendatario['aren_cedula_id']);
    $query_comentarios->execute();
    $result_comentarios = $query_comentarios->get_result();

    while ($comentario = $result_comentarios->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($comentario['comentario']) . "</td>";
        echo "<td>" . htmlspecialchars($comentario['fecha_comentario']) . "</td></tr>";
    }

    echo "</tbody></table></div>";
}
?>

<style>
 body {
    
            background-image: url('https://www.blogdelfotografo.com/wp-content/uploads/2021/12/Fondo_Negro_4.webp');
            background-size: cover;
            background-repeat: no-repeat;
            color: #fff;
            padding-top: 50px;
            min-height: 100vh;
        }

    /* Estilos para la tabla y el fondo gris oscuro */
 .container {
    background-color: #333; /* Gris oscuro */
    color: white;
    padding: 20px;
    border-radius: 5px;
 }

 .table {
    background-color: #454545; /* Un gris un poco más claro para la tabla */
 }

 .table th, .table td {
    color: white;
 }

 /* Estilo para el botón de borrar */
 .btn-delete {
    color: white;
    background-color: red;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
 }

</style>