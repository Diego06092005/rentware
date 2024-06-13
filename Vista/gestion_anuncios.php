
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Anuncios</title>
    <link rel="icon" type="image/png" href="../vista/IMG/rent2.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../modelo/assets/css/gestionAnuncio.css">
</head>
<?php
    // Inicio de sesión para habilitar el uso de variables de sesión
    session_start();
    
    //===============================================================================================
    // Configuración de la conexión a la base de datos
    //===============================================================================================
    $servername = "localhost"; // Servidor de la base de datos
    $username = "root";        // Usuario de la base de datos
    $password = "";            // Contraseña para el usuario de la base de datos
    $dbname = "rentware";      // Nombre de la base de datos

    // Crear una nueva conexión al servidor MySQL
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Comprobar si la conexión ha fallado y terminar la ejecución en ese caso
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    //===============================================================================================
    // Funciones de la lógica.
    //===============================================================================================
    // Función para eliminar un anuncio
    function eliminarAnuncio($id) {
        global $mysqli;                                 // Hacer la conexión a la base de datos accesible
        $sql = "DELETE FROM anuncios WHERE id = ?";     // Sentencia SQL para eliminar un anuncio por ID
        $stmt = $mysqli->prepare($sql);                 // Preparar la sentencia SQL para su ejecución
        $stmt->bind_param("i", $id);                    // Vincular el ID del anuncio al parámetro de la sentencia
        $stmt->execute();                               // Ejecutar la sentencia preparada
        return $stmt->affected_rows > 0;                // Devolver verdadero si se eliminó algún anuncio
    }

    // Comprobar si la petición es POST y si se solicitó eliminar un anuncio
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['eliminar'])) {
        $id_anuncio = $_POST['id_anuncio'];             // Obtener el ID del anuncio a eliminar desde el formulario
        if (eliminarAnuncio($id_anuncio)) {
            // Si el anuncio se eliminó correctamente, mostrar mensaje de éxito
            echo "<p class='alert alert-success'>Anuncio eliminado correctamente.</p>";
        } else {
            // Si hubo un error al eliminar, mostrar mensaje de error
            echo "<p class='alert alert-danger'>Error al eliminar el anuncio.</p>";
        }
    }

    // Obtener los anuncios del usuario logueado
    $id_arrendador = $_SESSION['id_usuario'];          // ID del usuario tomado de la sesión
    $sql = "SELECT * FROM anuncios WHERE id_arrendador = ?"; // Consulta SQL para obtener anuncios del usuario
    $stmt = $mysqli->prepare($sql);                    // Preparar la sentencia SQL
    $stmt->bind_param("i", $id_arrendador);            // Vincular el ID del usuario al parámetro de la sentencia
    $stmt->execute();                                  // Ejecutar la sentencia preparada
    $result = $stmt->get_result();                     // Obtener el resultado de la ejecución
?>
<body>
    <!-- Contenedor principal -->
    <div class="container-fluid">
        <a class="navbar-brand" href="sesiones514.php">
            <img src="../vista/IMG/logo2.png" alt="Logo" style="width:60px;">
        </a>
    </div>
    <div class="container mt-4">
    <!-- Encabezado principal -->
    <h1 class="mb-4" style="text-align: center;">Gestor de Anuncios</h1>
    <!-- Botón para agregar nuevo anuncio -->
    <div class="text-center" style="margin-left: 440px;">
        <a href="crearAnuncio.php" class="btn btn-primary">
            <i class="fas fa-plus"> Agregar</i> <!-- Ícono y texto del botón para agregar -->
            <i class="fas fa-bullhorn"></i> <!-- Ícono de bocina -->
        </a>
    </div>
    <!-- Verificar si existen anuncios para mostrar -->
    <?php if ($result->num_rows > 0): ?>
        <!-- Contenedor de la tabla con anuncios -->
 <div class="table-responsive">
        <table class="table table-striped">
                <thead>
                    <tr>
                        <!-- Encabezados de la tabla -->
                        <th>Título</th>
                        <th>Contenido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Iterar sobre cada anuncio y mostrarlo en la tabla -->
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['titulo']) ?></td> <!-- Mostrar título del anuncio -->
                            <td><?= htmlspecialchars($row['contenido']) ?></td> <!-- Mostrar contenido del anuncio -->
                            <td>
                                <!-- Formulario para eliminar un anuncio -->
                                <form method="post" action="" style="display: inline;">
                                    <input type="hidden" name="id_anuncio" value="<?= $row['id'] ?>">
                                    <button type="submit" name="eliminar" class="btn-icon" onclick="return confirm('¿Está seguro de eliminar?');">
                                        <i class="fas fa-trash"></i> <!-- Ícono de basura para eliminar -->
                                    </button>
                                   </form>
                                  <!-- Enlace para editar un anuncio -->
                                  <a href="editarAnuncio.php?id=<?= $row['id'] ?>" class="btn-icon">
                                    <i class="fas fa-edit"></i> <!-- Ícono de lápiz para editar -->
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
        </table>
    </div>
    <?php else: ?>
        <!-- Mensaje si no hay anuncios para mostrar -->
        <p class="text-center">No hay anuncios para mostrar.</p>
    <?php endif; ?>
 </div>
    <!-- Se incluye los scripts para mejorar la interactividad de la tabla -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../modelo/javascript/gestion_anuncios.js"></script>
    <script src="../modelo/javascript/notificaciones.js"></script>
 </body>
</html>
<?php
// Cerrar la sentencia y la conexión a la base de datos
$stmt->close();
$mysqli->close();
?>